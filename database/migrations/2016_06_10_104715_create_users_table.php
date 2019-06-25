<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->increments('id');
            $table->string('country_code', 2)->nullable()->index('country_code');
            $table->integer('user_type_id')->unsigned()->nullable()->index('user_type_id');
            $table->integer('gender_id')->unsigned()->nullable()->index('gender_id');
            $table->string('name', 100)->nullable();
            $table->string('about')->nullable();
            $table->string('phone', 60)->nullable();
            $table->boolean('phone_hidden')->nullable()->default(0);
            $table->string('email', 100)->nullable();
            $table->string('password', 60)->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->boolean('is_admin')->nullable()->default(0);
            $table->boolean('comments_enabled')->nullable()->default(0);
            $table->boolean('receive_newsletter')->nullable()->default(1);
            $table->boolean('receive_advice')->nullable()->default(1);
            $table->string('ip_addr', 50)->nullable();
            $table->string('provider', 50)->nullable();
            $table->integer('provider_id')->unsigned()->nullable();
            $table->string('activation_token', 32)->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->boolean('blocked')->nullable()->default(0);
            $table->boolean('closed')->nullable()->default(0);
            $table->dateTime('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
