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
        Schema::create('table_denda', function (Blueprint $table) {
            $table->bigIncrements('id');
            // fk pinjaman
            $table->unsignedBigInteger('id_pinjaman');
            $table->foreign('id_pinjaman')->references('id')->on('table_peminjaman')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('jumlah_yg_dibyr');
            $table->integer('denda_yg_hrs_byr');
            $table->dateTime('tgl_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_denda');
    }
};