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

class AccountInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $account_information = User::find($id);
        $validate = Validator::make($request->all(), [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'tel_phone' => 'numeric|nullable'
        ]);
        $email_notification = $adviser = 0;
        if (!empty($request->email_notification)) {
            $email_notification = 1;
        }
        if (!empty($request->adviser)) {
            $adviser = 1;
        }
        if ($validate->fails()) {
            return redirect()->route('account-information.edit')->withErrors($validate)->withInput();
        } else {
            $account_information->email = $request->email;
            $account_information->first_name = $request->first_name;
            $account_information->last_name = $request->last_name;
            $account_information->country_code = $request->country_code;
            $account_information->tel_phone = $request->tel_phone;
            /*$account_information->notification    =   $request->privacy;*/
            $account_information->email_notification = $email_notification;
            $account_information->adviser = $adviser;
            $account_information->save();
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
                $accountInformation->delete_status = 1;
                $accountInformation->updated_by = "User";
                $accountInformation->updated_at = Carbon::now()->toDateTimeString();
            } elseif ($request->type == "deactivate") {
               // $accountInformation->status = 0;
                $accountInformation->status = 0;
                $accountInformation->updated_by = "User";
                $accountInformation->updated_at = Carbon::now()->toDateTimeString();
            }
            $accountInformation->save();
        }
        return redirect()->route('user.logout')->with('success', 'Data ' . UPDATED_ALERT);
    }
}
