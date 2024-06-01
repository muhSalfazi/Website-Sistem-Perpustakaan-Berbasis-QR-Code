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
                'rak' => '1',
            ],
            [
                'name' => '1B',
                'rak' => '1',
            ],
            [
                'name' => '1C',
                'rak' => '1',
            ],
            [
                'name' => '2A',
                'rak' => '2',
            ],
            [
                'name' => '2B',
                'rak' => '2',
            ],
            [
                'name' => '2C',
                'rak' => '2',
            ],
            [
                'name' => '3A',
                'rak' => '3',
            ],
            [
                'name' => '3B',
                'rak' => '3',
            ],
            [
                'name' => '3C',
                'rak' => '3',
            ],
            // [
            //     'name' => '3D',
            //     'rak' => '3',
            // ],
        ]);
    }
}