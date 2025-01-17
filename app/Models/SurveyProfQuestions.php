<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyProfQuestions extends Model
{
    use HasFactory;

    protected $table = 'survey_prof_questions';

    protected $fillable = ['question_text', 'question_type', 'options', 'parent_question_id', 'condition', 'order'];

    protected $casts = [
        'options' => 'array', 
    ];
}
