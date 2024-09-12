<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Notifiable;


class Publicacion extends Model
{
    
    
    protected $table ='publicacion';

    protected $fillable = [
        'description', 'titulo_id', 'categoria_id', 'view', 'aprobado', 'hash','active',
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'publicacion_user');
        //->withTimestamps();
    }

    public function user_publicacion(){
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }

    public function user(){
        return $this->belongsToMany('App\Models\User', 'publicacion_user')->withTimestamps();
    }

    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');
    }
    public function titulo(){
        return $this->belongsTo('App\Models\Titulo');
    }

    //el profile pertenece a
    public function imagenes() {
        return $this->hasmany('App\Models\Publicacion_image');
    }

    public function interactions() {
        return $this->hasmany('App\Models\Interactionhead', 'publicacion_id');
    }

    public function consultas() {
        return $this->hasmany('App\Models\Interactionhead', 'publicacion_id');
    }

    public function titulos_asociados(){
        return $this->belongsToMany('App\Models\Titulo')->withTimestamps();
        //->withPivot('estado');
        //->withTimestamps();
    }

    public function hasTitulo($titulo){   
        if ($this->titulos_asociados()->where('name', $titulo->name)->first()) {
            return true;
        }
        return false;
    }

    public function whatsapp(){
        return $this->hasmany('App\Models\Publicacion_Whatsapp', 'publicacion_id');
    }

    public function visita(){
        return $this->hasmany('App\Models\Publicacion_Visita', 'publicacion_id');
    }

    public function scopeBuscador($query, $description)
    {
        return $query->where('description', 'like', "%$description%")->where('aprobado', 1)->where('active', 1);
    }

    public function scopeBuscador_admin($query, $description)
    {
        return $query->where('description', 'like', "%$description%")->where('active', 1);
    }

    public function surveys() {
        return $this->hasmany('App\Models\Survey', 'publicacion_id', 'id');
    }

    public function rating()
    {
        return round($this->surveys()->avg('satisfaction'), 1);
    }

    public function getClientsRegistered()
    {
        return $this->surveys()->count();
    }
    
    public function surveys_sent()
    {
        return $this->surveys()->where('contacted', true)->count();
    }
    public function surveys_accepted()
    {
        return $this->surveys()->where('accepts_survey', true)->count();
    }
   
    public function most_used_positive_words()
    {

        $allWords = $this->surveys->pluck('descriptive_words')->filter()->flatten()->values();

        $wordCount = $allWords->countBy();

        $sortedWords = $wordCount->sortDesc();

        $topThreeWords = $sortedWords->take(3)->keys()->toArray();
        
        $topThreeWords = array_map(function ($word) {
            return str_replace('_', ' ', $word);
        }, $topThreeWords);

        return $topThreeWords;

    }

    public function most_used_negative_words()
    {

        $allWords = $this->surveys->pluck('no_agreement')->filter()->flatten()->values();

        $wordCount = $allWords->countBy();

        $sortedWords = $wordCount->sortDesc();

        $topThreeWords = $sortedWords->take(3)->keys()->toArray();
        
        $topThreeWords = array_map(function ($word) {
            return str_replace('_', ' ', $word);
        }, $topThreeWords);

        return $topThreeWords;

    }
}
