<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule as ValidationRule;

class AccountController extends Controller
{
    public function index()
    {
        $users = User::leftJoin('collectors', ['users.id' => 'collectors.user_id'])
            ->select('users.*', 'collectors.code', 'collectors.ctc_no', 'collectors.cashbond')
            ->get();
        return view('admin/users', ['users' => $users]);
    }


    public function createView()
    {
        $users = User::all();
        $roles = Role::all();

        return view('admin/create_user', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birthday' => ['required', 'string'],
            'address' => ['required', 'string'],
            'contact' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect(route("get_user_create"))
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'birthday' => $request->input('birthday'),
            'address' => $request->input('address'),
            'contact' => $request->input('contact'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'approval_status' => 1 // approved
        ]);

        return redirect(route("get_user_create"))->withSuccess('Account Created');
    }

    protected function put(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code' => [
                    'required_if:role,3',
                ],
                'cashbond' => [
                    'required_if:role,3',
                ],
                'ctcnum' => [
                    'required_if:role,3',
                ],

                'approval_status' => ['required'],
                'role' => ['required'],
                'id' => ['required'],
            ],
            $messages = [
                'required_if' => 'The :attribute field is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect(route("get_user_index"))
                ->withErrors($validator)
                ->withInput();

            dd($validator);
        }

        $user = User::find($request->input('id'));
        $user->approval_status = $request->input('approval_status');
        $user->save();


        $approvedLib = [
            1 => 'approved',
            2 => 'pending'
        ];
        $collector = Collector::create([
            'user_id' => $request->input('id'),
            'code' => $request->input('code'),
            'fullname' => $user->name,
            'mobile' => $user->name,
            'address' => '',
            'cashbond' => $request->input('cashbond'),
            'ctc_no' => $request->input('ctcnum'),
            'status' => 'active',
            'row_status' => $approvedLib[$request->input('approval_status')]
        ]);

        return redirect(route("get_user_index"))
            ->with(['success' => 'Update Successful'])
            ->withInput();
    }
}
