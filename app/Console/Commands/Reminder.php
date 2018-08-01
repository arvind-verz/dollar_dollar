<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use DB;
use DateTime;
use App\Mail\Reminder as RM;


class Reminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ProductReminder:productReminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Reminder to User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dtNow = new DateTime();

        $beginOfDay = clone $dtNow;

        // Go to midnight.  ->modify('midnight') does not do this for some reason
        $beginOfDay->modify('today');

        $endOfDay = clone $beginOfDay;
        $endOfDay->modify('tomorrow');

        // adjust from the next day to the end of the day, per original question
        $endDate = $endOfDay->modify('1 second ago');
        $endDate = $endDate->format('Y-m-d H:i:s');
        $reminderData = \DB::table('product_managements')
            ->join('users', 'product_managements.user_id', 'users.id')
            ->where('product_managements.end_date', '>', $endDate)->get()->toArray();
        //dd($reminderData);

        if (count($reminderData)) {

            foreach ($reminderData as $k => $detail) {
                if (!$detail->product_reminder) {
                    $detail->product_reminder = [];
                } else {
                    $detail->product_reminder = json_decode($detail->product_reminder);
                }
                if (count($detail->product_reminder)) {
                    foreach ($detail->product_reminder as $dayKey => $reminderDay) {
                        $reminderDate = null;
                        if ($reminderDay == '1 Day') {
                            $reminderDate =date('Y-m-d H:i:s', strtotime($endDate. ' + 1 days'));
                        } elseif ($reminderDay == '1 Week') {
                            $reminderDate =date('Y-m-d H:i:s', strtotime($endDate. ' + 7 days'));
                        }elseif($reminderDay == '2 Week'){
                            $reminderDate =date('Y-m-d H:i:s', strtotime($endDate. ' + 14 days'));
                        }
                        if(!is_null($reminderDate) && ($reminderDate==$detail->end_date ))
                        {

                            $reminder = (array)$detail;
                            Mail::to($reminder['email'])->send(new RM($reminder));

                        }
                    }
                }

            }
        }
    }
}
