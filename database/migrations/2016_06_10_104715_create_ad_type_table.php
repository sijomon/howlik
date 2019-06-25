<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('translation_lang', 10)->nullable()->index('translation_lang');
            $table->integer('translation_of')->unsigned()->nullable()->index('translation_of');
            $table->string('name', 100)->default('');
            $table->boolean('active')->nullable()->default(1);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ad_type');
    }
}
