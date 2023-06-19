<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;

class ExpensesController extends Controller
{
    public function index(){
        $expenses = Expense::all();
        return view('expenses', compact('expenses'));
    }

    public function saveExpenses(Request $request) {
        $expenses = new Expense();
        $expenses->code = $request->input('code');
        $expenses->description = $request->input('description');
        $expenses->addon_interest = $request->input('addon_interest');

        $expenses->save();

        return redirect('/expenses')->with('message', 'New Data Added Successfully!');
    }
}
