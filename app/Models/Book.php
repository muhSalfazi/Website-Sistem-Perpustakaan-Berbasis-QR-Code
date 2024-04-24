<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Book extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'books';
    
    protected $fillable = [
    'slug',
    'title',
    'author',
    'publisher',
    'isbn',
    'year',
    'rack_id',
    'category_id',
    'book_cover',
];

}