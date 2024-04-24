<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Kategori::insert([
            ['name' => 'sejarah'],
            ['name' => 'non-fiksi'],
            ['name' => 'komik'],
            ['name' => 'novel'],
            ['name' => 'biografi'],
            ['name' => 'agama'],
            ['name' => 'ekonomi'],
            ['name' => 'fiksi'],
            ['name' => 'teknologi']
        ]);
    }
}