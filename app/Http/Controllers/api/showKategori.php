<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class showKategori extends Controller
{
    //

    public function index()
    {
        $categories = Kategori::all();
        return response()->json($categories);
    }

    public function show($id)
    {
        $category = Kategori::findOrFail($id);
        return response()->json($category);
    }
}