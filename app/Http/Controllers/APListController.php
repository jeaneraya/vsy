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
}
