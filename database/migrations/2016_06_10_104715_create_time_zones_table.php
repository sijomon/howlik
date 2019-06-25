<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimeZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_zones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code', 2)->default('')->unique('country_code');
            $table->string('time_zone_id', 40)->nullable()->default('');
            $table->float('gmt', 10, 0)->nullable();
            $table->float('dst', 10, 0)->nullable();
            $table->float('raw', 10, 0)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('time_zones');
    }
}
