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
            $table->timestamp('date_sent')->nullable();
            $table->timestamp('date_completed')->nullable();
            $table->boolean('job_done')->nullable();
            $table->string('agreement_evaluation')->nullable();
            $table->text('evaluation_reason')->nullable(); //comment
            $table->boolean('time_evaluation')->nullable();
            $table->boolean('pricing_evaluation')->nullable();
            $table->text('adjustments')->nullable(); //comment
            $table->boolean('client_satisfaction')->nullable();
            $table->text('client_satisfaction_comments')->nullable(); // comment
            $table->string('client_interaction')->nullable(); //options, muy bueno, bueno, malo
            $table->text('client_interaction_comments')->nullable(); // comment
            $table->text('additional_comments')->nullable(); // comment
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
