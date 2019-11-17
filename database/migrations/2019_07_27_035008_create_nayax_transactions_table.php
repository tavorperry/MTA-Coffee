<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNayaxTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nayax_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transactionId');
            $table->integer('userId')->unsigned();
            $table->boolean('used');
            $table->timestamps();
            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nayax_transactions');
    }
}
