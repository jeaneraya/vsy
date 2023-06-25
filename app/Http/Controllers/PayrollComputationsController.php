<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\PayrollSchedule;
use Illuminate\Http\Request;

class PayrollComputationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        $results['employee'] = Employee::find($request->input('employee_id'));
        $results['payroll_schedule'] = PayrollSchedule::find($schedule_id);

        return view('payroll_computation_add', ['results' => $results]);
    }
}
