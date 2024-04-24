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
     Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title', 127);
            $table->string('author', 64);
            $table->string('publisher', 64);
            $table->string('isbn', 13);
            $table->year('year');
            $table->unsignedBigInteger('rack_id');
            $table->unsignedBigInteger('category_id');
            $table->string('book_cover')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('rack_id')->references('id')->on('racks')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
        
    }
    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};