<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeSurveyIdColNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chatbot', function (Blueprint $table) {
            $table->dropForeign(['survey_id']);
        });

        Schema::table('chatbot', function (Blueprint $table) {
            $table->dropColumn('survey_id');
        });

        Schema::table('chatbot', function (Blueprint $table) {
            $table->unsignedBigInteger('survey_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chatbot', function (Blueprint $table) {
            $table->dropColumn('survey_id');
        });

        Schema::table('chatbot', function (Blueprint $table) {
            $table->unsignedBigInteger('survey_id');
            $table->foreign('survey_id')->references('id')->on('surveys')->onDelete('cascade');
        });
    }
}
