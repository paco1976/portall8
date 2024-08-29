<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobNotCompletedOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_not_completed_options', function (Blueprint $table) {
            $table->id();
            $table->string('option');
            $table->timestamps();
        });
        $options = [
            ['option' => 'El cliente no respondió mis mensajes'],
            ['option' => 'Dejé de responder los mensajes'],
            ['option' => 'No pudimos ponernos de acuerdo'],

        ];

        DB::table('job_not_completed_options')->insert($options);

        Schema::table('survey_professionals', function (Blueprint $table) {
            $table->foreignId('job_not_completed_option_id')->nullable()->constrained('job_not_completed_options');
        });
    }

    public function down()
    {
        Schema::table('survey_professionals', function (Blueprint $table) {
            $table->dropForeign(['job_not_completed_option_id']);
            $table->dropColumn('job_not_completed_option_id');
        });

        Schema::dropIfExists('job_not_completed_options');
    }
}
