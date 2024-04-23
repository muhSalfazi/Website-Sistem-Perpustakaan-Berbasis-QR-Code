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
            $table->bigIncrements('id');
            $table->string('slug')->unique();
            $table->string('title', 150);
            $table->string('author', 70);
            $table->string('publisher', 70);
            $table->string('isbn', 20);
            $table->year('year');
            // FK rack id
            $table->unsignedBigInteger('rack_id');
            $table->foreign('rack_id')->references('id')->on('rack')->cascadeOnUpdate()->cascadeOnDelete();
            // FK category id
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnUpdate()->cascadeOnDelete();
            // 
            $table->string('book_cover', 255);
            $table->timestamps();
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