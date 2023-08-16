<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Supplierproduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class SupplierController extends Controller
{
    public function index(){

        $suppliers = Supplier::all();
        return view('suppliers.index', compact('suppliers'));
    }

    public function saveSupplier(Request $request) {
        $supplier = new Supplier();
        $supplier->supplier_name = $request->input('supplier_name');
        $supplier->supplier_address = $request->input('supplier_address');
        $supplier->contact_person = $request->input('contact_person');
        $supplier->contact_num = $request->input('contact_num');

        $supplier->save();

        return redirect('/suppliers')->with('message', 'Supplier Added Successfully!');

    }

    public function editSupplier(Request $request) {
        $update_supplier = [
            'id'                => $request->supplier_id,
            'supplier_name'     => $request->e_supplier_name,
            'supplier_address'  => $request->e_supplier_address,
            'contact_person'    => $request->e_contact_person,
            'contact_num'       => $request->e_contact_num
        ];

        DB::table('suppliers')->where('id', $request->supplier_id)->update($update_supplier);

        return redirect('/suppliers');
    }

    public function deleteSupplier($id) {
        DB::table('suppliers')->where('id', $id)->delete();

        return redirect('/suppliers');
    }

    public function supplierProducts($supplier_id) {
        $suppliers_products = DB::table('supplier_products')
        ->where('supplier_id', $supplier_id)
        ->where('status', 1)
        ->get();

        $supplier = DB::table('suppliers')->where('id', $supplier_id)->first();
        $supplier_name = $supplier->supplier_name;

        return view('suppliers.product-list',compact('suppliers_products'),['supplier_id' => $supplier_id, 'supplier_name' => $supplier_name]);
    }

    public function supplierProductsInactive($supplier_id) {
        $suppliers_products = DB::table('supplier_products')
        ->where('supplier_id', $supplier_id)
        ->where('status', 0)
        ->get();

        $supplier = DB::table('suppliers')->where('id', $supplier_id)->first();
        $supplier_name = $supplier->supplier_name;

        return view('suppliers.product-list',compact('suppliers_products'),['supplier_id' => $supplier_id, 'supplier_name' => $supplier_name]);
    }

    public function supplierProductsAll($supplier_id) {
        $suppliers_products = DB::table('supplier_products')
        ->where('supplier_id', $supplier_id)
        ->get();

        $supplier = DB::table('suppliers')->where('id', $supplier_id)->first();
        $supplier_name = $supplier->supplier_name;

        return view('suppliers.product-list',compact('suppliers_products'),['supplier_id' => $supplier_id, 'supplier_name' => $supplier_name]);
    }

    public function addSupplierProduct(Request $request) {
        $new_supplier_products = [
            'supplier_id'       =>  $request->query('supplier_id'),
            'item_code'         =>  $request->input('item_code'),
            'item_description'  =>  $request->input('description'),
            'unit'              =>  $request->input('unit'),
            'price'             =>  $request->input('price') 
        ];

        DB::table('supplier_products')->insert($new_supplier_products);

        return back();
    }

    public function editSupplierProduct(Request $request) {
        $update_supplier_products = [
            "item_code"         =>  $request->e_item_code,
            "item_description"  =>  $request->e_description,
            "unit"              =>  $request->e_unit,
            "price"             =>  $request->e_price,
            "status"            =>  $request->e_status
        ];

        DB::table('supplier_products')->where('id', $request->pid)->update($update_supplier_products);

        return back();
    }

    public function deleteSupplierProduct(Request $request) {
        DB::table('supplier_products')->where('id', $request->query('product_id'))->delete();
        return back();
    }

    public function supplierTransactions($supplier_id) { 
        $supplier_trans = DB::table('supplier_transactions')
                        ->where('supplier_id', $supplier_id)
                        ->get();

        $supplier = DB::table('suppliers')->where('id', $supplier_id)->first();
        $supplier_name = $supplier->supplier_name;
        $supplier_id = $supplier->id;

        $total_payment = DB::table('supplier_payments')
        ->where('supplier_id', $supplier_id)
        ->sum('amount_paid');

        $startDate = '';
        $endDate = '';

        return view('suppliers.transactions', compact('supplier_trans'),['supplier_name' => $supplier_name, 'supplier_id' => $supplier_id, 'total_payment' => $total_payment, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function filterSupplierTransactions($supplier_id,Request $request) {

        $startDate = date('Y-m-d', strtotime($request->input('covered-from')));
        $endDate = date('Y-m-d', strtotime($request->input('covered-to')));

        $supplier_trans = DB::table('supplier_transactions')
                        ->join('suppliers', 'supplier_transactions.supplier_id', 'suppliers.id')
                        ->where('supplier_id', $supplier_id)
                        ->whereBetween('supplier_transactions.trans_date', [$startDate, $endDate])
                        ->get();

        $supplier = DB::table('suppliers')->where('id', $supplier_id)->first();
        $supplier_name = $supplier->supplier_name;
        $supplier_id = $supplier->id;

        $total_payment = DB::table('supplier_payments')
        ->where('supplier_id', $supplier_id)
        ->sum('amount_paid');

        return view('suppliers.transactions', compact('supplier_trans'),['supplier_name' => $supplier_name, 'supplier_id' => $supplier_id, 'total_payment' => $total_payment, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function printSupplierTransactions($supplier_id,Request $request) {

        $startDate = date('Y-m-d', strtotime($request->query('startDate')));
        $endDate = date('Y-m-d', strtotime($request->query('endDate')));

        if ($startDate == '1970-01-01' || $endDate == '1970-01-01') {
            $supplier_trans = DB::table('supplier_transactions')
                ->where('supplier_id', $supplier_id)
                ->get();
        } else {
            $supplier_trans = DB::table('supplier_transactions')
                ->where('supplier_id', $supplier_id)
                ->whereBetween('supplier_transactions.trans_date', [$startDate, $endDate])
                ->get();
        }

        $total_payment = $supplier_trans->sum('payments');
        $total_charges = $supplier_trans->sum('charges');
        $balance = $supplier_trans->sum('balance');

        $supplier_details = DB::table('suppliers')->where('id', $supplier_id)->first();
        $supplier_name = $supplier_details->supplier_name;
        $supplier_address = $supplier_details->supplier_address;
        $contact_person = $supplier_details->contact_person;
        $contact_num = $supplier_details->contact_num;

        // dd($supplier_details);
        
        $formattedStartDate = Carbon::parse($startDate)->format('m-d-y');
        $formattedEndDate = Carbon::parse($endDate)->format('m-d-y');

        return view('suppliers.prints.reports', compact('supplier_trans'),[
            'startDate'         => $formattedStartDate, 
            'endDate'           => $formattedEndDate,
            'supplier_name'     => $supplier_name,
            'supplier_address'  => $supplier_address,
            'contact_person'    => $contact_person,
            'contact_num'       => $contact_num,
            'total_payment'     => $total_payment,
            'total_charges'     => $total_charges,
            'balance'           => $balance
        ]);

    }

    public function addSupplierTransaction(Request $request) {
        $add_supplier_trans = [
            'trans_date'    =>  $request->trans_date,
            'ref_no'        =>  $request->ref_no,
            'charges'       =>  $request->charges,
            'remarks'       =>  $request->remarks,
            'supplier_id'   =>  $request->sid,
            'trans_description'   =>  $request->description
        ];

        DB::table('supplier_transactions')->insert($add_supplier_trans);
        return back();
    }

    public function deleteSupplierTransaction($supplier_id, $trans_id) {
    
        DB::table('supplier_transactions')
            ->where('supplier_id', $supplier_id)
            ->where('id', $trans_id)
            ->delete();
        
        return back();
    }

    public function supplierTransDetails($supplier_id, $trans_id) {
        $trans_details = DB::table('supplier_trans_details')
            ->join('supplier_products', 'supplier_trans_details.product_id', '=', 'supplier_products.id')
            ->select('supplier_trans_details.*','supplier_products.item_code', 'supplier_products.item_description','supplier_products.unit', 'supplier_products.price')
            ->where('supplier_trans_id', $trans_id)
            ->get();

        $supplier = DB::table('suppliers')->where('id', $supplier_id)->first();
        $supplier_name = $supplier->supplier_name;

        return view('suppliers.trans-details', compact('trans_details'),['supplier_name' => $supplier_name, 'supplier_id' => $supplier_id, 'trans_id' => $trans_id]);
    }

    public function searchSupplierProductCode(Request $request) {
        $query = $request->input('query');
        $supplier_id = $request->input('supplier_id');

        $results = DB::table('supplier_products')
            ->select('*')
            ->where('item_description', 'LIKE', '%' . $query . '%')
            ->where('supplier_id', $supplier_id)
            ->get();

        $output = '<ul class="form-control list-dropdown" id="supplier-products-list-ul">';

        if ($results->count() > 0) {
            foreach ($results as $row) {
                $output .= '<li data-productid="' . $row->id . '" data-productcode="' . $row->item_code . '">' . $row->item_description . '</li>';
            }
        } else {
            $output .= '<li>Product Not Found</li>';
        }

        $output .= '</ul>';

        return $output;
    }

    public function getSupplierProductPrice(Request $request) {
        $product = $request->query('product');
        $unit = $request->query('unit');

        $product = Supplierproduct::where([
            ['id', '=', $product],
            ['unit', '=', $unit]
        ])->first();        

        if ($product) {
            $price = $product->price;
        } else {
            $price = null; 
        }

        return response()->json($price);
    }

    public function addSupplierItems(Request $request) {
        $supplier_id = $request->supplier_id;
        
        $currentBalance = DB::table('supplier_transactions')
        ->where('id', $request->trans_id)
        ->where('supplier_id', $supplier_id)
        ->value('balance');

        $currentBalance == null ? $currentBalance = 0 : $currentBalance = $currentBalance;

        $charges = DB::table('supplier_transactions')
        ->where('supplier_id', $supplier_id)
        ->where('id', $request->trans_id)
        ->value('charges');

        $updatedBalance = $currentBalance + $request->total + $charges;

        $insert_items = [
            'supplier_trans_id' => $request->trans_id,
            'product_id'        => $request->product_id,
            'qty'               => $request->qty,
            'total'             => $request->total
        ];

        DB::table('supplier_trans_details')->insert($insert_items);

        $update_balance = ['balance' => $updatedBalance];

        DB::table('supplier_transactions')
        ->where('supplier_id', $supplier_id)
        ->where('id', $request->trans_id)
        ->update($update_balance);

        return back()->with('openCollapseSupplierItems', true);
    }

    public function supplierPayment(Request $request) {

        $payments = DB::table('supplier_transactions')
        ->where('id', $request->p_stid)
        ->where('supplier_id', $request->p_supplier_id)
        ->value('payments');

        $updatedBalance = $request->balance - $request->amount;
        $totalPayments = $payments + $request->amount; 

        $add_payment = [
            'supplier_id'      =>  $request->p_supplier_id,
            'trans_id'         =>  $request->p_stid,
            'amount_paid'      =>  $request->amount, 
            'payment_date'     =>  $request->payment_date,
            'balance'          =>  $updatedBalance  
        ];

        DB::table('supplier_transactions')
        ->where('supplier_id', $request->p_supplier_id)
        ->where('id', $request->p_stid)
        ->update(['payments' => $totalPayments]);

        DB::table('supplier_transactions')
        ->where('supplier_id', $request->p_supplier_id)
        ->where('id', $request->p_stid)
        ->update(['balance' => $updatedBalance]);

        DB::table('supplier_payments')->insert($add_payment);
        return back();
    }
}
