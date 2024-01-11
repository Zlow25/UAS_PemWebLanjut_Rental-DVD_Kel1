<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DVD;
use App\Models\RentLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DVDRentController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get(); // get() -> lebih dari satu data
        $dvds = DVD::all();
        return view('BackEnd.dvd-rent', ['users' => $users, 'dvds' => $dvds]);
    }

    public function store(Request $request)
    {
        $request['rent_date'] = Carbon::now()->toDateTimeString();
        $request['return_date'] = Carbon::now()->addDay(3)->toDateTimeString();

        $dvd = DVD::findOrFail($request->dvd_id)->only('status'); // hanya mengambil status dari dvd
        // dd($dvd);
        if ($dvd['status'] != 'in stock') {
            Session::flash('message', 'Cannot Rent, the dvd is not available!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('dvd-rent');
        } else {
            // get user_id yang actual_return_datenya null
            $count = RentLogs::where('user_id', $request->user_id)->where('actual_return_date', null)->count();

            // cek kondisi user_id yang actual_return_datenya null
            if ($count >= 3) {
                Session::flash('message', 'Cannot Rent, User has reach limit of dvds!');
                Session::flash('alert-class', 'alert-danger');
                return redirect('dvd-rent');
            }
            try {
                DB::beginTransaction();
                // process insert to rent_logs table
                RentLogs::create($request->all());
                // process update dvd table
                $dvd = DVD::findOrFail($request->dvd_id);
                $dvd->status = 'not available';
                $dvd->save();
                DB::commit();

                Session::flash('message', 'Rent dvd success!!!');
                Session::flash('alert-class', 'alert-success');
                return redirect('dvd-rent');
            } catch (\Throwable $th) {
                DB::rollBack();
            }
        }
    }

    public function returnDVD()
    {
        $users = User::where('id', '!=', 1)->where('status', '!=', 'inactive')->get(); // get() -> lebih dari satu data
        $dvds = DVD::all();
        return view('BackEnd.dvd-return', ['users' => $users, 'dvds' => $dvds]);
    }

    public function saveReturnDVD(Request $request)
    {
        // user & buku yang dipilih untuk direturn benar, maka berhasil return dvd
        // user & buku yang dipilih untuk direturn salah, maka muncul error notice
        $rent = RentLogs::where('user_id', $request->user_id)->where('dvd_id', $request->dvd_id)->where('actual_return_date', null);
        $rentData = $rent->first();
        $countData =  $rent->count();

        if ($countData == 1) {
            try {
                DB::beginTransaction();
                // return dvd
                $rentData->actual_return_date = Carbon::now()->toDateTimeString();
                $rentData->save();

                // process update dvd table
                $dvd = DVD::findOrFail($request->dvd_id);
                $dvd->status = 'in stock';
                $dvd->save();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
            }

            Session::flash('message', 'The dvd is returned successfully!');
            Session::flash('alert-class', 'alert-success');
            return redirect('dvd-return');
        } else {
            // error notice
            Session::flash('message', 'The dvd is error process!');
            Session::flash('alert-class', 'alert-danger');
            return redirect('dvd-return');
        }
    }
}
