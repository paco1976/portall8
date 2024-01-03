<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoriaTipo
 *
 * @property $id
 * @property $name
 * @property $icon
 * @property $active
 * @property $created_at
 * @property $updated_at
 *
 * @property Categorium[] $categorias
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class CategoriaTipo extends Model
{
    
    static $rules = [
		'name' => 'required',
    'keyword' => 'required',
		'active' => 'required',
    ];

    protected $table ='categoria_tipo';

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name','keyword','icon','active'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categorias()
    {
        return $this->hasMany('App\Models\Categoria', 'categoria_tipo_id');
    }
    

}
