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
        Schema::create('roles',function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('ranks',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->integer('order');
            $table->timestamps();
        });

        Schema::create('cities',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('districts',function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username');
            $table->string('image_url')->default('user_avatar.png');
            $table->string('main_image')->default('background-cement-concrete-242236.jpg');
            $table->string('email')->unique();
            $table->text('about')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->integer('role_id')->unsigned()->nullable();
            $table->integer('rank_id')->unsigned()->nullable();
            $table->integer('location')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('rank_id')->references('id')->on('ranks');
            $table->foreign('location')->references('id')->on('cities');
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
        Schema::dropIfExists('roles');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('ranks');
    }
}
