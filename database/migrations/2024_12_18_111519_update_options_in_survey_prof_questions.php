<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOptionsInSurveyProfQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('survey_prof_questions')
            ->whereIn('id', [4, 5, 7])
            ->update(['options' => json_encode(["Sí", "No"])]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you can reverse the changes if needed
        DB::table('survey_prof_questions')
            ->whereIn('id', [4, 5, 7])
            ->update(['options' => null]); // Set to null or original value
    }
}
