<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chatbot extends Model
{
    protected $table = 'chatbot';

    protected $fillable = [
        'survey_id',
        'message_received',
        'message_sent',
        'id_wa',
        'timestamp_wa',
        'phone'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }
}
