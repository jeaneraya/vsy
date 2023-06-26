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
    public function view_create(Request $request, $schedule_id)
    {
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

    public function create(Request $request)
    {
        $employee = Employee::find($request->input('employee_id'));

        $validator = Validator::make($request->all(), [
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
        ], [
            'employee_id:exists' => 'Employee is Invalid.',
            'schedule_id:exists' => 'Schedule is Invalid.'
        ]);

        if ($validator->fails()) {
            return redirect(route("payroll_schedule"))
                ->withErrors($validator)
                ->withInput();
        }

        $payroll_schedule = PayrollSchedule::find($request->input('schedule_id'));
        if ($payroll_schedule == false) {
            return redirect(route('payroll_schedule'))
                ->withErrors(['Please Select valid Computation Schedule']);
        }

        $payrollComputations = PayrollComputations::create([
            'payroll_schedule_id' => $request->input('schedule_id'),
            'employee_id' => $request->input('employee_id'),
            'rate_per_day' => $employee->rate_per_day,
            'hours_overtime' => $request->input('no_of_hours_overtime'),
            'hours_late' => $request->input('no_hours_late'),
            'days_absent' => $request->input('no_of_days_absent'),
            'days_present' => $request->input('no_of_days_worked'),
            'deductions_list' => '',
            'bonus' => $request->input('bonuses'),
            'total_deductions' => $request->input('input_amount_total_deductions'),
            'gross_pay' => $request->input('input_gross'),
            'net_pay' => $request->input('input_amount_net_pay'),
            'status' => 1,
            'is_claimed' => 0,
        ]);
        return redirect(route('payroll_computations', ['id' => $request->input('schedule_id')]))
            ->withSuccess("Created!");;
    }
}
