<?php

namespace App\Http\Controllers;

use App\Models\Batchtransaction;
use App\Models\Reminder;
use App\Models\RemindersLogger;
use App\Models\ReminderTypes;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CronController extends Controller
{

    /**
     * 1. @1AM everyday - get all crons that will run save to reminder_loggers
     * 2. depending on type, set time when will the sending of notications/SMS will take place
     * 3. when the sending of notifications and sms
     *  - check reminder_loggers ---- as a main table
     *  - tag as sent
     */
    const firstMonthlyCollection = 15;
    const softReminder = 2;

    /**
     * cron/birthdays?code=random
     * 0 7 * * *
     * everyday at 7am
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
            return json_encode($validator);
        }

        $today = Carbon::now()->format('Y-m-d');
        $results = User::where([
            ['birthday', '=', $today]
        ])   ->leftjoin('users', 'users.id', '=', 'batchtransactions.collector_id')
        ->get();

        try {
            foreach ($results as $result) {
                // insert template
                $template = "Happy birthday!";

                // send message

                RemindersLogger::create([
                    'reminder_id' => $result->id,
                    'sent_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
                    'tyle' => $result->type
                ]);

            }
            return 'Success';
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * cron/firstCollection?code=random
     * 30 7 * * *
     * everyday at 7:30am
     *
     * @param Request $request
     * @return void
     */
    public function firstCollection(Request $request)
    {
        $validator = Validator::make([...$request->all(), 'code' => $request->input('code')], [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $today = Carbon::now()->format('Y-m-d');
        $dueDate =  Carbon::now();
        $results = Batchtransaction::where([
            ['status', '=', 'active'],
            ['first_collection', '=', $today]
        ])
        ->leftjoin('users', 'users.id', '=', 'batchtransactions.collector_id')
        ->get();

        try {
            $template = $this->getCollectionCronMessage($dueDate);
            foreach ($results as $result) {
                // send message
                echo $template;
                RemindersLogger::create([
                    'reminder_id' => $result->id,
                    'sent_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
                    'tyle' => $result->type
                ]);
            }
            return 'Success';
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * cron/firstCollection?code=random
     * 0 8 15 * *
     * every 15th of the month  at 8am
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
            return json_encode($validator);
        }

        $today = Carbon::now()->format('Y-m-d');
        $dueDate =  Carbon::now();
        $results = Batchtransaction::where([
            ['status', '=', 'active']
        ])->leftjoin('users', 'users.id', '=', 'batchtransactions.collector_id')
        ->get();

        try {
            $template = $this->getCollectionCronMessage($dueDate);
            foreach ($results as $result) {
                // send message
                echo $template;
                RemindersLogger::create([
                    'reminder_id' => $result->id,
                    'sent_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
                    'tyle' => $result->type
                ]);
            }
            return 'Success';
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }


    /**
     * cron/secondCollection?code=random
     *
     *
     * 30 8 31 1,3,5,7,8,10,12 *
     * At 08:30 on day-of-month 31 in January, March, May, July, August, October, and December.
     *
     * 30 8 28 2 *
     * “At 08:30 on day-of-month 28 in February.”
     *
     * 30 8 30 4,6,9,11 *
     * At 08:30 on day-of-month 30 in April, June, September, and November.
     *
     * @param Request $request
     * @return void
     */
    public function secondMonthlyCollection(Request $request)
    {
        $validator = Validator::make([...$request->all(), 'code' => $request->input('code')], [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $today = Carbon::now()->format('Y-m-d');
        $dueDate = Carbon::now()->endOfMonth();
        $results = User::where([
            ['status', '=', 'active']
        ])->get();

        try {
            $template = $this->getCollectionCronMessage($dueDate);
            foreach ($results as $result) {
                 // send message
                 echo $template;
                 RemindersLogger::create([
                    'reminder_id' => $result->id,
                    'sent_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
                    'tyle' => $result->type
                ]);
            }
            return 'Success';
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * cron/customReminders?code=random
     *
     * * 9 7 * * *
     * everyday at 9am
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
        $results = Reminder::where([
            ['schedule', '=', $today]
        ])->get();

        try {
            foreach ($results as $result) {
                $message = $result->message;
                // send message
                echo $message;

                RemindersLogger::create([
                    'reminder_id' => $result->id,
                    'sent_datetime' => Carbon::now()->format('Y-m-d H:i:s'),
                    'tyle' => $result->type
                ]);
            }
            return 'Success';
            exit;
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $date
     * @return void
     */
    private function getCollectionCronMessage(DateTime $date)
    {
        $date = $date->format('F d, Y (l)');
        return "Reminding that your scheduled payment date is on $date. Please pay your obligations to avoid late payment charges. Thank you.";
    }
}
