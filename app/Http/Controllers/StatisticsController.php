<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publicacion_Visita;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Intervention\Image\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class StatisticsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    public function GetViewsByDate(Request $request){
        //dd($request);
        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
      
        $views = Publicacion_Visita::query();

        // Filtro por fecha
        if ($request->get("date")) {
            $date = $request->get("date");
            if($request->get("date"))
            {
                $month = substr($request->get("date"), 5, 9);
                $views = $views->whereMonth('publicacion_vista.created_at', '=', $month);
                $year = substr($request->get("date"), 0, 4);
                $views = $views->whereYear('publicacion_vista.created_at', '=',  $year);
            }
        }

        $visitsCount=null;
        //Filtro de vistas totales by year and month-
        if ($request->has("visits")) {
            $visitsCount=$views->count();
        }

        $expiringTodayCount=null;
        $categoryVisits=null;
        $pendingApproval=null;
        
        return view('/admin.statisticsPanel', compact('user'))
            ->with('expiringTodayCount', $expiringTodayCount)
            ->with('categoryVisits', $categoryVisits)
            ->with('visitsCount', $visitsCount)
            ->with('pendingApproval', $pendingApproval);
    }

}
