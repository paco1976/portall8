<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'user_id',
        'publicacion_id',
        'client_name',
        'client_cellphone',
        'client_email',
        'contacted',
        'accepts_survey',
        'service_provided',
        'satisfaction',
        'descriptive_words',
        'descriptive_words_prof',
        'negative_words',
        'no_agreement',
        'wa_id',
        'review',
    ];

    protected $casts = [
        'descriptive_words' => 'array',
        'descriptive_words_prof' => 'array',  
        'negative_words' => 'array',
        'no_agreement' => 'array'
    ];
    
    public function chatbot()
    {
        return $this->hasMany(Chatbot::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }

    public function isRatingEmpty()
    {
        return empty($this->satisfaction);
    }
    public function isReviewEmpty()
    {
        return empty($this->review);
    }

    public function positiveWords()
    {        
        $descriptiveWords = $this->descriptive_words ?? [];
        $descriptiveWordsProf = $this->descriptive_words_prof ?? [];
    
        $allWords = array_merge($descriptiveWords, $descriptiveWordsProf);

        return array_map(function ($word) {
                return str_replace('_', ' ', $word);
        }, $allWords);
    }

    public function negativeWords()
    {        
        if($this->negative_words !== null){
            return array_map(function ($word) {
                return str_replace('_', ' ', $word);
            }, $this->negative_words);
        } else return [];
    }

    public function reasonNoAgree()
    {        
        if($this->no_agreement !== null){
            return array_map(function ($word) {
                return str_replace('_', ' ', $word);
            }, $this->no_agreement);
        } else return [];
    }

    public function professionalSurvey()
    {
        return $this->hasOne(SurveyProfessionals::class, 'client_survey_id', 'id');
    }

}