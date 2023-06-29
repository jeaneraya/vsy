<?php

namespace App\Http\Controllers;

use App\Models\Batchtransaction;
use App\Models\Reminder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CronController extends Controller
{
    /**
     * cron/birthdays?code=random
     *
     * @param Request $request
     * @return void
     */
    public function todayBirthday(Request $request)
    {
        $validator = Validator::make([...$request->all(), 'code' => $request->input('code')], [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            // return redirect()->back()
            //     ->withErrors($validator)
            //     ->withInput();

            return json_encode($validator);
        }

        $today = Carbon::now()->format('Y-m-d');
        $users = User::where([
            ['birthday', '=', $today]
        ])->get();

        foreach ($users as $user) {
            // insert template
            $template = "Happy birthday $user->name";

            // send message
        }
    }

    /**
     * cron/firstCollection?code=random
     *
     * @param Request $request
     * @return void
     */
    public function firstMonthlyCollection(Request $request)
    {
        $validator = Validator::make([...$request->all(), 'code' => $request->input('code')], [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            // return redirect()->back()
            //     ->withErrors($validator)
            //     ->withInput();

            return json_encode($validator);
        }

        $today = Carbon::now()->format('Y-m-d');
        $results = Batchtransaction::where([
            ['first_collection', '=', $today]
        ])->get();

        foreach ($results as $result) {
            // insert template
            $template = "Happy birthday $result->name";

            // send message
        }
    }

    /**
     * cron/secondCollection?code=random
     *
     * @param Request $request
     * @return void
     */
    public function secondMonthyCollection(Request $request)
    {
        $validator = Validator::make([...$request->all(), 'code' => $request->input('code')], [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            // return redirect()->back()
            //     ->withErrors($validator)
            //     ->withInput();

            return json_encode($validator);
        }

        $today = Carbon::now()->format('Y-m-d');
        $users = User::where([
            ['birthday', '=', $today]
        ])->get();

        foreach ($users as $user) {
            // insert template
            $template = "Happy birthday $user->name";

            // send message
        }
    }

    /**
     * cron/customReminders?code=random
     *
     * @param Request $request
     * @return void
     */
    public function customReminders(Request $request)
    {
        $validator = Validator::make([...$request->all(), 'code' => $request->input('code')], [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $today = Carbon::now()->format('Y-m-d');
        $users = Reminder::where([
            ['schedule', '=', $today]
        ])->get();

        foreach ($users as $user) {
            // insert template
            $template = "Happy birthday $user->name";

            // send message
        }
    }
}
