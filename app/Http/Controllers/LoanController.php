<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ToolModel;
use App\Models\LoanModel;
use App\Notifications\LoanLiberatedNotification;

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
        // $this->middleware('auth');
    }
    public function admin_loan_removedTool($loan_id){

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $loan = LoanModel::where('id', $loan_id)->first();
        //$loan->state_id
        if($user->permisos->name == "Administrador"){
            if($loan->state_id==1){// (4)Finalizado - (2)Rechazado
                LoanModel::where('id',$loan_id)->update([
                    'removed' =>1                                          
                ]);                       
            }else{
                session::flash('error', 'Debe aprobar el presatamo para retirar la herramienta');
                return back();
            }
            session::flash('message', 'La Herramienta fue retirada');
            return back();
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }
    }

    public function admin_loan_returnedTool($loan_id){

        $user = User::find(Auth::user()->id);
        $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $loan = LoanModel::where('id', $loan_id)->first();
        //$loan->state_id
        if($user->permisos->name == "Administrador"){
            if($loan->state_id==1){// (4)Finalizado - (2)Rechazado
                LoanModel::where('id',$loan_id)->update([
                    'returned' => 1                                         
                ]);                       
            }
            session::flash('message', 'La Herramienta fue devuelta');
            return back();
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function admin_loans_enable_desable($loan_id, $state){

        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $loan = LoanModel::where('id', $loan_id)->first();

        if($user->permisos->name == "Administrador"){
            if($state==4 || $state== 2){// (4)Finalizado - (2)Rechazado
                $state_returned=0;
                if($state==4){
                    $state_returned=1;
                }
                $now = date_create(date('y-m-d'));
                LoanModel::where('id',$loan_id)->update([
                    'dateClose'=>$now,
                    'returned' =>$state_returned                                          
                ]);
                          
            }

            if($state== 1 ){//Aprobado
                session::flash('message', 'El préstamo ha sido dado de alta');
            }else if ($state== 2 || $state== 4) {//Rechazado
                session::flash('message', 'El préstamo ha sido dado de baja');
            }

            $loan->state_id =$state;
            $loan->save(['state_id']);
            return back();
         
        }
        else{
            session::flash('message', 'No está autorizado para esta acción');
            return redirect('/');
        }

    }

    public function getLoansFiltered(Request $request){
        //dd($request);
        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        
            $loans = LoanModel::query();
            $loans = $loans 
            ->join('users AS u', 'loans.user_id', '=', 'u.id')
            ->join('tools AS h', 'loans.tool_id', '=', 'h.id')
            ->join('categorytools AS c', 'h.categoryTool_id', '=', 'c.id');

            if($user->permisos->name == "Profesional"){
                $loans=$loans->where('loans.user_id', '=', $user->id);
            }
                  
        // Filtro por ID
        if ($request->has("id")) {
            $loanId = $request->get("id");
            $loans = $loans->where('loans.id', '=', $loanId);
        }

        // Filtro por fecha
        if ($request->get("date")) {
            $date = $request->get("date");
            $year = substr($request->get("date"), 0, 4);
            $month = substr($request->get("date"), 5, 9);

            $loans = $loans->whereMonth('loans.dateInit', '=', $month);
            $loans = $loans->whereYear('loans.dateFinish', '=',  $year);
        }

        // Filtro por nombre de profesional
        if ($request->get("name")) {
            $name = $request->get("name");

            $keywords = explode(" ", $name);

            $loans = $loans->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where(function ($query) use ($keyword) {
                        $query->where('u.name', 'like', "%{$keyword}%")
                            ->orWhere('u.last_name', 'like', "%{$keyword}%");
                    });
                }
            });
        }

        // Filtro por estado de préstamo (pendiente, aprobado, no aprobado, cerrado)
        if ($request->get("state")) {
            $state = $request->get("state");
            if ($state == "pending") {
                $loans = $loans->where('loans.state_id', 3);
            } else if ($state == "refused") {
                $loans = $loans->where('loans.state_id',  2);
            } else if ($state == "approved") {
                $loans = $loans->where('loans.state_id',  1);
            } else if ($state == "close") {
                $loans = $loans->whereNotNull('loans.dateClose');
            }
        }

        // Filtro de vencen hoy
        if ($request->has("expiring_today")) {
            $loans = $loans->whereDate('loans.dateFinish', now()->toDateString())
                ->where('loans.state_id', '=', 1);
        }

        // Filtro de vendcido (retiró pero no devolvió)
        if ($request->has("expired")) {
            $loans = $loans->whereDate('loans.dateFinish', '<', now()->toDateString())
                ->where('loans.removed', '=', 1);
        }

        // Filtro de retiran hoy. Solo muestra approved. 
        if ($request->has("must_pick_up_today")) {
            $loans = $loans->whereDate('loans.dateInit', '=', now()->toDateString())
                ->where('loans.state_id', '=', 1);
        }

        if ($request->has("pending")) {
            $loans = $loans->where('loans.state_id', '=', 3);
        }


        $loans = $loans
            ->select(
                'loans.id as loanId',
                'h.id as toolId',
                'c.id as categoryToolId',
                'c.name as categoryName',
                'h.name as toolName',
                'h.description as description',
                'u.name as name',
                'u.last_name as lastName',
                'loans.dateInit as init',
                'loans.dateFinish as finish',
                'loans.dateClose as close',
                'loans.state_id as state_id',
                'loans.returned as returned',
                'loans.removed  as removed',
            )
            ->orderBy('loans.dateInit', 'asc')
            ->paginate(15);

        // Cantidades
        $expiringTodayCount = LoanModel::whereDate('dateFinish', now()->toDateString())->where('loans.state_id', '=', 1)->count();
        $expiredCount = LoanModel::whereDate('dateFinish', '<', now()->toDateString())->where('loans.removed', '=', 1)->count();
        $mustPickUpTodayCount = LoanModel::whereDate('dateInit', '=', now()->toDateString())->where('loans.state_id', '=', 1)->count();
        $pendingApproval = LoanModel::where('loans.state_id', '=', 3)->count();

        return view('/loans', compact('user', 'loans'))
            ->with('expiringTodayCount', $expiringTodayCount)
            ->with('expiredCount', $expiredCount)
            ->with('mustPickUpTodayCount', $mustPickUpTodayCount)
            ->with('pendingApproval', $pendingApproval);
    }

    public function loanGetForm(){ 
        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();

        $users= User::All();
        $tools = ToolModel::all(); 
        $tool_selectd=null;
        $dates_=[];

        if($user->permisos->name == "Administrador"){
            return view('/loan_new', compact('users', 'tool_selectd', 'tools', 'dates_', 'user'));   
           }else{
            return view('/loan_new', compact( [] , 'tool_selectd', 'tools', 'dates_', 'user'));   //null? o vacio++??
           }
    }

    public function loanSave(Request $request){

        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $users= User::All();

        $dataForm =null;

        if($user->permisos->name == "Administrador"){
            $dataForm = request()->validate([
                'user' => 'required',
                'tool_selectd' => 'required',
                'dates' => 'required',
            ],[
                'user.required' => 'Debe seleccionar una herramienta',
                'tool_selectd.required' => 'Debe seleccionar una herramienta',
                'date.required' => 'Debe ingresar una fecha',
            ]);

        }else{

            $dataForm = request()->validate([
                'tool_selectd' => 'required',
                'dates' => 'required',
            ],[
                'tool_selectd.required' => 'Debe seleccionar una herramienta',
                'date.required' => 'Debe ingresar una fecha',
            ]);
        }

       $datesRequest=$dataForm['dates'];
       $datesTrue=str_contains($datesRequest, "a");

       $userSelected=null;
       if($user->permisos->name == "Administrador"){ 
            $userSelected= (int)$dataForm['user'];
        }else{
            $userSelected=$user->id;
        }

       if($datesTrue){

               $myArray = explode('a', $datesRequest);
            
               $tool_selectd= $this->GetTool((int)$dataForm['tool_selectd']);
               //dd($this-> greaterThanMax($myArray), $this-> existLoans($myArray, $tool_selectd));

               if($this-> greaterThanMax($myArray) || $this-> existLoans($myArray, $tool_selectd)){
                   Session::flash('message', 'Asegúrese de que el máximo de días que eligió no sea mayor a 7, o que el préstamo esté disponible');
                   $dates_=$this->dateEnableByTool($tool_selectd);
                   $tools = null;

                   if($user->permisos->name == "Administrador"){ //Le tiene que mandar si o si el tool_selected y usuarios
                    return view('/loan_new', compact('users', 'tool_selectd', 'tools', 'dates_', 'user'));   
                   }else{
                    return view('/loan_new', compact( 'tool_selectd', 'tools', 'dates_', 'user'));   //null? o vacio++??
                   }

               }else{
                                       
                   if($this-> existLoans($myArray, $tool_selectd)){
                       Session::flash('message', 'Ya existe el préstamo');
                       return redirect()->route('loans');   
                   }
                   $loan = LoanModel::create([
                           'user_id' => $userSelected,
                           'tool_id' => $dataForm['tool_selectd'],
                           'dateInit' => $myArray[0],
                           'dateFinish' => $myArray[count($myArray)-1], 
                           'state_id' => 3,//pendiente                          
                       ]);

                    $loan->save();                    
                    Session::flash('message', 'Ingreso exitoso');                   
                    return redirect()->route('loans');  
               }
       }else{
          $loan = LoanModel::create([
          'user_id' => $userSelected,
          'tool_id' => $dataForm['tool_selectd'],
          'dateInit' => $datesRequest,
          'dateFinish' => $datesRequest,  
          'state_id' => 3,//pendiente     
        ]);

           $loan->save();
           Session::flash('message', 'Ingreso exitoso');
           return redirect()->route('toolsList');   
       }


   }

    private function existLoans($myArray, $tool_id){
        $dates= DB::table('loans AS p')
        ->select('p.dateInit', 'p.dateFinish')
        ->where('tool_id', '=', $tool_id)
        ->where(function ($query) use ($myArray) {
            $query->where('state_id', '=', 1)
                  ->orWhere('state_id', '=', 3)
                  ->where('p.dateInit', '>=', $myArray[0])
                  ->where('p.dateFinish', '<=',  $myArray[count($myArray)-1]);
        })
        ->groupBy('p.dateInit', 'p.dateFinish')
        ->get();
        
        $dates_=$this->convertToArrayDates($dates);

        if(count($dates_)>0){
            return true;
        }
        return false;
    }

    private function greaterThanMax (array $myArray)
    {
        $fecha1 = date('d-m-Y', strtotime($myArray[0]));
        $fecha2 = date('d-m-Y', strtotime($myArray[1]));
        $fecha1 = date_create($fecha1);
        $fecha2 = date_create($fecha2);
        $dif = date_diff($fecha1, $fecha2);

        if($dif->days>=7){
            return true;
        }
        return false;
    }

    public function admin_loan_dates( $id){

        $user = User::find(Auth::user()->id);
        // $user->avatar = Storage::disk('avatares')->url($user->avatar);
        $user->permisos = $user->user_type()->first();
        $user->cfp = $user->cfp()->first();

        $tools = null;
            //dd($id);
            $tool_selectd= $this->GetTool($id);
            $dates_=$this->dateEnableByTool($id);

            if($user->permisos->name == "Administrador"){
    
                $users = User::all();
                return view('loan_new', compact('users', 'tool_selectd', 'tools', 'user', 'dates_'));   
    
            }else{         
                return view('loan_new',  compact( [],'tool_selectd','tools','user', 'dates_'));   
            }

        
    }

    private function GetTool($tool_id){
        $tool_selectd= ToolModel::where('id', $tool_id)->first();
        return $tool_selectd;
    }

    private function dateEnableByTool($tool_id){

        $dt = now();
        $dt->format('Y-m-d');
        $dates= DB::table('loans AS p')
        ->select('p.dateInit', 'p.dateFinish')
        ->where('tool_id', '=', $tool_id)
        ->where(function ($query) use ($dt) {
            $query->where('state_id', '=', 1)
                  ->orWhere('state_id', '=', 3)
                  ->where('p.dateInit', '>=', $dt);
        })
        ->groupBy('p.dateInit', 'p.dateFinish')
        ->get();

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
                array_push($arrayDates, date("Y-m-d H:i:s", strtotime($fechauno)));
            }else{
                $currentDate = date("Y-m-d H:i:s", strtotime($fechauno));
                array_push($arrayDates, $currentDate);

                while(strtotime($fechados) > strtotime($fechauno)) { 
                    $currentDate = date("Y-m-d H:i:s", strtotime($fechauno . " + 1 day"));
    
                    array_push($arrayDates, $currentDate);
                    $fechauno=$currentDate;       
                }
            }
        }
        return $arrayDates;
    }

    public function liberateLoans()
    {
        $now = now()->toDateString();

        $loansToLiberate = LoanModel::where('removed', 0)
            ->where('dateInit', '<', $now)
            ->where('state_id', 1)
            ->get();


        if ($loansToLiberate->count()) {
            foreach ($loansToLiberate as $loan) {
                $id = $loan->id;
                LoanModel::where('id', $id)->update([
                    'state_id' => 3,
                    'dateClose' => now()
                ]);
            }
            info('Loans liberated successfully');

            // Enviar notificacion a admin 
            $admin = User::where('type_id', 5)->first();
            $admin->notify(new LoanLiberatedNotification($loansToLiberate));
        }
    }
}
