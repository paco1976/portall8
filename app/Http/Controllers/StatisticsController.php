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

        $months = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];
    
        $years = range(date('Y'), 2017);
        $years = array_reverse($years);

        $periodos = [
            '3' => 'Últimos tres meses',
            '6' =>  'Últimos seis meses'
        ];

        $publicaciones_vistas = Publicacion_Visita::query();
        $views = $publicaciones_vistas -> count();
        $viewsPerMonth = Publicacion_Visita::whereYear('created_at', '=', now()->year)
        ->whereMonth('created_at', '=', now()->month)
        ->count();

        $month = $request->input('month', now()->format('m'));
        $year = $request->input('year', now()->format('Y'));
        $periodo = $request->input('periodo');

        $categories = Publicacion_Visita::query()
        ->join('publicacion AS p', 'p.id', '=', 'publicacion_visita.publicacion_id')
        ->join('categoria AS c', 'c.id', '=', 'p.categoria_id')
        ->when($periodo, function ($query) use ($periodo) {
            $endDate = now()->startOfMonth()->subDay();
            $startDate = $endDate->copy()->subMonths((int) $periodo - 1)->startOfMonth();

            return $query->whereBetween('publicacion_visita.created_at', [$startDate, $endDate]);
        })
        ->when(!$periodo, function ($query) use ($year, $month) {
            if ($year) {
                $query->whereYear('publicacion_visita.created_at', $year);
            }
            if ($month) {
                $query->whereMonth('publicacion_visita.created_at', $month);
            }
            return $query;
        })
        ->groupBy('c.id', 'c.name')
        ->select('c.id', 'c.name', DB::raw('COUNT(publicacion_visita.id) as view_count'))
        ->orderByDesc('view_count')
        ->get();

    $categoryViews = $categories->map(function ($category) use ($year, $month, $periodo) {
        // Get views by professional for the selected period
        $viewsByProfessional = Publicacion_Visita::query()
            ->join('publicacion AS p', 'p.id', '=', 'publicacion_visita.publicacion_id')
            ->join('publicacion_user AS pu', 'pu.publicacion_id', '=', 'publicacion_visita.publicacion_id')
            ->join('users AS u', 'u.id', '=', 'pu.user_id')
            ->where('p.categoria_id', $category->id)
            ->when($periodo, function ($query) use ($periodo) {
                $endDate = now()->startOfMonth()->subDay();
                $startDate = $endDate->copy()->subMonths((int) $periodo - 1)->startOfMonth();

                return $query->whereBetween('publicacion_visita.created_at', [$startDate, $endDate]);
            })
            ->when(!$periodo, function ($query) use ($year, $month) {
                if ($year) {
                    $query->whereYear('publicacion_visita.created_at', $year);
                }
                if ($month) {
                    $query->whereMonth('publicacion_visita.created_at', $month);
                }
                return $query;
            })
            ->groupBy('u.id', 'u.name', 'u.last_name', 'p.id')
            ->select('u.id', 'u.name', 'u.last_name', 'p.id as pub_id', DB::raw('COUNT(publicacion_visita.id) as views'))
            ->orderByDesc('views')
            ->get()
            ->slice(0, 3); // Get top 3 professionals

        return [
            'nameCat' => $category->name,
            'view_count' => $category->view_count,
            'views_by_professional' => $viewsByProfessional
        ];
    });


        $categoryAverage = $categories->first();



        $perfilVisitado = Publicacion_Visita::query()
        ->join('publicacion_user AS pu', 'pu.publicacion_id', '=', 'publicacion_visita.publicacion_id')
        ->join('users AS u', 'u.id', '=', 'pu.user_id')
        ->groupBy('u.id', 'u.name', 'u.last_name')
        ->select('u.name','u.last_name', DB::raw('COUNT(*) as view_count'))
        ->orderByDesc('view_count') 
        ->first();

        $publicacionMasVisitada = Publicacion_Visita::query()
        ->join('publicacion_user AS pu', 'pu.publicacion_id', '=', 'publicacion_visita.publicacion_id')
        ->join('users AS u', 'u.id', '=', 'pu.user_id')
        ->join('publicacion AS p', 'p.id', '=', 'pu.publicacion_id') // Ensure you join with the publicaciones table
        ->groupBy('p.id', 'u.id', 'u.name', 'u.last_name') // Group by publication and user
        ->select('p.id', 'u.name', 'u.last_name', DB::raw('COUNT(publicacion_visita.id) as view_count')) // Count views for each publication
        ->orderByDesc('view_count') // Order by view count
        ->first(); // Get the top publication


    $publicaciones = Publicacion_Visita::query()
    ->join('publicacion AS p', 'p.id', '=', 'publicacion_visita.publicacion_id')
    ->join('publicacion_user AS pu', 'pu.publicacion_id', '=', 'p.id')
    ->join('users AS u', 'u.id', '=', 'pu.user_id')
    ->join('categoria AS c', 'c.id', '=', 'p.categoria_id')
    ->when($periodo, function ($query) use ($periodo) {
        $endDate = now()->startOfMonth()->subDay();
        $startDate = $endDate->copy()->subMonths((int) $periodo - 1)->startOfMonth();

        return $query->whereBetween('publicacion_visita.created_at', [$startDate, $endDate]);
    })
    ->when(!$periodo, function ($query) use ($year, $month) {
        if ($year) {
            $query->whereYear('publicacion_visita.created_at', $year);
        }
        if ($month) {
            $query->whereMonth('publicacion_visita.created_at', $month);
        }
        return $query;
    })
    ->groupBy('p.id', 'u.name', 'u.last_name', 'c.name')
    ->select(
        'p.id as pub_id', 
        'c.name as cat',
        'u.name', 
        'u.last_name',
        DB::raw('COUNT(publicacion_visita.id) as view_count')
    )
    ->orderByDesc('view_count')
    ->get();

    $publicacionesBest = $publicaciones->first();

        $recentView = Publicacion_Visita::query()
        ->join('publicacion_user AS p_user', 'p_user.publicacion_id', '=', 'publicacion_visita.publicacion_id')
        ->join('users AS us', 'us.id', '=', 'p_user.user_id')
        ->join('publicacion AS publi', 'publi.id' , '=', 'publicacion_visita.publicacion_id')
        ->join('categoria AS cat', 'cat.id', '=', 'publi.categoria_id')
        ->groupBy('us.name','us.last_name','publi.hash','cat.name', 'cat.id', 'publicacion_visita.created_at')
        ->select('cat.name as cat','us.last_name','us.name', 'publi.hash', 'publicacion_visita.created_at')
        ->orderByDesc('publicacion_visita.created_at') 
        ->take(30)
        ->get();

        $allSurveys = Survey::query()
            ->where('accepts_survey', 1)
            ->join('publicacion AS pub', 'surveys.publicacion_id', '=', 'pub.id')
            ->join('categoria AS cat', 'cat.id', '=', 'pub.categoria_id')
            ->join('users AS us', 'surveys.user_id', '=', 'us.id')
            ->select(
                'surveys.id',
                'surveys.client_name',
                'surveys.satisfaction',
                'cat.name AS cat',
                'us.name AS name',
                'us.last_name AS last_name',
                'surveys.updated_at'
                )
                ->orderByDesc('surveys.updated_at') 
                ->get();
                
                $averageProfesional = Survey::query()
                ->where('accepts_survey', 1)
                ->join('users AS us', 'us.id', '=', 'surveys.user_id')
                ->join('publicacion AS pub', 'surveys.publicacion_id', '=', 'pub.id')
                ->join('categoria AS cat', 'cat.id', '=', 'pub.categoria_id')
                ->groupBy('surveys.user_id', 'pub.id', 'us.name', 'us.last_name', 'pub.hash', 'cat.name')
                ->select(
                'pub.hash',
                'surveys.user_id',
                'us.name AS name',
                'us.last_name AS last_name',
                'pub.hash',
                'cat.name AS cat',
                DB::raw('COUNT(pub.id) AS surveysWRating'),
                DB::raw('ROUND(AVG(surveys.satisfaction), 2) AS average')
            )
            ->orderByDesc('average')  
            ->orderByDesc('surveysWRating')
            ->get();
        
        // Get the top average
        $topAverage = $averageProfesional->first()->average ?? 0;
        
        // Filter professionals with the top average
        $averageProfesionalBest = $averageProfesional->filter(function ($professional) use ($topAverage) {
            return $professional->average == $topAverage;
        });
        
        $averageProfesionalWorst = $averageProfesional->sortBy('average')->values();

