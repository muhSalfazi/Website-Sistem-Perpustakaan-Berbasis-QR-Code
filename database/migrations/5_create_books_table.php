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
     Schema::create('tbl_books', function (Blueprint $table) {
            $table->id();
            $table->string('book_cover')->nullable();
            $table->string('title', 157);
            $table->string('author', 80);
            $table->string('publisher', 80);
            $table->string('isbn', 100)->unique();
            $table->year('year');
            $table->unsignedBigInteger('rack_id');
            $table->unsignedBigInteger('category_id');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rack_id')->references('id')->on('tbl_racks')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('tbl_categories')->onDelete('cascade');
        });
        
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tbl_books');
    }
};