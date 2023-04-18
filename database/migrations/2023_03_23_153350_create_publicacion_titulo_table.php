<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicacionTituloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicacion_titulo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('publicacion_id')->unsigned();
            $table->Integer('titulo_id')->unsigned();
            $table->timestamps();
            $table->foreign('publicacion_id')->references('id')->on('publicacion');
            $table->foreign('titulo_id')->references('id')->on('titulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publicacion_titulo');
    }
}
