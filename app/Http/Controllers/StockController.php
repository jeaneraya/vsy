<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class StockController extends Controller
{
    public function index() {

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
}
