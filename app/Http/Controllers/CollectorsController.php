<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Collector;

class CollectorsController extends Controller
{
    public function index() {

        $collectors = Collector::all();
        return view('collectors.index', compact('collectors'));
    }

    public function addCollector(Request $request) {
        $validateData = $request->validate([
            'code' => 'required|string|max:10',
            'fullname' => 'required|string|max:255',
            'mobile' => 'string|max:11',
            'address' => 'required|string|max:255'
        ]);

        $collector = new Collector();
        $collector->code = $validateData['code'];
        $collector->fullname = $validateData['fullname'];
        $collector->mobile = $validateData['mobile'];
        $collector->address = $validateData['address'];
        $collector->cashbond = $request->input('cashbond');
        $collector->ctc_no = $request->input('ctcnum');

        $collector->save();

        $request->session()->flash('message', 'Form submitted successfully!');
    }
}
