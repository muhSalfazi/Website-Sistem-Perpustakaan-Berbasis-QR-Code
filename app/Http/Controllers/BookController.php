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
        $book->fill($request->all());

        if ($request->hasFile('book_cover')) {
            $imageFile = $request->file('book_cover');
            $imageFileName = Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('cover_book'), $imageFileName);
            $book->book_cover = 'cover_book/' . $imageFileName;

            // Remove old book cover if exists
            if ($book->getOriginal('book_cover')) {
                Storage::delete($book->getOriginal('book_cover'));
            }
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

        // Remove book cover if exists
        if ($book->book_cover) {
            Storage::delete($book->book_cover);
        }

        $book->delete(); // Soft delete

        return redirect()->route('books.index')->with('msg', 'Book deleted successfully')->with('error', false);
    }
}