<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('translation_lang', 10)->nullable()->index('translation_lang');
            $table->integer('translation_of')->unsigned()->nullable()->index('translation_of');
            $table->enum('type', array('page', 'term', 'help'))->nullable()->index('type');
            $table->integer('parent_id')->unsigned()->nullable()->index('parent_id');
            $table->string('title', 200)->nullable();
            $table->string('slug', 100)->nullable();
            $table->text('content', 65535)->nullable();
            $table->integer('lft')->unsigned()->nullable();
            $table->integer('rgt')->unsigned()->nullable();
            $table->integer('depth')->unsigned()->nullable();
            $table->boolean('active')->nullable()->default(1);
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
        Schema::drop('pages');
    }
}
