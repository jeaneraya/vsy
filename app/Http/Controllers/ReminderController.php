<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reminders = Reminder::all();
        return view('reminders', compact('reminders'));
    }

    public function view_add_reminder() {
        return view('reminder_create');
    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'description' => ['required'],
            'schedule' => ['required', 'date', 'after:tomorrow'],
            'message' => ['required'],
            'type' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect(route("get_user_create"))
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $employee = Reminder::create([
                'description' => $request->input('description'),
                'schedule' => $request->input('schedule'),
                'template_id' => 0, // todo,
                'type' => $request->input('type'), // todo
                'status' => 0, // pending
                'created_by' => Auth::user()->id
            ]);
        } catch (Exception $e) {
            return redirect(route("view_add_reminder"))
                ->withErrors([$e->getMessage()])
                ->withInput();
        }
        return redirect(route("view_add_reminder"))->withSuccess('Account Created');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function show(Reminder $reminder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function edit(Reminder $reminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reminder $reminder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reminder $reminder)
    {
        //
    }
}
