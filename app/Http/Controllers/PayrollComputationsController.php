<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollComputations;
use App\Models\PayrollSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayrollComputationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:payroll_schedules,id'],
        ], [
            'id.exists' => 'Schedule is Invalid.'
        ]);

        if ($validator->fails()) {
            return redirect(route("payroll_schedule"))
                ->withErrors($validator)
                ->withInput();
        }

        $payroll_schedule = PayrollSchedule::find($request->input('id'));
        if ($payroll_schedule == false) {
            return redirect(route('payroll_schedule'))
                ->withErrors(['Please Select valid Computation Schedule']);
        }

        $results['payroll_schedules'] = PayrollSchedule::all();

        $results['withComputations'] = PayrollSchedule::join('payroll_computations', 'payroll_computations.payroll_schedule_id', '=', 'payroll_schedules.id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll_computations.employee_id')
            ->select(

                'payroll_schedules.id as schedules.id',
                'payroll_computations.total_deductions as computations_total_deductions',
                'payroll_computations.net_pay as computations_net_pay',
                'payroll_computations.gross_pay as computations_gross',
                'payroll_computations.is_claimed as computations_is_claimed',

                'employees.id as employee_id',
                'employees.employee_code as employee_code',
                'employees.fullname as employee_full_name',

                'payroll_computations.id as computations_id',
            )
            ->where([
                ['payroll_schedules.id', '=', $request->input('id')]
            ])
            ->get();

        $results['withOutComputations'] = Employee::whereNotIn('id', $results['withComputations']->pluck('employee_id')->all())
            ->get();

        return view('payroll_computation_index', ['results' => $results]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_create(Request $request, $id)
    {
        $schedule_id = $id;
        $validator = Validator::make([...$request->all(), 'schedule_id' => $schedule_id], [
            'employee_id' => ['required', 'exists:employees,id'],
            'schedule_id' => ['required', 'exists:payroll_schedules,id']
        ], [
            'employee_id:exists' => 'Employee is Invalid.',
            'schedule_id:exists' => 'Schedule is Invalid.'
        ]);

        if ($validator->fails()) {
            return redirect(route("payroll_schedule"))
                ->withErrors($validator)
                ->withInput();
        }

        $results['employee'] = Employee::find($request->input('employee_id'));
        $results['payroll_schedule'] = PayrollSchedule::find($schedule_id);

        return view('payroll_computation_add', ['results' => $results]);
    }

    public function create(Request $request, $id)
    {
        // dd($request->all());
        $schedule_id = $id;
        $validator = Validator::make([...$request->all(), 'schedule_id' => $id], [
            'employee_id' => ['required', 'exists:employees,id'],
            'schedule_id' => ['required', 'exists:payroll_schedules,id'],
            'employee_id' => ['required'],
            'no_of_hours_overtime' => ['required'],
            'no_hours_late' => ['required'],
            'no_of_days_absent' => ['required'],
            'no_of_days_worked' => ['required'],
            'bonuses' => ['required'],
            'input_amount_total_deductions' => ['required'],
            'input_gross' => ['required'],
            'input_amount_net_pay' => ['required'],
            "deductions-SSS" => ['required'],
            "deductions-Pag-ibig" => ['required'],
            "deductions-Philhealth" => ['required'],
            "deductions-Others" => ['required'],
        ], [
            'employee_id:exists' => 'Employee is Invalid.',
            'schedule_id:exists' => 'Schedule is Invalid.'
        ]);

        if ($validator->fails()) {
            return redirect(route("payroll_schedule"))
                ->withErrors($validator)
                ->withInput();
        }

        $payroll_schedule = PayrollSchedule::find($schedule_id);
        if ($payroll_schedule == false) {
            return redirect(route('payroll_schedule'))
                ->withErrors(['Please Select valid Computation Schedule']);
        }
        $employee = Employee::find($request->input('employee_id'));
        $computations = $payrollComputations = PayrollComputations::create([
            'payroll_schedule_id' => $schedule_id,
            'employee_id' => $request->input('employee_id'),
            'rate_per_day' => $employee->rate_per_day,
            'hours_overtime' => $request->input('no_of_hours_overtime'),
            'hours_late' => $request->input('no_hours_late'),
            'days_absent' => $request->input('no_of_days_absent'),
            'days_present' => $request->input('no_of_days_worked'),
            'sss' => $request->input('deductions-SSS'),
            'pagibig' => $request->input('deductions-Pag-ibig'),
            'philhealth' => $request->input('deductions-Philhealth'),
            'others' => $request->input('deductions-Others'),
            'bonus' => $request->input('bonuses'),
            'total_deductions' => $request->input('input_amount_total_deductions'),
            'gross_pay' => $request->input('input_gross'),
            'net_pay' => $request->input('input_amount_net_pay'),
            'status' => 1,
            'is_claimed' => 0,
        ]);

        return redirect(route('payroll_computations', ['id' => $schedule_id]))
            ->withSuccess("Created!");
    }

    public function put_claimed(Request $request, $id)
    {

        $validator = Validator::make([...$request->all(), 'id' => $id], [
            'id' => ['required', 'exists:payroll_computations,id'],
            'is_claimed' => ['required'],
            'schedule_id' => ['required']
        ], [
            'id.exists' => 'Computation is Invalid.'
        ]);

        if ($validator->fails()) {
            return redirect(route('payroll_computations', ['id' => $request->input('schedule_id')]))
                ->withErrors($validator)
                ->withInput();
        }

        $computations = PayrollComputations::find($id);
        $computations->is_claimed = $request->input('is_claimed');
        $computations->save();

        $claimed = $request->input('is_claimed') == 1 ? 'Clamed' : 'Unclaimed';

        return redirect(route('payroll_computations', ['id' => $computations->payroll_schedule_id]))
            ->withSuccess("Mark as $claimed successful!");
    }

    public function show_employee(Request $request, $id, $employee_id)
    {
        $validator = Validator::make(['id' => $id, 'employee_id' => $employee_id], [
            'id' => ['required', 'exists:payroll_computations,id'],
            'employee_id' => ['required'],
        ], [
            'id.exists' => 'Computation is Invalid.'
        ]);

        if ($validator->fails()) {
            return redirect(route('payroll_computations', ['id' => $id]))
                ->withErrors($validator)
                ->withInput();
        }

        $computations = PayrollSchedule::join('payroll_computations', 'payroll_computations.payroll_schedule_id', '=', 'payroll_schedules.id')
            ->leftJoin('employees', 'employees.id', '=', 'payroll_computations.employee_id')
            ->select(

                'payroll_schedules.id as schedule_id',
                'payroll_schedules.name as schedule_name',
                'payroll_schedules.from as schedule_from',
                'payroll_schedules.to as schedule_to',

                'payroll_computations.total_deductions as computations_total_deductions',
                'payroll_computations.net_pay as computations_net_pay',
                'payroll_computations.gross_pay as computations_gross',
                'payroll_computations.is_claimed as computations_is_claimed',
                'payroll_computations.rate_per_day as computations_rate_per_day',
                'payroll_computations.days_present as computations_days_present',
                'payroll_computations.bonus as computations_bonus',
                'payroll_computations.hours_overtime as computations_hours_overtime',
                'payroll_computations.days_absent as computations_days_absent',
                'payroll_computations.hours_late as computations_hours_late',

                'payroll_computations.sss as computations_sss',
                'payroll_computations.pagibig as computations_pagibig',
                'payroll_computations.philhealth as computations_philhealth',
                'payroll_computations.others as computations_others',

                'employees.id as employee_id',
                'employees.employee_code as employee_code',
                'employees.fullname as employee_full_name',
                'employees.position as employee_position',
                'employees.date_hired as employee_date_hired',

                'payroll_computations.id as computations_id',
            )
            ->where([
                ['payroll_computations.id', '=', $id],
                ['payroll_computations.employee_id', '=', $employee_id]
            ])
            ->first();

        if (!$computations) {
            return redirect(route('payroll_computations', ['id' => $id]))
                ->withErrors(['asdfasfsafsfs'])
                ->withInput();
        }
        $results = $computations;
        return view('payroll_computation_show', ['results' => $results]);
    }

    function update_employee(Request $request, $id, $employee_id)
    {

        $validator = Validator::make(
            [...$request->all(), 'id' => $id, 'employee_id' => $employee_id],
            [
                "no_of_days_worked" => ['required'],
                "bonuses" => ['required'],
                "no_of_hours_overtime" => ['required'],
                "no_of_days_absent" => ['required'],
                "no_hours_late" => ['required'],
                "deductions-SSS" => ['required'],
                "deductions-Pag-ibig" => ['required'],
                "deductions-Philhealth" => ['required'],
                "deductions-Others" => ['required'],
                "employee_id" => ['required', 'exists:payroll_computations,employee_id'],
                "schedule_id" => ['required'],
                "input_amount_no_of_days_worked" => ['required'],
                "input_amount_bonuses" => ['required'],
                "input_amount_no_of_hours_overtime" => ['required'],
                "input_gross" => ['required'],
                "input_amount_no_of_days_absent" => ['required'],
                "input_amount_no_of_hours_late" => ['required'],
                "input_amount_total_deductions" => ['required'],
                "input_amount_net_pay" => ['required'],
                "id" => ['required', 'exists:payroll_computations,id']
            ],
            [
                'employee_id:exists' => 'Employee is Invalid.',
                'id:exists' => 'Schedule is Invalid.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $computations = PayrollComputations::find($id);

        $computations->employee_id = $request->input('employee_id');
        $computations->hours_overtime = $request->input('input_amount_no_of_hours_overtime');
        $computations->hours_late = $request->input('input_amount_no_of_hours_late');
        $computations->days_absent = $request->input('input_amount_no_of_days_absent');
        $computations->days_present = $request->input('input_amount_no_of_days_worked');
        $computations->sss = $request->input('deductions-SSS');
        $computations->pagibig = $request->input('deductions-Pag-ibig');
        $computations->philhealth = $request->input('deductions-Philhealth');
        $computations->others = $request->input('deductions-Others');
        $computations->bonus = $request->input('input_amount_bonuses');
        $computations->total_deductions = $request->input('input_amount_total_deductions');
        $computations->gross_pay = $request->input('input_gross');
        $computations->net_pay = $request->input('input_amount_net_pay');
        $computations->save();

        return redirect()->back()
            ->withSuccess("Update Successful.");
    }
}
