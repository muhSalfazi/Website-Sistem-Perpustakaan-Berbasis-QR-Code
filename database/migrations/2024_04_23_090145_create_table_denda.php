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
        Schema::create('tbl_denda', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_member')->nullable();
            $table->unsignedInteger('denda_yg_diberikan')->nullable();
            $table->unsignedInteger('uang_yg_dibyrkn');
            $table->unsignedInteger('kembalian');
            $table->unsignedInteger('total_days');
            // $table->dateTime('create_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_member')->references('id')->on('tbl_peminjaman')->onDelete('set null');
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