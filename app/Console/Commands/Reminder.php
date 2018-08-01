<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Mail;
use DB;


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
        $date = Carbon::now();
        $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->endOfDay()->toDateTimeString();

        $reminderData = \DB::table('product_managements')
            ->join('users', 'product_managements.user_id', 'users.id')
            ->where('product_managements.end_date', '>', $endDate)->get()->toArray();
        //dd($reminderData);
        if (count($reminderData)) {
            foreach ($reminderData as $k => $detail) {
                if (!$detail->product_reminder) {
                    $detail->product_reminder = [];
                } else {
                    $detail->product_reminder = \GuzzleHttp\json_decode($detail->product_reminder);
                }
                if (count($detail->product_reminder)) {
                    foreach ($detail->product_reminder as $dayKey => $reminderDay) {
                       
                        $reminderDate = null;
                        if ($reminderDay == '1 Day') {
                            $reminderDate =Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addDay(1))->endOfDay()->toDateTimeString();
                        } elseif ($reminderDay == '1 Week') {
                            $reminderDate =Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addDay(7))->endOfDay()->toDateTimeString();
                        }elseif($reminderDay == '2 Week'){
                            $reminderDate =Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->addDay(14))->endOfDay()->toDateTimeString();
                        }
                        if(!is_null($reminderDate) && ($reminderDate==$detail->end_date ))
                        {
                            try{
                                $reminder = (array)$detail;
                                Mail::to($reminder['email'])->send(new \App\Mail\Reminder($reminder));
                            }
                            catch(\Exception $e){
                                // Never reached
                            }

                        }
                    }
                }

            }
        }
    }
}
