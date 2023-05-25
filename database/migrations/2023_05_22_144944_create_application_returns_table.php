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
        Schema::create('application_returns', function (Blueprint $table) {
            $table->id();
            $table->json('key_id');
            $table->integer('employee_id');
            $table->integer('user_id');
            $table->integer('purchase_id');
            $table->timestamp('application_date');
            $table->string('status')->default('Ожидание');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_returns');
    }
};
