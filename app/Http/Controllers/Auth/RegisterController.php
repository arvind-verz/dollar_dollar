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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'tel_phone' => $data['tel_phone'],
            'company' => $data['company'],
            'subscribe' => $data['subscribe'],
            
        ]);
    }


    public function userRegistration(Request $request) {
        //dd($request->all());
        $validate = [
            'salutation'        =>  'required',
            'first_name'        =>  'required',
            'last_name'         =>  'required',
            'contact'           =>  'required|numeric',
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
        }
        else {
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
            if(!empty($request->notification)) {
              $notification = 3;
            }
            if(!empty($request->email_notification)) {
              $email_notification = 1;
            }
            if(!empty($request->adviser)) {
              $adviser = 1;
            }
            $registration = new User();
            $registration->salutation   =   $request->salutation;
            $registration->first_name   =   $request->first_name;
            $registration->last_name    =   $request->last_name;
            $registration->email        =   $request->email;
            $registration->tel_phone    =   $request->contact;
            $registration->password     =   Hash::make($request->password);
            $registration->notification     =   $notification;
            $registration->email_notification     =   $email_notification;
            $registration->adviser     =   $adviser;
            $registration->save();
            $user = User::where('email',$registration->email)->where('delete_status',0)->first();
            if($user)
            {
                $data = $user->toArray();
                $data['blog_url'] = url('/') . '/blog-list';
                $data['admin_url'] = url('/') . '/admin';

                try {
                    Mail::to($registration->email)->send(new NewUserWelcome($data));
                    Mail::to(ADMIN_EMAIL)->send(new NewUserNotify($data));
                } catch (Exception $exception) {
                    //dd($exception);
                }
            }

            $redirect_url = $request->redirect_url;
            if(empty($redirect_url)) {
                $redirect_url = REGISTRATION;
            }
            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
        
                // if successful, then redirect to their intended location
                return redirect(url($redirect_url))->with('success','Data ' . ADDED_ALERT);
              }
            return redirect(url($redirect_url))->with('success','Data ' . ADDED_ALERT);
        }
        //$registration = new User();
    }

    public function registration_page($redirect_url=NULL) {
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
