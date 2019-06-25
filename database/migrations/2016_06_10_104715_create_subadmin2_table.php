<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubadmin2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subadmin2', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 20)->default('')->unique('code');
            $table->string('name', 200)->nullable()->index('name');
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
        Schema::drop('subadmin2');
    }
}
