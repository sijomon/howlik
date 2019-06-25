<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->char('code', 2)->default('')->unique('code');
            $table->char('iso3', 3)->nullable();
            $table->integer('iso_numeric')->unsigned()->nullable();
            $table->char('fips', 2)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('asciiname', 100)->nullable();
            $table->string('capital', 100)->nullable();
            $table->integer('area')->unsigned()->nullable();
            $table->integer('population')->unsigned()->nullable();
            $table->char('continent_code', 4)->nullable();
            $table->char('tld', 4)->nullable();
            $table->string('currency_code', 3)->nullable();
            $table->string('phone', 10)->nullable();
            $table->string('postal_code_format', 50)->nullable();
            $table->string('postal_code_regex', 200)->nullable();
            $table->string('languages', 50)->nullable();
            $table->string('neighbours', 50)->nullable();
            $table->string('equivalent_fips_code', 100)->nullable();
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
        Schema::drop('countries');
    }
}
