<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User_Cfp extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

     /* es para especificar la tabla donde están los cfp */
    protected $table ='user_cfp';

    protected $fillable = [
        'name', 'email',
    ];

    public function users(){
        return $this->hasMany('App\Models\User');
    }
    
}
