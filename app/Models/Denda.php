<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    use HasFactory;

    protected $table = 'tbl_denda';

    protected $fillable = [
        'id',
        'resi_pjmn',
        'denda_yg_dibyr',
        'uang_yg_dibyrkn',
        'status',
    ];
 protected $casts = [
 'created_at' => 'datetime',
 'return_date' => 'datetime',
 ];
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'resi_pjmn', 'resi_pjmn');
    }

}