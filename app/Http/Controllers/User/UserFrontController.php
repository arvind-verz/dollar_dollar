<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use App\Mail\NewUserNotify;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Mail\ForgotPassword;
use App\AdsManagement;
use App\SystemSetting;
use App\Mail\ResetNewPassword;
use App\EmailTemplate;


class UserFrontController extends Controller
{

    private $systemSetting;

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['logout', 'getLoginStatus', 'postContactUs', 'postResetNewPassword', 'postForgotPassword', 'postForgotPasswordReset', 'postResetPassword']]);
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
    public function edit($id)
    {
        //
        $user = User::find($id);

        return view("frontend.user.account-setting", compact("user"));
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
        //dd($request->all());
        //get user detail by id
        $user = User::find($id);

        $fields = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            //'shipping_address' => 'required|max:255',
            //'billing_address' => 'required|max:255',
        ];
        if (isset($request->password)) {
            $fields = array_add($fields, 'password', 'min:8|confirmed');
            $user->password = bcrypt($request->password);
        }
        /*if (isset($request->tel_phone)) {
            $fields = array_add($fields, 'tel_phone', 'digits:8');
            $user->tel_phone = $request->tel_phone;
        }
        if (isset($request->shipping_address)) {
            $user->shipping_address = $request->shipping_address;
        }
        if (isset($request->billing_address)) {
            $user->billing_address = $request->billing_address;
        }*/
        $this->validate($request, $fields);

        //set detail for update
        //$user->billing_address = $request->billing_address;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->tel_phone = $request->tel_phone;
        $user->shipping_address = $request->shipping_address;
        $user->subscribe = $request->subscribe;
        $user->updated_at_user = Carbon::now()->toDateTimeString();

        if ($user->save()) {
            /* Mail::send('frontEnd.email.welcome', [
                 'fname' => $request->first_name,
                 'lname' => $request->last_name,
                 's_email' => $request->email_address,
                 'email' => $request->email_address,
                 'url' => "#",
                 'password' => $request->password,
                 'content' => $email_cont->contents
             ], function ($message) use ($company_name) {
                 $message->to(Input::get('email_address'))->subject($company_name . ' is now a Company of Good!');
                 $message->bcc(trans('backLang.bccEmail'))->subject($company_name . ' is now a Company of Good!');
             });

             Auth::login($user);
             $email = $request->email_address;
             $register_status = 1;
             $subscribe = $this->subscribe($email, $register_status);
             \DB::table('users')->where('email', $request->email_address)->update(['last_login' => Carbon::now()->toDateTimeString()]);
             */
            return redirect(route('user.edit', ['id' => $id]))->with('success', 'Account updated successfully');
        } else {
            return redirect(route('user.edit', ['id' => $id]))->with('success', 'Whoops! Something went wrong!');
        }


    }

    public function changePassword($id)
    {
        //
        $user = User::find($id);

        return view("frontend.user.change-password", compact("user"));
    }

    public function updatePassword(Request $request, $id)
    {
        //dd($request->all());
        //get user detail by id
        $user = User::find($id);

        $fields = [
            'password' => 'required|min:8|confirmed',
        ];
        $this->validate($request, $fields);

        //set detail for update
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            Auth::guard('web')->logout();
            return redirect(route('login'))->with('success', 'Password updated successfully.Please login again.');
        } else {
            return redirect(route('user.change.password', ['id' => $id]))->with('success', 'Whoops! Something went wrong!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @return mixed
     * check login status
     */
    public function getLoginStatus()
    {
        if (Auth::check()) {
            return ['status' => true];
        } else {
            return ['status' => false];
        }

    }

    /*Contct us */
    public function postContactUs(Request $request)
    {
        $systemSetting = $this->systemSetting;

        //check validation
        $fields = [
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'feedback' => 'required|max:255',
            'g-recaptcha-response' => 'required|captcha'
        ];
        $this->validate($request, $fields);
        $data = $request->all();
        $data['sender_email'] = $systemSetting->auto_email;
        $data['sender_name'] = $systemSetting->email_sender_name;

        try {
            Mail::to($systemSetting->admin_email)->send(new ContactUs($data));
        } catch (Exception $exception) {

            return redirect(url('contact-us'))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('contact-us'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function postForgotPassword(Request $request)
    {
        $systemSetting = $this->systemSetting;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors())->with('form', 'forgot');
        }
        $user = User::where('email', $request->email)->where('delete_status', 0)->first();
        if (!$user) {
            $validator->getMessageBag()->add('email', 'We cant find a user with this e-mail address.');
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
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
            DB::table('password_resets')->insert(['email' => $user->email, 'token' => str_random(80), 'created_at' => Carbon::now()->toDateTimeString()]);
            $pw_reset = DB::table('password_resets')->where('email', $user->email)->first();
            $token = \Helper::base64_encode($pw_reset->token);
            $url = url('/') . '/password-reset/' . $token;
            $contactUrl = url('/') . '/contact';

            $data1 = ['{{ad_link}}' => $adLink,'{{first_name}}' => $user->first_name, '{{last_name}}' => $user->last_name, '{{url}}' => $url];
            $emailTemplate = EmailTemplate::find(FORGOT_LOGIN_MAIL_ID);
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
                if ($logo) {
                    $data1['{{logo}}'] = $data2['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href=' . url("/") . '> <img src=' . asset($logo) . '> </a>';
                } else {
                    $data1['{{logo}}'] = $data2['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href=' . url("/") . '>' . config('app.name') . '</a>';
                }
                $data1['{{ad}}'] = "<a href=" . $adLink . "><img style='max-width: 570px;' src=" . asset($ad) . "></a>";
                $key1 = array_keys($data1);
                $value1 = array_values($data1);
                $newContent1 = \Helper::replaceStrByValue($key1, $value1, $emailTemplate->contents);
                try {
                    Mail::send('frontend.emails.reminder', ['content' => $newContent1], function ($message) use ($emailTemplate) {
                        $message->from($emailTemplate->auto_email, $emailTemplate->email_sender_name);
                        $message->to($emailTemplate->email)->subject($emailTemplate->subject);
                    });

                } catch (Exception $exception) {
                    return redirect()->back()->with('error', 'Oops! Something wrong please try after sometime.');
                }

            }

            return redirect()->back()->with(['status' => 'We have sent password reset link to your mail', 'form' => 'forgot']);
        }
    }

    public function postResetNewPassword(Request $request)
    {
        $systemSetting = $this->systemSetting;
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors())->with('form', 'forgot');
        }
        $user = User::where('email', $request->email)->where('delete_status', 0)->first();
        if (!$user) {
            $validator->getMessageBag()->add('email', 'We cant find a user with this e-mail address.');
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
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
            DB::table('password_resets')->insert(['email' => $user->email, 'token' => str_random(80), 'created_at' => Carbon::now()->toDateTimeString()]);
            $pw_reset = DB::table('password_resets')->where('email', $user->email)->first();
            $token = \Helper::base64_encode($pw_reset->token);
            $url = url('/') . '/password-reset/' . $token;
            $contactUrl = url('/') . '/contact';

            $data1 = ['{{ad_link}}' => $adLink,'{{first_name}}' => $user->first_name, '{{last_name}}' => $user->last_name, '{{url}}' => $url];
            $emailTemplate = EmailTemplate::find(RESET_LOGIN_MAIL_ID);
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
                if ($logo) {
                    $data1['{{logo}}'] = $data2['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href=' . url("/") . '> <img src=' . asset($logo) . '> </a>';
                } else {
                    $data1['{{logo}}'] = $data2['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href=' . url("/") . '>' . config('app.name') . '</a>';
                }
                $data1['{{ad}}'] = "<a href=" . $adLink . "><img style='max-width: 570px;' src=" . asset($ad) . "></a>";
                $key1 = array_keys($data1);
                $value1 = array_values($data1);
                $newContent1 = \Helper::replaceStrByValue($key1, $value1, $emailTemplate->contents);
                try {
                    Mail::send('frontend.emails.reminder', ['content' => $newContent1], function ($message) use ($emailTemplate) {
                        $message->from($emailTemplate->auto_email, $emailTemplate->email_sender_name);
                        $message->to($emailTemplate->email)->subject($emailTemplate->subject);
                    });

                } catch (Exception $exception) {
                    return redirect()->back()->with('error', 'Oops! Something wrong please try after sometime.');
                }

            }
            return redirect()->back()->with(['status' => 'We have sent password reset link to your mail', 'form' => 'forgot']);
        }
    }

    public function postForgotPasswordReset($token)
    {
        $decodeToken = \Helper::base64_decode($token);
        $getToken = DB::table('password_resets')->where('token', $decodeToken)->first();
        if ($getToken) {
            return view('frontend.user.reset-password')->with(['token' => $token]);
        } else {
            return redirect('/home')->with(['error' => 'The Requested url is invalid']);
        }
    }

    public function postResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->errors());
        }

        $token = \Helper::base64_decode($request->token);
        $detail = DB::table('password_resets')->where('token', $token)->first();
        if ($detail) {
            if ($detail->email != $request->email) {
                return back()->with(['error' => 'Email does not match with our records']);
            }
            $user = User::where('email', $detail->email);
            $password = bcrypt($request->input('password'));
            if ($user->update(['password' => $password])) {
                DB::table('password_resets')->where('token', $token)->delete();
                return redirect('/login')->with(['status' => 'Your password has been changed successfully. Please login again', 'form' => 'login']);
            } else {
                return back()->with(['error' => 'Unable to reset password. Please try again!']);
            }
        } else {
            return back()->with(['error' => 'The Requested url is invalid']);
        }
    }


}
