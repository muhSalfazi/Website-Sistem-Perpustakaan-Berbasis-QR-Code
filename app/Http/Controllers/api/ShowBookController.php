<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ShowBookController extends Controller
{
    public function index()
    {
        $books = Book::with(['category', 'rack', 'bookStock'])->get();

        $transformedBooks = $books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'publisher' => $book->publisher,
                'category' => $book->category,
                'rack' => $book->rack,
                'stock' => $book->bookStock,
                'description' => $book->description,
                'cover_link' => 'http://127.0.0.1:8000/' . $book->book_cover,
            ];
        });

        return response()->json($transformedBooks);
    }

    public function show($id)
    {
        $book = Book::with(['category', 'rack', 'bookStock'])->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $transformedBook = [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'publisher' => $book->publisher,
            'category' => $book->category,
            'rack' => $book->rack,
            'stock' => $book->bookStock,
            'description' => $book->description,
            'cover_link' => 'http://127.0.0.1:8000/' . $book->book_cover,
        ];

        return response()->json($transformedBook);
    }

    public function showByCategory($categoryName)
    {
        $category = Kategori::where('name', $categoryName)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $books = $category->books()->with(['rack', 'bookStock'])->get();

        $transformedBooks = $books->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'publisher' => $book->publisher,
                'category' => $book->category,
                'rack' => $book->rack,
                'stock' => $book->bookStock,
                'cover_link' => 'http://127.0.0.1:8000/' . $book->book_cover,
            ];
        });

        return response()->json($transformedBooks);
    }
}