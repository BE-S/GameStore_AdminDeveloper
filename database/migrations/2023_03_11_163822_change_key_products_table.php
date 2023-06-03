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
            $table->integer("user_id")->nullable();
            $table->timestamp("reservation_at")->nullable();
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
           $table->dropColumn("user_id");
           $table->dropColumn("reservation_at");
        });
    }
};
