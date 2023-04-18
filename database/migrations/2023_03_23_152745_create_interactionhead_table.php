<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionheadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactionhead', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('publicacion_id')->unsigned();
            $table->bigInteger('subjet_id')->unsigned();
            $table->datetime('date')->nullable();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email', 400)->nullable();
            $table->string('mobile', 100)->nullable();
            $table->string('hash')->nullable();
            $table->timestamps();

            $table->foreign('publicacion_id')->references('id')->on('publicacion');
            $table->foreign('subjet_id')->references('id')->on('interactionsubjet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interactionhead');
    }
}
