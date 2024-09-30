<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptiveWordsProfAndNegativeWordsToSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->json('descriptive_words_prof')->nullable()->after('descriptive_words');
            $table->json('negative_words')->nullable()->after('descriptive_words_prof');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('descriptive_words_prof');
            $table->dropColumn('negative_words');
        });
    }
}
