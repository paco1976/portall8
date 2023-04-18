<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicacionImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicacion_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('publicacion_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('extension')->nullable();
            $table->bigInteger('size')->nullable();
            $table->string('url');
            $table->timestamps();

            $table->foreign('publicacion_id')->references('id')->on('publicacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publicacion_image');
    }
}
