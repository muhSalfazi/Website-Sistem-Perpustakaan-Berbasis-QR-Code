<?php


namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mendapatkan ID kategori dan rak yang sudah ada dalam database
        $categories = \App\Models\Kategori::pluck('id');
        $racks = \App\Models\Rack::pluck('id');

        // Direktori penyimpanan gambar
        $imagePath = 'public/img/book_cover';

        // Ambil daftar file gambar di direktori penyimpanan
        $files = Storage::files($imagePath);

        // Membuat 10 buku acak
        
            // Pilih file gambar secara acak dari daftar file
            $randomFile = $files[array_rand($files)];

            // Simpan file gambar ke penyimpanan
            $uploadedFile = basename($randomFile);
            Storage::copy($randomFile, 'public/img/book_cover/' . $uploadedFile);

            Book::create([
                // 'slug' => 'book-',
                'title' => 'Book Title ' ,
                'author' => 'Author ' ,
                'publisher' => 'Publisher ' ,
                'isbn' => 'ISBN-' ,
                'year' => random_int(2000, 2022), // Tahun acak antara 2000 dan 2022
                'rack_id' => $racks->random(),
                'category_id' => $categories->random(),
                'book_cover' => 'img/book_cover/' . $uploadedFile, // Simpan path file gambar ke dalam basis data
            ]);

            // Book::factory()->count(9)->create();
        
    }
}