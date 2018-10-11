<?php

namespace App\Http\Controllers\Enquiry;

use App\ContactEnquiry;
use App\HealthInsuranceEnquiry;
use App\Http\Controllers\Controller;
use App\LifeInsuranceEnquiry;
use App\InvestmentEnquiry;
use App\Mail\ContactEnquiryMail;
use App\Mail\HealthEnquiryMail;
use App\Mail\LifeEnquiryMail;
use App\Mail\InvestmentEnquiryMail;
use App\User;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Mail;
use Validator;

class EnquiryFrontController extends Controller
{
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
        //
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

    /*Contact us */
    public function postContactEnquiry(Request $request)
    {
        //check validation
        $fields = [
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|max:255',
            'telephone' => 'required|min:8|max:255',
            'subject' => 'required|max:255',
            'message' => 'required|max:3500',
            'g-recaptcha-response' => 'required|captcha'
        ];
        $this->validate($request, $fields);
        $data = $request->all();

        $contactEnquiry = new ContactEnquiry();

        $contactEnquiry->full_name = $request->full_name;
        $contactEnquiry->email = $request->email;
        $contactEnquiry->country_code = $request->country_code;
        $contactEnquiry->telephone = $request->telephone;
        $contactEnquiry->subject = $request->subject;
        $contactEnquiry->message = $request->message;
        $contactEnquiry->save();

        try {
            Mail::to(ADMIN_EMAIL)->send(new ContactEnquiryMail($data));
        } catch (Exception $exception) {
            //dd($exception);
            return redirect(url('contact'))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function postHealthEnquiry(Request $request)
    {
        // dd($request->all());
        //check validation
        $fields = [
            'coverage' => 'required|max:255',
            'level' => 'required|max:255',
            'time' => 'required|max:255',
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|max:255',
            'telephone' => 'required|min:8|max:255',

        ];

        if (isset($request->time)) {
            if (in_array("Other", $request->time)) {
                $fields ['other_value'] = 'required';
            }
        }
        if (isset($request->level)) {
            if ($request->level==YES) {
                $fields ['health_condition'] = 'required';
            }
        }
        $validator = Validator::make($request->all(), $fields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();

        $healthInsuranceEnquiry = new HealthInsuranceEnquiry();

        $healthInsuranceEnquiry->coverage = $request->coverage;
        $healthInsuranceEnquiry->level = $request->level;
        $healthInsuranceEnquiry->health_condition = $request->health_condition;
        $times = [];
        if (isset($request->time)) {
            $times = $request->time;
        }
        $healthInsuranceEnquiry->times = serialize($times);
        $healthInsuranceEnquiry->other_value = $request->other_value;
        $healthInsuranceEnquiry->full_name = $request->full_name;
        $healthInsuranceEnquiry->email = $request->email;
        $healthInsuranceEnquiry->country_code = $request->country_code;
        $healthInsuranceEnquiry->telephone = $request->telephone;

        $healthInsuranceEnquiry->save();

        if(Auth::user()->email==$request->email) {
            $user = User::find(Auth::user()->id);

            $user->country_code = $request->country_code;
            $user->tel_phone = $request->telephone;

            $user->save();
        }

        try {
            Mail::to(ADMIN_EMAIL)->send(new HealthEnquiryMail($data));
        } catch (Exception $exception) {
            //dd($exception);
            return redirect(url(HEALTH_INSURANCE_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function postLifeEnquiry(Request $request)
    {
        //dd($request->all());
        //check validation
        $fields = [
            'components' => 'required',
            'gender' => 'required|max:255',
            'dob' => 'required|max:255',
            'smoke' => 'required|max:255',
            'time' => 'required',
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|max:255',
            'telephone' => 'required|max:255',

        ];

        if (isset($request->time)) {
            if (in_array("Other", $request->time)) {
                $fields ['other_value'] = 'required';
            }
        }
        $validator = Validator::make($request->all(), $fields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();

        $lifeInsuranceEnquiry = new LifeInsuranceEnquiry();
        $components = [];
        if (isset($request->components)) {
            $components = $request->components;
        }
        $lifeInsuranceEnquiry->components = serialize($components);
        $lifeInsuranceEnquiry->gender = $request->gender;
        $lifeInsuranceEnquiry->dob = date("Y-m-d", strtotime($request->dob));
        $lifeInsuranceEnquiry->smoke = $request->smoke;
        $times = [];
        if (isset($request->time)) {
            $times = $request->time;
        }
        $lifeInsuranceEnquiry->times = serialize($times);
        $lifeInsuranceEnquiry->other_value = $request->other_value;
        $lifeInsuranceEnquiry->full_name = $request->full_name;
        $lifeInsuranceEnquiry->email = $request->email;
        $lifeInsuranceEnquiry->country_code = $request->country_code;
        $lifeInsuranceEnquiry->telephone = $request->telephone;

        $lifeInsuranceEnquiry->save();

        if(Auth::user()->email==$request->email) {
            $user = User::find(Auth::user()->id);

            $user->country_code = $request->country_code;
            $user->tel_phone = $request->telephone;

            $user->save();
        }

        try {
            Mail::to(ADMIN_EMAIL)->send(new LifeEnquiryMail($data));
        } catch (Exception $exception) {
            
            return redirect(url(LIFE_INSURANCE_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function investmentEnquiry(Request $request)
    {

        //check validation
        $fields = [
            'goals' => 'required',
            'experience' => 'required',
            'risks' => 'required',
            'age' => 'required',
            'time' => 'required',
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'country_code' => 'required|max:255',
            'telephone' => 'required|max:255',

        ];
        if (isset($request->experience)) {
            if ($request->experience==YES) {
                $fields ['experience_detail'] = 'required';
            }
        }
        if (isset($request->time)) {
            if (in_array(TIME_OTHER, $request->time)) {
                $fields ['other_value'] = 'required';
            }
        }
        if (isset($request->goals)) {
            if (in_array(GOAL_OTHER, $request->goals)) {
                $fields ['goal_other_value'] = 'required';
            }
        }

        $validator = Validator::make($request->all(), $fields);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();

        $investmentEnquiry = new InvestmentEnquiry();
        $goals = [];
        if (isset($request->goals)) {
            $goals = $request->goals;
        }
        $investmentEnquiry->goals = serialize($goals);
        $investmentEnquiry->goal_other_value = isset($request->goal_other_value) ? $request->goal_other_value :null;
        $investmentEnquiry->experience = $request->experience;
        $investmentEnquiry->experience_detail = isset($request->experience_detail) ? $request->experience_detail :null;
        $risks = [];
        if (isset($request->risks)) {
            $risks = $request->risks;
        }
        $investmentEnquiry->risks = serialize($risks);
        $times = [];
        if (isset($request->time)) {
            $times = $request->time;
        }
        $investmentEnquiry->times = serialize($times);
        $investmentEnquiry->other_value = $request->other_value;
        $investmentEnquiry->full_name = $request->full_name;
        $investmentEnquiry->email = $request->email;
        $investmentEnquiry->country_code = $request->country_code;
        $investmentEnquiry->telephone = $request->telephone;

        $investmentEnquiry->save();

        if(Auth::user()->email==$request->email) {
            $user = User::find(Auth::user()->id);

            $user->country_code = $request->country_code;
            $user->tel_phone = $request->telephone;

            $user->save();
        }

        try {
            Mail::to(ADMIN_EMAIL)->send(new InvestmentEnquiryMail($data));
        } catch (Exception $exception) {

            return redirect(url(INVESTMENT_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }
    public  function testMail(Request $request)
    {

        try {
            Mail::raw('Text', function ($message){
                $message->to('nicckk.verz@gmail.com');
            });
            dd("Hi");
        } catch (Exception $exception) {
            dd($exception);
        }

    }
}
