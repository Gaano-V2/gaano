<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('vehicle_id');
            $table->string('start_date')->length(15);
            $table->string('end_date')->length(15);
            $table->string('time')->length(7);
            $table->integer('status')->default(0)->length(3);
            $table->longText('message')->nullable();
            $table->decimal('total', 13, 2)->nullable();
            $table->boolean('is_walkin');
            $table->timestamps();
            $table->index('id');
            $table->index('user_id');
            $table->index('vehicle_id');
            $table->index('start_date');
            $table->index('end_date');
            $table->index('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
