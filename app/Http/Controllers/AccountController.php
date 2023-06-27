<?php

namespace App\Http\Controllers;

use App\Models\Collector;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        $where = [];
        if ($request->has('status')) {
            $where[] = [
                'approval_status', '=', $request->query('status')
            ];
        }
        $users = User::leftJoin('collectors', ['users.id' => 'collectors.user_id'])
            ->select('users.*', 'collectors.code', 'collectors.ctc_no', 'collectors.cashbond')
            ->where($where)
            ->get();

        $allUsers = User::all();
        return view('admin/users', ['users' => $users, 'allUsers' => $allUsers]);
    }


    public function createView()
    {
        $users = User::all();
        $roles = Role::where([
            ['for_registration', '=', 1]
        ])->get(); // yes

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
                // collectors
            'code' => [
            'required_if:role,3',
            ],
            'cashbond' => [
                'required_if:role,3',
            ],
            'ctcnum' => [
                'required_if:role,3',
            ]],
            $messages = [
                'required_if' => 'The :attribute field is required.',
            ]
        );

        if ($validator->fails()) {
            return redirect(route("get_user_create"))
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'birthday' => $request->input('birthday'),
            'address' => $request->input('address'),
            'contact' => $request->input('contact'),
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('role'),
            'approval_status' => 1, // approved
        ]);


        if ($request->input('role') == 3) {
            Collector::create([
                'user_id' => $user->id,
                'code' => $request->input('code'),
                'cashbond' => $request->input('cashbond'),
                'ctc_no' => $request->input('ctcnum'),
                'status' => 1, // active
            ]);
        }
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
        }

        $user = User::find($request->input('id'));
        $user->approval_status = $request->input('approval_status');
        $user->save();

        if ($request->input('role') == 3) { // collector and approved

            $collector = Collector::where([
                ['user_id','=', $request->input('id')]
            ])->first();

            if ($collector) {
                $collector->user_id = $request->input('id');
                $collector->code = $request->input('code');
                $collector->cashbond = $request->input('cashbond');
                $collector->ctc_no = $request->input('ctcnum');
                $collector->status = 1; // active
                $collector->save();
            } else {
                Collector::create([
                    'user_id' => $request->input('id'),
                    'code' => $request->input('code'),
                    'cashbond' => $request->input('cashbond'),
                    'ctc_no' => $request->input('ctcnum'),
                    'status' => 1, // active
                ]);
            }
        }

        return redirect(route("get_user_index"))
            ->with(['success' => 'Update Successful'])
            ->withInput();
    }

    protected function get(Request $request, User $userId)
    {
        return view('admin/view_user', ['user' => $userId]);
    }

    protected function archive_user(User $userId)
    {
        $userId->approval_status = 3; // archive
        $userId->save();

        return redirect(route("get_user_index"))
            ->with(['success' => 'Update Successful'])
            ->withInput();
    }
}
