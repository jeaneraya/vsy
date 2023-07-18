<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplist;
use Illuminate\Support\Facades\DB;

class APListController extends Controller
{
    public function index(){
        $aplists = Aplist::where('status', '1')->get();
        return view('ap_list', compact('aplists'));
    }

    public function aplistInactive() {
        $aplists = Aplist::where('status', '0')->get();
        return view('ap_list', compact('aplists'));
    }

    public function aplistAll() {
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

    public function editAPList(Request $request) {
        $update_aplist = [
            'id'        => $request->e_id,
            'name'      => $request->e_name,
            'remarks'   => $request->e_remarks,
            'status'    => $request->e_status
        ];

        DB::table('aplists')->where('id', $request->e_id)->update($update_aplist);
        return redirect('/ap_list');
    }

    public function deleteAPList($id) {
        DB::table('aplists')->where('id', $id)->delete();
        return redirect('/ap_list');
    }
}
