<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyProfessionals extends Model
{
    protected $table = 'survey_professionals';
    use HasFactory;

    protected $fillable = ['client_survey_id', 'hash', 'phone_number', 'date_completed', 'responses', 'contacted'];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'client_survey_id');
    }
}
