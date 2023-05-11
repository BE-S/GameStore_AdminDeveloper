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
        Schema::table('recommended_genres', function (Blueprint $table) {
            $table->renameColumn('category_id', 'genre_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recommended_genres', function (Blueprint $table) {
            $table->renameColumn('genre_id', 'category_id');
        });
    }
};
