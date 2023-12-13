<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Link
 *
 * @property $id
 * @property $name
 * @property $description
 * @property $link
 * @property $active
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Link extends Model
{
    protected $table ='links';
    
    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','description','link','active'];



}
