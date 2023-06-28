<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class LoanModel extends Model
{
    use Notifiable;
    protected $table ='loans';

    protected $fillable = [
        'id','loan_id', 'user_id', 'tool_id', 'dateInit', 'dateFinish', 'state_id', 'created_at', 'updated_at' 
    ];

    

    // public function users(){
    //     return $this->belongsTo('App\Models\User');
    // }

    // public function herramientas(){//tiene muchas
    //     return $this->belongsTo('App\Models\Tools');
    // }

    

}
