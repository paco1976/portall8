<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publicacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', '2000');
            $table->Integer('titulo_id')->unsigned();
            $table->Integer('categoria_id')->unsigned();
            $table->Integer('view')->unsigned();
            $table->boolean('aprobado')->default(FALSE);
            $table->boolean('active')->default(TRUE);
            $table->timestamps();
            $table->foreign('titulo_id')->references('id')->on('titulo');
            $table->foreign('categoria_id')->references('id')->on('categoria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publicacion');
    }
}
