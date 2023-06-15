<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        $users = User::all();


        return view('admin/users', ['users' => $users]);
    }


    public function createView() {
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
        ]);

        return redirect(route("get_user_create"))->withSuccess('Account Created');
    }
}
