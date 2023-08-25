<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Categoria_Tipo extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table ='categoria_tipo';

    protected $fillable = [
        'name',
    ];

    public function categorias()
    {
        return $this->hasMany('App\Models\Categoria', 'categoria_tipo_id');
    }

}
