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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => ['required'],
            'schedule' => ['required', 'date', 'after:today'],
            'message' => ['required'],
            'type' => ['required'],
            'frequency' => ['required'],
            'is_active' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
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
                'frequency' => $request->input('frequency'),
                'created_by' => Auth::user()->id,
                'is_active' => $request->input('is_active'), // active
            ]);

        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors([$e->getMessage()])
                ->withInput();
        }
        return redirect(route("view_add_reminder"))->withSuccess('Account Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function show(Request $requests, $id)
    {
        $reminders = Reminder::find($id);

        if ($reminders) {
            return view('reminder_update', ['reminder' => $reminders]);
        }
        return redirect(route('reminders'))
        ->withErrors(['Reminder does not exist.'])
        ->withInput();
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
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => ['required'],
            'schedule' => ['required', 'date', 'after:today'],
            'message' => ['required'],
            'type' => ['required'],
            'frequency' => ['required'],
            'is_active' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect(route("show_reminder"))
                ->withErrors($validator)
                ->withInput();
        }
        $reminder = Reminder::find($id);
        if (is_null($reminder) === true) {
            return redirect(route('reminders'))
                ->withErrors(['Reminder does not exist.'])
                ->withInput();
        }
        try {
            $reminder->description = $request->input('description');
            $reminder->schedule = $request->input('schedule');
            $reminder->frequency = $request->input('frequency');
            // $reminder->message = $request->input('message');
            $reminder->type = $request->input('type');
            $reminder->is_active = $request->input('is_active');
            $reminder->save();
        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors([$e->getMessage()])
                ->withInput();
        }
        return redirect()->back()->withSuccess('Account Updated');

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
