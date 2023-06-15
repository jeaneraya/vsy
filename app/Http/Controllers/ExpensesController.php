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
}
