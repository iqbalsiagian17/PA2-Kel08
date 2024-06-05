<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDonaturDonasiTable extends Migration
{
    public function up()
    {
        Schema::create('donatur_donasi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('donasi_id');
            $table->unsignedInteger('donatur_id');
            $table->timestamps();

            $table->foreign('donasi_id')->references('id')->on('donasi')->onDelete('cascade');
            $table->foreign('donatur_id')->references('id')->on('donatur')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('donatur_donasi');
    }
}
