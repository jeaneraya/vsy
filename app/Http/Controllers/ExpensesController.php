<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

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

    public function editExpenses(Request $request) {
        $update_expenses = [
            'id' => $request->e_expense_id,
            'code' => $request->e_code,
            'description' => $request->e_description,
            'addon_interest' => $request->e_addon_interest
        ];

        DB::table('expenses')->where('id', $request->e_expense_id)->update($update_expenses);
        return redirect('/expenses');
    }

    public function deleteExpense($id) {
        DB::table('expenses')->where('id', $id)->delete();
        return redirect('/expenses');
    }
}
