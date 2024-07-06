<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::create('tbl_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255)->unique();
            $table->string('imageProfile')->nullable();
            $table->string('phone',15)->nullable();
            $table->text('address')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('qr_code', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('tbl_users')->onDelete('cascade')->onUpdate('cascade');
        });
     
    }


    public function down()
    {

        DB::unprepared('DROP TRIGGER IF EXISTS after_user_created');
    }
};