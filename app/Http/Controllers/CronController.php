<?php

namespace App\Http\Controllers;

use App\Models\Batchtransaction;
use App\Models\ItexMo;
use App\Models\Reminder;
use App\Models\RemindersLogger;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CronController extends Controller
{

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
    protected function scheduleTodayBirthday()
    {

        $today = Carbon::now()->format('Y-m-d');
        $results = User::where([
            ['birthday', '=', $today]
        ])->get();

        try {
            foreach ($results as $result) {

                // insert template
                $template = "Happy birthday $result->id!";
                // send message
                $logger = RemindersLogger::create([
                    'type' => 7, // birthday
                    'description' => 'Birthday',
                    'sent_to' => $result->id,
                    'message' => $template,
                    'sent_via' => 1, // sms
                    'schedule' => $today
                ]);
                // dd('asdasdasdsad');
                // dd( $logger );

            }
            return 'Success';
        } catch (Exception $e) {
            dd($e->getMessage());
            // return "Error: " . $e->getMessage();
            dd($e->getMessage());
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
    protected function scheduleFirstCollection()
    {
        $today = Carbon::now()->format('Y-m-d');
        $dueDate =  Carbon::now();
        $results = Batchtransaction::where([
            ['batchtransactions.status', '=', 'active'],
            ['batchtransactions.first_collection', '=', $today]
        ])->leftjoin('users', 'users.id', '=', 'batchtransactions.collector_id')
            ->select('batchtransactions.collector_id', 'users.contact')
            ->groupBy('batchtransactions.collector_id', 'users.contact')
            ->get();

        try {
            $template = $this->getCollectionCronMessage($dueDate);
            foreach ($results as $result) {
                // send message
                RemindersLogger::create([
                    'type' => 4, // first collection
                    'description' => 'First Collection',
                    'sent_to' => $result->collector_id,
                    'message' => $template,
                    'sent_via' => 1, // sms
                    'schedule' => $today
                ]);
            }
            return 'Success';
        } catch (Exception $e) {
            dd($e->getMessage());
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
    protected function scheduleFirstMonthlyCollection()
    {
        $today = Carbon::now()->format('Y-m-d');
        $dueDate =  Carbon::now();
        $results = Batchtransaction::where([
            ['batchtransactions.status', '=', 'active'],
        ])->leftjoin('users', 'users.id', '=', 'batchtransactions.collector_id')
            ->select('batchtransactions.collector_id', 'users.contact')
            ->groupBy('batchtransactions.collector_id', 'users.contact')
            ->get();


        try {
            $template = $this->getCollectionCronMessage($dueDate);
            foreach ($results as $result) {
                // send message
                RemindersLogger::create([
                    'type' => 5, // first collection
                    'description' => 'First Monthly Collection',
                    'sent_to' => $result->collector_id,
                    'message' => $template,
                    'sent_via' => 1, // sms
                    'schedule' => $today
                ]);
            }
            return 'Success';
        } catch (Exception $e) {
            dd($e->getMessage());
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
    protected function scheduleSecondMonthlyCollection()
    {
        $today = Carbon::now()->format('Y-m-d');
        $dueDate = Carbon::now()->endOfMonth();
        $results = Batchtransaction::where([
            ['batchtransactions.status', '=', 'active'],
        ])->leftjoin('users', 'users.id', '=', 'batchtransactions.collector_id')
            ->select('batchtransactions.collector_id', 'users.contact')
            ->groupBy('batchtransactions.collector_id', 'users.contact')
            ->get();

        try {
            $template = $this->getCollectionCronMessage($dueDate);
            foreach ($results as $result) {
                // send message
                RemindersLogger::create([
                    'type' => 6, // first collection
                    'description' => 'End of Month Monthly Collection',
                    'sent_to' => $result->collector_id,
                    'message' => $template,
                    'sent_via' => 1, // sms
                    'schedule' => $today
                ]);
            }
            return 'Success';
        } catch (Exception $e) {
            dd($e->getMessage());
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
    protected function scheduleCustomReminders()
    {
        $now = Carbon::now();
        $today = $now->format('Y-m-d');
        $results = Reminder::where([
            ['is_active', '=', 1],
        ])->get();

        try {
            foreach ($results as $result) {
                $isScheduled = false;
                $message = $result->message;
                $schedule = Carbon::createFromFormat('Y-m-d', $result->schedule);
                $description = 'Custom - ';
                // send message

                // one time
                if ($result->frequency == 1 && $schedule->format('Y-m-d') == $today) {
                    $description .= 'One time';
                    $isScheduled = true;
                }

                // daily
                else if ($result->frequency == 2 && $schedule->format('Y-m-d') <= $today) {
                    $description .= 'Daily';
                    $isScheduled = true;
                }

                // weekly
                else if (
                    $result->frequency == 3
                    && $schedule->format('Y-m-d') < $today
                ) {
                    // todo: get Day
                    $description .= 'Weekly';
                    $isScheduled = true;
                }

                // monthly
                else if (
                    $result->frequency == 4
                    && $schedule->format('Y-m-d') < $today
                    && $schedule->format('d') == $now->format('d')
                ) {
                    $description .= 'Monthly';
                    $isScheduled = true;
                }

                // yearly
                else if (
                    $result->frequency == 5
                    && $schedule->format('Y-m-d') < $today
                    && $schedule->format('m-d') == $now->format('m-d')
                ) {
                    $description .= 'Yearly';
                    $isScheduled = true;
                }

                if ($isScheduled == true) {
                    RemindersLogger::create([
                        'reminder_id' => $result->id,
                        'type' => $result->type,
                        'description' => $description,
                        'sent_to' => 1, // super admin
                        'message' => $result->message,
                        'sent_via' => 2, // notification
                        'schedule' => $today
                    ]);

                    RemindersLogger::create([
                        'reminder_id' => $result->id,
                        'type' => $result->type,
                        'description' => $description,
                        'sent_to' => 2, // super admin
                        'message' => $result->message,
                        'sent_via' => 2, // notification
                        'schedule' => $today
                    ]);
                }
            }
            return 'Success';
        } catch (Exception $e) {
            dd($e->getMessage());
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

    public function cronScheduler(Request $request)
    {

        $validator = Validator::make([...$request->all(), 'code' => $request->input('code')], [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $dateToday = Carbon::now();

        try {

            // birthday
            $this->scheduleTodayBirthday();
            // // 1st collection
            $this->scheduleFirstCollection();

            if (in_array($dateToday->format('d'), [13, 15, 17])) {
                // 1st monthly collection (13, 15, 17)
                $this->scheduleFirstMonthlyCollection();
            }

            $lastDayOfMonth = $dateToday->endOfMonth()->format('d');
            if (in_array($dateToday->format('d'), [2, $lastDayOfMonth, $lastDayOfMonth - 2])) {
                // 2nd monthly collection
                $this->scheduleSecondMonthlyCollection();
            }
            // custom
            $this->scheduleCustomReminders();
        } catch (Exception $e) {
            // return json_encode($e->getMessage());
            dd($e->getMessage());
        }

        return true;
    }


    public function cronRunner(Request $request)
    {

        $itexmo = ItexMo::broadcast('sdasdasdsad', ['09971903477']);
        // dd($itexmo);

        $validator = Validator::make([...$request->all(), 'code' => $request->input('code')], [
            'code' => ['required']
        ]);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        try {
            $today = Carbon::now()->format('Y-m-d');
            $cronForRunning = RemindersLogger::where([['schedule', '=', $today], ['sent_datetime', '=', null]])
                ->leftJoin('users', 'users.id', '=', 'reminders_loggers.sent_to')
                ->select('reminders_loggers.*', 'users.contact as mobile')
                ->get();
            $now = Carbon::now();
            foreach ($cronForRunning as $key => $value) {
                if (is_null($value->reminder_id) == false) {
                    $reminder = Reminder::find($value->reminder_id);
                    $reminder->sent_on = $now;
                    $reminder->status = 1;
                    $reminder->save();
                }

                $itexmo = ItexMo::broadcast($value->message, [$value->mobile]);
                echo "$itexmo <br>";
            }

            $table = "<table class='table'>
                        <thead class='thead-light'>
                            <tr class='table-secondary'>
                                <th scope='row'>ID</th>
                                <th>Description</th>
                                <th>Sent to</th>
                                <th>Message</th>
                                <th>Schedule</th>
                                <th>Send By</th>
                            </tr>
                        </thead>

                        <tbody>";

            foreach ($cronForRunning as $key => $value) {
                // echo '<br>';
                // echo "$value->id | $value->description | $value->sent_to | $value->message | $value->schedule";
                $value->sent_datetime = Carbon::now()->format('Y-m-d H:i:s');
                $value->save();

                $table .= "<tr>
                <th>$value->id</th>
                <td>$value->description</td>
                <th>$value->sent_to</th>
                <th>$value->message</th>
                <th>$value->schedule</th>
                <th>$value->send_via</th>
            </tr>";
            }


            $table .= `  </tbody></table>`;

            echo $table;
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
