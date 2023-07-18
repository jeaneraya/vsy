<?php

namespace App\Http\Controllers;

use App\Models\Batchtransaction;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\UserTableSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function indexxx(Request $request){
        $results['payments'] = DB::table('payments')
        ->whereRaw('payments.id in (select min(id) from payments where payment_status = "unpaid" group by (collector_id))')
        ->leftJoin('users', 'users.id' , '=', 'payments.collector_id')
        ->get()
        ->sortBy('payment_sched');

        $today = Carbon::now();
        $results['nextDueCarbon'] = $today->format('m') >= 15 ? Carbon::now()->endOfMonth() : Carbon::now()->setDay(15);
        $results['nextDueDate'] =  $results['nextDueCarbon']->format('Y-m-d');

        $results['employees'] = Employee::where([[
            'hiring_status', '=', '0' // active
        ]])->get();

        $results['collectors'] = User::where([
            ['role', '=', '3'], // collector
            ['approval_status', '=', 1] // approved
            ])->get();
        return view('dashboard', ['results' => $results]);
    }
}
