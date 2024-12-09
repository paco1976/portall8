<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyProfessionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_professionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_survey_id');
            $table->foreign('client_survey_id')->references('id')->on('surveys')->onDelete('cascade');
            $table->string('hash')->unique();
            $table->string('phone_number');
            $table->timestamp('date_completed')->nullable();            
            $table->json('responses')->nullable();
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
        Schema::dropIfExists('survey_professionals');
    }
}
