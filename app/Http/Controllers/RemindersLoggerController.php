<?php

namespace App\Http\Controllers;

use App\Models\RemindersLogger;
use Illuminate\Http\Request;

class RemindersLoggerController extends Controller
{
    public function view_reminders_log(Request $request) {

        $results = RemindersLogger::
        leftJoin('users', 'users.id', '=', 'reminders_loggers.sent_to')
        ->select('reminders_loggers.*', 'users.name as sent_to_name')
        ->get();

        return view('reminders-log', ['results' => $results]);
    }
}
