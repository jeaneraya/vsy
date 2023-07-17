<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index() {

        $products = Product::where('status', '1')->get();
        return view('products.index', compact('products'));
    }

    public function showInactive() {
        $products = Product::where('status', '0')->get();
        return view('products.index', compact('products'));
    }

    public function showAll() {
        $products = Product::all();

        return view('products.index', compact('products'));
    }
    

    public function saveProduct(Request $request) {
        $product = new Product();
        $product->product_code = $request->input('product_code');
        $product->description = $request->input('description');
        $product->unit = $request->input('unit');
        $product->price = $request->input('price');

        $product->save();

        return redirect('/products')->with('message', 'Product Added Successfully!');
    }

    public function editProduct(Request $request) {
        $update_product = [
            'id' => $request->e_product_id,
            'product_code' =>$request->e_product_code,
            'description' =>$request->e_description,
            'unit' => $request->e_unit,
            'price' => $request->e_price,
            'status' => $request->e_status
        ];

        DB::table('products')->where('id', $request->e_product_id)->update($update_product);
        return redirect('/products');
    }

    public function deleteProduct($id) {
        DB::table('products')->where('id', $id)->delete();

        return redirect('/products');
    }
}
