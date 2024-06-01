<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'tbl_pengembalian';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tgl_kembali',
    ];

    public function Peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

}