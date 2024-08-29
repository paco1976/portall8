<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyProfessionals extends Model
{
    protected $table = 'survey_professionals';
    use HasFactory;

    protected $fillable = [
        'client_survey_id',
        'hash',
        'phone_number',
        'job_done',
        'agreement_evaluation',
        'evaluation_reason',
        'time_evaluation',
        'pricing_evaluation',
        'adjustments',
        'client_satisfaction',
        'client_satisfaction_comments',
        'client_interaction',
        'client_interaction_comments',
        'additional_comments',
        'disagreement_option_id',
        'disagreement_comments',
        'job_not_completed_option_id',

        'date_sent',//x
        'date_completed',
        'wa_id',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'client_survey_id');
    }
}
