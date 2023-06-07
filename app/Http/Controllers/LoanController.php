<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ToolModel;
use App\Models\LoanModel;

use Barryvdh\Debugbar\Facade as Debugbar;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Intervention\Image\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index(){

        return view('admin.loan');
    }

    private function desableEnableTool( $toolId, $state){

        $tool = ToolModel::where('id', $toolId)->first();
        //dd($tool);
            if($state == 1 || $state == -1 ){//Prestamos aprovados o pendientes
                $tool->state_id = 2; // RESERVADA
            }else{
                $tool->state_id = 1; // DISPONIBLE
            }
            $tool->save(['state_id']);

    }

    public function admin_loans_enable_desable($loan_id, $state){

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $loan = LoanModel::where('id', $loan_id)->first();
        $tool = ToolModel::where('id', $loan->tool_id)->first();

        //dd($tool);

        //$loan_user = $loan->user()->first();

        if($user->permisos->name == "Administrador"){
            $loan->approved =  $state;
            $loan->save(['approved']);
            if($state== 1 ){
                session::flash('message', 'El prestamo esta dado de alta');
            }else{
                session::flash('message', 'El prestamo esta dado de baja');
            }
            $this->desableEnableTool($loan->tool_id, $state);                   

            return back();
         
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function admin_loansList(Request $request){

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            // ->join('articles', 'entries.id', '=', 'articles.entryID')
            // ->orderBy('articles.created_at', 'desc')

                    $loans= DB::table('loans AS p')
                    ->join('users AS u', 'p.user_id', '=', 'u.id')
                    ->join('tools AS h', 'p.tool_id', '=', 'h.id')
                    ->join('categorytools AS c', 'h.categoryTool_id', '=', 'c.id')
                    ->select(
                        'p.id as loanId',
                        'h.id as toolId',
                        'c.id as categoryToolId',
                        'c.name as categoryName',
                        'h.name as toolName',
                        'h.description as descirption',
                        'u.name as name',
                        'u.last_name as lastName',
                        'p.dateInit as init',
                        'p.dateFinish as finish',
                        'p.approved as approved',

                      ) 
                    ->paginate(15);
         
            Debugbar::info($loans);
                //dd($loans);
            return view('/admin.loan', compact('user', 'loans'));
        }else{
            return redirect('/');
        }
    }

    public function getLoansByState(Request $request){
       // dd($request);

        $filter = "";
        $operador;
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            // ->join('articles', 'entries.id', '=', 'articles.entryID')
            // ->orderBy('articles.created_at', 'desc')
            if ($request->get("filter")) {
                $filter = $request->get("filter");
            }

            if($filter == "all"){
                return redirect()->route('admin_loan');    
            }
            if($filter == "pending"){
                $filter=null;
            }elseif($filter == "refused"){
                $filter=0;
            }else{
                $filter=1;
            }
 
            $loans= DB::table('loans AS p')
            ->join('users AS u', 'p.user_id', '=', 'u.id')
            ->join('tools AS h', 'p.tool_id', '=', 'h.id')
            ->join('categorytools AS c', 'h.categoryTool_id', '=', 'c.id')
            ->where('p.approved', $filter)
            ->select(
                'p.id as loanId',
                'h.id as toolId',
                'c.id as categoryToolId',
                'c.name as categoryName',
                'h.name as toolName',
                'h.description as descirption',
                'u.name as name',
                'u.last_name as lastName',
                'p.dateInit as init',
                'p.dateFinish as finish',
                'p.approved as approved',
               ) 
            ->paginate(15);
            
            return view('/admin.loan', compact('user', 'loans'));
        }else{
            return redirect('/');
        }


    }

    public function getLoansOrderByDate(){

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            // ->join('articles', 'entries.id', '=', 'articles.entryID')
            // ->orderBy('articles.created_at', 'desc')
                    $loans= DB::table('loans AS p')
                    ->join('users AS u', 'p.user_id', '=', 'u.id')
                    ->join('tools AS h', 'p.tool_id', '=', 'h.id')
                    ->join('categorytools AS c', 'h.categoryTool_id', '=', 'c.id')
                    ->orderBy('dateFinish', 'asc')
                    ->select(
                        'p.id as loanId',
                        'h.id as toolId',
                        'c.id as categoryToolId',
                        'c.name as categoryName',
                        'h.name as toolName',
                        'h.description as descirption',
                        'u.name as name',
                        'u.last_name as lastName',
                        'p.dateInit as init',
                        'p.dateFinish as finish',
                        'p.approved as approved',
                       ) 
                    ->paginate(15);
         
                //dd($loans);
            return view('/admin.loan', compact('user', 'loans'));
        }else{
            return redirect('/');
        }


    }

    public function getLoansByName(Request $request){
        

        $name = "";

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        if($user->permisos->name == "Administrador"){
            // ->join('articles', 'entries.id', '=', 'articles.entryID')
            // ->orderBy('articles.created_at', 'desc')
            if ($request->get("name")) {
                $name = $request->get("name");
            }
                    $loans= DB::table('loans AS p')
                    ->join('users AS u', 'p.user_id', '=', 'u.id')
                    ->join('tools AS h', 'p.tool_id', '=', 'h.id')
                    ->join('categorytools AS c', 'h.categoryTool_id', '=', 'c.id')
                    ->where('u.name', 'like', "%{$name}%")
                    ->select(
                        'p.id as loanId',
                        'h.id as toolId',
                        'c.id as categoryToolId',
                        'c.name as categoryName',
                        'h.name as toolName',
                        'h.description as descirption',
                        'u.name as name',
                        'u.last_name as lastName',
                        'p.dateInit as init',
                        'p.dateFinish as finish',
                        'p.approved as approved')
                    ->paginate(15);
         
                //dd($loans);
                if(count($loans) == 0){
                    Session::flash('message', 'No hay prestamos con este nombre');
                    return back();
                }
            return view('/admin.loan', compact('user', 'loans'));
        }else{
            return redirect('/');
        }

    }

    public function admin_loanGetForm(){ 
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user_prof = User::where('type_id', 1)->get();
        $tools = ToolModel::where('state_id', 1)->get();
        $dates_=[];
        $tool_selectd=null;
        return view('/admin.loan_new', compact('user_prof', 'tool_selectd','tools','user', 'dates_'));
    }

    public function admin_loanSave(Request $request){
        //dd($request);

        //Validacion Campos
        //dd($request);

        $dataForm = request()->validate([
            'tool_selectd' => 'required',
            'dates' => 'required',
        ],[
            'tool_selectd.required' => 'Debe seleccionar una herramienta',
            'date.required' => 'Debe Ingresar una fecha',
        ]);

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);

        $datesRequest=$dataForm['dates'];
        $datesTrue=str_contains($datesRequest, "to");

        if($datesTrue){
                $myArray = explode('to', $datesRequest);

                if($this-> greaterThanMax($myArray)){
                    Session::flash('message', 'El maximo de dias para el prestamo es de 3');
                    return redirect('/');
                }else{
                    $loan = LoanModel::create([
                            'user_id' => $user->id,
                            'tool_id' => $dataForm['tool_selectd'],
                            'dateInit' => $myArray[0],
                            'dateFinish' => $myArray[count($myArray)-1], 
                            'approved' => -1,     
                        ]);
                    
                    $loan->save();
                    $this->desableEnableTool($dataForm['tool_selectd'], -1); //Estado nuevo prestamo pendiente de aprovar                    
                    Session::flash('message', 'Ingreso exitoso');
                    return redirect('admin_loan_new');       
                }
        } else{
            $loan = LoanModel::create([
                'user_id' => $user->id,
                'tool_id' => $dataForm['tool_selectd'],
                'dateInit' => $datesRequest,
                'dateFinish' => $datesRequest, 
                'approved' => -1,        
            ]);
            $loan->save();
            $this->desableEnableTool($dataForm['tool_selectd'], -1); //Estado nuevo prestamo pendiente de aprovar                  

            Session::flash('message', 'Ingreso exitoso');
            return redirect('admin_loan_new');
        }

        
    }

    private function greaterThanMax (Array $myArray){
        dd($request);
        $num_a=explode('-', $myArray[0]);
        $num_b=explode('-', $myArray[1]);
        if($num_a[2]-$num_b[2]>3){
            return true;
        }
        return false;
    }

    public function admin_loan_dates(Request $request){
        //dd($request);
        $dataForm = request()->validate([
            'tool_id' => 'required'        
        ],[
            'tool_id.required' => 'Debe seleccionar una herramienta'
        ]);

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);

        $tools = ToolModel::where('state_id', 1)->get();
        $tool_id = (int)$dataForm['tool_id'];

        //dd($tool_id);
        $tool_selectd= ToolModel::where('id', 1)->first();

        $dt = now();
        $dt->format('Y-m-d');

        $dates= DB::table('loans AS p')
        ->select('p.dateInit', 'p.dateFinish')
        ->where('tool_id', '=', $tool_id)
        ->where('approved', '=', 1)
        ->orWhere('approved', '=', -1)
        ->whereDate( 'p.dateInit' ,'>=', $dt)
        ->groupBy('p.dateInit', 'p.dateFinish')
        ->get();

        $dates_=$this->convertToArrayDates($dates);

         return view('/admin.loan_new', compact('user', 'tool_selectd', 'tools','user', 'dates_'));   
    }

    private function convertToArrayDates($dates){

        $arrayDates=[];
        foreach($dates as $date)
        {

            $fechauno = $date->dateInit; 
            $fechados = $date->dateFinish; 
            //dd(date("Y-m-d H:i:s", strtotime($fechauno)));

            $currentDate;
            if(strtotime($fechados) == strtotime($fechauno)){
                array_push($arrayDates ,date("Y-m-d H:i:s", strtotime($fechauno)));
            }else{
                $currentDate = date("Y-m-d H:i:s", strtotime($fechauno));
                array_push($arrayDates,$currentDate);
    
                while(strtotime($fechados) > strtotime($fechauno)) { 
                    $currentDate = date("Y-m-d H:i:s", strtotime($fechauno . " + 1 day"));
    
                    array_push($arrayDates,$currentDate);
                    $fechauno=$currentDate;       
                }
            }

           
        }
        return $arrayDates;

    }

}
