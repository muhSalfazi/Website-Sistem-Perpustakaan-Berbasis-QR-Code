<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_pengembalian', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('id_pnjmn')->nullable();
            $table->unsignedInteger('tgl_kembali')->nullable();
            // $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pnjmn')->references('id')->on('tbl_peminjaman')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_pengembalian');
    }
};