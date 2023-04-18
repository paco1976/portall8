<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table ='categoria';

    protected $fillable = [
        'name', 'icon', 'categoria_tipo_id','active',
    ];
    

    public function publicaciones(){
        $publicaciones = $this->hasMany('App\Models\Publicacion');
        //dd($profiles);
        //dd($publicaciones);
        return $publicaciones;
    }

    public function categoria_tipo(){
        return $this->belongsTo('App\Models\categoria_tipo');
    }

    public function categorias(){
        return $this->belongsToMany('App\Models\Categoria');
    }
    public function tipo($id)
    {   
        $categoria_tipo =  Categoria_Tipo::where('id', $id)->first();
        //dd($propuesta);
        return $categoria_tipo->name;
    }

    public function estado($id)
    {   
        $categoria =  categoria::where('id', $id)->first();
        if($categoria->active == true){
            return "Activa";
        }else{
            return "Desactivada";
        }
    }

    public function scopeBuscador($query, $description)
    {
        return $query->where('name', 'like', "%$description%")->where('active', 1);
    }
}