// Get the lowest average
$worstAverage = $averageProfesionalWorst->first()->average ?? 0;

// Filter professionals with the lowest average
$averageProfesionalWorst = $averageProfesionalWorst->filter(function ($professional) use ($worstAverage) {
    return $professional->average == $worstAverage;
});

          

        $surveysCount = $allSurveys->count();

        foreach ($averageProfesional as $professional) {
            $professional->avarage = rtrim(rtrim($professional->avarage, '0'), '.'); // Remove trailing zeros
        }
        
        

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

    // Handle AJAX request
    if ($request->ajax()) {
        return response()->json([
            'categoryViews' => $categoryViews,
            'publicacionesViews' => $publicaciones,
            'html' => view('admin.partials.category_views', ['filteredCategories' => $categoryViews])->render(),
            'html_pubs' => view('admin.partials.publicacion_views', ['filteredPublicaciones' => $publicaciones])->render()

        ]);
    }

        return view('admin.statistics', compact('user'))
            ->with('categoryViews',  $categoryAverage)
            ->with('allCategoryViews',  $categoryViews)
            ->with('viewsCount', $views)
            ->with('viewsMonth', $viewsPerMonth)
            // ->with('category_Profile', $categoryWithProfile)
            ->with('perfilVisitado', $publicacionMasVisitada)
            ->with('profesionalMorequalified',  $averageProfesionalBest)
            ->with('profesionalWorstqualified',  $averageProfesionalWorst)
            ->with('SurveyTotal',  $surveysCount)
            ->with('allSurveys', $allSurveys)
            //->with('chart', $chart)
            ->with('months',  $months)
            ->with('years',  $years)
            ->with('periodos', $periodos)
            ->with('periodo', $periodo)
            ->with('month',  $month)
            ->with('year',  $year)
            ->with('recentView',  $recentView)
            ->with('publicacionesViews', $publicacionesBest)
            ->with('allPublicacionesViews', $publicaciones);

    }
    
}