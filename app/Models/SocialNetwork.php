<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialNetwork
 *
 * @property $id
 * @property $name
 * @property $link
 * @property $active
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SocialNetwork extends Model
{
    protected $table ='social_networks';

    static $rules = [
        'name'=> 'required',
        'link'=> 'required',
        'active'=> 'required'
    ];

    
    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','link','active'];



}
