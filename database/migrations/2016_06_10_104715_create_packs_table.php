<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('translation_lang', 10)->nullable();
            $table->integer('translation_of')->unsigned()->nullable();
            $table->string('name', 100)->nullable();
            $table->string('description')->nullable();
            $table->float('price', 10, 0)->unsigned()->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->integer('duration')->unsigned()->nullable()->default(30);
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->boolean('active')->nullable()->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('packs');
    }
}
