<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, Notifiable,SoftDeletes;

    protected $table = 'tbl_categories';
    
    protected $fillable = [
        'id',
        'name',
    ];
    protected $dates = ['
    deleted_at
    '];
    public function books()
    {
        return $this->hasMany(Book::class, 'category_id');
    }

    public function bookStocks()
    {
        return $this->hasManyThrough(BookStock::class, Book::class, 'category_id', 'book_id', 'id', 'id');
    }
}