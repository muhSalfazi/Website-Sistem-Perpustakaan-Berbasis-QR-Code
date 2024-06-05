<?php

namespace App\Http\Controllers;

use App\Models\Rack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RakbukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $racks = Rack::withCount('books')
            ->where('name', 'like', "%$search%")
            ->orWhere('rak', 'like', "%$search%")
            ->get();

        return view('Rak.showdata', compact('racks'));
    }

    public function create()
    {
        return view('Rak.createRak');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'rak' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Rack::create([
            'name' => $request->input('name'),
            'rak' => $request->input('rak'),
        ]);

        return redirect()->route('Rak.showdata')->with('msg', 'Rak berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rack_name' => 'required|string|max:255',
            'rak' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $rack = Rack::findOrFail($id);
        $rack->name = $request->input('rack_name');
        $rack->rak = $request->input('rak');
        $rack->save();

        return redirect()->route('Rak.showdata')->with('msg', 'Rak berhasil diperbarui');
    }


    public function destroy($id)
    {
        $rack = Rack::findOrFail($id);
        $rack->delete();

        return redirect()->route('Rak.showdata')->with('msg', 'Rak berhasil dihapus');
    }

    
}