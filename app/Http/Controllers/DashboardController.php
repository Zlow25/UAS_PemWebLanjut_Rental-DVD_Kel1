<?php

namespace App\Http\Controllers;

use App\Models\DVD;
use App\Models\User;
use App\Models\Category;
use App\Models\RentLogs;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // $request->session()->flush();
        $dvdCount = DVD::count();
        $categoryCount = Category::count();
        $userCount = User::count();
        $rentlogs = RentLogs::with(['user', 'dvd'])->get();
        return view('BackEnd.dashboard', ['dvd_count' => $dvdCount, 'category_count' => $categoryCount, 'user_count' => $userCount, 'rentlogs' => $rentlogs]);
    }
}
