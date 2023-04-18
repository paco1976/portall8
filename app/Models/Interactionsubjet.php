<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Interactionsubjet extends Model
{
    use Notifiable;
    protected $table ='interactionsubjet';

    protected $fillable = [
        'name'
    ];

    public function head() {
        return $this->hasmany('App\Models\Interactionhead');
    }

}
