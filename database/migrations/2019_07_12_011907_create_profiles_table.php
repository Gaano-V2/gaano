<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('avatar')->nullable();
            $table->string('fname')->length(150);
            $table->string('mname')->length(150)->nullable();
            $table->string('lname')->length(150);
            $table->integer('gender')->length(2);
            $table->string('bday')->length(15);
            $table->string('phone')->length(12)->unique();
            $table->index('user_id');
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
        Schema::dropIfExists('profiles');
    }
}
