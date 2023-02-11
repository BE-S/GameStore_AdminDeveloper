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
        Schema::create('game_covers', function (Blueprint $table) {
            $table->id();
            $table->integer('game_id')->unique();
            $table->string('main')->nullable();
            $table->string('small')->nullable();
            $table->string('store_header_image')->nullable();
            $table->json('screen')->nullable();
            $table->string('background_image')->nullable();
            $table->string('job_hash')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_covers');
    }
};
