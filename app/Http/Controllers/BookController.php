<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookStock;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $books = Book::with(['stock', 'category', 'rack'])
            ->where('title', 'LIKE', "%$search%")
            ->orWhere('author', 'LIKE', "%$search%")
            ->orWhereHas('category', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })
            ->orWhereHas('rack', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })
            ->orWhereHas('stock', function ($query) use ($search) {
                $query->where('stok_buku', 'LIKE', "%$search%");
            })
            ->paginate(10);

        return view('daftarbook', compact('books', 'search'));
    }


    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required',
            'rack_id' => 'required',
            'year' => 'required|integer',
            'book_cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|integer',
        ]);

        $book = new Book($request->except('stock'));

        if ($request->hasFile('book_cover')) {
            $fileName = time() . '.' . $request->book_cover->extension();
            $request->book_cover->move(public_path('covers'), $fileName);
            $book->book_cover = $fileName;
        }

        $book->save();

        // Create new stock and associate it with the book
        $bookStock = new BookStock([
            'stok_buku' => $request->input('stock'),
        ]);

        $book->stock()->save($bookStock);

        return redirect()->route('books.index')->with('msg', 'Book created successfully');
    }


    public function edit(Book $book)
    {
        $book->load('stock');
        return response()->json($book);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'category_id' => 'required',
            'rack_id' => 'required',
            'year' => 'required|integer',
            'book_cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'required|integer',
        ]);

        $book->fill($request->all());

        if ($request->hasFile('book_cover')) {
            $fileName = time() . '.' . $request->book_cover->extension();
            $request->book_cover->move(public_path('covers'), $fileName);
            $book->book_cover = $fileName;
        }

        $book->save();

        $book->stock()->updateOrCreate(
            ['book_id' => $book->id],
            ['stok_buku' => $request->input('stock')]
        );

        return redirect()->route('books.index')->with('msg', 'Book updated successfully');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('msg', 'Book deleted successfully');
    }
}