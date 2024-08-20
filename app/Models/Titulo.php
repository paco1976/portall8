<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * Class Titulo
 *
 * @property $id
 * @property $name
 * @property $description
 * @property $categoria_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Categorium $categorium
 * @property Publicacion[] $publicacions
 * @property PublicacionTitulo[] $publicacionTitulos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Titulo extends Model
{
    protected $table ='titulo';
    
    static $rules = [
		'name' => 'required',
		'description' => '',
		'categoria_id' => 'required',
    ];

    protected $fillable = [
        'name', 'description', 'categoria_id',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function categorium()
    {
        return $this->hasOne('App\Models\Categorium', 'id', 'categoria_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicacions()
    {
        return $this->hasMany('App\Models\Publicacion', 'titulo_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicacionTitulos()
    {
        return $this->hasMany('App\Models\PublicacionTitulo', 'titulo_id', 'id');
    }
    
    public function publicaciones(){
        return $this->hasMany('App\Models\Publicacion');
    }

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }

    public function categorias_asociadas() {
        return $this->belongsToMany('App\Models\Categoria')->withTimestamps();
        //->withPivot('estado');
        //->withTimestamps();
    }

}
