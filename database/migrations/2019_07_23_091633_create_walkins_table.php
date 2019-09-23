<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalkinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walkins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reservation_id')->unique();
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('cascade');
            $table->string('email')->length(150);
            $table->string('fname')->length(150);
            $table->string('mname')->length(150)->nullable();
            $table->string('lname')->length(150);
            $table->integer('gender')->length(2);
            $table->string('bday')->length(15);
            $table->string('phone')->length(12);
            $table->string('government_id')->nullable();
            $table->string('license')->nullable();
            $table->index('id');
            $table->index('email');
            $table->index('fname');
            $table->index('mname');
            $table->index('lname');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('walkins');
    }
}
