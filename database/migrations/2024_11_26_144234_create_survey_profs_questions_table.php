<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSurveyProfsQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_prof_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text');
            $table->enum('question_type', ['boolean', 'select', 'text', 'multiple-choice']);
            $table->json('options')->nullable();
            $table->unsignedBigInteger('parent_question_id')->nullable();
            $table->json('condition')->nullable();
            $table->unsignedInteger('order')->default(0);

            $table->foreign('parent_question_id')->references('id')->on('survey_prof_questions')->onDelete('cascade');
        });

        DB::table('survey_prof_questions')->insert([
            [
                'id' => 1,
                'question_text' => '¿Pudiste realizar el trabajo?',
                'question_type' => 'boolean',
                'options' => json_encode([
                'Sí',
                'No',
                ]),
                'parent_question_id' => null,
                'condition' => null,
                'order' => 1
            ],
            [
                'id' => 2,
                'question_text' => '¿Cómo evaluás el acuerdo?',
                'question_type' => 'select',
                'options' => json_encode([
                'Muy bueno',
                'Bueno',
                'Malo'
                ]),
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'Sí']),
                'order' => 2
            ],
            [
                'id' => 3,
                'question_text' => '¿Por qué?',
                'question_type' => 'text',
                'options' => null,
                'parent_question_id' => 2,
                'condition' => json_encode(['response' => 'Malo']),
                'order' => 3
            ],
            [
                'id' => 4,
                'question_text' => '¿Te llevó el tiempo que esperabas?',
                'question_type' => 'boolean',
                'options' => null,
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'Sí']),
                'order' => 4
            ],
            [
                'id' => 5,
                'question_text' => '¿Pudiste ponerle un precio acorde al tiempo y los costos que implicó su realización?',
                'question_type' => 'boolean',
                'options' => null,
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'Sí']),
                'order' => 5
            ],
            [
                'id' => 6,
                'question_text' => '¿Qué cosas ajustarías para el próximo trabajo?',
                'question_type' => 'text',
                'options' => null,
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'Sí']),
                'order' => 6
            ],
            [
                'id' => 7,
                'question_text' => '¿Crees que el cliente quedó conforme?',
                'question_type' => 'boolean',
                'options' => null,
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'Sí']),
                'order' => 7
            ],
            [
                'id' => 8,
                'question_text' => '¿Por qué?',
                'question_type' => 'text',
                'options' => null,
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'Sí']),
                'order' => 8
            ],
            [
                'id' => 9,
                'question_text' => '¿Qué te pareció el trato con el cliente?',
                'question_type' => 'select',
                'options' => json_encode([
                'Muy bueno',
                'Bueno',
                'Malo'
                ]),
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'Sí']),
                'order' => 9
            ],
            [
                'id' => 10,
                'question_text' => '¿Por qué?',
                'question_type' => 'text',
                'options' => null,
                'parent_question_id' => 9,
                'condition' => json_encode(['response' => 'Malo']),
                'order' => 10
            ],
            [
                'id' => 11,
                'question_text' => 'Otros comentarios que quieras dejarnos',
                'question_type' => 'text',
                'options' => null,
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'Sí']),
                'order' => 11
            ],
            [
                'id' => 12,
                'question_text' => '¿Por qué no realizaste el trabajo?',
                'question_type' => 'select',
                'options' => json_encode([
                'El cliente no respondió mis mensajes',
                'Dejé de responder los mensajes',
                'No pudimos ponernos de acuerdo'
                ]),
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'No']),
                'order' => 12
            ],
            [
                'id' => 13,
                'question_text' => '¿En qué?',
                'question_type' => 'multiple-choice',
                'options' => json_encode([
                    'En el día de visita',
                    'Me resultó muy lejos',
                    'En el presupuesto',
                    'No sé hacer el tipo de trabajo que me solicitaron',
                    'No tengo las herramientas para hacer el tipo de trabajo que me solicitaron',
                    'No tengo tiempo para realizar ese trabajo',
                ]),
                'parent_question_id' => 12,
                'condition' => json_encode(['response' => 'No pudimos ponernos de acuerdo']),
                'order' => 13
            ],
            [
                'id' => 14,
                'question_text' => 'Otra razón que quieras comentarnos…',
                'question_type' => 'text',       
                'options' => null,     
                'parent_question_id' => 12,
                'condition' => json_encode(['response' => 'No pudimos ponernos de acuerdo']),
                'order' => 14    
            ],
            [
                'id' => 15,
                'question_text' => 'Otros comentarios que quieras dejarnos',
                'question_type' => 'text',       
                'options' => null,     
                'parent_question_id' => 1,
                'condition' => json_encode(['response' => 'No']),
                'order' => 15    
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_prof_questions');
    }
}
