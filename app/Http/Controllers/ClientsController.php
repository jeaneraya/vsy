<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Clientproduct;
use App\Models\Clienttransaction;
use App\Models\Clienttransdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ClientsController extends Controller
{
    public function index(){

        $clients = Client::all();
        $products = Clientproduct::all();

        return view('clients.index', compact('clients', 'products'));
    }

    public function saveClient(Request $request) {
        $client = new Client();
        $client->client_name = $request->input('client_name');
        $client->client_address = $request->input('client_address');
        $client->contact_person = $request->input('contact_person');
        $client->contact_num = $request->input('contact_num');

        $client->save();

        return redirect('/clients')->with('message', 'Supplier Added Successfully!');

    }

    public function saveClientsProducts(Request $request) {
        $product = new Clientproduct();
        $product->product_code = $request->input('product_code');
        $product->description = $request->input('description');
        $product->unit = $request->input('unit');
        $product->price = $request->input('price');

        $product->save();

        return redirect('/clients' . '?openProductsModal=true');
    }

    public function editClient(Request $request) {
        $update_client = [
            'client_name'     => $request->client_name,
            'client_address'  => $request->e_client_address,
            'contact_person'    => $request->e_contact_person,
            'contact_num'       => $request->e_contact_num
        ];

        DB::table('clients')->where('id', $request->client_id)->update($update_client);

        return redirect('/clients');
    }

    public function deleteClient($id) {
        DB::table('clients')->where('id', $id)->delete();

        return redirect('/clients');
    }

    public function clientTransactions($client_id) { 
        $client_trans = DB::table('clients_transactions')
            ->join('clients_transdetails', 'clients_transactions.id', '=', 'clients_transdetails.client_trans_id')
            ->select('clients_transactions.*', 'clients_transdetails.total as total')
            ->where('clients_transactions.client_id', $client_id)
            ->get();
    

        $client = DB::table('clients')->where('id', $client_id)->first();
        $client_name = $client->client_name;

        $startDate = '';
        $endDate = '';

        return view('clients.transactions', compact('client_trans'),['client_name' => $client_name, 'client_id' => $client_id, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function filterClientTransactions($client_id,Request $request) {

        $startDate = date('Y-m-d', strtotime($request->input('covered-from')));
        $endDate = date('Y-m-d', strtotime($request->input('covered-to')));

        $client_trans = DB::table('clients_transactions')
                        ->join('clients', 'clients_transactions.client_id', 'clients.id')
                        ->where('client_id', $client_id)
                        ->whereBetween('clients_transactions.trans_date', [$startDate, $endDate])
                        ->get();

        $client = DB::table('clients')->where('id', $client_id)->first();
        $client_name = $client->client_name;

        $total_payment = DB::table('client_payments')
        ->where('client_id', $client_id)
        ->sum('amount_paid');

        return view('clients.transactions', compact('client_trans'),['client_name' => $client_name, 'client_id' => $client_id, 'total_payment' => $total_payment, 'startDate' => $startDate, 'endDate' => $endDate]);
    }

    public function printClientTransactions($client_id,Request $request) {

        $startDate = date('Y-m-d', strtotime($request->query('startDate')));
        $endDate = date('Y-m-d', strtotime($request->query('endDate')));

        if ($startDate == '1970-01-01' || $endDate == '1970-01-01') {
            $client_trans = DB::table('clients_transactions')
                ->where('client_id', $client_id)
                ->get();
        } else {
            $client_trans = DB::table('clients_transactions')
                ->where('client_id', $client_id)
                ->whereBetween('clients_transactions.trans_date', [$startDate, $endDate])
                ->get();
        }

        $total_payment = $client_trans->sum('payments');
        $total_charges = $client_trans->sum('charges');
        $balance = $client_trans->sum('balance');

        $client_details = DB::table('clients')->where('id', $client_id)->first();
        $client_name = $client_details->client_name;
        $client_address = $client_details->client_address;
        $contact_person = $client_details->contact_person;
        $contact_num = $client_details->contact_num;

        // dd($supplier_details);
        
        $formattedStartDate = Carbon::parse($startDate)->format('m-d-y');
        $formattedEndDate = Carbon::parse($endDate)->format('m-d-y');

        return view('clients.prints.reports', compact('client_trans'),[
            'startDate'         => $formattedStartDate, 
            'endDate'           => $formattedEndDate,
            'client_name'       => $client_name,
            'client_address'    => $client_address,
            'contact_person'    => $contact_person,
            'contact_num'       => $contact_num,
            'total_payment'     => $total_payment,
            'total_charges'     => $total_charges,
            'balance'           => $balance
        ]);

    }

    public function addClientTransaction(Request $request) {

        $add_client_trans = [
            'trans_date'    =>  $request->trans_date,
            'ref_no'        =>  $request->ref_no,
            'remarks'       =>  $request->remarks,
            'client_id'     =>  $request->cid,
            'trans_description'   =>  $request->description
        ];

        DB::table('clients_transactions')->insert($add_client_trans);
        return redirect()->back();
    }

    public function clientTransDetails($client_id, $trans_id) {
        $trans_details = DB::table('clients_transdetails')
            ->join('clients_products', 'clients_transdetails.product_id', '=', 'clients_products.id')
            ->select('clients_transdetails.*','clients_products.product_code', 'clients_products.description','clients_products.unit', 'clients_products.price')
            ->where('client_trans_id', $trans_id)
            ->get();

        $client = DB::table('clients')->where('id', $client_id)->first();
        $client_name = $client->client_name;

        return view('clients.trans-details', compact('trans_details'),['client_name' => $client_name, 'client_id' => $client_id, 'trans_id' => $trans_id]);
    }

    public function deleteClientTransaction($client_id, $trans_id) {
    
        DB::table('clients_transactions')
            ->where('client_id', $client_id)
            ->where('id', $trans_id)
            ->delete();
        
        return back();
    }

    public function searchClientProductCode(Request $request) {
        $query = $request->input('query');

        $results = DB::table('clients_products')
            ->select('*')
            ->where('description', 'LIKE', '%' . $query . '%')
            ->get();

        $output = '<ul class="form-control list-dropdown" id="client-products-list-ul">';

        if ($results->count() > 0) {
            foreach ($results as $row) {
                $output .= '<li data-productid="' . $row->id . '" data-productcode="' . $row->product_code . '">' . $row->description . '</li>';
            }
        } else {
            $output .= '<li>Product Not Found</li>';
        }

        $output .= '</ul>';

        return $output;
    }

    public function getClientProductPrice(Request $request) {
        $product = $request->query('product');
        $unit = $request->query('unit');

        $product = Clientproduct::where([
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

    public function addClientItems(Request $request) {
        $client_id = $request->input('client_id');
        $trans_id = $request->input('trans_id');
        
        $currentBalance = DB::table('clients_transactions')
        ->where('id', $trans_id)
        ->where('client_id', $client_id)
        ->value('balance');

        $charges = DB::table('Clients_transactions')
        ->where('client_id', $client_id)
        ->where('id', $trans_id)
        ->value('charges');

        $updatedBalance = $currentBalance + $request->total + $charges;

        $insert_items = [
            'client_trans_id'   => $request->input('trans_id'),
            'product_id'        => $request->input('product_id'),
            'qty'               => $request->input('qty'),
            'total'             => $request->input('total')
        ];

        DB::table('clients_transdetails')->insert($insert_items);

        DB::table('clients_transactions')
        ->where('client_id', $client_id)
        ->where('id', $trans_id)
        ->update(['balance' => $updatedBalance]);

        return back()->with('openCollapseClientItems', true);
    }

    public function addClientPayment(Request $request) {
        $payments = DB::table('clients_transactions')
        ->where('id', $request->p_tid)
        ->where('client_id', $request->p_client_id)
        ->value('payments');

        $updatedBalance = $request->balance - $request->amount;
        $totalPayments = $payments + $request->amount; 

        $add_payment = [
            'client_id'        =>  $request->p_client_id,
            'trans_id'         =>  $request->p_tid,
            'amount_paid'      =>  $request->amount, 
            'payment_date'     =>  $request->payment_date,
            'balance'          =>  $updatedBalance  
        ];

        DB::table('clients_transactions')
        ->where('client_id', $request->p_client_id)
        ->where('id', $request->p_tid)
        ->update(['payments' => $totalPayments]);

        DB::table('clients_transactions')
        ->where('client_id', $request->p_client_id)
        ->where('id', $request->p_tid)
        ->update(['balance' => $updatedBalance]);

        DB::table('client_payments')->insert($add_payment);
        return back();
    }
}
