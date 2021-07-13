<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->unsignedBigInteger('fk_user_reservation');
            $table->unsignedBigInteger('fk_book_reservation');
            $table->string('date_reservation');
            $table->string('date_devolution');
            $table->foreign('fk_user_reservation')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('fk_book_reservation')->references('id')->on('books')->onDelete('cascade');;
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
        Schema::dropIfExists('reservations');
    }
}
