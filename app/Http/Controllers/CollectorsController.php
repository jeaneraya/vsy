<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collector;
use App\Models\Batchtransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CollectorsController extends Controller
{
    public function index() {

        $collectors = Collector::leftJoin('users', 'users.id', '=', 'collectors.user_id')
            ->where([
            ['users.approval_status', '=', '1']
        ])
        ->get();
        return view('collectors.index', compact('collectors'));
    }

    public function addCollector(Request $request) {
        $validateData = $request->validate([
            'code' => 'required|string|max:10',
            'fullname' => 'required|string|max:255',
            'mobile' => 'string|max:11',
            'address' => 'required|string|max:255'
        ]);

        $user = User::create([
            'name' => $request->input('fullname'),
            'email' => $request->input('email'),
            'birthday' => '2023-01-01', //$request->input('birthday'),
            'address' => $request->input('address'),
            'contact' => $request->input('mobile'),
            'password' => Hash::make($request->input('password')),
            'role' => 3, //$request->input('role'),
            'approval_status' => 1, // approved
        ]);



        Collector::create([
            'user_id' => $user->id,
            'code' => $request->input('code'),
            'cashbond' => $request->input('cashbond'),
            'ctc_no' => $request->input('ctcnum'),
            'status' => 1, // active
        ]);


        return redirect('/collectors')->with('message', 'New Collector Added Successfully!');
    }

    public function viewCollector($id,$name) {
        $batch_trans = DB::table('batchtransactions')
            ->join('collectors', 'batchtransactions.collector_id', '=', 'collectors.id')
            ->select('batchtransactions.*', 'collectors.fullname')
            ->where('batchtransactions.collector_id',$id)
            ->get();

        $collector_id = $id;
        $collector_name = $name;
        $filteredBatchTrans = $batch_trans->where('collector_id', $collector_id);
        $batchTransCount = $filteredBatchTrans->count();
        return view('collectors.view', compact('batch_trans'), ['collector_id' => $id, 'batchTransCount' => $batchTransCount, 'collector_name' => $collector_name]);
    }

    public function saveBatch(Request $request) {
        $batch_trans = new Batchtransaction();
        $batch_trans->num = $request->input('batch_num');
        $batch_trans->period_from = $request->input('period_from');
        $batch_trans->period_to = $request->input('period_to');
        $batch_trans->addon_interest = $request->input('addon_interest');
        $batch_trans->collector_id = $request->input('collector_id');
        $batch_trans->first_collection = $request->input('first_collection');
        $batch_trans->remarks = $request->input('remarks');

        $batch_trans->save();
        $id = $request->input('collector_id');
        $name = $request->input('collector_name');
        return redirect(route('collectors.show', ['id' => $id, 'name' => $name]))->with('message', 'New Batch Added Successfully!');
    }

    public function viewWithdrawals($batch_id,$name) {
        $batch_withdrawals = DB::table('batchtransactions')
            ->join('batchdetails', 'batchtransactions.id', '=', 'batchdetails.batch_num')
            ->join('products', 'batchdetails.product_id', '=', 'products.id')
            ->select('batchtransactions.*', 'batchdetails.*', 'products.*')
            ->where('batchtransactions.id', $batch_id)
            ->get();

        $batchid = $batch_id;
        $collector_name = $name;
        return view('collectors.viewbatch', compact('batch_withdrawals'), ['batch_id' => $batchid, 'collector_name' => $collector_name]);
    }
}
