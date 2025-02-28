<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_games', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("game_id");
            $table->float("amount_payment");
            $table->integer('discount')->nullable();
            $table->json('key_id');
            $table->integer('merchant_order_id');
            $table->integer('int_id');
            $table->integer('cur_id');
            $table->string('sign');
            $table->timestamps();
            $table->timestamp("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchased_games');
    }
};
