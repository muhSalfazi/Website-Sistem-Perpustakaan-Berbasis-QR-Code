<?php
namespace Database\Factories;

use App\Models\Peminjaman;
use App\Models\Member;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition()
    {

        // Ambil satu baris acak dari tabel 'members'
        $member = Member::inRandomOrder()->first();

        // Ambil satu baris acak dari tabel 'books'
        $book = Book::inRandomOrder()->first();

        return [
            'resi_pjmn' => $this->faker->unique()->regexify('[0-9]{10}'),
            'book_id' => $book->id ?? null,
            'jmlh_buku' => $this->faker->numberBetween(1, 5), // Perbaikan disini, pastikan nilai adalah angka
            'member_id' => $member->id ?? null,
           'created_at' => Carbon::now(),
            'updated_at' => null,
        ];
    }
}