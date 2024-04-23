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
        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('nim')->unique();
            $table->String('fist_name');
            $table->String('last_name');
            $table->String('email');
            $table->String('phone');
            $table->String('address');
            $table->Date('TGL-Lahir');
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->string('qr_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};