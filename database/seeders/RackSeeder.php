<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rack;

class RackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rack::insert([
            [
                'name' => '1A',
                'lantai' => '1',
            ],
            [
                'name' => '1B',
                'lantai' => '1',
            ],
            [
                'name' => '1C',
                'lantai' => '1',
            ],
            [
                'name' => '2A',
                'floor' => '2',
            ],
            [
                'name' => '2B',
                'lantai' => '2',
            ],
            [
                'name' => '2C',
                'lantai' => '2',
            ],
            [
                'name' => '3A',
                'lantai' => '3',
            ],
            [
                'name' => '3B',
                'floor' => '3',
            ],
            [
                'name' => '3C',
                'lantai' => '3',
            ],
            [
                'name' => '3D',
                'lantai' => '3',
            ],
        ]);
    }
}