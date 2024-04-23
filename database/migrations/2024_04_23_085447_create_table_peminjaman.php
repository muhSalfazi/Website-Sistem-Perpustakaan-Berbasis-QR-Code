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
        Schema::create('table_peminjaman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nim')->unique();
            // FK book id
           $table->unsignedBigInteger('book_id');
            $table->foreign('book_id')->references('id')->on('books')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('quantity');
            // FK member id
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->date('tanggal_pengembalian')->nullable();
            $table->boolean('status_pengembalian')->default(false);
            $table->String('qr_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_peminjaman');
    }
};