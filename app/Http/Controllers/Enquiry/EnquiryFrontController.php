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
use App\Mail\LoanEnquiry as LoanEnquiryMail;
use App\Mail\ThankYou;
use App\User;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Http\Request;
use Mail;
use Validator;
use App\Page;
use App\LoanEnquiry;
use App\PromotionProducts;
use App\SystemSetting;
use App\AdsManagement;

class EnquiryFrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $systemSetting;
    private $ads;

    public function __construct()
    {
        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            $systemSetting = new SystemSetting();
            $systemSetting->email_sender_name = env('MAIL_FROM_NAME');
            $systemSetting->admin_email = env('ADMIN_EMAIL');
            $systemSetting->auto_email = env('MAIL_FROM_ADDRESS');
        }

        $this->systemSetting = $systemSetting;

        $ads = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'email')
            ->inRandomOrder()
            ->first();

        if ($ads) {

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

            $ads->ad = $ad;
            $ads->ad_link = $adLink;
        }
        $this->ads = $ads;

    }

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
        $systemSetting = $this->systemSetting;
        $ads = $this->ads;
        //check validation
        $fields = [

            'subject' => 'required|max:255',
            'message' => 'required|max:3500',
            'g-recaptcha-response' => 'required|captcha'
        ];
        $validator = Validator::make($request->all(), $fields);
        if (!$request->full_name) {
            $validator->getMessageBag()->add('full_name', 'This field is required.');
        }
        if (!$request->email) {
            $validator->getMessageBag()->add('email', 'This field is required.');
        } elseif (\Helper::isValidEmail($request->email) == false) {
            $validator->getMessageBag()->add('email', 'The email must be a valid email address.');
        }
        if (!$request->telephone) {
            $validator->getMessageBag()->add('telephone', 'This field is required.');
        }
        if (!$request->country_code) {
            $validator->getMessageBag()->add('country_code', 'This field is required.');
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['sender_email'] = $systemSetting->auto_email;
        $data['sender_name'] = $systemSetting->email_sender_name;
        $data['ad'] = null;
        $data['ad_link'] = null;
        if($ads){
            $data['ad'] = $ads->ad;
            $data['ad_link'] = $ads->ad_link;
        }

        $contactEnquiry = new ContactEnquiry();

        $contactEnquiry->full_name = $request->full_name;
        $contactEnquiry->email = $request->email;
        $contactEnquiry->country_code = $request->country_code;
        $contactEnquiry->telephone = $request->telephone;
        $contactEnquiry->subject = $request->subject;
        $contactEnquiry->message = $request->message;
        $contactEnquiry->save();

        try {
            Mail::to($systemSetting->admin_email)->send(new ContactEnquiryMail($data));
            Mail::to($request->email)->send(new ThankYou($data));
        } catch (Exception $exception) {
            //dd($exception);
            return redirect(url('contact'))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function postHealthEnquiry(Request $request)
    {
        $systemSetting = $this->systemSetting;
        $ads = $this->ads;

        // dd($request->all());
        //check validation
        $fields = [
            'coverage' => 'required|max:255',
            'level' => 'required|max:255',
            'time' => 'required|max:255',
            'g-recaptcha-response' => 'required|captcha'
        ];

        if (isset($request->time)) {
            if (in_array("Other", $request->time)) {
                $fields ['other_value'] = 'required';
            }
        }
        if (isset($request->level)) {
            if ($request->level == YES) {
                $fields ['health_condition'] = 'required';
            }
        }
        $validator = Validator::make($request->all(), $fields);
        if (!$request->full_name) {
            $validator->getMessageBag()->add('full_name', 'This field is required.');
        }
        if (!$request->email) {
            $validator->getMessageBag()->add('email', 'This field is required.');
        } elseif (\Helper::isValidEmail($request->email) == false) {
            $validator->getMessageBag()->add('email', 'The email must be a valid email address.');
        }
        if (!$request->telephone) {
            $validator->getMessageBag()->add('telephone', 'This field is required.');
        }
        if (!$request->country_code) {
            $validator->getMessageBag()->add('country_code', 'This field is required.');
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['sender_email'] = $systemSetting->auto_email;
        $data['sender_name'] = $systemSetting->email_sender_name;
        $data['ad'] = null;
        $data['ad_link'] = null;
        if($ads){
            $data['ad'] = $ads->ad;
            $data['ad_link'] = $ads->ad_link;
        }
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

        if (Auth::check()) {
            $user = User::find(Auth::user()->id);

            $user->country_code = $request->country_code;
            $user->tel_phone = $request->telephone;

            $user->save();
        }

        try {
            Mail::to($systemSetting->admin_email)->send(new HealthEnquiryMail($data));
            Mail::to($request->email)->send(new ThankYou($data));
        } catch (Exception $exception) {
            //dd($exception);
            return redirect(url(HEALTH_INSURANCE_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function postLifeEnquiry(Request $request)
    {
        $systemSetting = $this->systemSetting;
        $ads = $this->ads;

        //dd($request->all());
        //check validation
        $fields = [
            'components' => 'required',
            'gender' => 'required|max:255',
            'dob' => 'required|max:255',
            'smoke' => 'required|max:255',
            'time' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ];

        if (isset($request->time)) {
            if (in_array("Other", $request->time)) {
                $fields ['other_value'] = 'required';
            }
        }
        $validator = Validator::make($request->all(), $fields);
        if (!$request->full_name) {
            $validator->getMessageBag()->add('full_name', 'This field is required.');
        }
        if (!$request->email) {
            $validator->getMessageBag()->add('email', 'This field is required.');
        } elseif (\Helper::isValidEmail($request->email) == false) {
            $validator->getMessageBag()->add('email', 'The email must be a valid email address.');
        }
        if (!$request->telephone) {
            $validator->getMessageBag()->add('telephone', 'This field is required.');
        }
        if (!$request->country_code) {
            $validator->getMessageBag()->add('country_code', 'This field is required.');
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['sender_email'] = $systemSetting->auto_email;
        $data['sender_name'] = $systemSetting->email_sender_name;
        $data['ad'] = null;
        $data['ad_link'] = null;
        if($ads){
            $data['ad'] = $ads->ad;
            $data['ad_link'] = $ads->ad_link;
        }

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

        if (Auth::check()) {
            $user = User::find(Auth::user()->id);

            $user->country_code = $request->country_code;
            $user->tel_phone = $request->telephone;

            $user->save();
        }

        try {
            Mail::to($systemSetting->admin_email)->send(new LifeEnquiryMail($data));
            Mail::to($request->email)->send(new ThankYou($data));
        } catch (Exception $exception) {

            return redirect(url(LIFE_INSURANCE_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function investmentEnquiry(Request $request)
    {

        $systemSetting = $this->systemSetting;
        $ads = $this->ads;
        //check validation
        $fields = [
            'goals' => 'required',
            'experience' => 'required',
            'risks' => 'required',
            'age' => 'required',
            'time' => 'required',
            'g-recaptcha-response' => 'required|captcha'
        ];
        if (isset($request->experience)) {
            if ($request->experience == YES) {
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

        if (!$request->full_name) {
            $validator->getMessageBag()->add('full_name', 'This field is required.');
        }
        if (!$request->email) {
            $validator->getMessageBag()->add('email', 'This field is required.');
        } elseif (\Helper::isValidEmail($request->email) == false) {
            $validator->getMessageBag()->add('email', 'The email must be a valid email address.');
        }
        if (!$request->telephone) {
            $validator->getMessageBag()->add('telephone', 'This field is required.');
        }
        if (!$request->country_code) {
            $validator->getMessageBag()->add('country_code', 'This field is required.');
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['sender_email'] = $systemSetting->auto_email;
        $data['sender_name'] = $systemSetting->email_sender_name;
        $data['ad'] = null;
        $data['ad_link'] = null;
        if($ads){
            $data['ad'] = $ads->ad;
            $data['ad_link'] = $ads->ad_link;
        }

        $investmentEnquiry = new InvestmentEnquiry();
        $goals = [];
        if (isset($request->goals)) {
            $goals = $request->goals;
        }
        $investmentEnquiry->goals = serialize($goals);
        $investmentEnquiry->goal_other_value = isset($request->goal_other_value) ? $request->goal_other_value : null;
        $investmentEnquiry->experience = $request->experience;
        $investmentEnquiry->experience_detail = isset($request->experience_detail) ? $request->experience_detail : null;
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
        $investmentEnquiry->age = $request->age;
        $investmentEnquiry->country_code = $request->country_code;
        $investmentEnquiry->telephone = $request->telephone;

        $investmentEnquiry->save();

        if (Auth::check()) {
            $user = User::find(Auth::user()->id);

            $user->country_code = $request->country_code;
            $user->tel_phone = $request->telephone;

            $user->save();
        }

        try {
            Mail::to($systemSetting->admin_email)->send(new InvestmentEnquiryMail($data));
            Mail::to($request->email)->send(new ThankYou($data));
        } catch (Exception $exception) {

            return redirect(url(INVESTMENT_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function loanEnquiry(Request $request)
    {

        $searchFilter = $request->all();
        //dd($searchFilter);
        $page = Page::where('pages.slug', LOAN_ENQUIRY)
            ->where('delete_status', 0)->first();
        if (!$page) {
            return redirect()->action('Blog\BlogController@index')->with('error', OPPS_ALERT);
        }
        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            return back()->with('error', OPPS_ALERT);
        }

        $banners = \Helper::getBanners(LOAN_ENQUIRY);
        return view("frontend.CMS.loan-enquiry", compact("productIds", "page", "banners", 'systemSetting', 'searchFilter'));

    }

    public function postLoanEnquiry(Request $request)
    {
        $systemSetting = $this->systemSetting;
        $ads = $this->ads;
        //check validation
        $fields = ['g-recaptcha-response' => 'required|captcha'];

        $validator = Validator::make($request->all(), $fields);
        if (!$request->full_name) {
            $validator->getMessageBag()->add('full_name', 'This field is required.');
        }
        if (!$request->email) {
            $validator->getMessageBag()->add('email', 'This field is required.');
        } elseif (\Helper::isValidEmail($request->email) == false) {
            $validator->getMessageBag()->add('email', 'The email must be a valid email address.');
        }
        if (!$request->telephone) {
            $validator->getMessageBag()->add('telephone', 'This field is required.');
        }
        if (!$request->rate_type_search) {
            $validator->getMessageBag()->add('rate_type_search', 'This field is required.');
        }
        if (!$request->property_type_search) {
            $validator->getMessageBag()->add('property_type_search', 'This field is required.');
        }
        if (!$request->loan_amount) {
            $validator->getMessageBag()->add('loan_amount', 'This field is required.');
        }
        if (!$request->loan_type) {
            $validator->getMessageBag()->add('loan_type', 'This field is required.');
        }else if($request->loan_type =='Refinance' && is_null($request->existing_bank_loan)){
            $validator->getMessageBag()->add('existing_bank_loan', 'This field is required.');
        }
        if (!$request->country_code) {
            $validator->getMessageBag()->add('country_code', 'This field is required.');
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['sender_email'] = $systemSetting->auto_email;
        $data['sender_name'] = $systemSetting->email_sender_name;
        $data['ad'] = null;
        $data['ad_link'] = null;
        if($ads){
            $data['ad'] = $ads->ad;
            $data['ad_link'] = $ads->ad_link;
        }

        $loanEnquiry = new LoanEnquiry();
        $productIds = [];
        if (!empty($request->product_ids)) {
            $productIds = explode(",", $request->product_ids);
        }
        $productNames = [];
        if (count($productIds)) {
            $products = PromotionProducts::whereIn('id', $productIds)->where('delete_status', 0)->where('status', 1)->get();
            if ($products->count()) {
                $productNames = $products->pluck('product_name')->all();
            }
        }
        $data['product_names'] = $productNames;
        $loanEnquiry->product_ids = serialize($productIds);
        $loanEnquiry->rate_type = isset($request->rate_type_search) ? $request->rate_type_search : null;
        $loanEnquiry->property_type = isset($request->property_type_search) ? $request->property_type_search : null;
        $loanEnquiry->loan_amount = isset($request->loan_amount) ? $request->loan_amount : null;
        $loanEnquiry->loan_type = isset($request->loan_type) ? $request->loan_type : null;
        $loanEnquiry->existing_bank_loan = isset($request->existing_bank_loan) ? $request->existing_bank_loan : null;
        $loanEnquiry->full_name = $request->full_name;
        $loanEnquiry->email = $request->email;
        $loanEnquiry->country_code = $request->country_code;
        $loanEnquiry->telephone = $request->telephone;
        $loanEnquiry->save();
        if (Auth::check()) {
            if (Auth::user()->email == $request->email) {
                $user = User::find(Auth::user()->id);

                $user->country_code = $request->country_code;
                $user->tel_phone = $request->telephone;

                $user->save();
            }
        }

        try {
            Mail::to($systemSetting->admin_email)->send(new LoanEnquiryMail($data));
            Mail::to($request->email)->send(new ThankYou($data));
        } catch (Exception $exception) {
            //dd($exception);
            return redirect(url(LOAN_ENQUIRY))->with('error', 'Oops! Something wrong please try after sometime.');
        }
        return redirect(url('thank'))->with('success', 'Your inquiry has been sent to the respective team.');
    }

    public function testMail(Request $request)
    {

        try {
            Mail::raw('Text', function ($message) {
                $message->to('nicckk.verz@gmail.com');
            });
            dd("Hi");
        } catch (Exception $exception) {
            dd($exception);
        }

    }
}
