<?php

namespace Database\Seeders;

use Database\Factories\PeminjamanFactory;
use App\Models\Peminjaman;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PinjamBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Peminjaman ::factory()->count(10)->create();
    }
}