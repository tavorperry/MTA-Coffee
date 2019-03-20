<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditCardTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_card_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user')->unsigned();
            $table->string('DealNumber')->nullable();
            $table->string('Code')->nullable();
            $table->string('ErrorDesc')->nullable();
            $table->string('TotalSum')->nullable();
            $table->string('AuthNum')->nullable();
            $table->string('CardNumber')->nullable();
            $table->string('PayDate')->nullable();
            $table->string('Terminal')->nullable();
            $table->string('DealID')->nullable();
            $table->string('DealType')->nullable();
            $table->string('DealTypeOut')->nullable();
            $table->string('OkNumber')->nullable();
            $table->string('DealDate')->nullable();
            $table->string('CardName')->nullable();
            $table->string('CardNameID')->nullable();
            $table->string('ManpikID')->nullable();
            $table->string('MutagID')->nullable();
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
        Schema::dropIfExists('credit_card_transactions');
    }
}
