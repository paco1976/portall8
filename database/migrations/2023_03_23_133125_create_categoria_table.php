<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('name', '200');
            $table->string('icon', '400');
            $table->Integer('categoria_tipo_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('categoria_tipo_id')->references('id')->on('categoria_tipo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoria');
    }
}
