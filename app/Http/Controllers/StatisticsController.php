<?php  

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publicacion_Visita;
use App\Models\Survey;
use App\Models\Categoria;
use App\Models\User_type;
// use App\Charts\StatisticsChart;
// use App\Charts\Chart;
//usaba este
//use ConsoleTVs\Charts\Classes\Chartjs\Chart;


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
         $this->middleware('auth');
    }
    public function getStatistics(Request $request){
         //dd($request);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $publicaciones_vistas = Publicacion_Visita::query();
        $views = $publicaciones_vistas -> count();
        $viewsPerMonth = Publicacion_Visita::whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at', '=', now()->month)
        ->count();

            

        $categories = Publicacion_Visita::query()
        ->join('publicacion AS p', 'p.id', '=', 'publicacion_visita.publicacion_id')
        ->join('categoria AS c', 'c.id', '=', 'p.categoria_id')
        ->groupBy('c.id', 'c.name')
        ->select('c.id', 'c.name', DB::raw('COUNT(publicacion_visita.id) as view_count'))
        ->orderByDesc('view_count')
        ->get();

        $categoryAverage = $categories->first();

        $categoryViews = $categories->map(function ($category) {
            $viewsByProfessional = Publicacion_Visita::query()
                ->join('publicacion AS p', 'p.id', '=', 'publicacion_visita.publicacion_id')
                ->join('publicacion_user AS pu', 'pu.publicacion_id', '=', 'publicacion_visita.publicacion_id')
                ->join('users AS u', 'u.id', '=', 'pu.user_id')
                ->where('p.categoria_id', $category->id)
                ->groupBy('u.id', 'u.name', 'u.last_name')
                ->select('u.id', 'u.name', 'u.last_name', DB::raw('COUNT(publicacion_visita.id) as views'))
                ->orderByDesc('views')
                ->get();
    
            $viewsByProfessional = $viewsByProfessional->slice(0, 3);
            
            return [
                'nameCat' => $category->name,
                'view_count' => $category->view_count,
                'views_by_professional' => $viewsByProfessional
            ];
        });      

        // MySQL para probar promedio  de categorias con profesionales
        // select `c`.`name`, round(sum(c.id) / ( select count(cat2.id) from `categoria` cat2 ),0 ) as view_count
        // from `publicacion_visita` 
        // inner join `publicacion` as `p` on `p`.`id` = `publicacion_visita`.`publicacion_id` 
        // inner join `categoria` as `c` on `c`.`id` = `p`.`categoria_id` 
        // where c.name = 'Peluquero/a'
        // group by `c`.`id` 
        // order by `view_count` desc


        $perfilVisitado = Publicacion_Visita::query() //revisar no s epueden sacar promedios
        ->join('publicacion_user AS pu', 'pu.publicacion_id', '=', 'publicacion_visita.publicacion_id')
        ->join('users AS u', 'u.id', '=', 'pu.user_id')
        ->groupBy('u.id', 'u.name', 'u.last_name')
        ->select('u.name','u.last_name', DB::raw( 'round(( COUNT(*) / COUNT(u.id)),0 ) as view_count'))
        ->orderByDesc('view_count') 
        ->first();

        
        //MySql Promedio publicaciones perfil mas visitado ??? REVISAR
        // select  round(( sum(pv.id) / COUNT(pu.user_id)),0 ) as view_count, pu.user_id
        // from publicacion_visita pv
        // inner join publicacion_user  as pu on pu.publicacion_id=pv.publicacion_id
        // inner join users as u on  u.id = pu.user_id
        // group by pu.user_id
        // ORDER by view_count DESC;
        
        // select count(pv.id), u.id
        // from publicacion_visita pv
        // inner join publicacion_user  as pu on pu.publicacion_id=pv.publicacion_id
        // inner join users as u on  u.id = pu.user_id
        // group by u.id



        $recentView = Publicacion_Visita::query()
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
        ->join('users AS us', 'us.id', '=', 'surveys.user_id')
        ->groupBy('user_id', 'us.name', 'us.last_name', 'client_name', 'client_email', 'Satisfaction')
        ->select('user_id', 'us.name','us.last_name', DB::raw('COUNT(surveys.id) as Survays'), 'client_name', 'client_email', 'Satisfaction')
        ->get();

        //Average Profesional --revisar no s epueden sacar promedios
        $averageProfesional = Survey::query()
        ->join('users AS us', 'us.id', '=', 'surveys.user_id')
        ->join('publicacion_user AS p_user', 'p_user.user_id', '=', 'us.id')
        ->join('publicacion AS publi', 'publi.id' , '=', 'p_user.publicacion_id')
        ->join('categoria AS cat', 'cat.id', '=', 'publi.categoria_id')
        ->groupBy('surveys.user_id', 'us.name', 'us.last_name', 'client_name', 'client_email', 'satisfaction', 'cat.name')
        ->select('surveys.user_id', 'us.name','us.last_name', DB::raw('COUNT(surveys.user_id) as Survays'), 'client_name', 'client_email'
        , DB::raw( ' round( SUM(surveys.satisfaction) / COUNT(surveys.user_id), 2 ) as Prom'), 'cat.name as cat', 'surveys.satisfaction as satisf')
        ->orderByDesc('Survays') 
        ->first();
        
        $SurveyTotal = Survey::query()
        ->count();


            


//*Grafico, Pendiente: verificar en la query, agregando datos en la bbdd, que en una misma fecha, aparezcan dos categorias distintas con visitas-

$averageViewsToGraph = Publicacion_Visita::query()
    ->join('publicacion_user AS p_user', 'p_user.publicacion_id', '=', 'publicacion_visita.publicacion_id')
    ->join('users AS us', 'us.id', '=', 'p_user.user_id')
    ->join('publicacion AS publi', 'publi.id', '=', 'publicacion_visita.publicacion_id')
    ->join('categoria AS cat', 'cat.id', '=', 'publi.categoria_id')
    ->select( 'cat.name as categoria', 'cat.id as catId',
        DB::raw('COUNT(`publicacion_visita`.`id`) as vistas'), 
        DB::raw('DATE(`publicacion_visita`.`created_at`) as date'))
    ->groupBy( 'categoria', 'cat.id',
        DB::raw('DATE(`publicacion_visita`.`created_at`)')
        )
        ->orderByDesc('date')
        ->get();
     

$datasets = [];
$dates = [];


foreach ($averageViewsToGraph as $resultado) {
    $date = $resultado->date;
    $categoria = $resultado->categoria;
    $vistas = $resultado->vistas;

    // Si no existe la fecha en el array datasets, se inicializa- Trabajara tipo arbol. Por fecha -> categoria -> vistas
    if (!isset($datasets[$date])) {
        $datasets[$date] = [
            'categorias' => [],
        ];
        $dates[] = $date; // Agregar la fecha al array de etiquetas (fechas)
    }

    // Asignar las vistas a la fecha y categoría correspondiente
    if (!isset($datasets[$date]['categorias'][$categoria])) {
        $datasets[$date]['categorias'][$categoria] = $vistas;
    }else { 
        // Si ya existe la categoría para esa fecha, acumular las vistas
        $datasets[$date]['categorias'][$categoria] += $vistas;
    }
}



// Preparar las categorías y vistas para el gráfico
$categories = [];
$vistasPorCategoria = [];

//Por cada fecha agrupa -> Categorias : Por cada Categoria Asigna la s Vistas
foreach ($datasets as $date => $data) {
    foreach ($data['categorias'] as $categoria => $vistas) {
        $categories[] = $categoria; // Guardar las categorías
        $vistasPorCategoria[$categoria][] = $vistas; // Guardar las vistas asociadas a la categoría
    }
}

// Crear el gráfico y definir las etiquetas (fechas)
//$chart = new Chart;
//$chart->labels($dates); // Usamos fechas como etiquetas para el eje X

// Agregar un dataset por cada categoría y la libreria lo asocia a cada fecha que le mandamos en la linea

/*
foreach ($vistasPorCategoria as $categoria => $vistas) {
    $chart->dataset("Vistas para $categoria", 'line', $vistas);
}
    */


        return view('admin.statistics', compact('user'))
            ->with('categoryVisits',  $categoryAverage)
            ->with('visitsCount', $views)
            ->with('visitsMonth', $viewsPerMonth)
            // ->with('category_Profile', $categoryWithProfile)
            ->with('perfilVisitado', $perfilVisitado)
            ->with('allCategoryVisits',  $categoryViews)
            ->with('profesionalMorequalified',  $averageProfesional)
            ->with('SurveyTotal',  $SurveyTotal)
            ->with('SurveyByProfesional',  $SurveyByProfesional)
            //->with('chart', $chart)
            ->with('recentView',  $recentView);
    }
    
}