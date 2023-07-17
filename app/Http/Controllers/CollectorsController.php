<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collector;
use App\Models\Batchtransaction;
use App\Models\User;
use App\Models\Batchdetail;
use App\Models\Product;
use App\Models\Expensestransaction;
use App\Models\Payment;
use App\Models\Stockdelivery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CollectorsController extends Controller
{
    public function index() {

        $collectors = Collector::leftJoin('users', 'users.id', '=', 'collectors.user_id')
        ->where([
            ['users.approval_status', '=', '1'],
            ['collectors.status', '=', '1']
        ])
        ->get();

        return view('collectors.index', compact('collectors'));
    }

    public function collectorsInactive() {

        $collectors = Collector::leftJoin('users', 'users.id', '=', 'collectors.user_id')
        ->where([
            ['users.approval_status', '=', '1'],
            ['collectors.status', '=', '0']
        ])
        ->get();

        return view('collectors.index', compact('collectors'));
    }

    public function collectorsAll() {

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
            'birthday' => $request->input('bday'),
            'address' => $request->input('address'),
            'contact' => $request->input('mobile'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
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

    public function editCollector(Request $request) {
        $update_users = [
            "name"      =>  $request->e_name,
            "birthday"  =>  $request->e_bday,
            "address"   =>  $request->e_address,
            "contact"   =>  $request->e_mobile,
            "role"      =>  $request->e_role    
        ];

        $update_collector = [
            "code"      =>  $request->e_code,
            "cashbond"  =>  $request->e_cashbond,
            "ctc_no"    =>  $request->e_ctcnum,
            "status"    =>  $request->e_status,
        ];

        DB::table('users')->where('id', $request->e_id)->update($update_users);
        DB::table('collectors')->where('user_id', $request->e_id)->update($update_collector);

        return redirect('/collectors');
    }

    public function deleteCollector($id) {
        DB::table('users')->where('id', $id)->delete();
        DB::table('collectors')->where('user_id',$id)->delete();

        return redirect('/collectors');
    }

    public function viewCollector($id,$name) {
        $batch_trans = DB::table('batchtransactions')
            ->join('users', 'batchtransactions.collector_id', '=', 'users.id')
            ->select('batchtransactions.*', 'users.name')
            ->where('batchtransactions.collector_id', $id)
            ->where('status', '1')
            ->get();

        //dd($batch_trans);

        $collector_id = $id;
        $collector_name = $name;
        $filteredBatchTrans = $batch_trans->where('collector_id', $collector_id);
        $batchTransCount = $filteredBatchTrans->count();
        return view('collectors.view', compact('batch_trans'), ['collector_id' => $id, 'batchTransCount' => $batchTransCount, 'collector_name' => $collector_name]);
    }

    public function viewCollectorInactive($id,$name) {
        $batch_trans = DB::table('batchtransactions')
            ->join('users', 'batchtransactions.collector_id', '=', 'users.id')
            ->select('batchtransactions.*', 'users.name')
            ->where('batchtransactions.collector_id', $id)
            ->where('status', '0')
            ->get();

        //dd($batch_trans);

        $collector_id = $id;
        $collector_name = $name;
        $filteredBatchTrans = $batch_trans->where('collector_id', $collector_id);
        $batchTransCount = $filteredBatchTrans->count();
        return view('collectors.view', compact('batch_trans'), ['collector_id' => $id, 'batchTransCount' => $batchTransCount, 'collector_name' => $collector_name]);
    }

    public function viewCollectorAll($id,$name) {
        $batch_trans = DB::table('batchtransactions')
            ->join('users', 'batchtransactions.collector_id', '=', 'users.id')
            ->select('batchtransactions.*', 'users.name')
            ->where('batchtransactions.collector_id', $id)
            ->get();

        //dd($batch_trans);

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

    public function editBatch(Request $request) {
        $update_batch = [
            'period_from'       => $request->e_period_from,
            'period_to'         => $request->e_period_to,
            'remarks'           => $request->e_remarks,
            'first_collection'  => $request->e_first_collection,
            'addon_interest'    => $request->e_addon_interest,
            'status'            => $request->e_status  
        ];

        DB::table('batchtransactions')->where('id', $request->e_batch_id)->update($update_batch);

        $id = $request->input('collector_id');
        $name = $request->input('collector_name');

        return redirect(route('collectors.show', ['id' => $id, 'name' => $name]));
    }

    public function deleteBatch($collector_id,$batch_id,$name) {
        DB::table('batchtransactions')->where('id', $batch_id)->delete();
        DB::table('batchdetails')->where('batch_num', $batch_id)->delete();

        return redirect(route('collectors.show', ['id' => $collector_id, 'name' => $name]));
    }

    public function viewWithdrawals($collector_id, $batch_id, $name) {
        $users_infos = DB::table('users')
        ->join('collectors', 'users.id', '=', 'collectors.user_id')
        ->select('users.*','collectors.*')
        ->where('users.id', '=', $collector_id)
        ->get();

        $transactions = DB::table('batchtransactions')
            ->where('id', $batch_id)
            ->get();
    
        $batch_withdrawals = DB::table('batchtransactions')
            ->join('batchdetails', 'batchtransactions.id', '=', 'batchdetails.batch_num')
            ->join('products', 'batchdetails.product_id', '=', 'products.id')
            ->select('batchtransactions.*', 'batchdetails.*', 'batchdetails.ID as batchdetails_ID', 'products.*')
            ->where('batchtransactions.id', $batch_id)
            ->get();

        $expenses_transactions = DB::table('batchtransactions')
            ->join('expensestransactions', 'batchtransactions.id', '=', 'expensestransactions.batch_num')
            ->join('expenses', 'expensestransactions.expenses_id', '=', 'expenses.id')
            ->select('batchtransactions.*', 'expensestransactions.*', 'expenses.*')
            ->where('batchtransactions.id', $batch_id)
            ->get();

        $payments = DB::table('batchtransactions')
            ->join('payments', 'batchtransactions.id', '=', 'payments.batch_id')
            ->select('batchtransactions.*', 'payments.*')
            ->where('batchtransactions.id', $batch_id)
            ->get();
    
        $batchid = $batch_id;
        $collector_name = $name;
        $collectorid = $collector_id;

        if(request()->routeIs('collectors.withdrawals')) { 
            return view('collectors.viewbatch', compact('users_infos','batch_withdrawals', 'transactions', 'expenses_transactions', 'payments'))
            ->with('batch_id', $batchid)
            ->with('collector_name', $collector_name)
            ->with('collector_id', $collectorid);
        } elseif (request()->routeIs('print-expenses-summary')) {
            return view('collectors.printables.expenses_summary', compact('users_infos','batch_withdrawals', 'transactions', 'expenses_transactions', 'payments'))
            ->with('batch_id', $batchid)
            ->with('collector_name', $collector_name)
            ->with('collector_id', $collectorid);
        } elseif (request()->routeIs('trust-receipt')) {
            return view('collectors.printables.trust_receipt', compact('users_infos','batch_withdrawals', 'transactions', 'expenses_transactions', 'payments'))
            ->with('batch_id', $batchid)
            ->with('collector_name', $collector_name)
            ->with('collector_id', $collectorid);
        }
    
    }

    public function searchProductCode(Request $request) {
        $query = $request->input('query');

        $results = DB::table('products')
            ->select('*')
            ->where('product_code', 'LIKE', '%' . $query . '%')
            ->get();

        $output = '<ul class="form-control list-dropdown" id="product-list-ul">';

        if ($results->count() > 0) {
            foreach ($results as $row) {
                $output .= '<li data-productid="' . $row->id . '" data-productcode="' . $row->product_code . '" data-productprice="' . $row->price . '" data-unit="' . $row->unit . '" data-productname="' . $row->description . '">' . $row->description . '</li>';
            }
        } else {
            $output .= '<li>Product Not Found</li>';
        }

        $output .= '</ul>';

        return $output;
    }

    public function searchExpensesCode(Request $request) {
        $query = $request->input('query');

        $results = DB::table('expenses')
            ->select('*')
            ->where('code', 'LIKE', '%' . $query . '%')
            ->get();

        $output = '<ul class="form-control list-dropdown" id="expenses-list-ul">';

        if ($results->count() > 0) {
            foreach ($results as $row) {
                $output .= '<li data-expensesid="' . $row->id . '" data-expensescode="' . $row->code . '">' . $row->description . '</li>';
            }
        } else {
            $output .= '<li>Expenses Not Found</li>';
        }

        $output .= '</ul>';

        return $output;
    }

    public function getProductPrice(Request $request) {
        $product = $request->query('product');
        $unit = $request->query('unit');

        $product = Product::where([
            ['product_code', '=', $product],
            ['unit', '=', $unit]
        ])->first();        

        if ($product) {
            $price = $product->price;
        } else {
            $price = null; 
        }

        return response()->json($price);
    }
    
    public function saveBatchProduct(Request $request) {
        $addProducts = new Batchdetail();
        $addProducts->batch_num = $request->input('batch');
        $addProducts->ref_no = $request->input('ref_no');
        $addProducts->product_id = $request->input('product_id');
        $addProducts->qty = $request->input('qty');
        $addProducts->total_amount = $request->input('total');
        $addProducts->save();

        $collector_id = $request->input('collector');
        $batch_id = $request->input('batch'); 
        $name = $request->input('collector_name'); 
        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]) . '?openCollapse=true');
    }  
    
    public function saveBatchExpenses(Request $request) {
        $expensestransactions = new Expensestransaction();
        $expensestransactions->batch_num = $request->input('batch');
        $expensestransactions->expenses_id = $request->input('code');
        $expensestransactions->amount = $request->input('amount');
        $expensestransactions->remarks = $request->input('remarks');
        $expensestransactions->save();

        $collector_id = $request->input('collector');
        $batch_id = $request->input('batch'); 
        $name = $request->input('collector_name'); 
        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]))->with('message', 'New Product Added Successfully!');
    }

    public function addPayment(Request $request) {
        // dd($request->all());
        $collector = $request->input('collector');
        $rem_balance = $request->input('total_credit');

        $date_details = DB::table('batchtransactions')
            ->select('first_collection')
            ->where('collector_id', $collector)
            ->get();

        $amount = $request->input('amount');
        $new_balance = $rem_balance - $amount;

        $datepayment = $request->input('payment_date');

        $date_details = Carbon::parse($date_details[0]->first_collection);
        $datepayment = Carbon::parse($datepayment);
        $intervalDays = $date_details->diffInDays($datepayment);

        $payment = new Payment();
        $payment->batch_id = $request->input('batch');
        $payment->collector_id = $request->input('collector');
        $payment->payment_date = $request->input('payment_date');
        $payment->paid_amount = $request->input('amount');
        $payment->balance = $new_balance;
        $payment->mop = $request->input('mop');
        $payment->mop_details = $request->input('mop_details');
        $payment->days = $intervalDays;
        $payment->save();

        $collector_id = $request->input('collector');
        $batch_id = $request->input('batch'); 
        $name = $request->input('collector_name'); 
        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]))->with('message', 'Payment Added Successfully!');
        
    }

    public function getEditPaymentData($payment_id) {
        $payment_datas = DB::table('payments')
            ->select('*')
            ->where('id', $payment_id)
            ->get();
            return response()->json(['payment_datas' => $payment_datas]);
    }

    public function editPayment(Request $request) {
        $payment_id = $request->input('payid');
        $current_amount = $request->input('current-amount');
        $current_balance = $request->input('current-balance');
        $updated_amount = $request->input('edit-amount');
        $collector_id = $request->input('collector');
        $result = $current_amount - $updated_amount;

        if ($current_amount > $updated_amount) {
            $new_balance = $current_balance + $result;
        } else if ($current_amount < $updated_amount) {
            $new_balance = $current_balance - abs($result);
        } else {
            $new_balance = $current_balance;
        }

        $date_details = DB::table('batchtransactions')
            ->select('first_collection')
            ->where('collector_id', $collector_id)
            ->get();
        
        $datepayment = $request->input('edit-payment-date');

        $date_details = Carbon::parse($date_details[0]->first_collection);
        $datepayment = Carbon::parse($datepayment);
        $intervalDays = $date_details->diffInDays($datepayment);
        
        $update_payment = Payment::find($payment_id);

        $update_payment->payment_date = $request->input('edit-payment-date');
        $update_payment->days = $intervalDays;
        $update_payment->paid_amount = $request->input('edit-amount');
        $update_payment->mop = $request->input('edit-mop');
        $update_payment->mop_details = $request->input('edit-mop-details');
        $update_payment->balance = $new_balance;
        $update_payment->save();

        $collector_id = $request->input('collector');
        $batch_id = $request->input('batch'); 
        $name = $request->input('collector_name'); 
        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]))->with('message', 'Payment Added Successfully!');
        
    }

    public function deletePayment(Request $request) {
        $ids = $request->ids;
        Payment::whereIn('id', $ids)->delete();
        return response()->json(['success' => "Data has been deleted successfully"]);
      }      

    public function stockDelivery($userid,$name) {
        $stock_deliveries = DB::table('stockdeliveries')
            ->where('stockdeliveries.am_id', '=', $userid)
            ->get();

        $previousBalance = DB::table('stockdeliveries')
        ->select('balance')
        ->where('id', function ($query) {
            $query->select(DB::raw('MAX(id) - 1'))
                ->from('stockdeliveries');
        })
        ->value('balance');
        
        

        $collector_name = $name;
        $collector_id = $userid;
        return view('collectors.stockdelivery', compact('stock_deliveries'), ['previousBalance' => $previousBalance,'collector_name' => $collector_name, 'collector_id' => $collector_id]);
    }

    public function addStockDelivery(Request $request) {
        $currentdate = Carbon::today();

        $previousBalance = DB::table('stockdeliveries')
        ->select('balance')
        ->where('id', function ($query) {
            $query->select(DB::raw('MAX(id) - 1'))
                ->from('stockdeliveries');
        })
        ->value('balance');

        if($previousBalance == NULL) {
            $previousBalance = 0;
        } else {
            $previousBalance = DB::table('stockdeliveries')
        ->select('balance')
        ->where('id', function ($query) {
            $query->select(DB::raw('MAX(id)'))
                ->from('stockdeliveries');
        })
        ->value('balance');
        }

        $new_stock_delivery = new Stockdelivery();
        $new_stock_delivery->covered_date = $request->input('covered_date');
        $new_stock_delivery->am_id = $request->input('am_id');
        $new_stock_delivery->description = $request->input('description');
        $new_stock_delivery->dr_num = $request->input('dr_num');
        $new_stock_delivery->total_delivery = $request->input('total_delivery');
        $new_stock_delivery->credit_limit = $request->input('credit_limit');
        $new_stock_delivery->balance = $request->input('total_delivery') + $previousBalance;
        $new_stock_delivery->cutoff_date = $request->input('covered_date');

        $new_stock_delivery->save();

        $collector_id = $request->input('am_id');
        $collector_name = $request->input('name');

        return redirect(route('stock-delivery', ['user_id' => $collector_id, 'name' => $collector_name] ))->with('message', 'Transaction Added Successfully');
    }

    public function addStockPayment(Request $request) {
        $prev_balance = $request->input('balance');

        $new_stock_payment = new Stockdelivery();
        $new_stock_payment->description = $request->input('description');
        $new_stock_payment->amount_paid = $request->input('amount_paid');
        $new_stock_payment->am_id = $request->input('am_id');
        $new_stock_payment->balance = $prev_balance - $request->input('amount_paid');
        $new_stock_payment->save();

        $collector_id = $request->input('am_id');
        $collector_name = $request->input('name');

        return redirect(route('stock-delivery', ['user_id' => $collector_id, 'name' => $collector_name] ))->with('message', 'Transaction Added Successfully');
    }

    public function printStockDelivery($userid,$name) {
        $am_infos = DB::table('users')
            ->join('collectors', 'users.id', '=', 'collectors.user_id')
            ->select('users.*','collectors.*')
            ->where('users.id', '=', $userid)
            ->get();

        $stock_deliveries = DB::table('stockdeliveries')
            ->where('stockdeliveries.am_id', '=', $userid)
            ->get();
        
        $previousBalance = DB::table('stockdeliveries')
        ->select('balance')
        ->where('id', function ($query) {
            $query->select(DB::raw('MAX(id) - 1'))
                ->from('stockdeliveries');
        })
        ->value('balance');

        $collector_name = $name;
        $collector_id = $userid;
        return view('collectors.printables.printstockdelivery', compact('stock_deliveries','am_infos'), ['previousBalance' => $previousBalance,'collector_name' => $collector_name, 'collector_id' => $collector_id]);
    }
}
