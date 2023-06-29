<?php

namespace App\Http\Controllers;

use App\Models\PayrollComputations;
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
        foreach ($payrollSchedule as $key => $value) {
            $payrollSchedule[$key]->total_net = PayrollComputations::where([
                ['payroll_schedule_id', '=', $value->id]
            ])->get()->sum('net_pay');
        }
        return view('payroll_schedule', compact('payrollSchedule'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date'],
            'description' => ['required'],
            'name' => ['required'],
        ]);


        if ($validator->fails()) {
            return redirect(route("payroll_schedule"))
                ->withErrors($validator)
                ->withInput();
        }
        $from = Carbon::createFromFormat('Y-m-d', $request->input('period_start'));
        $to = Carbon::createFromFormat('Y-m-d', $request->input('period_end'));
        try {

            $payrollSchedule = PayrollSchedule::create([
                'from' => $request->input('period_start'),
                'to' => $request->input('period_end'),
                'name' =>  $request->input('name'),
                'description' =>  $request->input('description'),
                'created_by' =>  Auth::user()->id,
            ]);

            return redirect(route("payroll_computations", ['id' => $payrollSchedule->id, 'schedule_id' => $payrollSchedule->id]))->withSuccess("Payroll Schedule Added: $request->input('name')");
        } catch (Exception $e) {
            return redirect(route("payroll_schedule"))
                ->withErrors([$e->getMessage()])
                ->withInput();
        }

    }

    public function show(Request $request, $schedule_id) {

        $validator = Validator::make(['schedule_id' => $schedule_id], [
            'schedule_id' => ['required', 'exists:payroll_schedules,id'],
        ],[
            'schedule_id:exists' => 'Schedule Invalid'
        ]);

        if ($validator->fails()) {
            return redirect(route("payroll_schedule"))
                ->withErrors($validator)
                ->withInput();
        }
        $results = PayrollSchedule::find($schedule_id);

        return view('payroll_schedule_show', ['results' => $results]);
    }

    public function update(Request $request, $schedule_id) {
        $validator = Validator::make([...$request->all(), 'schedule_id' => $schedule_id], [
            'period_start' => ['required', 'date'],
            'period_end' => ['required', 'date'],
            'description' => ['required'],
        ]);


        if ($validator->fails()) {
            return redirect(route("payroll_schedule"))
                ->withErrors($validator)
                ->withInput();
        }

        $results = PayrollSchedule::find($schedule_id);
        $results->from = $request->input('period_start');
        $results->to = $request->input('period_end');
        $results->description = $request->input('description');
        $results->name = $request->input('name');
        $results->save();

        return redirect()->back()->withSuccess("Update successful!");
    }
}
