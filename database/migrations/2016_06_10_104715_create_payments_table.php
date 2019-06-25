<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ad_id')->unsigned()->nullable()->index('ad_id');
            $table->integer('pack_id')->unsigned()->nullable()->index('pack_id');
            $table->integer('payment_method_id')->unsigned()->nullable()->default(0)->index('payment_method_id');
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
        Schema::drop('payments');
    }
}
