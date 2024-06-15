<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Kategori;
use App\Models\Rack;
use App\Models\BookStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'rack_id' => 'required|exists:tbl_racks,id',
            'category_id' => 'required|exists:tbl_categories,id',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'jmlh_tersedia' => 'required|integer|min:0',
        ]);

        try {
            $book = new Book($request->except('cover'));

            if ($request->hasFile('cover')) {
                $imageFile = $request->file('cover');
                $imageFileName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
                $path = $imageFile->storeAs('cover_book', $imageFileName);
                $book->book_cover = $path;
            }

            $book->save();

            $bookStock = new BookStock();
            $bookStock->book_id = $book->id;
            $bookStock->jmlh_tersedia = $request->input('jmlh_tersedia');
            $bookStock->save();

            return redirect()->route('books.index')->with('msg', 'Book added successfully')->with('error', false);
        } catch (\Exception $e) {
            Log::error('Error storing book: ' . $e->getMessage());
            return redirect()->route('books.index')->with('msg', 'Failed to add book')->with('error', true);
        }
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:80',
            'isbn' => 'required|string|max:100|unique:tbl_books,isbn,' . $book->id,
            'year' => 'required|integer|min:1000|max:' . date('Y'),
            'category_id' => 'required|integer|exists:tbl_categories,id',
            'rack_id' => 'required|integer|exists:tbl_racks,id',
            'jumlah' => 'required|integer|min:0',
            'description' => 'required|string',
            'book_cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            if ($request->hasFile('book_cover')) {
                if ($book->book_cover) {
                    $oldImagePath = public_path($book->book_cover);
                    if (File::exists($oldImagePath)) {
                        File::delete($oldImagePath);
                    }
                }
            }

            $book->update($request->except('book_cover'));

            if ($request->hasFile('book_cover')) {
                $imageFile = $request->file('book_cover');
                $imageFileName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
                $path = $imageFile->storeAs('cover_book', $imageFileName);
                $book->book_cover = $path;
                $book->save();
            }

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
        } catch (\Exception $e) {
            Log::error('Error updating book: ' . $e->getMessage());
            return redirect()->back()->with('msg', 'Failed to update book')->with('error', true);
        }
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
        try {
            $book = Book::findOrFail($id);

            if ($book->book_cover) {
                Storage::delete($book->book_cover);
            }

            $book->delete();

            return redirect()->route('books.index')->with('msg', 'Book deleted successfully')->with('error', false);
        } catch (\Exception $e) {
            Log::error('Error deleting book: ' . $e->getMessage());
            return redirect()->route('books.index')->with('msg', 'Failed to delete book')->with('error', true);
        }
    }
}