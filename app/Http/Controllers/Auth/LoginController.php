<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Socialite;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Brand;
use DB;
use App\Page;
use App\ProductManagement;
use App\User;


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
    protected $redirectTo = '/';

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

    protected function credentials(Request $request) {
        // Validate the form data
        /*$this->validate($request, [
            'g-recaptcha-response' => 'required|captcha'
        ]);*/
        return array_merge($request->only($this->username(), 'password'), ['status' => 1,'delete_status'=>0]);
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

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect('profile-dashboard');
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

    public function resetPassword($id) {
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
            $brands = Brand::where('delete_status', 0)->orderBy('view_order', 'asc')->get();
        return view('auth.passwords.reset', compact("brands", "page", "systemSetting", "banners"));
        }
    }

    public function resetPasswordUpdate(Request $request, $id) {
        $reset = User::find($id);

        if (!Hash::check($request->old_password, $reset->password)) {
            return redirect()->route('user.resetpassword', ['id'    =>  $id])->with('error', 'Old Password does not match')->withInput();
        }

        $validate = Validator::make($request->all(), [
            'old_password'  =>  'required|min:8',
            'new_password'  =>  'required|confirmed|min:8'
        ]);

        if($validate->fails()) {
            return redirect()->route('user.resetpassword', ['id'    =>  $id])->withErrors($validate)->withInput();
        }
        else {
            $reset->password    =   Hash::make($request->new_password);
            $reset->save();
        }
        return redirect('account-information')->with('success', 'Password ' . UPDATED_ALERT);
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    function findOrCreateUser($user, $provider) {
        $authUser = User::where('email', $user->email)->first();
        if ($authUser) {
            return $authUser;
        }

        return User::create([
            'name'      => $user->name,
            'email'     => $user->email,
            'password'  => bcrypt('!!!!!'),
            'provider'  => $provider
        ]);
    }
}
