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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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

    public function viewWithdrawals($collector_id, $batch_id, $name) {
        $transactions = DB::table('batchtransactions')
            ->where('id', $batch_id)
            ->get();
    
        $batch_withdrawals = DB::table('batchtransactions')
            ->join('batchdetails', 'batchtransactions.id', '=', 'batchdetails.batch_num')
            ->join('products', 'batchdetails.product_id', '=', 'products.id')
            ->select('batchtransactions.*', 'batchdetails.*', 'products.*')
            ->where('batchtransactions.id', $batch_id)
            ->get();

        $expenses_transactions = DB::table('batchtransactions')
            ->join('expensestransactions', 'batchtransactions.id', '=', 'expensestransactions.batch_num')
            ->join('expenses', 'expensestransactions.expenses_id', '=', 'expenses.id')
            ->select('batchtransactions.*', 'expensestransactions.*','expensestransactions.ID as et_ID', 'expenses.*')
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
    
        return view('collectors.viewbatch', compact('batch_withdrawals', 'transactions', 'expenses_transactions', 'payments'))
            ->with('batch_id', $batchid)
            ->with('collector_name', $collector_name)
            ->with('collector_id', $collectorid);
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
        $addProducts->product_id = $request->input('product_id');
        $addProducts->qty = $request->input('qty');
        $addProducts->total_amount = $request->input('total');
        $addProducts->save();

        $collector_id = $request->input('collector');
        $batch_id = $request->input('batch'); 
        $name = $request->input('collector_name'); 
        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]) . '?openCollapseProducts=true');
    }  
    
    public function updateBatchProduct(Request $request) {
        $update_batch_details = [
            'ref_no'        =>  $request->ref_no,
            'product_id'    =>  $request->product_id,
            'qty'           =>  $request->qty,
            'total_amount'  =>  $request->total
        ];

        // dd($update_batch_details);

        DB::table('batchdetails')->where('id', $request->bdid)->update($update_batch_details);
        $collector_id = $request->collector;
        $batch_id = $request->batch;
        $name = $request->collector_name;

        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]));

    }

    public function deleteBatchProduct($collector_id,$batch_id,$name,$bd_id) {
        DB::table('batchdetails')->where('id', $bd_id)->delete();

        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]));
        
    }

    public function saveBatchExpenses(Request $request) {
        $expensestransactions = new Expensestransaction();
        $expensestransactions->batch_num = $request->input('batch');
        $expensestransactions->expenses_id = $request->input('e_code');
        $expensestransactions->amount = $request->input('amount');
        $expensestransactions->save();

        $collector_id = $request->input('collector');
        $batch_id = $request->input('batch'); 
        $name = $request->input('collector_name'); 
        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]) . '?openCollapseExpenses=true');
    }

    public function updateBatchExpenses(Request $request) {
        $update_batch_expenses = [
            'expenses_id'   =>  $request->e_code,
            'amount'        =>  $request->amount,
            'remarks'       =>  $request->remarks
        ];

        DB::table('expensestransactions')->where('id', $request->et_id)->update($update_batch_expenses);

        $collector_id = $request->collector;
        $batch_id = $request->batch;
        $name = $request->collector_name;

        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name])); 
    }

    public function deleteBatchExpenses($collector_id,$batch_id,$name,$et_id) {
        DB::table('expensestransactions')->where('id',$et_id)->delete();

        return redirect(route('collectors.withdrawals', ['collector_id'=>$collector_id,'batch_id' => $batch_id, 'name' => $name]));

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
}
