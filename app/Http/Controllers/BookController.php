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
        return view('Books.daftarbook', compact('books'));
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:255',
            'category_id' => 'required|exists:tbl_categories,id',
            'rack_id' => 'required|exists:tbl_racks,id',
            'jumlah' => 'required|integer|min:1',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'book_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $book = Book::findOrFail($id);
        $book->title = $request->input('title');
        $book->isbn = $request->input('isbn');
        $book->category_id = $request->input('category_id');
        $book->rack_id = $request->input('rack_id');
        $book->author = $request->input('author');
        $book->publisher = $request->input('publisher');
        $book->year = $request->input('year');

        if ($request->hasFile('book_cover')) {
            $book->book_cover = $request->file('book_cover')->store('book_covers', 'public');
        }

        $book->save();

        // Update the book stock
        $bookStock = BookStock::firstOrCreate(['book_id' => $book->id]);
        $bookStock->jmlh_tersedia = $request->input('jumlah');
        $bookStock->save();

        return redirect()->route('books.index')->with('msg', 'Book updated successfully');
    }

    public function showDetail($id)
    {
        $book = Book::findOrFail($id);
        $categories = Kategori::all();
        $racks = Rack::all();

        return view('Books.showDetail', compact('book', 'categories', 'racks'));
    }

    public function getBook($id)
    {
        $book = Book::with('category', 'rack', 'bookStock')->findOrFail($id);
        return response()->json(['book' => $book]);
    }
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete(); // Soft delete

        return redirect()->route('books.index')->with('msg', 'Book deleted successfully')->with('error', false);
    }
}