<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateUsersWalletsTable extends Migration
    {
        /**
         * Run the migrations.
         */
        public function up()
        {
            Schema::create('users_wallets', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unsigned()->index();
                $table->double("balance");
                $table->timestamps();
                $table->foreign('user_id') ->references('id')->on('users')->onDelete('cascade');
            });
        }
        /**
         * Reverse the migrations.
         */
        public function down()
        {
            Schema::dropIfExists('users-wallets');
        }
    }
