<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvertisingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertising', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug', 50)->default('');
            $table->string('provider_name', 100)->nullable();
            $table->text('tracking_code_large', 65535)->nullable();
            $table->text('tracking_code_medium', 65535)->nullable();
            $table->text('tracking_code_small', 65535)->nullable();
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
        Schema::drop('advertising');
    }
}
