<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Profile extends Model
{
    /* es para especificar la tabla donde están los cfp */
    protected $table ='user_profile';

    protected $fillable = [
        'user_id', 'mobile', 'phone', 'twitter', 'facebook', 'instagram', 'linkedin',
    ];

    //el profile pertenece a
    public function users() {
        return $this->belongsTo('App\Models\User');
    }

    public function getUser()
    {
        return $this->user;
    }
    
}
