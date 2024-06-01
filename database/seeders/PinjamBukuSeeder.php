<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Member; // Import model Member

class PinjamBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ambil semua anggota
        $members = Member::all();

        // Pastikan ada anggota yang tersedia
        if ($members->isEmpty()) {
            $this->command->info('Tidak ada anggota yang tersedia dalam database. Silakan tambahkan anggota terlebih dahulu.');
            return;
        }

        // Buat 10 peminjaman buku
        Peminjaman::factory()->count(5)->create([
            'member_id' => function () use ($members) {
                // Pilih anggota secara acak
                return $members->random()->id;
            },
        ]);
    }
}