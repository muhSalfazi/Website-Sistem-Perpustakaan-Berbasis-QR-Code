<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStock extends Model
{
    use HasFactory;

    protected $table = 'book_stock';
    
    protected $fillable = [
    'book_id',
    'stok_buku'
];
}