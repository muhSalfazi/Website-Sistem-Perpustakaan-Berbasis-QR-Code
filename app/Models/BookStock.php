<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStock extends Model
{
    use HasFactory;

    protected $table = 'tbl_book_stock';

    protected $fillable = [
        'book_id',
        'jmlh_tersedia'
    ];
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}