<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDisagreementOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('disagreement_options', function (Blueprint $table) {
            $table->id();
            $table->string('option');
            $table->timestamps();
        });

        $options = [
            ['option' => 'En el día de visita'],
            ['option' => 'Me resultó muy lejos'],
            ['option' => 'En el presupuesto'],
            ['option' => 'No sé hacer el tipo de trabajo que me solicitaron'],
            ['option' => 'No tengo las herramientas para hacer el tipo de trabajo que me solicitaron'],
            ['option' => 'No tengo tiempo para realizar ese trabajo'],
            ['option' => 'Otra'],
        ];

        DB::table('disagreement_options')->insert($options);

        Schema::table('survey_professionals', function (Blueprint $table) {
            $table->foreignId('disagreement_option_id')->nullable()->constrained('disagreement_options');
            $table->text('disagreement_comments')->nullable();
        });
    }

    public function down()
    {
        Schema::table('survey_professionals', function (Blueprint $table) {
            $table->dropForeign(['disagreement_option_id']);
            $table->dropColumn('disagreement_option_id');
            $table->dropColumn('disagreement_comments');
        });

        Schema::dropIfExists('disagreement_options');
    }
}
