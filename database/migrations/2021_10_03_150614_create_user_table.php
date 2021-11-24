<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('email',100);
            $table->string('name',200);
            $table->string('password');
            $table->integer('phone')->nullable();
            $table->string('address',200)->nullable();
            $table->string('avatar')->nullable();
            $table->tinyinteger('role')->default(0);
            $table->string('otp')->nullable();
            $table->string('remember_token',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
