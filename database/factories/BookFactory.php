<?php
namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // datetime
        $currentMonth = Carbon::now()->month;
        $randomDay = $this->faker->numberBetween(1, Carbon::now()->daysInMonth);
        $randomHour = $this->faker->numberBetween(0, 23);
        $randomMinute = $this->faker->numberBetween(0, 59);
        $randomSecond = $this->faker->numberBetween(0, 59);
        $randomDate = Carbon::create(null, $currentMonth, $randomDay, $randomHour, $randomMinute, $randomSecond);

        // Direktori penyimpanan gambar
        $imagePath = 'public/img/book_cover';

        // Pastikan direktori ada
        if (!Storage::exists($imagePath)) {
            Storage::makeDirectory($imagePath);
        }

        // Ambil daftar file gambar di direktori penyimpanan
        $files = Storage::files($imagePath);

        // Pilih file gambar secara acak dari daftar file
        $randomFile = $files[array_rand($files)];

        // Ambil ID rack secara acak dari data yang sudah ada
        $rackId = \App\Models\Rack::pluck('id')->random();

        // Ambil ID kategori secara acak dari data yang sudah ada
        $categoryId = \App\Models\Kategori::pluck('id')->random();

        // Ambil title dan buat slug
        $title = $this->faker->sentence;

        // Generate nomor random di belakang slug
        $randomNumber = rand(10000, 99999);
        $slug = Str::slug($title, '-') . '-' . $randomNumber;

        return [
            'slug' => $slug,
            'title' => $title,
            'author' => $this->faker->name,
            'publisher' => $this->faker->company,
            'isbn' => $this->faker->isbn13,
            'year' => $this->faker->numberBetween(2000, 2022),
            'rack_id' => $rackId,
            'category_id' => $categoryId,
            'book_cover' => 'img/book_cover/' . basename($randomFile),
            'created_at' => $randomDate, // Set created_at menjadi NULL
            'updated_at' => null, // Set updated_at menjadi NULL
        ];
    }
}