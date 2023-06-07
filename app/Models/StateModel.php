<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class StateModel  extends Model
{
    use Notifiable;
    protected $table ='states';

    protected $fillable = [
        'name', 'created_at', 'update_at'
    ];

    // public function stateIsIn() {
    //     return $this->hasmany(ToolModel::Class, 'state_id', 'id');
    // }

}
