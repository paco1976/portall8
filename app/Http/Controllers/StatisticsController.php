<?php  

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publicacion_Visita;
use App\Models\Survey;

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
    public function getStatistics(Request $request){
        //dd($request);
        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $publicaciones_vistas = Publicacion_Visita::query();
        $views = $publicaciones_vistas -> count();
        $views_month = Publicacion_Visita::whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at', '=', now()->month)
        ->count();

        $allCategoryVisits = $publicaciones_vistas
            ->join('publicacion AS p', 'p.id' , '=', 'publicacion_visita.publicacion_id')
            ->join('publicacion_user AS pu', 'pu.publicacion_id', '=', 'publicacion_visita.publicacion_id')
            ->join('users AS u', 'u.id', '=', 'pu.user_id')
            ->join('categoria AS c', 'c.id', '=', 'p.categoria_id')
            ->groupBy('c.id', 'c.name', 'u.name', 'u.last_name')
            ->select('c.name', DB::raw('COUNT(*) as view_count'), 'u.name as user', 'u.last_name')
            ->orderByDesc('view_count')
            ->get();
        $categoriesViews = $allCategoryVisits ->first();
        $perfilVisitado = Publicacion_Visita::query()
        ->join('publicacion_user AS pu', 'pu.publicacion_id', '=', 'publicacion_visita.publicacion_id')
        ->join('users AS u', 'u.id', '=', 'pu.user_id')
        ->groupBy('u.id', 'u.name', 'u.last_name')
        ->select('u.name','u.last_name', DB::raw('COUNT(*) as view_count'))
        ->orderByDesc('view_count') 
        ->first();

        $recentView = Publicacion_Visita::query()//Seguir buscando al forma de unir query
        ->join('publicacion_user AS p_user', 'p_user.publicacion_id', '=', 'publicacion_visita.publicacion_id')
        ->join('users AS us', 'us.id', '=', 'p_user.user_id')
        ->join('publicacion AS publi', 'publi.id' , '=', 'publicacion_visita.publicacion_id')
        ->join('categoria AS cat', 'cat.id', '=', 'publi.categoria_id')
        ->groupBy('us.name','us.last_name','publi.hash','cat.name', 'cat.id', 'publicacion_visita.created_at')
        ->select('cat.name as cat','us.last_name','us.name', 'publi.hash', 'publicacion_visita.created_at')
        ->orderByDesc('publicacion_visita.created_at') 
        ->take(10)
        ->get();


        //Profesionales

        $SurveyByProfesional = Survey::query()
        ->join('users AS us', 'us.id', '=', 'Surveys.user_id')
        ->groupBy('user_id', 'us.name', 'us.last_name', 'client_name', 'client_email', 'Satisfaction')
        ->select('user_id', 'us.name','us.last_name', DB::raw('COUNT(Surveys.satisfaction) as Survays'), 'client_name', 'client_email', 'Satisfaction')
        ->get();

        $profesionalMorequalified = Survey::query()
        ->join('users AS us', 'us.id', '=', 'Surveys.user_id')
        ->join('publicacion_user AS p_user', 'p_user.user_id', '=', 'us.id')
        ->join('publicacion AS publi', 'publi.id' , '=', 'p_user.publicacion_id')
        ->join('categoria AS cat', 'cat.id', '=', 'publi.categoria_id')
        ->groupBy('Surveys.user_id', 'us.name', 'us.last_name', 'client_name', 'client_email', 'Satisfaction', 'cat.name')
        ->select('Surveys.user_id', 'us.name','us.last_name', DB::raw('COUNT(Surveys.user_id) as Survays'), 'client_name', 'client_email', 'Satisfaction', 'cat.name')
        ->orderByDesc('Survays') 
        ->first();
        
        $SurveyTotal = Survey::query()
        ->count();

        return view('admin.statistics', compact('user'))
            ->with('categoryVisits',  $categoriesViews)
            ->with('visitsCount', $views)
            ->with('visitsMonth', $views_month)
            // ->with('category_Profile', $categoryWithProfile)
            ->with('perfilVisitado', $perfilVisitado)
            ->with('allCategoryVisits',  $allCategoryVisits)
            ->with('profesionalMorequalified',  $profesionalMorequalified)
            ->with('SurveyTotal',  $SurveyTotal)
            ->with('SurveyByProfesional',  $SurveyByProfesional)

            ->with('recentView',  $recentView);
    }
    
}