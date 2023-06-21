<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('client_name')->nullable();
            $table->string('client_cellphone');
            $table->string('client_email')->nullable();
            $table->boolean('contacted')->default(false);
            $table->boolean('service_provided')->default(false);
            $table->unsignedTinyInteger('satisfaction')->nullable();
            $table->json('descriptive_words')->nullable();
            $table->text('review')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surveys');
    }
}