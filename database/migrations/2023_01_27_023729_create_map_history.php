<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('map_histories', function (Blueprint $table) {
            $table->id();
            $table->text('humidity');
            $table->text('alerts')->nullable();
            $table->text('weather');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id');
            $table->timestamps();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
