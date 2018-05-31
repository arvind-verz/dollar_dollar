<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Mail;
use Illuminate\Http\Response;
use App\Mail\NewUserNotify;
use Exception;


class UserFrontController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['logout', 'getLoginStatus', 'postContactUs']]);
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
        //check validation
        $fields = [
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'feedback' => 'required|max:255',
            'g-recaptcha-response' => 'required|captcha'
        ];
        $this->validate($request, $fields);
        $data = $request->all();
        try {
            Mail::to(ADMIN_EMAIL)->send(new ContactUs($data));
        } catch (Exception $exception) {

            return redirect(url('contact-us'))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('contact-us'))->with('success', 'Your inquiry has been sent to the respective team.');
    }
}
