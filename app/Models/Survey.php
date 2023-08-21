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
        'no_agreement',
        'wa_id',
        'review',
    ];

    protected $casts = [
        'descriptive_words' => 'array',
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
        if($this->descriptive_words !== null){
            return array_map(function ($word) {
                return str_replace('_', ' ', $word);
            }, $this->descriptive_words);
        } else return [];
    }

    public function negativeWords()
    {        
        if($this->no_agreement !== null){
            return array_map(function ($word) {
                return str_replace('_', ' ', $word);
            }, $this->no_agreement);
        } else return [];
    }

}