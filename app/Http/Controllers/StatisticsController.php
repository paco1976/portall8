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


class StatisticsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
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


        $loans = null;

        // Cantidades
        $expiringTodayCount = LoanModel::whereDate('dateFinish', now()->toDateString())->where('loans.state_id', '=', 1)->count();
        $expiredCount = LoanModel::whereDate('dateFinish', '<', now()->toDateString())->where('loans.removed', '=', 1)->count();
        $visitsCount = LoanModel::whereDate('dateInit', '=', now()->toDateString())->where('loans.state_id', '=', 1)->count();
        $pendingApproval = LoanModel::where('loans.state_id', '=', 3)->count();

        return view('/admin.statisticsPanel', compact('user', 'loans'))
            ->with('expiringTodayCount', $expiringTodayCount)
            ->with('expiredCount', $expiredCount)
            ->with('visitsCount', $visitsCount)
            ->with('pendingApproval', $pendingApproval);
    }

}
