<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactedToSurveyProfessionalsTable extends Migration
{
    public function up()
    {
        Schema::table('survey_professionals', function (Blueprint $table) {
            $table->boolean('contacted')->default(false);
        });
    }

    public function down()
    {
        Schema::table('survey_professionals', function (Blueprint $table) {
            $table->dropColumn('contacted');
        });
    }
}
