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
 

    public function admin_loans_enable_desable($loan_id, $state){

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $loan = LoanModel::where('id', $loan_id)->first();

        if($user->permisos->name == "Administrador"){
            $loan->state_id =  $state;
            $loan->save(['state_id']);
            if($state== 1 ){
                session::flash('message', 'El prestamo esta dado de alta');
            }else{
                session::flash('message', 'El prestamo esta dado de baja');
            }
            // $this->desableEnableTool($loan->tool_id, $state);                   

            return back();
         
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function loan_cancel($loan_id){

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->type = $user->user_type()->first();
        //dd($user);

        if($user->type->name == "Profesional"){
            $loan = LoanModel::where('id', $loan_id)->first();
            //dd($loan->dateInit>now()->toDateString()); 
            $loan->state_id =  2;
            $loan->save(['state_id']);
            
            session::flash('message', 'El prestamo esta dado de baja');
            return back();
  
        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }


    public function getLoansFiltered(Request $request){
        //dd($request);
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
            $loans = LoanModel::query();
            $loans = $loans 
            ->join('users AS u', 'loans.user_id', '=', 'u.id')
            ->join('tools AS h', 'loans.tool_id', '=', 'h.id')
            ->join('categorytools AS c', 'h.categoryTool_id', '=', 'c.id');
                  
            if ($request->get("date")) { //Filtro de nombre
                $date = $request->get("date");
                $year=substr($request->get("date"),0, 4);
                $month=substr($request->get("date"),5,9);

                $loans=$loans ->whereMonth('loans.dateInit' ,'=', $month);
                $loans=$loans ->whereYear('loans.dateFinish' ,'=',  $year);
            }
            if ($request->get("name")) { //Filtro de nombre
                $name = $request->get("name");
                $loans=$loans->where('u.name', 'like', "%{$name}%");
            }

            if ($request->get("state")) { //Filtro de estado
                $state = $request->get("state");
                if($state == "pending"){
                    $loans = $loans->where('loans.state_id', 3);
                }else if($state == "refused"){
                    $loans = $loans->where('loans.state_id',  2);
                }else if($state == "approved"){
                    $loans = $loans->where('loans.state_id',  1);
                }
            }

            $loans = $loans
            ->select(
                'Loans.id as loanId',
                'h.id as toolId',
                'c.id as categoryToolId',
                'c.name as categoryName',
                'h.name as toolName',
                'h.description as descirption',
                'u.name as name',
                'u.last_name as lastName',
                'loans.dateInit as init',
                'loans.dateFinish as finish',
                'loans.state_id as state_id',
               ) 
            ->paginate(15);


            return view('/admin.loan', compact('user', 'loans'));

    }
    
    //Profesionales
    public function getLoansProfesionalFiltered(Request $request){
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->type = $user->user_type()->first();
        //dd($user);
        if($user->type->name == "Profesional"){       
            $loans = LoanModel::query();
            $loans = $loans 
            ->join('tools AS h', 'loans.tool_id', '=', 'h.id')
            ->join('categorytools AS c', 'h.categoryTool_id', '=', 'c.id');
                        
            $loans=$loans->where('loans.user_id', '=', $user->id);

            if ($request->get("date")) { //Filtro de nombre
                $date = $request->get("date");
                $year=substr($request->get("date"),0, 4);
                $month=substr($request->get("date"),5,9);

                $loans=$loans ->whereMonth('loans.dateInit' ,'=', $month);
                $loans=$loans ->whereYear('loans.dateFinish' ,'=',  $year);
            }
            if ($request->get("name")) { //Filtro de nombre
                $name = $request->get("name");
                $loans=$loans->where('u.name', 'like', "%{$name}%");
            }

            if ($request->get("state")) { //Filtro de estado
                $state = $request->get("state");
                if($state == "pending"){
                    $loans = $loans->where('loans.state_id', 3);
                }else if($state == "refused"){
                    $loans = $loans->where('Loans.state_id',  2);
                }else if($state == "approved"){
                    $loans = $loans->where('Loans.state_id',  1);
                }
            }

            $loans = $loans
            ->select(
                'loans.id as loanId',
                'h.id as toolId',
                'c.id as categoryToolId',
                'c.name as categoryName',
                'h.name as toolName',
                'h.description as descirption',
                'loans.dateInit as init',
                'loans.dateFinish as finish',
                'loans.state_id as state_id',
               ) 
            ->paginate(15);


            return view('/loan_profesional', compact('user', 'loans'));

        }else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
           

    }

    public function admin_loanGetForm(){ 
        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $tools = ToolModel::all(); 
        $dates_=[];
        $tool_selectd=null;
    
        return view('loan_new', compact( 'tool_selectd','tools','user', 'dates_'));
    }

    public function admin_loanSave(Request $request){
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
                //$maxDays=$this-> greaterThanMax($myArray);
                //dd($maxDays);
                $tool_selectd= $this->GetTool((int)$dataForm['tool_selectd']);

                if($this-> greaterThanMax($myArray)){
                    Session::flash('message', 'El maximo de dias para el prestamo es de 3');
                    $dates_=$this->dateEnableByTool($tool_selectd);
                    $tools = null;
                    return view('/loan_new', compact('user', 'tool_selectd', 'tools', 'dates_'));   
                }else{
                    if($this-> existLoans($myArray, $tool_selectd)){
                        Session::flash('message', 'Ya existe el prestamo');
                        return redirect()->route('loan_new');   
                    }
                    
                    $loan = LoanModel::create([
                            'user_id' => $user->id,
                            'tool_id' => $dataForm['tool_selectd'],
                            'dateInit' => $myArray[0],
                            'dateFinish' => $myArray[count($myArray)-1], 
                            'state_id' => 3,//pendiente     
                        ]);

                   $loan->save();                    
                    Session::flash('message', 'Ingreso exitoso');
                    return redirect()->route('loan_new');   
                }
        } else{

            $loan = LoanModel::create([
                'user_id' => $user->id,
                'tool_id' => $dataForm['tool_selectd'],
                'dateInit' => $datesRequest,
                'dateFinish' => $datesRequest, 
                'state_id' => 3,        
            ]);
            $loan->save();

            Session::flash('message', 'Ingreso exitoso');
            return redirect()->route('loan_new');   
        }

        
    }

    private function existLoans($myArray, $tool_id){
        $dates= DB::table('loans AS p')
        ->select('p.dateInit', 'p.dateFinish')
        ->where('tool_id', '=', $tool_id)
        ->where('state_id', '=', 1)
        ->orWhere('state_id', '=', 3)
        ->whereDate( 'p.dateInit' ,'>=', $myArray[0])
        ->whereDate( 'p.dateFinish' ,'<=',  $myArray[count($myArray)-1])
        ->groupBy('p.dateInit', 'p.dateFinish')
        ->get();
        //dd($dates);
        $dates_=$this->convertToArrayDates($dates);

        if(count($dates_)>0){
            return true;
        }
        return false;
    }

    private function greaterThanMax (Array $myArray){
        $num_a=explode('-', $myArray[0]);
        $num_b=explode('-', $myArray[1]);
        if($num_a[2]-$num_b[2]<=-3){
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

        $tools = null;
        $tool_id = (int)$dataForm['tool_id'];

        //dd($tool_id);

        $tool_selectd= $this->GetTool($tool_id);
        $dates_=$this->dateEnableByTool($tool_id);
        return view('/loan_new', compact('user', 'tool_selectd', 'tools', 'dates_'));   
    }

    private function GetTool($tool_id){
        $tool_selectd= ToolModel::where('id', $tool_id)->first();
        return $tool_selectd;
    }

    private function dateEnableByTool( $tool_id){

        $dt = now();
        $dt->format('Y-m-d');
        $dates= DB::table('loans AS p')
        ->select('p.dateInit', 'p.dateFinish')
        ->where('tool_id', '=', $tool_id)
        ->where('state_id', '=', 1)
        ->orWhere('state_id', '=', 3)
        ->whereDate( 'p.dateInit' ,'>=', $dt)
        ->groupBy('p.dateInit', 'p.dateFinish')
        ->get();
        //dd($dates);

        $dates_=$this->convertToArrayDates($dates);
        return $dates_;
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
