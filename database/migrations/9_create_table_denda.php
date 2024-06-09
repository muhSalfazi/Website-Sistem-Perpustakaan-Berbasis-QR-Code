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
        Schema::create('tbl_denda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pjmn')->nullable();
            $table->unsignedInteger('denda_yg_dibyr')->nullable();
            $table->unsignedInteger('uang_yg_dibyrkn')->nullable(); 
            $table->enum('status', ['lunas', 'belum lunas'])->nullable()->default('belum lunas'); 
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pjmn')->references('id')->on('tbl_peminjaman')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_denda');
    }
};