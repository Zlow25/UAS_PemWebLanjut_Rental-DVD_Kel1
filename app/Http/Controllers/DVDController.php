<?php

namespace App\Http\Controllers;

use App\Models\DVD;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class DVDController extends Controller
{
    public function index(Request $request)
    {
        $dvds = DVD::all();
        return view('BackEnd.dvds.dvd', ['dvds' => $dvds]);
    }

    public function add()
    {
        $categories = Category::all();
        return view('BackEnd.dvds.dvd-add', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'dvd_code' => 'required|unique:dvds|max:255',
            'title' => 'required|max:255',
            'cover' => 'file|mimes:jpeg,png,jpg,svg|max:5120',
        ]);

        // validasi gambar
        $newName = '';
        if ($request->file('cover')) {
            $extension = $request->file('cover')->getClientOriginalExtension();
            // $newName = $request->title . '-' . now()->timestamp . '.' . $extension;
            $newName = $request->title . '.' . $extension;
            // $request->cover->storeAs('public/images', $newName);
            $request->file('cover')->move(public_path('images'), $newName);
        }

        $dvd = DVD::create([
            'dvd_code' => $request->dvd_code,
            'title' => $request->title,
            'cover' => $newName,
            'slug' => str::slug($request->title),
        ]);
        $dvd->categories()->sync($request->categories); // sync relationship model dvd
        return redirect('/dvds')->with(['success' => 'New DVD Berhasil Tersimpan!']);
    }

    public function edit($slug)
    {
        $dvd = DVD::where('slug', $slug)->first();
        // dd($dvd);
        $category = Category::all();
        return view('BackEnd.dvds.dvd-edit', ['dvd' => $dvd, 'categories' => $category]);
    }

    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            'dvd_code' => 'required|max:255',
            'title' => 'required|max:255',
        ]);

        $dvd = DVD::where('slug', $slug)->first();

        // validasi gambar
        if ($request->file('cover')) {
            $extension = $request->file('cover')->getClientOriginalExtension();
            $newName = $request->title . '-' . now()->timestamp . '.' . $extension;
            // $request->cover->storeAs('images', $newName);
            $request->file('cover')->move(public_path('images'), $newName);

            $dvd->update([
                'dvd_code' => $request->dvd_code,
                'title' => $request->title,
                'slug' => str::slug($request->title),
                'cover' => $newName
            ]);
        }

        if ($request->categories) {
            $dvd->categories()->sync($request->categories); // sync relationship model dvd
        }

        return redirect('/dvds')->with(['success' => 'Update DVD Berhasil Tersimpan!']);
    }

    public function delete($slug)
    {
        $dvd = DVD::where('slug', $slug)->first();
        // dd($dvd);
        $dvd->delete();
        return redirect('/dvds')->with(['success' => 'DVDs Berhasil Dihapus!']);
    }

    public function deleteDVD()
    {
        $dvd = DVD::onlyTrashed()->get();
        return view('BackEnd.dvds.dvd-delete', ['deletedDVD' => $dvd]);
    }

    public function restore($slug)
    {
        $dvd = DVD::withTrashed()->where('slug', $slug)->first();
        $dvd->restore();
        return redirect('/dvds')->with(['success' => 'DVD Restore Berhasil Dikembalikan!']);
    }
}
