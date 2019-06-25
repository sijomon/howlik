<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('abbr', 10)->unique('abbr');
            $table->string('locale', 20)->nullable();
            $table->string('name', 100);
            $table->string('native', 20)->nullable();
            $table->string('flag', 100)->nullable();
            $table->string('app_name', 100);
            $table->string('script', 20)->nullable();
            $table->boolean('active')->default(1);
            $table->boolean('default')->default(0);
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
        Schema::drop('languages');
    }
}
