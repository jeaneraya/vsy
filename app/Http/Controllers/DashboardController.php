<?php

namespace App\Http\Controllers;

use App\Models\Batchtransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //

    public function indexxx(Request $request){
        $results['payments'] = DB::table('payments')
        ->whereRaw('payments.id in (select max(id) from payments group by (collector_id)) ') //AND status="active"
        ->leftJoin('users', 'users.id' , '=', 'payments.collector_id')
        ->get();

        $today = Carbon::now();
        $results['nextDueCarbon'] = $today->format('m') >= 15 ? Carbon::now()->endOfMonth() : Carbon::now()->setDay(15);
        $results['nextDueDate'] =  $results['nextDueCarbon']->format('Y-m-d');
        return view('dashboard', ['results' => $results]);
    }
}
