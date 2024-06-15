<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'tbl_denda';

    protected $fillable = [
        'id_pjmn',
        'denda_yg_dibyr',
        'uang_yg_dibyrkn',
        'status',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'resi_pjmn');
    }

}