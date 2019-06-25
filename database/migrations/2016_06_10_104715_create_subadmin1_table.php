<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubadmin1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subadmin1', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->default('')->unique('code');
            $table->string('name', 200)->default('')->index('name');
            $table->string('asciiname', 200)->nullable();
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
        Schema::drop('subadmin1');
    }
}
