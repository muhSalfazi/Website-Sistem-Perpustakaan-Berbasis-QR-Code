<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'category_id',
        'rack_id',
        'year',
        'book_cover',
    ];

    public function category()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function stock()
    {
        return $this->hasOne(BookStock::class);
    }
}