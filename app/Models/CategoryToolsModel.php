<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class CategoryToolsModel  extends Model
{
    use Notifiable;
    protected $table ='categorytools';

    protected $fillable = [
        'name', 'created_at', 'update_at'
    ];


}
