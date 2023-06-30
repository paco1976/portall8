<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'user_id',
        'client_name',
        'client_cellphone',
        'client_email',
        'contacted',
        'accepts_survey',
        'service_provided',
        'satisfaction',
        'descriptive_words',
        'review',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}