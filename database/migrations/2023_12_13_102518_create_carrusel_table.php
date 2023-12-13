<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarruselTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrusel', function (Blueprint $table) {
            $table->id();
            $table->string('text1', '40')->nullable();
            $table->string('text2', '40')->nullable();
            $table->string('image', '200')->nullable();
            $table->boolean('active')->default(TRUE)->nullable();
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
        Schema::dropIfExists('carrusel');
    }
}
