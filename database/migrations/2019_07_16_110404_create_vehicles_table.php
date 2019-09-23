<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image');
            $table->string('brand')->length(150);
            $table->string('name')->length(150);
            $table->integer('seats')->length(3);
            $table->decimal('d_price', 13, 2);
            $table->decimal('w_price', 13, 2);
            $table->decimal('m_price', 13, 2);
            $table->integer('gas')->length(2);
            $table->integer('transmission')->length(2);
            $table->timestamps();
            $table->index('brand');
            $table->index('name');
            $table->index('seats');
            $table->index('d_price');
            $table->index('w_price');
            $table->index('m_price');
            $table->index('gas');
            $table->index('transmission');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
