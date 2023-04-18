<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Interactionhead extends Model
{
    use Notifiable;
    protected $table ='interactionhead';

    protected $fillable = [
       'publicacion_id', 'subjet_id', 'date', 'name', 'last_name', 'email', 'mobile', 'hash',
    ];

    public function messages() {
        return $this->hasmany('App\Models\Interactionmessage','head_id');
    }

    public function subjet(){
        return $this->belongsTo('App\Models\Interactionsubjet');
    }

    public function publicaciones(){
        return $this->belongsTo('App\Models\Publicacion');
    }

    public function mensajes() {
        return $this->hasmany('App\Models\Interactionmessage','head_id');
    }
}
