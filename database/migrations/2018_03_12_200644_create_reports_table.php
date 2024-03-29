<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('opening_user_id')->unsigned();
            $table->integer('closing_user_id')->unsigned()->nullable();
            $table->integer('station_id')->unsigned();
            $table->string('type');
            $table->string('desc');
            $table->boolean('status')->default(0);
            $table->string('picture')->default('no_pic.png');
            $table->string('comment', 255)->nullable();
            $table->timestamps();
            $table->foreign('opening_user_id')->references('id')->on('users');
            $table->foreign('closing_user_id')->references('id')->on('users');
            $table->foreign('station_id')->references('id')->on('stations');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
