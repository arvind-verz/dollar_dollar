<?php

namespace App\Http\Controllers\Auth;

use App\AdsManagement;
use App\Brand;
use App\Http\Controllers\Controller;
use App\Page;
use App\ProductManagement;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout', 'resetPassword', 'resetPasswordUpdate']]);
    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    protected function credentials(Request $request)
    {
        // Validate the form data
        /*$this->validate($request, [
        'g-recaptcha-response' => 'required|captcha'
        ]);*/
        return array_merge($request->only($this->username(), 'password'), ['delete_status' => 0]);
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        
        $request->session()->regenerate();
        $user = User::where('email', $request->email)->first();
        if($user){
            $user->status = 1;
            $user->save();
        }
        return $this->authenticated($request, $this->guard()->user())
        ?: redirect($request->redirect_url);
    }

    protected function authenticated(Request $request, $user)
    {
        //
    }

    /*public function credentials(Request $request) {
    return array_merge($request->only($this->username(), 'password'), ['web_login' => 1,'delete_status'=>0]);
    //dd($request->all());
    $validate = [
    'email'     =>  'required|email',
    'password'  =>  'required'
    ];

    $validator = Validator::make($request->all(), $validate);

    if ($validator->getMessageBag()->count()) {
    return back()->withInput()->withErrors($validator->errors());
    }
    else {
    // Attempt to log the user in
    if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

    // if successful, then redirect to their intended location
    return redirect(url(LOGIN_SLUG))->with('success','Data ' . ADDED_ALERT);
    }

    }
    }
     */

    public function resetPassword($id)
    {
        $user_products = ProductManagement::join('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->get();
        $ads =[];
        $adsCollection = AdsManagement::where('delete_status', 0)
                    ->where('display', 1)
                    ->where('page', 'account')
                    ->inRandomOrder()
                    ->get();
        if ($adsCollection->count()) {
            $ads = \Helper::manageAds($adsCollection);
        }

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
            return view('frontend.user.change-password', compact("brands", "page", "systemSetting", "banners", 'ads'));
        }
    }

    public function resetPasswordUpdate(Request $request, $id)
    {
        $reset = User::find($id);

        if (!Hash::check($request->old_password, $reset->password)) {
            return redirect()->route('user.resetpassword', ['id' => $id])->with('error', 'Old Password does not match')->withInput();
        }

        $validate = Validator::make($request->all(), [
            'old_password' => 'required|min:8',
            'new_password' => 'required|confirmed|min:8',
        ]);

        if ($validate->fails()) {
            return redirect()->route('user.resetpassword', ['id' => $id])->withErrors($validate)->withInput();
        } else {
            $reset->password = Hash::make($request->new_password);
            $reset->save();
        }
        return redirect('account-information')->with('success', 'Password ' . UPDATED_ALERT);
    }

    public function redirectToProvider($provider,Request $request)
    {
        if(isset($request->redirect_url)){
             session(['redirect_url' => $request->redirect_url]);
        }
    
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider,Request $request)
    {
        if(session('redirect_url')){
            $this->redirectTo= session('redirect_url');
        }
        
        $request->session()->forget('redirect_url');
        if (!$request->has('code') || $request->has('denied')) {
            return redirect(url($this->redirectTo));
        }
        $user     = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        if($authUser){
            $authUser->status = 1;
            $authUser->save();
        }
        return redirect(url($this->redirectTo));
    }

    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }

        $name     = explode(' ', $user->name);
        $provider = $provider;
        //dd($provider);
        return User::create([
            'first_name'         => $name[0],
            'last_name'          => $name[1],
            'email'              => $user->email,
            'password'           => bcrypt('!!!!!'),
            'provider'           => $provider,
            'email_notification' => 1,
            'adviser'            => 1,
        ]);
    }
    public function logInPage($redirect_url=NULL) {

            return view('auth.login', compact("redirect_url"));
        }
}
