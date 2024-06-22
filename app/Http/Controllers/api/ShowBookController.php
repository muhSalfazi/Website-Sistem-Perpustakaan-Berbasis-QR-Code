<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
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

    public function favoriteBook($userId, $id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::find($userId);

        // Pastikan pengguna ada
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Temukan buku berdasarkan ID
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Periksa apakah buku sudah difavoritkan oleh pengguna
        if ($book->favoritedBy()->where('user_id', $userId)->exists()) {
            return response()->json(['message' => 'Buku sudah difavoritkan oleh pengguna']);
        }

        // Lampirkan pengguna ke buku favorit
        $user->favoriteBooks()->attach($book);

        return response()->json(['message' => 'Buku berhasil difavoritkan']);
    }


    public function unfavoriteBook($userId, $id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::find($userId);

        // Pastikan pengguna ada
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Find the book by its ID
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Detach the book from the user's favorite books
        $user->favoriteBooks()->detach($book);

        return response()->json(['message' => 'Buku yang tidak difavoritkan berhasil']);
    }

    public function getFavoriteBooks($userId)
    {
        // Find the user by ID
        $user = User::find($userId);

        // Ensure the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Ambil buku favorit yang terkait dengan pengguna
        $books = $user->favoriteBooks()->with(['category', 'rack', 'bookStock'])->get();

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


}