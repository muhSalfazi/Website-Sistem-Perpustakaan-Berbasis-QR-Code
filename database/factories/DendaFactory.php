<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Denda;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
 // Ambil satu baris acak dari tabel 'peminjaman' untuk mendapatkan 'id_member'
        $peminjaman = Peminjaman::inRandomOrder()->first();

        // Hitung selisih hari antara tgl_pinjam, tenggat waktu, dan tgl_kembali
        $tgl_pinjam = Carbon::parse($peminjaman->tgl_pinjam);
        $tgl_tenggat = Carbon::parse($peminjaman->tenggat_waktu);
        $tgl_kembali = Carbon::parse($peminjaman->tgl_kembali);

        // Perhitungan denda hanya jika tgl_kembali melebihi tenggat waktu
        if ($tgl_kembali->gt($tgl_tenggat)) {
            // Hitung selisih hari dengan tambahan 3 hari
            $selisih_hari = $tgl_tenggat->diffInDays($tgl_kembali->addDays(3));

            // Hitung denda, misalnya 5000 per hari terlambat
            $denda_per_day = 5000;
            $denda = $selisih_hari * $denda_per_day;
        } else {
            $denda = null; // Jika tidak ada denda, maka atur menjadi NULL
        }

        // Hitung uang yang dibayarkan
        $min_payment = $denda ?: 0; // Jika denda NULL, atur minimal pembayaran menjadi 0
        $max_payment = max(900000, $min_payment); // Maksimal pembayaran adalah 10.0000
        $uang_dibayarkan = $this->faker->numberBetween($min_payment, $max_payment);
        // $uang_dibayarkan = $this->faker->numberBetween($min_payment); // Tidak ada batasan maksimal



        // Hitung kembalian
        $kembalian = $uang_dibayarkan - $min_payment;
// 

        // Generate data factory
        
        return [
            'id_member' => $peminjaman->id,
            'denda_yg_diberikan' => $denda,
            'uang_yg_dibyrkn' => $uang_dibayarkan,
            'kembalian' => $kembalian,
            'total_days' => $selisih_hari ?? null, // Jika tidak ada denda, total_days juga NULL
        //    'created_at' =>  $randomDate,
        ];
    }
}