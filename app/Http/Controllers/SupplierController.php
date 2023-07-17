<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
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
}
