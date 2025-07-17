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
            $table->integer('user_id');

            $table->unsignedBigInteger('pool_id');
            $table->foreign('pool_id')->references('id')->on('pools')->onDelete('cascade');
            $table->unsignedBigInteger('pool_water_status_id');
            $table->foreign('pool_water_status_id')->references('id')->on('pool_water_statuses')->onDelete('cascade');

            $table->double('hardness_value');
            $table->string('hardness_code')->nullable();
            $table->string('hardness_status');

            $table->double('chlorine_value');
            $table->string('chlorine_code')->nullable();
            $table->string('chlorine_status');

            $table->double('free_chlorine_value');
            $table->string('free_chlorine_code')->nullable();
            $table->string('free_chlorine_status');

            $table->double('ph_value');
            $table->string('ph_code')->nullable();
            $table->string('ph_status');

            $table->double('alkalinity_value');
            $table->string('alkalinity_code')->nullable();
            $table->string('alkalinity_status');

            $table->double('stabilizer_value');
            $table->string('stabilizer_code')->nullable();
            $table->string('stabilizer_status');

            $table->string('image')->nullable();
            $table->json('action_items')->nullable();
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
