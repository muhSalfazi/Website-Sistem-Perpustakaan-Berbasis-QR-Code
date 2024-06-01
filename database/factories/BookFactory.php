<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        $currentMonth = Carbon::now()->month;
        $randomDay = $this->faker->numberBetween(1, Carbon::now()->daysInMonth);
        $randomHour = $this->faker->numberBetween(0, 23);
        $randomMinute = $this->faker->numberBetween(0, 59);
        $randomSecond = $this->faker->numberBetween(0, 59);
        $randomDate = Carbon::create(null, $currentMonth, $randomDay, $randomHour, $randomMinute, $randomSecond);

        $imagePath = 'public/img/book_cover';

        if (!Storage::exists($imagePath)) {
            Storage::makeDirectory($imagePath);
        }

        $files = Storage::files($imagePath);
        $randomFile = $files[array_rand($files)];

        $rackId = \App\Models\Rack::pluck('id')->random();
        $categoryId = \App\Models\Kategori::pluck('id')->random();

        return [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'publisher' => $this->faker->company,
            'isbn' => $this->faker->unique()->isbn13,
            'year' => $this->faker->numberBetween(2000, 2022),
            'rack_id' => $rackId,
            'category_id' => $categoryId,
            'book_cover' => 'img/book_cover/' . basename($randomFile),
            'created_at' => $randomDate,
            'updated_at' => null,
        ];
    }
}