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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('pool_id');
            $table->foreign('pool_id')->references('id')->on('pools')->onDelete('cascade');
            $table->unsignedBigInteger('pool_water_status_id');
            $table->foreign('pool_water_status_id')->references('id')->on('pool_water_statuses')->onDelete('cascade');
            $table->double('hardness');
            $table->double('chlorine');
            $table->double('free_chlorine');
            $table->double('ph');
            $table->double('alkalinity');
            $table->double('stabilizer');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('tests');
    }
};
