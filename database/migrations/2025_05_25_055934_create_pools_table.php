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
        Schema::create('pools', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->unsignedBigInteger('media_id');
            $table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade');
            $table->unsignedBigInteger('siding_id');
            $table->foreign('siding_id')->references('id')->on('sidings')->onDelete('cascade');
            $table->string('name');
            $table->string('size');
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
        Schema::dropIfExists('pools');
    }
};
