<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use DB;
use App\Page;
use App\ProductManagement;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\AdsManagement;
use Carbon\Carbon;
use App\UserLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProfileUpdated;
use App\CustomerUpdateDetail;
use Exception;
use App\Mail\UpdateDetailNotify;
use App\EmailTemplate;

class AccountInformationController extends Controller
{
    private $systemSetting;

    public function __construct()
    {
        $this->middleware('auth');
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $location = NULL)
    {
        $ads = [];
        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'account')
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads = \Helper::manageAds($adsCollection);
        }
        $user_products = ProductManagement::join('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->get();
        //dd($user_products);

        DB::enableQueryLog();
        $page = Page::LeftJoin('menus', 'menus.id', '=', 'pages.menu_id')
            ->where('pages.slug', ACCOUNTINFO)
            ->where('pages.delete_status', 0)
            ->where('pages.status', 1)
            ->select('pages.*', 'menus.title as menu_title', 'menus.id as menu_id')
            ->first();
        //dd(DB::getQueryLog());
        //dd($page,$slug);
        if (!$page) {
            return redirect(url('/'))->with('error', "Opps! page not found");
        } else {
            $systemSetting = \Helper::getSystemSetting();
            if (!$systemSetting) {
                return back()->with('error', OPPS_ALERT);
            }

            $slug = $page->slug;
            //get banners
            $banners = \Helper::getBanners($slug);

            //get slug
            $brands = Brand::where('delete_status', 0)->where('display', 1)->orderBy('view_order', 'asc')->get();
            return view('frontend.user.account-information-edit', compact("brands", "page", "systemSetting", "banners", 'ads', 'location'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = [];
        $data1 = [];
        $oldData = [];
        $newData = [];
        $updated = false;
        $systemSetting = $this->systemSetting;
        $account_information = User::find($id);
        $oldUser = $account_information;
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'tel_phone' => 'numeric|nullable'
        ]);

        if ($validate->fails()) {
            return redirect()->route('account-information.edit')->withErrors($validate)->withInput();
        } else {
            $data1['{{old_first_name}}'] = $oldUser->first_name;
            $data1['{{old_last_name}}'] = $oldUser->last_name;

            if ($oldUser->first_name != $request->first_name) {
                $newData['first_name'] = $data['first_name'] = $request->first_name;
                $oldData['first_name'] = $oldUser->first_name;
                $updated = true;
            }
            if ($oldUser->last_name != $request->last_name) {
                $newData['last_name'] = $data['last_name'] = $request->last_name;
                $oldData['last_name'] = $oldUser->last_name;
                $updated = true;
            }
            if ($oldUser->email != $request->email) {
                $newData['email'] = $data['email'] = $request->email;
                $oldData['email'] = $oldUser->email;
                $updated = true;
            }
            if ($oldUser->tel_phone != $request->tel_phone) {
                $newData['tel_phone'] = $data['tel_phone'] = $request->tel_phone;
                $oldData['tel_phone'] = $oldUser->tel_phone;
                $updated = true;
            }
            if ($oldUser->country_code != $request->country_code) {
                $newData['country_code'] = $data['country_code'] = $request->country_code;
                $oldData['country_code'] = $oldUser->country_code;
                $updated = true;
            }
            if (is_null($request->email_notification)) {
                $request->email_notification = 0;
            }
            if (is_null($request->adviser)) {
                $request->adviser = 0;
            }
            if ($oldUser->email_notification != $request->email_notification) {
                $newData['email_notification'] = $data['email_notification'] = $request->email_notification;
                $oldData['email_notification'] = $oldUser->email_notification;
                if ($data['email_notification'] == 0) {
                    $data['email_notification'] = "No";
                } elseif ($data['email_notification'] == 1) {
                    $data['email_notification'] = "Yes";
                }
                $updated = true;
            }
            if ($oldUser->adviser != $request->adviser) {
                $newData['adviser'] = $data['adviser'] = $request->adviser;
                if ($data['adviser'] == 0) {
                    $data['adviser'] = "No";
                } elseif ($data['adviser'] == 1) {
                    $data['adviser'] = "Yes";
                }
                $oldData['adviser'] = $oldUser->adviser;
                $updated = true;
            }
            $ads = collect([]);
            $adsCollection = AdsManagement::where('delete_status', 0)
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

            if ($ads->paid_ads_status == 1 && $current_time >= $ad_start_date && $current_time <= $ad_end_date && !empty($ads->paid_ad_image)) {
                $ad = $ads->paid_ad_image;
                $adLink = $ads->paid_ad_link;
            } else {
                $ad = $ads->ad_image;
                $adLink = $ads->ad_link;
            }
            if ($updated) {
                $account_information->email = $request->email;
                $account_information->first_name = $request->first_name;
                $account_information->last_name = $request->last_name;
                $account_information->country_code = $request->country_code;
                $account_information->tel_phone = $request->tel_phone;
                $accountInformation->updated_at = Carbon::now()->toDateTimeString();
                $account_information->updated_at_user    =   Carbon::now()->toDateTimeString();
                $account_information->email_notification = $request->email_notification;
                $account_information->adviser = $request->adviser;
                $account_information->save();

                $customerDetailUpdate = new CustomerUpdateDetail();
                $customerDetailUpdate->user_id = $id;
                $customerDetailUpdate->first_name = $account_information->first_name;
                $customerDetailUpdate->last_name = $account_information->last_name;
                $customerDetailUpdate->old_detail = json_encode($oldData);
                $customerDetailUpdate->updated_detail = json_encode($newData);
                $customerDetailUpdate->updated_by = FRONT_USER;
                $customerDetailUpdate->save();

                $emailTemplate = EmailTemplate::find(UPDATE_DETAIL_NOTIFY_MAIL_ID);
                if ($emailTemplate) {
                    $emailTemplate->auto_email = $systemSetting->auto_email;
                    $emailTemplate->email_sender_name = $systemSetting->email_sender_name;
                    $emailTemplate->admin_email = $systemSetting->admin_email;
                    $emailTemplate->email = $request->email;
                    $systemSetting = $this->systemSetting;
                    $logo = null;
                    if ($systemSetting) {
                        $logo = $systemSetting->logo;
                    }

                    $data1['{{updated_detail}}'] = '<table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;"><tbody>';

                    if (isset($data['salutation'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Salutation</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['salutation'] . '</td>
</tr>';
                    }
                    if (isset($data['first_name'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">First Name</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['first_name'] . '</td>
</tr>';
                    }
                    if (isset($data['last_name'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Last Name</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['last_name'] . '</td>
</tr>';
                    }
                    if (isset($data['email'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Email</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['email'] . '</td>
</tr>';
                    }
                    if (isset($data['password'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Password</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['password'] . '</td>
</tr>';
                    }
                    if (isset($data['country_code'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Country Code</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['country_code'] . '</td>
</tr>';
                    }
                    if (isset($data['tel_phone'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Contact Number</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['tel_phone'] . '</td>
</tr>';
                    }
                    if (isset($data['status'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Status</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['status'] . '</td>
</tr>';
                    }
                    if (isset($data['email_notification'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Newsletter</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['email_notification'] . '</td>
</tr>';
                    }
                    if (isset($data['adviser'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Consent to marketing information</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . $data['adviser'] . '</td>
</tr>';
                    }
                    if (isset($data['updated_at_admin'])) {
                        $data1['{{updated_detail}}'] .= '<tr>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Update on</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">:</td>
<td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787e; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">' . date("Y-m-d h:i A", strtotime($data['updated_at_admin'])) . '</td>
</tr>';
                    }
                    $data1['{{updated_detail}}'] .= '</tbody></table>';

                    if ($logo) {
                        $data1['{{logo}}'] = $data2['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href=' . url("/") . '> <img src=' . asset($logo) . '> </a>';
                    } else {
                        $data1['{{logo}}'] = $data2['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href=' . url("/") . '>' . config('app.name') . '</a>';
                    }
                    $data2['{{ad}}'] = "<a href=" . $adLink . "><img style='max-width: 570px;' src=" . asset($ad) . "></a>";
                    $key1 = array_keys($data1);
                    $value1 = array_values($data1);
                    $newContent1 = \Helper::replaceStrByValue($key1, $value1, $emailTemplate->contents);
                    try {
                        Mail::send('frontend.emails.reminder', ['content' => $newContent1], function ($message) use ($emailTemplate) {
                            $message->from($emailTemplate->auto_email, $emailTemplate->email_sender_name);
                            $message->to($emailTemplate->email)->subject($emailTemplate->subject);
                        });

                    } catch (Exception $exception) {

                    }

                }
            }
        }

        if (!empty($request->location)) {
            return redirect($request->location)->with('success', 'Data ' . UPDATED_ALERT);
        } else {
            return redirect('account-information')->with('success', 'Data ' . UPDATED_ALERT);
        }
    }


    public function deleteDeactivate($id, Request $request)
    {
        $accountInformation = User::find($id);
        if (!$accountInformation) {
            return redirect()->route('/');
        } else {
            if ($request->type == "delete") {

                $userLog = New UserLog();
                $userLog->first_name = $accountInformation->first_name;
                $userLog->last_name = $accountInformation->last_name;
                $userLog->country_code = $accountInformation->country_code;
                $userLog->tel_phone = $accountInformation->tel_phone;
                $userLog->email = $accountInformation->email;
                $userLog->user_id = $id;
                $userLog->status = DELETED;
                $userLog->updated_by_id = $id;
                $userLog->updated_by = FRONT_USER;
                $userLog->updated_on = Carbon::now()->toDateTimeString();
                User::destroy($id);
            } elseif ($request->type == "deactivate") {
                // $accountInformation->status = 0;
                $accountInformation->status = 0;
                $accountInformation->updated_by = "User";
                $accountInformation->updated_at = Carbon::now()->toDateTimeString();
                $accountInformation->updated_at_user = Carbon::now()->toDateTimeString();

                $userLog = New UserLog();
                $userLog->user_id = $id;
                $userLog->status = DEACTIVATED;
                $userLog->updated_by_id = $id;
                $userLog->updated_by = FRONT_USER;
                $userLog->updated_on = Carbon::now()->toDateTimeString();
                $accountInformation->save();

            }

            $userLog->save();
        }
        return redirect()->route('user.logout')->with('success', 'Data ' . UPDATED_ALERT);
    }
}
