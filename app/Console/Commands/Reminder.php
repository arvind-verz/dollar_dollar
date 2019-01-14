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
                            
                            $ads = collect([]);
                        $adsCollection = \DB::table('ads_management')->where('delete_status', 0)
                        ->where('display', 1)
                        ->where('page', 'email')
                        ->inRandomOrder()
                        ->get();
                    
                    if ($adsCollection->count()) {
                        $ads = \Helper::manageAds($adsCollection);
                    }
                    $current_time = strtotime(date('Y-m-d', strtotime('now')));
                    $ad_start_date = strtotime($ads->ad_start_date);
                    $ad_end_date = strtotime($ads->ad_end_date);
                    $ad = null;
                    $adLink = null;
            
                    if($ads->paid_ads_status==1 && $current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads->paid_ad_image)) {
                        $ad = $ads->paid_ad_image;
                         $adLink = $ads->paid_ad_link;
            
                    }else {
                        $ad = $ads->ad_image;
                        $adLink = $ads->ad_link;
                    }
                            Mail::send('frontend.emails.reminder',[
                                'account_name' => $detail->account_name,
                                'end_date' => $detail->end_date,
                                'ad'=>$ad,
                                'adLink'=>$adLink
                            ] , function ($message) use ($detail) {
                                $message->to($detail->email)->subject('A Product reminder');
                            });

                        }
                    }
                }

            }
        }
    }
}
