<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\RemindersLogger;
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
        $reminders = Reminder::leftJoin('users', 'reminders.created_by', '=', 'users.id')
            ->select('reminders.*', 'users.name as created_name')
            ->get();
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
                'message' => $request->input('message'), // active
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
        $reminderLoggers = RemindersLogger::where([['reminder_id', '=', $id]])->get();

        if ($reminders) {
            return view('reminder_update', ['reminder' => $reminders, 'reminderLoggers' => $reminderLoggers]);
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

    public function notifications_index(Request $request) {
        $results = RemindersLogger::where([
            ['sent_via', '=', '2'], // notifications
            ['sent_to', '=', Auth::user()->id]
        ])->orderBy('id', 'desc')
        ->get();

        return view('notifications', ['results' => $results]);
    }

    public function update_is_read(Request $request) {

        $validator = Validator::make($request->all(), [
            'log_id' => ['required', 'exists:reminders_loggers,id'],
            'is_read' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $results = RemindersLogger::find($request->input('log_id'));
        $results->is_read = $request->input('is_read');
        $results->save();

        $read = $results->is_read == 1 ? 'Read' : 'Unread';
        return redirect()->back()
            ->withSuccess("Marked as $read");

    }


    public function is_active(Request $request, $id) {

        $validator = Validator::make([...$request->all(), 'id' => $id], [
            'id' => ['required', 'exists:reminders,id'],
            'is_active' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $results = Reminder::find($id);
        $results->is_active = $request->input('is_active');
        $results->save();

        $read = $results->is_active == 1 ? 'Active' : 'Inactive';
        return redirect()->back()
            ->withSuccess("Marked as $read!");

    }

}
