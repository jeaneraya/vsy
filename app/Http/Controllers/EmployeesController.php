<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EmployeesController extends Controller
{


    public function index()
    {
        $employees = Employee::all();
        return view('employees', compact('employees'));
    }

    public function show(Request $requests, $id)
    {
        $employees = Employee::find($id);

        if ($employees) {
            return view('employees_update', ['employees' => $employees]);
        }
        return redirect(route('employees'))
        ->withErrors(['Employee does not exist.'])
        ->withInput();
    }

    public function put(Request $request, $id)
    {
        $employees = Employee::find($id);
        $validator = Validator::make($request->all(), [
            'employee_code' => ['required'],
            'fullname' => ['required'],
            'birthday' => ['required'],
            'address' => ['required'],
            'contact' => ['required'],
            'date_hired' => ['required'],
            'position' => ['required'],
            'rate_per_day' => ['required'],
            'overtime_pay' => ['required'],
            'interest' => ['required'],
            'ctc_number' => ['required'],
            'place_issued' => ['required'],
            'date_issued' => ['required'],
            'hiring_status' => ['required'],
            'status' => ['required']
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        try {
            $employees->employee_code = $request->input('employee_code');
            $employees->fullname = $request->input('fullname');
            $employees->birthday = $request->input('birthday');
            $employees->address = $request->input('address');
            $employees->contact = $request->input('contact');
            $employees->date_hired = $request->input('date_hired');
            $employees->date_resigned = null;
            $employees->position = $request->input('position');
            $employees->rate_per_day = $request->input('rate_per_day');
            $employees->overtime_pay = $request->input('overtime_pay');
            $employees->interest = $request->input('interest');
            $employees->ctc_number = $request->input('ctc_number');
            $employees->place_issued = $request->input('place_issued');
            $employees->date_issued = $request->input('date_issued');
            $employees->status = $request->input('status');
            $employees->hiring_status = $request->input('hiring_status');
            $employees->created_by = Auth::user()->id;
            $employees->save();
        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors([$e->getMessage()])
                ->withInput();
        }
        return redirect()->back()->withSuccess('Account Updated');
    }


    public function resign(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required'],
            'hiring_status' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $employees = Employee::find($request->input('id'));
        if (!$employees) {
            return redirect(route('employees'))
                ->withErrors(['Employee does not exist.'])
                ->withInput();
        }

        try {
            $employees->hiring_status = $request->input('hiring_status');
            $employees->save();
        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors([$e->getMessage()])
                ->withInput();
        }
        return redirect(route('employees'))->withSuccess('Account Updated');
    }


    public function createView(Request $requests)
    {
        $employees = Employee::all();
        return view('employees_create', ['employees' => $employees]);
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee_code' => ['required'],
            'fullname' => ['required'],
            'birthday' => ['required'],
            'address' => ['required'],
            'contact' => ['required'],
            'date_hired' => ['required'],
            'position' => ['required'],
            'rate_per_day' => ['required'],
            'overtime_pay' => ['required'],
            'interest' => ['required'],
            'ctc_number' => ['required'],
            'place_issued' => ['required'],
            'date_issued' => ['required'],
            'hiring_status' => ['required'],
            'status' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect(route("get_user_create"))
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $employee = Employee::create([
                'employee_code' => $request->input('employee_code'),
                'fullname' => $request->input('fullname'),
                'birthday' => $request->input('birthday'),
                'address' => $request->input('address'),
                'contact' => $request->input('contact'),
                'date_hired' => $request->input('date_hired'),
                'date_resigned' => null,
                'position' => $request->input('position'),
                'rate_per_day' => $request->input('rate_per_day'),
                'overtime_pay' => $request->input('overtime_pay'),
                'interest' => $request->input('interest'),
                'ctc_number' => $request->input('ctc_number'),
                'place_issued' => $request->input('place_issued'),
                'date_issued' => $request->input('date_issued'),
                'status' => $request->input('status'),
                'hiring_status' => $request->input('hiring_status'),
                'created_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            return redirect(route("create_view_employees"))
                ->withErrors([$e->getMessage()])
                ->withInput();
        }
        return redirect(route("create_view_employees"))->withSuccess('Account Created');
    }

}
