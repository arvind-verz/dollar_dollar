<?php

namespace App\Console\Commands;

use App\Helpers\Helper\Helper;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use DB;
use DateTime;
use App\SystemSetting;
use App\Mail\Reminder as RM;
use App\EmailTemplate;


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
    private $systemSetting;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            $systemSetting = new SystemSetting();
            $systemSetting->email_sender_name = env('MAIL_FROM_NAME');
            $systemSetting->admin_email = env('ADMIN_EMAIL');
            $systemSetting->auto_email = env('MAIL_FROM_ADDRESS');
        }

        $this->systemSetting = $systemSetting;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $systemSetting = $this->systemSetting;

        $dtNow = new DateTime();

        $beginOfDay = clone $dtNow;

        // Go to midnight.  ->modify('midnight') does not do this for some reason
        $beginOfDay->modify('today');

        $endOfDay = clone $beginOfDay;
        $endOfDay->modify('tomorrow');
        $logo = null;
        if ($systemSetting) {
            $logo = $systemSetting->logo;
        }
        // adjust from the next day to the end of the day, per original question
        $endDate = $endOfDay->modify('1 second ago');
        $endDate = $endDate->format('Y-m-d H:i:s');
        $reminderData = \DB::table('product_managements')
            ->join('users', 'product_managements.user_id', 'users.id')
            ->leftJoin('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->where('product_managements.end_date', '>', $endDate)
            ->where('users.status', '=', 1)
            ->get()->toArray();

        if (count($reminderData)) {

            foreach ($reminderData as $k => $detail) {
                if (!$detail->product_reminder) {
                    $detail->product_reminder = null;
                } else {
                    $detail->product_reminder = json_decode($detail->product_reminder);
                }
                $detail->auto_email = $systemSetting->auto_email;
                $detail->email_sender_name = $systemSetting->email_sender_name;
                if ($detail->product_reminder) {
                    foreach ($detail->product_reminder as $dayKey => $reminderDay) {
                        $reminderDate = null;
                        if ($reminderDay == '1 Day') {
                            $reminderDate = date('Y-m-d H:i:s', strtotime($endDate . ' + 1 days'));
                        } elseif ($reminderDay == '1 Week') {
                            $reminderDate = date('Y-m-d H:i:s', strtotime($endDate . ' + 7 days'));
                        } elseif ($reminderDay == '2 Week') {
                            $reminderDate = date('Y-m-d H:i:s', strtotime($endDate . ' + 14 days'));
                        }
                        if (!is_null($reminderDate) && ($reminderDate == $detail->end_date)) {
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

                            if ($ads->paid_ads_status == 1 && $current_time >= $ad_start_date && $current_time <= $ad_end_date && !empty($ads->paid_ad_image)) {
                                $ad = $ads->paid_ad_image;
                                $adLink = $ads->paid_ad_link;

                            } else {
                                $ad = $ads->ad_image;
                                $adLink = $ads->ad_link;
                            }

                            $emailTemplate = EmailTemplate::find(PRODUCT_REMINDER_MAIL_ID);
                            if ($emailTemplate) {
                                $data = [];
                                $data['{{full_name}}'] = $detail->first_name . ' ' . $detail->last_name;
                                $data['{{reminder_day}}'] = $reminderDay;

                                if ($logo) {
                                    $data['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href='.url("/").'> <img src='.asset($logo).'> </a>';
                                } else {
                                    $data['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href='.url("/").'>'.config('app.name').'</a>';
                                }
                                if ($detail->brand_logo) {
                                    $data['{{bank}}'] = "<img src=" . asset($detail->brand_logo) . " />";
                                } else {
                                    $data['{{bank}}'] = $detail->other_bank;
                                }
                                $data['{{account_name}}'] = $detail->account_name;
                                $data['{{amount}}'] = $detail->amount;
                                $data['{{tenure}}'] = $detail->tenure;
                                $data['{{tenure_calender}}'] = $detail->tenure_calender;
                                $data['{{start_date}}'] = !empty($detail->start_date) ? date("d-m-Y", strtotime($detail->start_date)) : '-';
                                $data['{{end_date}}'] = !empty($detail->end_date) ? date("d-m-Y", strtotime($detail->end_date)) : '-';
                                $data['{{interest_earned}}'] = $detail->interest_earned;
                                $data['{{ad}}'] = "<a href=".$adLink."><img style='max-width: 570px;' src=".asset($ad)."></a>";
                                $key = array_keys($data);
                                $value = array_values($data);
                                $newContent = Helper::replaceStrByValue($key, $value, $emailTemplate->contents);
                                $detail->subject = $emailTemplate->subject;
                                Mail::send('frontend.emails.reminder', ['content' => $newContent], function ($message) use ($detail) {
                                    $message->from($detail->auto_email, $detail->email_sender_name);
                                    $message->to($detail->email)->subject($detail->subject);
                                });
                            }


                        }
                    }
                }

            }
        }
    }
}
