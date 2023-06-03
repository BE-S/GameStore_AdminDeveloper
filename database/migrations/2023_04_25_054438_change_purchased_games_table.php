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
            $table->dropColumn("order_id");
            $table->dropColumn("p_email");
            $table->dropColumn("p_phone");
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
            $table->integer("order_id");
            $table->string("p_email");
            $table->string("p_phone")->nullable();
        });
    }
};
