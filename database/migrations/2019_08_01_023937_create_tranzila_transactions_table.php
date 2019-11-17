<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranzilaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tranzila_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned();
            $table->string('sum')->nullable();
            $table->string('currency')->nullable();
            $table->string('ccno')->nullable();
            $table->string('thtk')->nullable();
            $table->boolean('used')->default(false);
            $table->timestamps();
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tranzila_transactions');
    }
}
