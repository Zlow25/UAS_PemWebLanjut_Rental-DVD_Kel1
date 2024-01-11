<?php

namespace App\Http\Controllers;

use App\Models\DVD;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        if ($request->category || $request->title) {
            $dvds = DVD::where('title', 'like', '%' . $request->title . '%')
                ->orWhereHas('categories', function ($search) use ($request) {
                    $search->where('categories.id', $request->category);
                })->get();
        } else {
            $dvds = DVD::all();
        }
        $categories = Category::all();
        return view('FrontEnd.dvd-list', ['dvds' => $dvds, 'categories' => $categories]);
    }
}
