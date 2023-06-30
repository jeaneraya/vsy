<?php

namespace App\Http\Controllers;

use App\Models\RemindersLogger;
use Illuminate\Http\Request;

class RemindersLoggerController extends Controller
{
    public function view_reminders_log(Request $request) {

        $results = RemindersLogger::all();

        return view('reminders-log', ['results' => $results]);
    }
}
