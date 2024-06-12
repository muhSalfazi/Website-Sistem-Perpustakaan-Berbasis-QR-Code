<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use App\Models\Rack;
use App\Models\BookStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        return view('Books.create', compact('categories', 'racks'));
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
            $imageFile = $request->file('cover');
            $imageFileName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('cover_book'), $imageFileName);
            $book->book_cover = 'cover_book/' . $imageFileName;
        }

        $book->save();

        $bookStock = new BookStock();
        $bookStock->book_id = $book->id;
        $bookStock->jmlh_tersedia = $request->input('jmlh_tersedia');
        $bookStock->save();

        return redirect()->route('books.index')->with('msg', 'Book added successfully')->with('error', false);
    }

  public function update(Request $request, Book $book)
{
    // Validasi input
    $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'year' => 'required|integer|min:1000|max:' . date('Y'),
        'category_id' => 'required|integer|exists:tbl_categories,id',
        'rack_id' => 'required|integer|exists:tbl_racks,id',
        'jumlah' => 'required|integer|min:0',
    ]);

    // Update data buku
    $book->update([
        'title' => $request->title,
        'author' => $request->author,
        'year' => $request->year,
        'category_id' => $request->category_id,
        'rack_id' => $request->rack_id,
    ]);

    // Update stok buku
    if ($book->bookStock) {
        $book->bookStock->update([
            'jmlh_tersedia' => $request->jumlah,
        ]);
    } else {
        BookStock::create([
            'book_id' => $book->id,
            'jmlh_tersedia' => $request->jumlah,
        ]);
    }

    return redirect()->back()->with('msg', 'Data buku berhasil diperbarui.');
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
        $book = Book::with('bookStock')->findOrFail($id);
        return response()->json(['book' => $book]);
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        // Remove book cover if exists
        if ($book->book_cover) {
            Storage::delete($book->book_cover);
        }

        $book->delete(); // Soft delete

        return redirect()->route('books.index')->with('msg', 'Book deleted successfully')->with('error', false);
    }
}