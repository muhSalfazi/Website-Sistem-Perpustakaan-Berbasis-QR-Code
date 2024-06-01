<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_peminjaman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('resi_pjmn')->unique();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('book_id');
            $table->integer('jmlh_buku')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('book_id')->references('id')->on('tbl_books')->onDelete('cascade');
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