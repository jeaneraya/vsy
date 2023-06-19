<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

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
}
