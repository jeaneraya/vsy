<?php

namespace App\Http\Controllers;

use App\Models\Batchtransaction;
use App\Models\Employee;
use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use Carbon\Carbon;
use Database\Seeders\UserTableSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function indexxx(Request $request){

        $results['payments'] = DB::table('payments')
        ->whereRaw('payments.id in (select max(id) from payments group by (collector_id)) ') //AND status="active"
        ->leftJoin('users', 'users.id' , '=', 'payments.collector_id')
        ->get();

        $today = Carbon::now();
        $results['nextDueCarbon'] = $today->format('m') >= 15 ? Carbon::now()->endOfMonth() : Carbon::now()->setDay(15);
        $results['nextDueDate'] =  $results['nextDueCarbon']->format('Y-m-d');

        $results['employees'] = Employee::where([[
            'hiring_status', '=', '0' // active
        ]])->get();

        $results['products'] = Product::all();

        $results['collectors'] = User::where([
            ['approval_status', '=', 1] // approved
        ])->whereIn('role', [3, 4])->get();

        $results['total_collection'] = Payment::sum('paid_amount');
        return view('dashboard', ['results' => $results]);
    }
}
