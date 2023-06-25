<?php

namespace App\Http\Controllers;

use App\Models\PayrollSchedule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PayrollScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payrollSchedule = PayrollSchedule::all();
        return view('payroll_schedule', compact('payrollSchedule'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date'],
            'description' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect(route("payroll_schedule"))
                ->withErrors($validator)
                ->withInput();
        }
        $from = Carbon::createFromFormat('Y-m-d', $request->input('period_start'));
        $to = Carbon::createFromFormat('Y-m-d', $request->input('period_end'));
        $descriptionPrefix = $from->format('Y') . ' ' . $from->format('M') . ' ' . $from->format('d') .' to ' . $to->format('d');
        $description = $descriptionPrefix . ' - '.$request->input('description');
        try {

            $payrollSchedule = PayrollSchedule::create([
                'from' => $request->input('period_start'),
                'to' => $request->input('period_end'),
                'name' =>  $description,
                'description' =>  $description,
                'created_by' =>  Auth::user()->id,
            ]);
        } catch (Exception $e) {
            return redirect(route("payroll_schedule"))
                ->withErrors([$e->getMessage()])
                ->withInput();
        }
        return redirect(route("payroll_computations", ['id' => $payrollSchedule->id]))->withSuccess("Payroll Schedule Added: $description");
    }
}
