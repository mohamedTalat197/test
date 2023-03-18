<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->string('dateOfBirth')->nullable();
            $table->smallInteger('status')->default(0)->nullable();
            $table->integer('active_code')->nullable();
            $table->integer('password_code')->nullable();
            $table->smallInteger('gender')->default(0)->nullable();
            $table->string('lang',10)->nullable();
            $table->text('fire_base')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
