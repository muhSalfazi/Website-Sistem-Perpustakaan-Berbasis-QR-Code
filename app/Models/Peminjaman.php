<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Import trait HasFactory
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\User;

class Peminjaman extends Model
{
    use HasFactory; // Gunakan trait HasFactory

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_peminjaman';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resi_pjmn', 
        'book_id', 
        'stok_buku', 
        'member_id', 
        'tgl_pinjam',    
        'tgl_kembali', 
        'return_date'
    ];

    /**
     * Get the book record associated with the peminjaman.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Get the member record associated with the peminjaman.
     */
    public function member()
    {
        return $this->belongsTo(User::class);
    }
}