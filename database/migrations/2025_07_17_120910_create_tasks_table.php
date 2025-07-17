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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('pool_id');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->foreign('pool_id')->references('id')->on('pools')->onDelete('cascade');
            $table->string('title');
            $table->boolean('processed')->default(0);
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
        Schema::dropIfExists('tasks');
    }
};
