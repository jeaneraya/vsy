<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplist;

class APListController extends Controller
{
    public function index(){
        $aplists = Aplist::all();
        return view('ap_list', compact('aplists'));
    }

    public function saveAPList(Request $request) {
        $aplist = new Aplist();
        $aplist->name = $request->input('name');
        $aplist->remarks = $request->input('remarks');

        $aplist->save();

        return redirect('/ap_list')->with('message', 'AP List Added Successfully!');
    }
}
