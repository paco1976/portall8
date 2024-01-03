<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Logo
 *
 * @property $id
 * @property $image
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Logo extends Model
{
    protected $table ='logo';

    static $rules = [
		'image' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['image'];



}
