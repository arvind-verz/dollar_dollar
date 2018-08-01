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
        $date = Carbon::now()->addDay(1);
        $endDate=Carbon::createFromFormat('Y-m-d H:i:s', $date)->endOfDay()->toDateTimeString();

        $reminderData = \DB::table('product_managements')
            ->join('users', 'product_managements.user_id', 'users.id')
            ->where('product_managements.end_date', $endDate)->get();

        if($reminderData->count()){
            $reminderData=$reminderData->toArray();
            foreach($reminderData as $reminder)
            {
                Mail::to($reminder['email'])->send(new Reminder($reminder));
            }
        }
    }
}
