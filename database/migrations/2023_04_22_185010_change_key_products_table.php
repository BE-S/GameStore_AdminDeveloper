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
        Schema::table("key_products", function (Blueprint $table) {
            $table->renameColumn("user_id", "order_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("key_products", function (Blueprint $table) {
            $table->renameColumn("order_id", "user_id");
        });
    }
};
