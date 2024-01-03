<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Carrusel
 *
 * @property $id
 * @property $text1
 * @property $text2
 * @property $image
 * @property $active
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Carrusel extends Model
{
    
    protected $table ='carrusel'; 

    static $rules = [
        'image'=> 'required',
        'active'=> 'required'
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['text1','text2', 'link','image','active'];



}
