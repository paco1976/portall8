<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion_Whatsapp extends Model
{
    protected $table ='publicacion_whatsapp';

    protected $fillable = [
        'publicacion_id', 'celular',
    ];

    public function publicacion() {
        return $this->belongsTo('App\Models\Publicacion');
    }
    
}
