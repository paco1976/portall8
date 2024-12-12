<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSurveyProfsIdToChatbotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chatbot', function (Blueprint $table) {
            $table->unsignedBigInteger('survey_profs_id')->nullable();
            $table->foreign('survey_profs_id')->references('id')->on('survey_professionals')->onDelete('cascade');
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
            $table->dropForeign(['survey_profs_id']);
            $table->dropColumn('survey_profs_id');
        });
    }
}
