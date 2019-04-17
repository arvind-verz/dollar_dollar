<?php
namespace App\Http\Controllers\Auth;

use App\Mail\NewUserNotify;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Page;
use App\Brand;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Exception;
use App\Mail\NewUserWelcome;
use App\AdsManagement;
use App\SystemSetting;
use App\EmailTemplate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    private $systemSetting;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//dd($data);
        $validatorFields = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'password' => 'required|min:8|confirmed',
            'tel_phone' => '',
        ];
        if (User::where('email', $data['email'])->where('delete_status', 0)->exists()) {
            $validatorFields = array_add($validatorFields, 'email', "required|email|max:255|unique:users");
        } else {
            $validatorFields = array_add($validatorFields, 'email', "required|email|max:255");
        }
        return Validator::make($data, $validatorFields);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {

        /*set mail sending function in speedo\vendor\laravel\framework\src\Illuminate\Foundation\Auth\RegistersUsers.php  Line no 40.*/
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            //'tel_phone' => $data['tel_phone'],
            'company' => $data['company'],
            'subscribe' => $data['subscribe'],

        ]);
    }

    public function userRegistration(Request $request)
    {
        $systemSetting = $this->systemSetting;
//dd($request->all());
        $validate = [
            'salutation' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'nullable|numeric',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'g-recaptcha-response' => 'required|captcha'
//'slug' => 'required'
        ];
        if (User::where('email', $request->email)->where('delete_status', 0)->exists()) {
            $validate = array_add($validate, 'email', "required|email|max:255|unique:users");
        } else {
            $validate = array_add($validate, 'email', "required|email|max:255");
        }
        $validator = Validator::make($request->all(), $validate);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $slug = REGISTRATION;
            DB::enableQueryLog();
            $page = Page::LeftJoin('menus', 'menus.id', '=', 'pages.menu_id')
                ->where('pages.slug', $slug)
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
            }
            $notification = 1;
            $email_notification = $adviser = 0;
            if (!empty($request->notification)) {
                $notification = 3;
            }
            if (!empty($request->email_notification)) {
                $email_notification = 1;
            }
            if (!empty($request->adviser)) {
                $adviser = 1;
            }
            $registration = new User();
            $registration->salutation = $request->salutation;
            $registration->first_name = $request->first_name;
            $registration->last_name = $request->last_name;
            $registration->email = $request->email;
            $registration->tel_phone = $request->contact;
            $registration->password = Hash::make($request->password);
            $registration->notification = $notification;
            $registration->email_notification = $email_notification;
            $registration->adviser = $adviser;
            $registration->save();
            $user = User::where('email', $registration->email)->where('delete_status', 0)->first();
            if ($user) {
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

                $emailTemplate = EmailTemplate::find(NEW_USER_NOTIFY_MAIL_ID);
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
                    $data1 = [];
                    $data2 = [];
                    $data2['{{first_name}}']=$data1['{{first_name}}'] = $user->first_name;
                    $data2['{{last_name}}']=$data1['{{last_name}}'] = $user->last_name;
                    $data1['{{email}}'] = $user->email;
                    $data1['{{country_code}}'] = $user->country_code;
                    $data1['{{telephone}}'] = $user->tel_phone;
                    $data1['{{created_at}}'] = date("Y-m-d H:i", strtotime($user->created_at));

                    if ($logo) {
                        $data1['{{logo}}']=$data2['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href='.url("/").'> <img src='.asset($logo).'> </a>';
                    } else {
                        $data1['{{logo}}']=$data2['{{logo}}'] = '<a target="_blank" rel="noopener noreferrer" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #bbbfc3; font-size: 19px; font-weight: bold; text-decoration: none; text-shadow: 0 1px 0 white;" href='.url("/").'>'.config('app.name').'</a>';
                    }
                    $data2['{{ad}}'] = "<a href=".$adLink."><img style='max-width: 570px;' src=".asset($ad)."></a>";
                    $key1 = array_keys($data1);
                    $value1 = array_values($data1);
                    $newContent1 = \Helper::replaceStrByValue($key1, $value1, $emailTemplate->contents);

                    try {
                        Mail::send('frontend.emails.reminder', ['content' => $newContent1], function ($message) use ($emailTemplate) {
                            $message->from($emailTemplate->auto_email, $emailTemplate->email_sender_name);
                            $message->to($emailTemplate->admin_email)->subject($emailTemplate->subject);
                        });

                    } catch (Exception $exception) {
                        return redirect(url(HEALTH_INSURANCE_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
                    }
                    $thankEmail = EmailTemplate::find(NEW_USER_WELCOME_MAIL_ID);
                    if($thankEmail){
                        $key2 = array_keys($data2);
                        $value2 = array_values($data2);
                        $newContent2 = \Helper::replaceStrByValue($key2, $value2, $thankEmail->contents);
                        $thankEmail->auto_email = $systemSetting->auto_email;
                        $thankEmail->email_sender_name = $systemSetting->email_sender_name;
                        $thankEmail->admin_email = $systemSetting->admin_email;
                        $thankEmail->email = $request->email;

                        try {
                            Mail::send('frontend.emails.reminder', ['content' => $newContent2], function ($message) use ($thankEmail) {
                                $message->from($thankEmail->auto_email, $thankEmail->email_sender_name);
                                $message->to($thankEmail->email)->subject($thankEmail->subject);
                            });
                        } catch (Exception $exception) {
                            //dd($exception);
                            return redirect(url(HEALTH_INSURANCE_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
                        }
                    }

                    return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
                }
            }
            $redirect_url = $request->redirect_url;
            if (empty($redirect_url)) {
                $redirect_url = REGISTRATION;
            }
            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password,'delete_status'=>0], $request->remember)) {

// if successful, then redirect to their intended location
                return redirect(url($redirect_url))->with('success', 'Data ' . ADDED_ALERT);
            }
            return redirect(url($redirect_url))->with('success', 'Data ' . ADDED_ALERT);
        }
//$registration = new User();
    }

    public function registration_page($redirect_url = NULL)
    {
        $slug = REGISTRATION;
        $page = Page::LeftJoin('menus', 'menus.id', '=', 'pages.menu_id')
            ->where('pages.slug', $slug)
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

//get banners
            $banners = \Helper::getBanners($slug);
//get slug
            $brands = Brand::where('delete_status', 0)->where('display', 1)->orderBy('view_order', 'asc')->get();
            return view('frontend.CMS.registration', compact("redirect_url", "brands", "page", "systemSetting", "banners"));
        }
    }
}