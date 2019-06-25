<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->integer('id')->unsigned()->default(0)->primary();
            $table->string('country_code', 2)->default('')->index('country_code');
            $table->string('name', 200)->default('')->index('name');
            $table->string('asciiname', 200)->nullable();
            $table->float('latitude', 10, 0)->nullable();
            $table->float('longitude', 10, 0)->nullable();
            $table->char('feature_class', 1)->nullable();
            $table->string('feature_code', 10)->nullable();
            $table->string('subadmin1_code', 80)->nullable();
            $table->string('subadmin2_code', 20)->nullable();
            $table->bigInteger('population')->nullable();
            $table->string('time_zone', 100)->nullable();
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
        Schema::drop('cities');
    }
}
