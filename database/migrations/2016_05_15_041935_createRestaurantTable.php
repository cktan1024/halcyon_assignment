<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('restaurants')){
            Schema::create('restaurants', function (Blueprint $table) {
                $table->increments('restaurant_id');
                $table->string('name');
                $table->string('description');
                $table->integer('category_id');
                $table->string('lat');
                $table->string('lng');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            if(Schema::hasTable('restaurants')){
                Schema::drop('restaurants');
            }
                
    }
}
