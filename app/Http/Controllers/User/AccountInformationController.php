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
            $data['old_first_name'] = $oldUser->first_name;
            $data['old_last_name'] = $oldUser->last_name;

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
                $updated = true;
            }
            if ($oldUser->adviser != $request->adviser) {
                $newData['adviser'] = $data['adviser'] = $request->adviser;
                $oldData['adviser'] = $oldUser->adviser;
                $updated = true;
            }
            if ($updated) {
                $account_information->email = $request->email;
                $account_information->first_name = $request->first_name;
                $account_information->last_name = $request->last_name;
                $account_information->country_code = $request->country_code;
                $account_information->tel_phone = $request->tel_phone;
                /*$account_information->notification    =   $request->privacy;*/
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

                $data['profile_url'] = url('/') . '/account-information';
                $data['sender_email'] = $systemSetting->auto_email;
                $data['sender_name'] = $systemSetting->email_sender_name;
                $data['updated_by'] = YOU;

                try {
                    Mail::to($account_information->email)->send(new UpdateDetailNotify($data));
                } catch (Exception $exception) {
                    dd($exception);
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
