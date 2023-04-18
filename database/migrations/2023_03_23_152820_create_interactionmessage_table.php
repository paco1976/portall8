<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionmessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactionmessage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('head_id')->unsigned();
            $table->datetime('date')->nullable();
            $table->string('message')->nullable();
            $table->boolean('is_reply')->nullable();
            $table->timestamps();
            $table->foreign('head_id')->references('id')->on('interactionhead');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interactionmessage');
    }
}
