<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interactionimage extends Model
{
    protected $table ='interactionimage';

    protected $fillable = [
        'message_id', 'name', 'extension', 'size', 'url',
    ];

    public function message(){
        return $this->belongsTo('App\Models\Interactionmessage');
    }
}
