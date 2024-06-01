<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use App\Models\Rack;
use App\Models\BookStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $books = Book::with(['category', 'rack', 'bookStock'])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('rack', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('bookStock', function ($q) use ($search) {
                        $q->where('jmlh_tersedia', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(10);

        $categories = Kategori::all();
        $racks = Rack::all();

        return view('daftarbook', compact('books', 'categories', 'racks'));
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
            'book_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $book = new Book($request->all());

        if ($request->hasFile('book_cover')) {
            $book->book_cover = $request->file('book_cover')->store('book_covers', 'public');
        }

        $book->save();

        return redirect()->route('books.index')->with('msg', 'Book added successfully')->with('error', false);
    }

    public function edit(Book $book)
    {
        $categories = Kategori::all();
        $racks = Rack::all();
        return view('books.edit', compact('book', 'categories', 'racks'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:157',
            'author' => 'required|string|max:80',
            'publisher' => 'required|string|max:80',
            'isbn' => 'required|string|max:100|unique:tbl_books,isbn,' . $book->id,
            'year' => 'required|integer',
            'rack_id' => 'required|exists:tbl_racks,id',
            'category_id' => 'required|exists:tbl_categories,id',
            'book_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $book->fill($request->all());

        if ($request->hasFile('book_cover')) {
            if ($book->book_cover && Storage::disk('public')->exists($book->book_cover)) {
                Storage::disk('public')->delete($book->book_cover);
            }
            $book->book_cover = $request->file('book_cover')->store('book_covers', 'public');
        }

        $book->save();

        return redirect()->route('books.index')->with('msg', 'Book updated successfully')->with('error', false);
    }

    public function destroy(Book $book)
    {
        if ($book->book_cover && Storage::disk('public')->exists($book->book_cover)) {
            Storage::disk('public')->delete($book->book_cover);
        }
        $book->delete();

        return redirect()->route('books.index')->with('msg', 'Book deleted successfully')->with('error', false);
    }
}