<?php
// app/Models/Rack.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rack extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_racks';

    protected $fillable = ['id','name', 'rak'];

    // Define relationship with books
    public function books()
    {
        return $this->hasMany(Book::class, 'rack_id');
    }
}