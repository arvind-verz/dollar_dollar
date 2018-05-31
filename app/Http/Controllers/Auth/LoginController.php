<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }

    public function userLogout()
    {
        Auth::guard('web')->logout();
        return redirect('/');
    }

    protected function credentials(Request $request) {
        return array_merge($request->only($this->username(), 'password'), ['web_login' => 1,'delete_status'=>0]);
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

}
