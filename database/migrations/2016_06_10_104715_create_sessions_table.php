<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id', 11)->default('')->primary();
            $table->text('payload', 65535)->nullable();
            $table->integer('last_activity')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('ip_address', 250)->nullable()->default('');
            $table->text('user_agent', 65535);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sessions');
    }
}
