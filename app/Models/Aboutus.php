<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Aboutu
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $active
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Aboutus extends Model
{
    protected $table ='aboutus';  

    static $rules = [
		'title' => 'required',
		'description' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title','description','active'];



}
