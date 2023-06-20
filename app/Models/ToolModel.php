<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolModel extends Model
{
    protected $table ='tools';

    protected $fillable = [
        'categoryTool_id', 'name', 'description', 'nameImage', 'active', 'created_at', 'updated_at' 
    ];

    // public function headLoan() {//Tiene muchas
    //     return $this->hasmany('App\Models\Loans');
    // }

    // public function state() {//Pertenece a
    //     return $this->belongsTo(StateModel:: Class, 'state_id');
    // }

    // public function state_tool($id_tool)
    // {   
    //     $state =  State::where('id', $id_tool)->first();
    //     return $state;
    //     // if($estado->estado == true){
    //     //     return "Activa";
    //     // }else{
    //     //     return "Desactivada";
    //     // }
    // }



}
