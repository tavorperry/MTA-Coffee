<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateWalletTransactionsTable extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up()
        {
            Schema::create('wallet_transactions',function (Blueprint $table) {
                $table->increments('id');
                $table->integer('wallet_id')->unsigned()->index();
                $table->integer("credit_card_transaction")->unsigned()->nullable();
                $table->string('transaction_type')->index();
                $table->double("amount");
                $table->double("new_balance");
                $table->integer("station_id")->unsigned()->nullable();
                $table->string('comment','255')->nullable();
                $table->timestamps();
                $table->foreign('credit_card_transaction')->references('id')->on('credit_card_transactions')->onDelete('cascade');
                $table->foreign('wallet_id')->references('id')->on('users_wallets')->onDelete('cascade');
                $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');
            });
        }
        /**
         * Reverse the migrations.
         */
        public function down()
        {
            Schema::drop('wallet_transactions');
        }
    }