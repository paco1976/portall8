<?php

namespace App\Models;

use App\Models\Publicacion;
use App\Notifications\ResetPassword;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'dni',
        'avatar',
        'email',
        'password',
        'hash',
        'type_id',
        'cfp_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function user_profile()
    {
        return $this->hasMany('App\Models\User_Profile', 'user_id');
    }

    public function profile(){
        return $this->hasMany('App\Models\User_Profile', 'user_id');
    }
    
    public function user_cfp()
    {
        $user_cfp = $this->belongsTo('App\Models\User_Cfp', 'cfp_id');
        //dd($profiles);
        return $user_cfp;
    }

    public function cfp()
    {
        return $this->belongsTo('App\Models\User_Cfp');
    }

    public function user_type()
    {
        return $this->belongsTo('App\Models\User_type', 'type_id');
    }

    public function zonas()
    {
        return $this->belongsToMany('App\Models\Zonas');
    }

    public function hasZona($zon)
    {
        if ($this->zonas()->where('name', $zon->name)->first()) {
            return true;
        }
        return false;
    }

    public function publicaciones()
    {
        //return $this->hasMany('App\Publicacion');
        //morghToMany()
        return $this->belongsToMany('App\Models\Publicacion', 'publicacion_user');
    }

    public function headPrestamo() {
        return $this->hasmany('App\Models\Prestamo');
    }

    /*
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    */

    public function cfp_name($id)
    {
        $cfp = User_Cfp::where('id', $id)->first();
        //dd($propuesta);
        return $cfp->name;
    }

    public function scopeBuscador($query, $name)
    {
        return $query->where('name', 'like', "%$name%")->orwhere('last_name', 'like', "%$name%");
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function surveys_accepted()
    {
        return $this->surveys()->where('accepts_survey', true);
    }

    public function averageSatisfaction()
    {
        return round($this->surveys()->avg('satisfaction'), 1);
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

    public function routeNotificationForMail()
    {
        return $this->email;
    }
}