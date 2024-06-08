<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_books';

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'isbn',
        'year',
        'rack_id',
        'category_id',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Kategori::class, 'category_id');
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class, 'rack_id');
    }

    public function bookStock()
    {
        return $this->hasOne(BookStock::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'book_id');
    }
}