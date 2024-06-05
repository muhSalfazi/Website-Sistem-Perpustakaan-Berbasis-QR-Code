<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use App\Models\Rack;
use App\Models\BookStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'rack', 'bookStock'])->paginate(10);
        return view('daftarbook', compact('books'));
    }

    public function create()
    {
        $categories = Kategori::all();
        $racks = Rack::all();
        return view('books.create', compact('categories', 'racks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:157',
            'author' => 'required|string|max:80',
            'publisher' => 'required|string|max:80',
            'isbn' => 'required|string|max:100|unique:tbl_books',
            'year' => 'required|integer',
            'rack_id' => 'required|exists:tbl_racks,id',
            'category_id' => 'required|exists:tbl_categories,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'jmlh_tersedia' => 'required|integer',
        ]);

        $book = new Book($request->all());

        if ($request->hasFile('cover')) {
            $bookCoverPath = $request->file('cover')->store('cover_book', 'public');
            $book->book_cover = $bookCoverPath;
        }

        $book->save();

        $bookStock = new BookStock();
        $bookStock->book_id = $book->id;
        $bookStock->jmlh_tersedia = $request->input('jmlh_tersedia');
        $bookStock->save();

        return redirect()->route('books.index')->with('msg', 'Book added successfully')->with('error', false);
    }


    // BookController.php
    public function getBook($id)
    {
        $book = Book::with(['category', 'rack', 'bookStock'])->findOrFail($id);
        return response()->json([
            'id' => $book->id,
            'title' => $book->title,
            'isbn' => $book->isbn,
            'author' => $book->author,
            'publisher' => $book->publisher,
            'year' => $book->year,
            'category_id' => $book->category_id,
            'rack_id' => $book->rack_id,
            'bookStock' => [
                'jmlh_tersedia' => optional($book->bookStock)->jmlh_tersedia
            ]
        ]);
    }


    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:157',
            'author' => 'required|string|max:80',
            'publisher' => 'required|string|max:80',
            'isbn' => 'nullable|string|max:100|unique:tbl_books,isbn,' . $id,
            'year' => 'required|integer',
            'rack_id' => 'required|exists:tbl_racks,id',
            'category_id' => 'required|exists:tbl_categories,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'jmlh_tersedia' => 'required|integer',
        ]);

        $data = $request->except(['cover']);

        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('cover_book', 'public');
            Storage::disk('public')->delete($book->book_cover); // Delete old cover
            $data['book_cover'] = $coverPath;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('msg', 'Book updated successfully')->with('error', false);
    }




    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete(); // Soft delete

        return redirect()->route('books.index')->with('msg', 'Book deleted successfully')->with('error', false);
    }

}