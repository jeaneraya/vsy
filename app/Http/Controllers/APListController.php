<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplist;
use App\Models\Aplisttransaction;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class APListController extends Controller
{
    public function index(){
        $aplists = Aplist::where('status', '1')->get();
        return view('ap-list.ap_list', compact('aplists'));
    }

    public function aplistInactive() {
        $aplists = Aplist::where('status', '0')->get();
        return view('ap-list.ap_list', compact('aplists'));
    }

    public function aplistAll() {
        $aplists = Aplist::all();
        return view('ap-list.ap_list', compact('aplists'));
    }

    public function saveAPList(Request $request) {
        $aplist = new Aplist();
        $aplist->name = $request->input('name');
        $aplist->remarks = $request->input('remarks');

        $aplist->save();

        return redirect('/ap_list')->with('message', 'AP List Added Successfully!');
    }

    public function editAPList(Request $request) {
        $update_aplist = [
            'id'        => $request->e_id,
            'name'      => $request->e_name,
            'remarks'   => $request->e_remarks,
            'status'    => $request->e_status
        ];

        DB::table('aplists')->where('id', $request->e_id)->update($update_aplist);
        return redirect('/ap_list');
    }

    public function deleteAPList($id) {
        DB::table('aplists')->where('id', $id)->delete();
        return redirect('/ap_list');
    }

    public function aplistTransactions($ap_id) {
        $aplist_trans = DB::table('aplist_transactions')->where('ap_id', $ap_id)->get();
        $aplist = DB::table('aplists')->where('id', $ap_id)->first();
        $ap_name = $aplist->name;
        $ap_remarks = $aplist->remarks;

        return view('ap-list.transactions', compact('aplist_trans'),['ap_name' => $ap_name, 'ap_id' => $ap_id, 'ap_remarks' => $ap_remarks]);
    }

    public function addAPListTransaction(Request $request) {

        $ap_new_trans = [
            'ap_id'             =>  $request->ap_id,
            'schedule_date'     =>  $request->schedule_date,
            'amount_payable'    =>  $request->amount_payable,
            'remarks'           =>  $request->remarks
        ];

        DB::table('aplist_transactions')->insert($ap_new_trans);

        return back();
    }

    public function addAPListPayment(Request $request) {
        $ap_new_payment = [
            'ap_id'         =>  $request->p_apid,
            'schedule_date' =>  $request->p_schedule_date,
            'amount_paid'   =>  $request->p_amount,
            'remarks'       =>  $request->p_remarks,
            'type'          =>  $request->p_type,
            'bank'          =>  $request->p_bank,
            'check_num'     =>  $request->p_check_num
        ];

        DB::table('aplist_transactions')->insert($ap_new_payment);

        return back();
    }

    public function postApTransaction($ap_id,$detail_id, Request $request) {
        $balance = DB::table('aplist_transactions')
        ->select('balance')
        ->where('ap_id', $ap_id)
        ->where('id', '<', $detail_id)
        ->orderBy('id', 'desc')
        ->limit(1)
        ->value('balance');

        if($balance == null) {
            $balance = 0;
        }

        if($request->query('apy') != 0) {
            $balance += $request->query('apy');
        }

        if($request->query('ap') != 0) {
            $balance -= $request->query('ap');
        }

        DB::table('aplist_transactions')
        ->where('ap_id', $ap_id)
        ->where('id', $detail_id)
        ->update(['post_status' => 1, 'balance' => $balance]);

        return back();
    }

    public function accountsPayable() {
        $accounts_payable = DB::table('aplist_transactions')
        ->join('aplists', 'aplist_transactions.ap_id', '=', 'aplists.id')
        ->join(DB::raw('(SELECT ap_id, MAX(id) AS max_id FROM aplist_transactions WHERE amount_paid <> 0 GROUP BY ap_id) AS latest_transactions'), function ($join) {
            $join->on('aplist_transactions.ap_id', '=', 'latest_transactions.ap_id')
                ->on('aplist_transactions.id', '=', 'latest_transactions.max_id');
        })
        ->select('aplist_transactions.*', 'aplists.name')
        ->orderBy('aplist_transactions.schedule_date', 'asc')
        ->get();    

        $startDate = '';
        $endDate = '';
        
        return view('ap-list.reports', compact('accounts_payable'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function periodCovered(Request $request) {
        
        $startDate = date('Y-m-d', strtotime($request->input('covered-from')));
        $endDate = date('Y-m-d', strtotime($request->input('covered-to')));
        
        $accounts_payable = DB::table('aplist_transactions')
            ->join('aplists', 'aplist_transactions.ap_id', '=', 'aplists.id')
            ->join(DB::raw('(SELECT ap_id, MAX(id) AS max_id FROM aplist_transactions WHERE amount_paid <> 0 GROUP BY ap_id) AS latest_transactions'), function ($join) {
                $join->on('aplist_transactions.ap_id', '=', 'latest_transactions.ap_id')
                    ->on('aplist_transactions.id', '=', 'latest_transactions.max_id');
            })
            ->select('aplist_transactions.*', 'aplists.name')
            ->where('post_status','=', 0)
            ->whereBetween('aplist_transactions.schedule_date', [$startDate, $endDate])
            ->orderBy('aplist_transactions.schedule_date', 'asc')
            ->get();  
        
        return view('ap-list.reports', compact('accounts_payable'), ['startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function printPayables(Request $request) {
        $startDate = date('Y-m-d', strtotime($request->query('startDate')));
        $endDate = date('Y-m-d', strtotime($request->query('endDate')));
        
        $accounts_payable = DB::table('aplist_transactions')
            ->join('aplists', 'aplist_transactions.ap_id', '=', 'aplists.id')
            ->join(DB::raw('(SELECT ap_id, MAX(id) AS max_id FROM aplist_transactions WHERE amount_paid <> 0 GROUP BY ap_id) AS latest_transactions'), function ($join) {
                $join->on('aplist_transactions.ap_id', '=', 'latest_transactions.ap_id')
                    ->on('aplist_transactions.id', '=', 'latest_transactions.max_id');
            })
            ->select('aplist_transactions.*', 'aplists.name')
            ->where('post_status','=', 0)
            ->whereBetween('aplist_transactions.schedule_date', [$startDate, $endDate])
            ->orderBy('aplist_transactions.schedule_date', 'asc')
            ->get();  

        $formattedStartDate = Carbon::parse($startDate)->format('m-d-y');
        $formattedEndDate = Carbon::parse($endDate)->format('m-d-y');
    
        return view('ap-list.prints.reports',compact('accounts_payable'), ['startDate' => $formattedStartDate, 'endDate' => $formattedEndDate]);
    }
}
