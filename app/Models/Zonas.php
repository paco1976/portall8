<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;



class Zonas extends Model
{
    use Notifiable;
    protected $table ='zonas';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'name',
    ];
    
    public function users() {
        return $this->belongsToMany('App\Models\User');
    }

    public function todaslaszonas(){
        return $this->belongsToMany('App\Models\Zonas');
    }
    
}
