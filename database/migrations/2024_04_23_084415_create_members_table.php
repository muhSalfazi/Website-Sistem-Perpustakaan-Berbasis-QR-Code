<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tbl_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nim');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('email', 255)->unique();
            $table->string('phone', 20);
            $table->string('password');
            $table->text('address');
            $table->date('date_of_birth');
            $table->datetime('last_login')->nullable(   );
            $table->string('qr_code', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_members');
    }
};