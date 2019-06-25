<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code', 2)->default('')->index('country_code');
            $table->integer('user_id')->unsigned()->nullable()->index('user_id');
            $table->integer('category_id')->unsigned()->index('category_id');
            $table->integer('ad_type_id')->unsigned()->nullable()->index('ad_type_id');
            $table->string('title')->default('')->index('title');
            $table->text('description', 65535);
            $table->float('price', 10, 0)->nullable();
            $table->boolean('negotiable')->nullable()->default(0);
            $table->string('resume', 200)->nullable();
            $table->boolean('new')->nullable()->default(0);
            $table->string('brand', 100)->nullable();
            $table->string('seller_name', 200)->default('')->index('seller_name');
            $table->string('seller_email', 100)->default('');
            $table->string('seller_phone', 50)->nullable();
            $table->boolean('seller_phone_hidden')->nullable()->default(0);
            $table->string('address', 255)->nullable()->index('address');
            $table->integer('city_id')->unsigned()->index('city_id');
            $table->float('lat', 10, 0)->nullable()->default(0);
            $table->float('lon', 10, 0)->nullable()->default(0);
            $table->integer('pack_id')->unsigned()->nullable();
            $table->string('ip_addr', 50)->nullable();
            $table->integer('visits')->unsigned()->nullable()->default(0);
            $table->string('activation_token', 32)->nullable();
            $table->boolean('active')->nullable()->default(0)->index('active');
            $table->boolean('reviewed')->nullable()->default(0)->index('reviewed');
            $table->boolean('archived')->nullable()->default(0);
            $table->string('fb_profile')->nullable();
            $table->string('partner', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['lat', 'lon'], 'lat');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ads');
    }
}
