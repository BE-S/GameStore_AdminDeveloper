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
        Schema::table("purchased_games", function (Blueprint $table) {
            $table->renameColumn("game_id", "order_id");
            $table->dropColumn("discount");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("purchased_games", function (Blueprint $table) {
            $table->renameColumn("order_id", "game_id");
            $table->integer('discount')->nullable();
        });
    }
};
