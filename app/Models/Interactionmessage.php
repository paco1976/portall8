<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class Interactionmessage extends Model
{
    use Notifiable;
    
    protected $table ='interactionmessage';

    protected $fillable = [
        'head_id', 'date', 'message', 'read', 'is_reply', 'hash',
    ];

    public function head(){
        return $this->belongsTo('App\Interactionhead');
    }

    public function imagenes() {
        return $this->hasmany('App\Interactionimage', 'message_id');
    }
}
