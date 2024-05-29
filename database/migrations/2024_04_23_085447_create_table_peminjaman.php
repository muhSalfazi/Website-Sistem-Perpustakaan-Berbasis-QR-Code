<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::create('tbl_peminjaman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('resi_pjmn')->unique();
            $table->unsignedBigInteger('book_id');
            $table->unsignedInteger('jmlh_book')->default(1);
            $table->unsignedBigInteger('member_id');
            // $table->date('tengat_wktu');
            $table->dateTime('tgl_kembali')->nullable();
            $table->string('qr_code', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            $table->foreign('member_id')->references('id')->on('tbl_members')->onDelete('cascade');
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