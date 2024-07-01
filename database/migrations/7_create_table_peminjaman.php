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
            $table->string('resi_pjmn')->unique()->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('book_id')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Menambahkan foreign key constraint
            $table->foreign('member_id')->references('id')->on('tbl_members')->onDelete('cascade');
            $table->foreign('book_id')->references('id')->on('tbl_books')->onDelete('cascade');
        });
    }
 
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_peminjaman');
    }
};