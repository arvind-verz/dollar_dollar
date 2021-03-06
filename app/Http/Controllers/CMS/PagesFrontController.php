<?php

namespace App\Http\Controllers\CMS;

use App\AdsManagement;
use App\Brand;
use App\Currency;
use App\DefaultSearch;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Page;
use App\ProductManagement;
use App\PromotionProducts;
use App\systemSettingLegendTable;
use App\Tag;
use App\ToolTip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Defr;

class PagesFrontController extends Controller
{
    public function __construct()
    {

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
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show($slug)
    {
        DB::enableQueryLog();
        $user_products = null;
        if (Auth::check()) {
            $user_products = ProductManagement::leftjoin('brands', 'product_managements.bank_id', '=', 'brands.id')
                ->where('user_id', Auth::user()->id)
                ->orderBy('product_managements.id', 'DESC')
                ->select('product_managements.id as product_id', 'brands.*', 'product_managements.*')
                ->get();

            $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
                ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
                ->leftJoin('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
                ->where('promotion_products.featured', '=', 1)
                ->where('promotion_products.delete_status', '=', 0)
                ->where('promotion_products.status', '=', 1)
                ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
                ->get();
            if ($products->count()) {
                $todayDate = Carbon::today();
                foreach ($products as &$product) {
                    if (!is_null($product->until_end_date)) {
                        $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                        if ($untilEndDate > $todayDate) {
                            $product->remaining_days = $todayDate->diffInDays($untilEndDate); // tenure in days
                        } else {
                            $product->remaining_days = EXPIRED;
                        }
                    } else {
                        $product->remaining_days = null;
                    }
                    $maxTenure = 0;
                    $minTenure = 0;
                    if ($product->promotion_period == ONGOING) {
                        $product->tenure_category = ONGOING;
                    } elseif ($product->promotion_type_id != ALL_IN_ONE_ACCOUNT) {
                        $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                        if (count($placementPeriod)) {
                            $placementTenures = [];
                            foreach ($placementPeriod as $period) {
                                $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                                if ($value > 0) {
                                    $placementTenures[] = $value;
                                }
                            }
                            if (count($placementTenures)) {
                                $maxTenure = max($placementTenures);
                                $minTenure = min($placementTenures);
                                if (count($placementTenures) > 4) {
                                    $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                                }
                            }
                        }
                        if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2])) {
                            $product->tenure_category = DAYS;
                        } else {
                            $product->tenure_category = MONTHS;
                        }
                        $product->max_tenure = $maxTenure;
                        $product->min_tenure = $minTenure;
                        $product->tenure_value = $maxTenure;
                    } else {
                        $product->tenure_category = CRITERIA;
                    }
                }
                $results = collect();
                $products1 = $products->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                $products2 = $products->where('tenure_category', CRITERIA)->sortBy('promotion_period')->values();
                $products3 = $products->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                $products4 = $products->where('tenure_category', DAYS)->sortBy('min_tenure')->values();
                if ($products1->count()) {
                    $results = $results->merge($products1);
                }
                if ($products2->count()) {
                    $results = $results->merge($products2);
                }
                if ($products3->count()) {
                    $results = $results->merge($products3);
                }
                if ($products4->count()) {
                    $results = $results->merge($products4);
                }
                $products = $results;
            }
            //dd($products);

            $user_products_ending = ProductManagement::join('brands', 'product_managements.bank_id', '=', 'brands.id')
                ->where('user_id', Auth::user()->id)
                ->get();
        }
//dd(DB::getQueryLog());
        //dd($user_products);


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
            $redirect_url = "profile-dashboard";
            $slug = $page->slug;

//get banners
            $banners = \Helper::getBanners($slug);

//get slug
            $brands = Brand::where('delete_status', 0)->where('display', 1)->orderBy('title', 'asc')->get();

            if ($page->is_dynamic == 1) {

                if ($slug == CONTACT_SLUG) {
                    return view('frontend.CMS.contact', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == HEALTH_INSURANCE_ENQUIRY) {

                    $redirect_url = HEALTH_INSURANCE_ENQUIRY;
                    return view('frontend.CMS.health-insurance-enquiry', compact("brands", "page", "systemSetting", "banners"));

                } elseif ($slug == LIFE_INSURANCE_ENQUIRY) {
                    $redirect_url = LIFE_INSURANCE_ENQUIRY;
                    return view('frontend.CMS.life-insurance-enquiry', compact("brands", "page", "systemSetting", "banners"));

                } elseif ($slug == INVESTMENT_ENQUIRY) {

                    $redirect_url = INVESTMENT_ENQUIRY;
                    return view('frontend.CMS.investment-enquiry', compact("brands", "page", "systemSetting", "banners"));

                } elseif ($slug == LOAN_ENQUIRY) {
                    return view('frontend.CMS.loan-enquiry', compact("brands", "page", "systemSetting", "banners"));

                } elseif ($slug == REGISTRATION) {
                    return view('frontend.CMS.registration', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == PROFILEDASHBOARD) {
                    $adsCollection = AdsManagement::where('delete_status', 0)
                        ->where('display', 1)
                        ->where('page', 'account')
                        ->inRandomOrder()
                        ->get();
                    //dd($adsCollection);
                    if ($adsCollection->count()) {
                        $ads = \Helper::manageAds($adsCollection);
                    }
                    if (AUTH::check()) {
                        return view('frontend.user.profile-dashboard', compact("brands", "page", "systemSetting", "banners", "user_products", "user_products_ending", "ads", 'products'));
                    } else {
                        return redirect('/login');
                    }
                } elseif ($slug == ACCOUNTINFO) {
                    $adsCollection = AdsManagement::where('delete_status', 0)
                        ->where('display', 1)
                        ->where('page', 'account')
                        ->inRandomOrder()
                        ->get();
                    if ($adsCollection->count()) {
                        $ads = \Helper::manageAds($adsCollection);
                    }
                    if (AUTH::check()) {
                        return view('frontend.user.account-information', compact("brands", "page", "systemSetting", "banners", 'ads'));
                    } else {
                        return redirect('/login');
                    }

                } elseif ($slug == PRODUCTMANAGEMENT) {
                    $adsCollection = AdsManagement::where('delete_status', 0)
                        ->where('display', 1)
                        ->where('page', 'account')
                        ->inRandomOrder()
                        ->get();
                    if ($adsCollection->count()) {
                        $ads = \Helper::manageAds($adsCollection);
                    }
                    if (AUTH::check()) {
                        return view('frontend.user.product-management', compact("brands", "page", "systemSetting", "banners", "user_products", 'ads'));
                    } else {
                        return redirect('/login');
                    }

                } elseif ($slug == FIXED_DEPOSIT_MODE) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->fixDepositMode($details);

                } elseif ($slug == SAVING_DEPOSIT_MODE) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->savingDepositMode($details);

                } elseif ($slug == PRIVILEGE_DEPOSIT_MODE) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->privilegeDepositMode($details);

                } elseif ($slug == FOREIGN_CURRENCY_DEPOSIT_MODE) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->foreignCurrencyDepositMode($details);

                } elseif ($slug == AIO_DEPOSIT_MODE) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->aioDepositMode($details);

                } elseif ($slug == LOAN_MODE) {

                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->loanMode($details);

                } elseif ($slug == TERMS_CONDITION) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->termsCondition($details);

                } elseif ($slug == FORGOT_PASSWORD) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->forgotPassword($details);

                } elseif ($slug == RESET_PASSWORD) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->resetPassword($details);

                }

            } elseif ($page->is_blog == 1) {
                $query = Page::join('menus', 'pages.menu_id', '=', 'menus.id')
                    ->where('pages.delete_status', 0)
                    ->where('pages.is_blog', 1)
                    ->whereNotIn('pages.slug', [$slug])
                    ->select('pages.*', 'menus.title as menu_title')
                    ->orderBy('pages.id', 'DESC');
                if (Auth::guest()) {
                    $details = $query->whereIn('after_login', [0, null])->get();

                } else {
                    $details = $query->get();
                }
                $adsCollection = AdsManagement::where('delete_status', 0)
                    ->where('display', 1)
                    ->where('page', 'blog')
                    ->where('page_type', 'blog-inner')
                    ->inRandomOrder()
                    ->get();
                if ($adsCollection->count()) {
                    $ads = \Helper::manageAds($adsCollection);
                }
                $tags = [];
                if ($page->tags != null) {
                    $page->tags = json_decode($page->tags);
                    $tags = \Helper::getTags($page->tags);
                } else {
                    $page->tags = [];
                }
                $relatedBlog = [];
                if ($details->count()) {
                    foreach ($details as &$detail) {
                        if ($detail->tags != null) {
                            $detail->tags = json_decode($detail->tags);
                        } else {
                            $detail->tags = [];
                        }
                        $relatedBlog[] = $detail;
                    }
                }
                if (count($relatedBlog) > 3) {
                    $relatedBlog = array_random($relatedBlog, 3);
                }

                return view("frontend.Blog.blog-detail", compact("page", "systemSetting", "banners", "relatedBlog", 'tags', 'ads'));
            } else {
                return view("frontend.CMS.page", compact("page", "systemSetting", "banners", 'slug'));
            }
        }

    }

    public function termsCondition($details)
    {
        $details = \Helper::get_page_detail(TERMS_CONDITION);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        return view('frontend.CMS.terms-condition', compact("brands", "page", "systemSetting", "banners"));
    }

    public function fixDepositMode($details)
    {
        return $this->fixed([]);
    }

    public function search_fixed_deposit(Request $request)
    {
        return $this->fixed($request->all());
    }

    public function fixed($request)
    {

        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', FIXED_DEPOSIT_MODE)
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads_manage = \Helper::manageAds($adsCollection);
        }
        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : INTEREST;


        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', FIX_DEPOSIT)
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->leftJoin('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', FIX_DEPOSIT)
            //->whereNotNull('promotion_products.formula_id')
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();
        /*$nonFormulaProducts = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->where('promotion_products.promotion_type_id', '=', FIX_DEPOSIT)
            ->whereNull('promotion_products.formula_id')
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.created_at', 'DESC')
            ->select('promotion_products.*', 'brands.*')
            ->inRandomOrder()
            ->get();*/

        $details = \Helper::get_page_detail(FIXED_DEPOSIT_MODE);
        $brands = $details['brands'];
        if ($products->count() && $brands->count()) {
            $productsBrandIds = $products->pluck('bank_id')->all();
            $brands = $brands->whereIn('id', $productsBrandIds);
        }
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
        $remainingProducts = [];
        $sliderProducts = collect([]);
        //dd($products);
        if (!count($request)) {

            $searchFilter = [];
        } else {
            $searchFilter = $request;

        }
        foreach ($products as $key => &$product) {
            //dd($product);
            $defaultSearch = DefaultSearch::where('promotion_id', FIX_DEPOSIT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
            } else {
                $defaultPlacement = 0;
            }

            if (!count($request)) {
                $placement = 0;
                $searchValue = $defaultPlacement;
                $searchFilter['search_value'] = $defaultPlacement;
                $searchFilter['filter'] = INTEREST;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
                if (!is_numeric($searchValue)) {
                    $searchValue = $defaultPlacement;
                }
                $searchFilter['search_value'] = $searchValue;

            }

            $productRanges = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            $todayDate = Carbon::today();
            $startDate = \Helper::convertToCarbonEndDate($product->promotion_start);
            $endDate = \Helper::convertToCarbonEndDate($product->promotion_end);
            //including end day so 1 day add in end date
            $remainingDays = $todayDate->diffInDays($endDate); // tenure in days
            $monthSuffix = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
            $product->ads = json_decode($product->ads_placement);

            $product->tenure = $tenures;
            if (!is_null($product->until_end_date)) {
                $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                if ($untilEndDate > $todayDate) {
                    $product->remaining_days = $todayDate->diffInDays($untilEndDate); // tenure in days
                } else {
                    $product->remaining_days = EXPIRED;
                }
            } else {
                $product->remaining_days = null;
            }
            $status = false;

            if (in_array($product->promotion_formula_id, [FIX_DEPOSIT_F1])) {

                $totalInterestPercent = 0;
                $totalInterest = 0;
                $ranges = [];
                $resultKey = null;
                foreach ($productRanges as $k => $productRange) {
                    $bonusInterestHighlight = [];
                    $interestEarnedArray = [];
                    $bonusInterests = $productRange->bonus_interest;
                    $productRange->placement_highlight = false;
                    $productRange->placement_value = false;
                    $interestEarn = 0;
                    $interestPercent = 0;
                    if (count($searchFilter)) {
                        if (count($tenures)) {

                            foreach ($tenures as $tenureKey => $tenure) {

                                $bonusInterestHighlight[$tenureKey] = false;
                                if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                                    if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                        $productRange->placement_highlight = true;
                                        $productRange->placement_value = true;
                                        $status = true;
                                    }

                                    $placement = (float)$searchValue;
                                    $resultKey = $tenureKey;

                                }
                                if (empty($placement)) {
                                    $amount = $productRange->max_range;
                                    if (((count($tenures) - 1) == ($tenureKey)) && ((count($productRanges) - 1) == ($k))) {
                                        $placement = $productRange->max_range;
                                        $resultKey = $tenureKey;
                                    }
                                } else {
                                    $amount = $placement;
                                }
                                $interestEarn = ($amount * $bonusInterests[$tenureKey] * $tenure) / (100 * 12);
                                $interestEarnedArray[$tenureKey] = round($interestEarn, 2);
                            }
                        }
                        $productRange->bonus_interest_highlight = $bonusInterestHighlight;
                        $productRange->interest_earns = $interestEarnedArray;
                    }
                    $ranges[] = $productRange;

                }
                $product->interest_earns = [];
                $product->bonus_interests = [];
                $resultInterestEarn = 0;
                $resultInterestEarnPercent = 0;
                foreach ($ranges as $range) {
                    if ($placement >= $range->min_range && $placement <= $range->max_range) {
                        $product->interest_earns = $range->interest_earns;
                        $product->bonus_interests = $range->bonus_interest;
                    }

                }
                /*if (count($tenures)) {
                    $product->max_tenure = max($tenures);
                } else {
                    $product->max_tenure = 0;
                }*/

                if (count($product->interest_earns)) {
                    $resultInterestEarnArray = $product->interest_earns;
                    $resultInterestEarn = $resultInterestEarnArray[$resultKey];

                }
                if (count($product->bonus_interests)) {
                    $resultInterestEarnPercentArray = $product->interest_earns;
                    $resultInterestEarnPercent = $resultInterestEarnPercentArray[$resultKey];
                }
                $product->product_ranges = $ranges;
                $product->total_interest = $resultInterestEarnPercent;
                $product->total_interest_earn = round($resultInterestEarn, 2);
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }

                if ($status == true) {
                    $product->placement = $placement;
                    //dd($product);
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }
            } elseif (empty($product->promotion_formula_id)) {
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                $filterProducts[] = $product;
            }
        }
        $remainingProducts = collect($remainingProducts);
        if (count($searchFilter)) {

            $products = collect($filterProducts);
        }

        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $products->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                    $products2 = $products->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                    $products3 = $products->where('tenure_category', DAYS)->sortBy('min_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $products = $results;
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $products->where('tenure_category', ONGOING)->sortByDesc('max_tenure')->values();
                    $products2 = $products->where('tenure_category', MONTHS)->sortByDesc('max_tenure')->values();
                    $products3 = $products->where('tenure_category', DAYS)->sortByDesc('max_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $products = $results;
                }

            }
            $featured = $products->where('featured', 1)->values();
            $nonFeatured = $products->where('featured', 0)->values();
            $products = $featured->merge($nonFeatured);
            $sliderProducts = $products->where('promotion_formula_id', '!=', null)->values();
        }
        if ($remainingProducts->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $remainingProducts->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                    $products2 = $remainingProducts->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                    $products3 = $remainingProducts->where('tenure_category', DAYS)->sortBy('min_tenure')->values();

                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $remainingProducts = $results;
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $remainingProducts->where('tenure_category', ONGOING)->sortByDesc('max_tenure')->values();
                    $products2 = $remainingProducts->where('tenure_category', MONTHS)->sortByDesc('max_tenure')->values();
                    $products3 = $remainingProducts->where('tenure_category', DAYS)->sortByDesc('max_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $remainingProducts = $results;

                }
            }
            $featured = $remainingProducts->where('featured', 1)->values();
            $nonFeatured = $remainingProducts->where('featured', 0)->values();
            $remainingProducts = $featured->merge($nonFeatured);

        }
        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "sliderProducts", "searchFilter", "legendtable", "remainingProducts", 'ads_manage'));

    }

    public function savingDepositMode()
    {
        return $this->saving([]);
    }

    public function privilegeDepositMode($details)
    {
        return $this->privilege([]);
    }

    public function foreignCurrencyDepositMode($details)
    {
        $request = [];
        return $this->foreign_currency($request);
    }

    public function aioDepositMode()
    {
        $request = [];
        return $this->aio($request);

    }

    public function loanMode()
    {
        $request = ['first_time' => 1];
        return $this->loan($request);

    }

    public function getContactForm()
    {
        $page = Page::where('delete_status', 0)->where('slug', CONTACT_SLUG)->first();
        if (!$page) {
            return back()->with('error', OPPS_ALERT);
        }
        $brands = Brand::where('delete_status', 0)->where('display', 1)->orderBy('view_order', 'asc')->get();

        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            return back()->with('error', OPPS_ALERT);
        }
        $slug = $page->slug;
//get banners
        $banners = \Helper::getBanners($slug);

        return view('frontend.contact', compact("brands", "page", "systemSetting", "banners"));
    }

    public function getBlogByCategories($id = NULL, Request $request)
    {
        //dd($request->all(),$id);
        if (isset($request->blog_id)) {
            $id = $request->blog_id;
        }
        $page = Page::where('pages.slug', BLOG_URL)
            ->where('delete_status', 0)->first();
        if (!$page) {
            return back()->with('error', OPPS_ALERT);
        }
        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            return back()->with('error', OPPS_ALERT);
        }


//get banners
        $banners = \Helper::getBanners(BLOG_URL);

        $query = Page::join('menus', 'pages.menu_id', '=', 'menus.id')
            ->where('pages.delete_status', 0)
            ->where('pages.is_blog', 1)
            ->select('pages.*', 'menus.title as menu_title')
            ->orderBy('pages.id', 'DESC');
        $menu = null;
        if (!is_null($id)) {
            $query = $query->where('pages.menu_id', $id);
            $menu = Menu::where('id', $id)->where('delete_status', 0)->first();

        }
        $blogSearch = null;
        if (isset($request->b_search)) {
            $blogSearch = $request->b_search;
            $tags = Tag::where('title', 'LIKE', '%' . $request->b_search . '%')->get();
            $tagFound = [];
            if ($tags->count()) {
                $tags = $tags->pluck('id')->all();
                $pagesTagNotNull = Page::whereNotNull('tags')->where('delete_status', 0)->get();
                //dd($sel_query[0]->tags);
                if ($pagesTagNotNull->count()) {
                    foreach ($pagesTagNotNull as $page) {
                        $pageTags = json_decode($page->tags);
                        //print_r($tag_id);
                        $commonTags = [];
                        if (count($pageTags) && count($tags)) {
                            $commonTags = array_intersect($pageTags, $tags);
                            if (count($commonTags)) {
                                $tagFound[] = $page->id;
                            }
                        }
                    }
                }
            }

            $query = $query->where('pages.name', 'LIKE', '%' . $request->b_search . '%')
                ->orwhere('menus.title', 'LIKE', '%' . $request->b_search . '%');
            //dd($tagFound);
            if (count($tagFound)) {
                $query->orWhereIn('pages.id', [$tagFound]);
            }

        }
        if (Auth::guest()) {
            $details = $query->whereIn('after_login', [0, null])->paginate(10);
        } else {
            $details = $query->paginate(10);
        }

        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('page', 'blog')
            ->where('page_type', 'blog')
            ->where('display', 1)
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads = \Helper::manageAds($adsCollection);
        }
        if (!$details->count()) {
            if (isset($request->b_search)) {
                \Session::flash('error', SEARCH_RESULT_ERROR);
            }
            return view("frontend.Blog.blog-list", compact("details", "page", "banners", 'systemSetting', 'id', 'ads', 'blogSearch', 'menu'));
        } else {
            return view("frontend.Blog.blog-list", compact("details", "page", "banners", 'systemSetting', 'id', 'ads', 'blogSearch', 'menu'));
        }

    }

    public function getBlogByPostedBy($name = NULL, Request $request)
    {
        //dd($request->all(),$name);
        $id = null;
        $page = Page::where('pages.slug', BLOG_URL)
            ->where('delete_status', 0)->first();
        if (!$page) {
            return back()->with('error', OPPS_ALERT);
        }
        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            return back()->with('error', OPPS_ALERT);
        }


//get banners
        $banners = \Helper::getBanners(BLOG_URL);

        $query = Page::join('menus', 'pages.menu_id', '=', 'menus.id')
            ->where('pages.delete_status', 0)
            ->where('pages.is_blog', 1)
            ->select('pages.*', 'menus.title as menu_title')
            ->orderBy('pages.id', 'DESC');
        $menu = null;

        $blogSearch = null;

        $query = $query->where('pages.posted_by', 'LIKE', '%' . $name . '%');

        if (Auth::guest()) {
            $details = $query->whereIn('after_login', [0, null])->paginate(10);
        } else {
            $details = $query->paginate(10);
        }

        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('page', 'blog')
            ->where('page_type', 'blog')
            ->where('display', 1)
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads = \Helper::manageAds($adsCollection);
        }
        if (!$details->count()) {
            if (isset($request->b_search)) {
                \Session::flash('error', SEARCH_RESULT_ERROR);
            }
            return view("frontend.Blog.blog-list", compact("details", "page", "banners", 'systemSetting', 'id', 'ads', 'blogSearch', 'menu'));
        } else {
            return view("frontend.Blog.blog-list", compact("details", "page", "banners", 'systemSetting', 'id', 'ads', 'blogSearch', 'menu'));
        }

    }

    public function search_tags($slug)
    {
        $page = Page::where('pages.slug', BLOG_URL)
            ->where('delete_status', 0)->first();
        if (!$page) {
            return redirect()->action('Blog\BlogController@index')->with('error', OPPS_ALERT);
        }
        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            return back()->with('error', OPPS_ALERT);
        }

//get banners
        $banners = \Helper::getBanners(BLOG_URL);

        $search_tag = \Helper::searchTags($slug);

        $sel_query = Page::join('menus', 'pages.menu_id', '=', 'menus.id')
            ->where('pages.delete_status', 0)
            ->where('pages.is_blog', 1)
            ->whereIn('pages.id', $search_tag)
            ->select('pages.*', 'menus.title as menu_title')
            ->orderBy('pages.id', 'DESC');

        if (Auth::guest()) {
            $details = $sel_query->whereIn('after_login', [0, null])->paginate(10);

        } else {
            $details = $sel_query->paginate(10);
        }
        $id = null;

        return view("frontend.Blog.blog-list", compact("details", "page", "banners", 'systemSetting', 'id'));

    }

    public function search_privilege_deposit(Request $request)
    {
        return $this->privilege($request->all());
    }

    public function privilege($request)
    {
        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', PRIVILEGE_DEPOSIT_MODE)
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads_manage = \Helper::manageAds($adsCollection);
        }
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : INTEREST;


        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', PRIVILEGE_DEPOSIT)
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->leftJoin('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', PRIVILEGE_DEPOSIT)
            //->whereNotNull('promotion_products.formula_id')
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        $details = \Helper::get_page_detail(PRIVILEGE_DEPOSIT_MODE);
        $brands = $details['brands'];
        if ($products->count() && $brands->count()) {
            $productsBrandIds = $products->pluck('bank_id')->all();
            $brands = $brands->whereIn('id', $productsBrandIds);
        }
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
        $remainingProducts = [];
        $sliderProducts = collect([]);
        //dd($products);
        if (!count($request)) {

            $searchFilter = [];
        } else {
            $searchFilter = $request;
        }
        foreach ($products as $key => &$product) {
            //dd($product);
            $defaultSearch = DefaultSearch::where('promotion_id', PRIVILEGE_DEPOSIT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
            } else {
                $defaultPlacement = 0;
            }
            if (!count($request)) {

                $placement = 0;
                $searchValue = $defaultPlacement;
                $searchFilter['search_value'] = $defaultPlacement;
                $searchFilter['filter'] = INTEREST;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
                if (!is_numeric($searchValue)) {
                    $searchValue = $defaultPlacement;
                }
                $searchFilter['search_value'] = $searchValue;
            }
            $productRanges = json_decode($product->product_range);
            $todayDate = Carbon::today();
            $startDate = \Helper::convertToCarbonEndDate($product->promotion_start);
            $endDate = \Helper::convertToCarbonEndDate($product->promotion_end);
            //including end day so 1 day add in end date
            $tenure = $todayDate->diffInDays($endDate); // tenure in days
            $tenureTotal = 365; //by default tenure in days so total days 365
            $tenureType = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
            $product->ads = json_decode($product->ads_placement);
            $product->product_ranges = $productRanges;
            if (!is_null($product->until_end_date)) {
                $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                if ($untilEndDate > $todayDate) {
                    $product->remaining_days = $todayDate->diffInDays($untilEndDate); // tenure in days
                } else {
                    $product->remaining_days = EXPIRED;
                }
            } else {
                $product->remaining_days = null;
            }
            $status = false;
            $product->max_tenure = 0;

            if (in_array($product->promotion_formula_id, [PRIVILEGE_DEPOSIT_F6])) {
                $tenures = json_decode($product->tenure);
                //including end day so 1 day add in end date
                $remainingDays = $todayDate->diffInDays($endDate); // tenure in days
                $monthSuffix = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
                $product->ads = json_decode($product->ads_placement);

                $product->tenure = $tenures;
                $totalInterestPercent = 0;
                $totalInterest = 0;
                $ranges = [];
                $resultKey = null;
                foreach ($productRanges as $k => $productRange) {
                    $bonusInterestHighlight = [];
                    $interestEarnedArray = [];
                    $bonusInterests = $productRange->bonus_interest;
                    $productRange->placement_highlight = false;
                    $productRange->placement_value = false;
                    $interestEarn = 0;
                    $interestPercent = 0;
                    if (count($searchFilter)) {
                        if (count($tenures)) {

                            foreach ($tenures as $tenureKey => $tenure) {

                                $bonusInterestHighlight[$tenureKey] = false;
                                if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                                    if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                        $productRange->placement_highlight = true;
                                        $productRange->placement_value = true;
                                        $status = true;
                                    }

                                    $placement = (float)$searchValue;
                                    $resultKey = $tenureKey;

                                }
                                if (empty($placement)) {
                                    $amount = $productRange->max_range;
                                    if (((count($tenures) - 1) == ($tenureKey)) && ((count($productRanges) - 1) == ($k))) {
                                        $placement = $productRange->max_range;
                                        $resultKey = $tenureKey;
                                    }
                                } else {
                                    $amount = $placement;
                                }
                                $interestEarn = ($amount * $bonusInterests[$tenureKey] * $tenure) / (100 * 12);
                                $interestEarnedArray[$tenureKey] = round($interestEarn, 2);
                            }

                        }

                        $productRange->bonus_interest_highlight = $bonusInterestHighlight;
                        $productRange->interest_earns = $interestEarnedArray;
                    }
                    $ranges[] = $productRange;

                }

                $product->interest_earns = [];
                $product->bonus_interests = [];
                $resultInterestEarn = 0;
                $resultInterestEarnPercent = 0;
                foreach ($ranges as $range) {
                    if ($placement >= $range->min_range && $placement <= $range->max_range) {
                        $product->interest_earns = $range->interest_earns;
                        $product->bonus_interests = $range->bonus_interest;
                    }

                }
                /*if (count($tenures)) {
                    $product->max_tenure = max($tenures);
                } else {
                    $product->max_tenure = 0;
                }*/

                if (count($product->interest_earns)) {
                    $resultInterestEarnArray = $product->interest_earns;
                    $resultInterestEarn = $resultInterestEarnArray[$resultKey];

                }
                if (count($product->bonus_interests)) {
                    $resultInterestEarnPercentArray = $product->interest_earns;
                    $resultInterestEarnPercent = $resultInterestEarnPercentArray[$resultKey];
                }
                $product->product_ranges = $ranges;
                $product->total_interest = $resultInterestEarnPercent;
                $product->total_interest_earn = round($resultInterestEarn, 2);
                $product->placement = $placement;

                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    //dd($product);
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }
            }
            if (in_array($product->promotion_formula_id, [PRIVILEGE_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F2])) {
                $maxPlacements = [];

                foreach ($productRanges as $productRange) {
                    //dd($productRange);
                    $maxPlacements[] = $productRange->max_range;
                }
                //$placement = max($maxPlacements);

                foreach ($productRanges as $k => &$productRange) {

                    $productRange->placement_highlight = false;
                    $productRange->tenure_highlight = false;
                    $productRange->bonus_interest_highlight = false;
                    $productRange->board_interest_highlight = false;
                    $productRange->total_interest_highlight = false;
                    $productRange->placement_value = false;
                    $allInterests = [$productRange->bonus_interest, $productRange->board_rate, $productRange->bonus_interest + $productRange->board_rate];

                    if (count($searchFilter)) {
                        if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                            if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                $productRange->placement_highlight = true;
                                $productRange->placement_value = true;
                                $status = true;
                            }
                            $placement = (int)$searchValue;

                        }
                        if (empty($placement) && (count($productRanges) - 1) == ($k)) {
                            $placement = $productRange->max_range;
                        }
                    }

                    if ($placement >= $productRange->min_range &&
                        $placement <= $productRange->max_range
                    ) {
                        if (in_array($product->promotion_formula_id, [PRIVILEGE_DEPOSIT_F2])) {
                            $tenure = $productRange->tenure;
                            $tenureTotal = 12;
                            $product->tenure_highlight = true;
                            //$product->max_tenure = $tenure;
                        } else {
                            $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                            $tenure = 0;
                            if ($product->promotion_period == ONGOING) {
                                $tenure = 1;
                                $tenureTotal = 1;
                            } elseif ($untilEndDate > $todayDate) {
                                $tenure = $todayDate->diffInDays($untilEndDate); // tenure in days
                            }
                        }
                        $product->duration = $tenure;
                        $product->total_interest = $productRange->bonus_interest + $productRange->board_rate;
                        $totalInterest = (($placement * $productRange->bonus_interest / 100) * ($tenure / $tenureTotal)) + (($placement * $productRange->board_rate / 100) * ($tenure / $tenureTotal));
                        $product->total_interest_earn = $totalInterest;
                        $product->placement = $placement;


                    }
                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [PRIVILEGE_DEPOSIT_F3])) {

                foreach ($productRanges as $k => &$productRange) {
                    //$placement = $productRange->max_range;
                    $productRange->high_light = false;

                    $productRange->placement_highlight = false;
                    $productRange->tenure_highlight = false;
                    $productRange->bonus_interest_highlight = false;
                    $productRange->board_interest_highlight = false;
                    $productRange->total_interest_highlight = false;
                    $productRange->placement_value = false;

                    $allInterests = [];
                    $allInterests[] = $productRange->sibor_rate;
                    $allInterests[] = $productRange->air;

                    if (count($searchFilter)) {
                        if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                            if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                $productRange->high_light = true;
                                $status = true;
                            }
                            $placement = (int)$searchValue;
                        }
                        if (empty($placement) && (count($productRanges) - 1) == ($k)) {
                            $placement = $productRange->max_range;
                        }
                    }

                    if ($placement >= $productRange->min_range &&
                        $placement <= $productRange->max_range
                    ) {
                        $product->total_interest = $productRange->air + $productRange->sibor_rate;
                        $totalInterest = (($product->total_interest / 100) * ($placement));
                        $product->total_interest_earn = round($totalInterest, 2);
                        $product->placement = $placement;
                    }
                }
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [PRIVILEGE_DEPOSIT_F4])) {
                $status = false;
                $maxPlacements = [];
                $highlight = -1;
                $maxRanges = [];
                $minRanges = [];

                foreach ($productRanges as $k => $productRange) {
                    //dd($productRanges);
                    $allInterests = [$productRange->bonus_interest, $productRange->board_rate, $productRange->bonus_interest + $productRange->board_rate];
                    $maxRanges[] = $productRange->max_range;
                    $minRanges[] = $productRange->min_range;
                    if (count($searchFilter)) {
                        if (($searchValue >= $productRange->min_range) && ($searchValue > 0)) {

                            if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                $highlight = $k;
                                $status = true;
                            }
                            $maxPlacements[] = (int)$searchValue;

                        }
                        if (count($maxPlacements) == 0 && (count($productRanges) - 1) == ($k)) {
                            $maxPlacements[] = $productRange->max_range;

                        }


                    } else {

                        $maxPlacements[] = $placement;
                    }

                }
                $placement = max($maxPlacements);
                $totalInterests = [];
                $interestEarns = [];
                $lastCalculatedAmount = 0;
                $maxPlacement = array_last(array_sort($maxRanges));
                $minPlacement = array_last(array_sort($minRanges));

                foreach ($productRanges as $k => $productRange) {
                    $interestEarn = 0;
                    if ($minPlacement == $productRange->min_range && $minPlacement <= $placement) {
                        $totalInterest = $productRange->bonus_interest + $productRange->board_rate;
                        if ($lastCalculatedAmount < $placement) {
                            $interestEarn = round(($placement - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $lastCalculatedAmount = $placement;
                        }
                        $productRange->interest_earn = $interestEarn;
                        $productRange->total_interest = $totalInterest;


                    } else {
                        $totalInterest = $productRange->bonus_interest + $productRange->board_rate;
                        $productRange->total_interest = $totalInterest;
                        if ($productRange->max_range < $placement) {
                            $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $totalInterests[] = $totalInterest;
                            $lastCalculatedAmount = $productRange->max_range;

                        } elseif ($lastCalculatedAmount < $placement) {

                            $interestEarn = round(($placement - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $totalInterests[] = $totalInterest;
                            $lastCalculatedAmount = $placement;
                        }
                        //if($k==2){dd($interestEarn);};

                        $productRange->interest_earn = $interestEarn;
                        $productRange->total_interest = $totalInterest;

                    }


                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
                    $product->highlight = $highlight;
                    $filterProducts[] = $product;
                } else {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $searchValue;
                    $product->highlight = $highlight;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [PRIVILEGE_DEPOSIT_F5])) {
                $extraMonth = null;
                $rowHeadings = [CUMMULATED_MONTHLY_SAVINGS_AMOUNT, BASE_INTEREST,
                    ADDITIONAL_INTEREST, TOTAL_AMOUNT];
                $product->highlight = false;
                //dd($productRanges);
                foreach ($productRanges as $productRange) {

                    $months = [1];
                    $allInterests = [$productRange->base_interest, $productRange->bonus_interest];
                    $placement = $productRange->max_range;
                    $searchValue = round($searchValue / ((int)$productRange->placement_month));


                    if (count($searchFilter)) {

                        if ($searchValue >= $productRange->min_range) {
                            if ($searchValue >= $productRange->max_range) {
                                $placement = $productRange->max_range;
                            } else {
                                $placement = $searchValue;
                            }
                            if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                $product->highlight = true;
                                $status = true;
                            }

                        } else {
                            $placement = $productRange->max_range;
                        }
                    }
                    $x = (int)$productRange->placement_month;
                    $y = (int)$productRange->display_month;
                    $j = 1;
                    $z = 1;
                    do {
                        $z = $y * $j;
                        if ($z == 1) {
                        } elseif (($x > $z)) {
                            $months[] = $z;
                        } else {
                            $z = $x;
                            $months[] = $z;
                        }
                        $j++;
                    } while ($z != $x);
                    if (!in_array($extraMonth, $months) && (!is_null($extraMonth))) {
                        $months[] = $extraMonth;
                    }
                    $product->months = array_sort($months);


                    //dd($product->months);
                    $monthlySavingAmount = [];
                    $baseInterests = [];
                    $additionalInterests = [];
                    $baseInterestAll = [];
                    $additionalInterestsAll = [];
                    $totalInterestAmount = 0;

                    foreach ($product->months as $month) {
                        $monthlySavingAmount[$month] = $placement * $month;
                    }
                    $monthlySavingAmount[] = $placement * end($months);

                    for ($i = 1; $i <= ($productRange->placement_month); $i++) {

                        $baseInterest = round(($productRange->base_interest / 100) * ($placement * $i) * (31 / 365), 5);
                        $AdditionalInterest = round((($productRange->bonus_interest / 100) * (($placement * $i) + $baseInterest)) * (31 / 365), 5);
                        $baseInterestAll[] = $baseInterest;
                        $additionalInterestsAll[] = $AdditionalInterest;
                        if (in_array($i, $product->months)) {
                            $baseInterests[$i] = round($baseInterest, 2);;
                            $additionalInterests[$i] = round($AdditionalInterest, 2);;
                        }
                    }
                    $baseInterests[] = array_sum($baseInterestAll);
                    $additionalInterests[] = array_sum($additionalInterestsAll);
                    $totalInterestAmount = end($baseInterests) + end($additionalInterests);
                    $product->row_headings = $rowHeadings;
                    $product->monthly_saving_amount = $monthlySavingAmount;
                    $product->base_interests = $baseInterests;
                    $product->additional_interests = $additionalInterests;
                    $product->total_interest_earn = $totalInterestAmount + ($placement * $productRange->placement_month);
                    $product->placement = $placement;
                    $product->total_interest = 0;
                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (empty($product->promotion_formula_id)) {
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                $filterProducts[] = $product;
            }

        }
        $remainingProducts = collect($remainingProducts);
        if (count($searchFilter)) {
            $products = collect($filterProducts);
        }
        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $products->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                    $products2 = $products->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                    $products3 = $products->where('tenure_category', DAYS)->sortBy('min_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $products = $results;
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $products->where('tenure_category', ONGOING)->sortByDesc('max_tenure')->values();
                    $products2 = $products->where('tenure_category', MONTHS)->sortByDesc('max_tenure')->values();
                    $products3 = $products->where('tenure_category', DAYS)->sortByDesc('max_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $products = $results;
                }
            }
            $featured = $products->where('featured', 1)->values();
            $nonFeatured = $products->where('featured', 0)->values();
            $products = $featured->merge($nonFeatured);
            $sliderProducts = $products->where('promotion_formula_id', '!=', null)->values();
        }
        if ($remainingProducts->count()) {
            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $remainingProducts->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                    $products2 = $remainingProducts->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                    $products3 = $remainingProducts->where('tenure_category', DAYS)->sortBy('min_tenure')->values();

                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $remainingProducts = $results;
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $remainingProducts->where('tenure_category', ONGOING)->sortByDesc('max_tenure')->values();
                    $products2 = $remainingProducts->where('tenure_category', MONTHS)->sortByDesc('max_tenure')->values();
                    $products3 = $remainingProducts->where('tenure_category', DAYS)->sortByDesc('max_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $remainingProducts = $results;

                }
            }
            $featured = $remainingProducts->where('featured', 1)->values();
            $nonFeatured = $remainingProducts->where('featured', 0)->values();
            $remainingProducts = $featured->merge($nonFeatured);
        }
        return view('frontend.products.privilege-deposit-products', compact("brands", "page", "systemSetting", "sliderProducts", "banners", "products", "searchFilter", "legendtable", "ads_manage", "remainingProducts"));

    }

    public function search_saving_deposit(Request $request)
    {
        return $this->saving($request->all());
    }

    public function saving($request)
    {
        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', SAVING_DEPOSIT_MODE)
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads_manage = \Helper::manageAds($adsCollection);
        }
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : INTEREST;


        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', SAVING_DEPOSIT)
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->leftJoin('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', SAVING_DEPOSIT)
            //->whereNotNull('promotion_products.formula_id')
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        $details = \Helper::get_page_detail(SAVING_DEPOSIT_MODE);
        $brands = $details['brands'];
        if ($products->count() && $brands->count()) {
            $productsBrandIds = $products->pluck('bank_id')->all();
            $brands = $brands->whereIn('id', $productsBrandIds);
        }
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
        $remainingProducts = [];
        $sliderProducts = collect([]);
        //dd($products);

        if (!count($request)) {

            $searchFilter = [];
        } else {
            $searchFilter = $request;

        }
        foreach ($products as $key => &$product) {
            //dd($product);
            $defaultSearch = DefaultSearch::where('promotion_id', SAVING_DEPOSIT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
            } else {
                $defaultPlacement = 0;
            }
            if (!count($request)) {

                $placement = 0;
                $searchValue = $defaultPlacement;
                $searchFilter['search_value'] = $defaultPlacement;
                $searchFilter['filter'] = INTEREST;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
                if (!is_numeric($searchValue)) {
                    $searchValue = $defaultPlacement;
                }
                $searchFilter['search_value'] = $searchValue;
            }
            $productRanges = json_decode($product->product_range);
            $todayDate = Carbon::today();
            $startDate = \Helper::convertToCarbonEndDate($product->promotion_start);
            $endDate = \Helper::convertToCarbonEndDate($product->promotion_end);
            //including end day so 1 day add in end date
            $tenure = $todayDate->diffInDays($endDate); // tenure in days
            $tenureTotal = 365; //by default tenure in days so total days 365
            $tenureType = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
            $product->ads = json_decode($product->ads_placement);
            $product->product_ranges = $productRanges;
            $status = false;
            $product->max_tenure = 0;
            if (!is_null($product->until_end_date)) {
                $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                if ($untilEndDate > $todayDate) {
                    $product->remaining_days = $todayDate->diffInDays($untilEndDate); // tenure in days
                } else {
                    $product->remaining_days = EXPIRED;
                }
            } else {
                $product->remaining_days = null;
            }
            if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, SAVING_DEPOSIT_F2])) {
                $maxPlacements = [];

                foreach ($productRanges as $productRange) {
                    //dd($productRange);
                    $maxPlacements[] = $productRange->max_range;
                }
                //$placement = max($maxPlacements);

                foreach ($productRanges as $k => &$productRange) {

                    $productRange->placement_highlight = false;
                    $productRange->tenure_highlight = false;
                    $productRange->bonus_interest_highlight = false;
                    $productRange->board_interest_highlight = false;
                    $productRange->total_interest_highlight = false;
                    $productRange->placement_value = false;
                    $allInterests = [$productRange->bonus_interest, $productRange->board_rate, $productRange->bonus_interest + $productRange->board_rate];

                    if (count($searchFilter)) {
                        if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                            if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                $productRange->placement_highlight = true;
                                $productRange->placement_value = true;
                                $status = true;
                            }
                            $placement = (int)$searchValue;

                        }
                        if (empty($placement) && (count($productRanges) - 1) == ($k)) {
                            $placement = $productRange->max_range;
                        }
                    }

                    if ($placement >= $productRange->min_range &&
                        $placement <= $productRange->max_range
                    ) {
                        if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F2])) {
                            $tenure = $productRange->tenure;
                            $tenureTotal = 12;
                            $product->tenure_highlight = true;
                        } else {
                            $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                            $tenure = 0;
                            if ($product->promotion_period == ONGOING) {
                                $tenure = 1;
                                $tenureTotal = 1;
                            } elseif ($untilEndDate > $todayDate) {
                                $tenure = $todayDate->diffInDays($untilEndDate); // tenure in days
                            }
                        }
                        $product->duration = $tenure;
                        $product->total_interest = $productRange->bonus_interest + $productRange->board_rate;
                        $totalInterest = (($placement * $productRange->bonus_interest / 100) * ($tenure / $tenureTotal)) + (($placement * $productRange->board_rate / 100) * ($tenure / $tenureTotal));
                        $product->total_interest_earn = round($totalInterest, 2);
                        $product->placement = $placement;
                        //dd($totalInterest);
                    }
                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F3])) {

                foreach ($productRanges as $k => &$productRange) {
                    //$placement = $productRange->max_range;
                    $productRange->high_light = false;

                    $productRange->placement_highlight = false;
                    $productRange->tenure_highlight = false;
                    $productRange->bonus_interest_highlight = false;
                    $productRange->board_interest_highlight = false;
                    $productRange->total_interest_highlight = false;
                    $productRange->placement_value = false;

                    $allInterests = [];
                    $allInterests[] = $productRange->sibor_rate;
                    $allInterests[] = $productRange->air;

                    if (count($searchFilter)) {
                        if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                            if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                $productRange->high_light = true;
                                $status = true;
                            }
                            $placement = (int)$searchValue;
                        }
                        if (empty($placement) && (count($productRanges) - 1) == ($k)) {
                            $placement = $productRange->max_range;
                        }
                    }

                    if ($placement >= $productRange->min_range &&
                        $placement <= $productRange->max_range
                    ) {
                        $product->total_interest = $productRange->air + $productRange->sibor_rate;
                        $totalInterest = (($product->total_interest / 100) * ($placement));
                        $product->total_interest_earn = round($totalInterest, 2);
                        $product->placement = $placement;
                    }
                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F4])) {
                $status = false;
                $maxPlacements = [];
                $highlight = -1;
                $maxRanges = [];
                $minRanges = [];

                foreach ($productRanges as $k => $productRange) {
                    //dd($productRanges);
                    $allInterests = [$productRange->bonus_interest, $productRange->board_rate, $productRange->bonus_interest + $productRange->board_rate];
                    $maxRanges[] = $productRange->max_range;
                    $minRanges[] = $productRange->min_range;
                    if (count($searchFilter)) {
                        if (($searchValue >= $productRange->min_range) && ($searchValue > 0)) {

                            if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                $highlight = $k;
                                $status = true;
                            }
                            $maxPlacements[] = (int)$searchValue;

                        }
                        if (count($maxPlacements) == 0 && (count($productRanges) - 1) == ($k)) {
                            $maxPlacements[] = $productRange->max_range;

                        }


                    } else {

                        $maxPlacements[] = $placement;
                    }

                }
                $placement = max($maxPlacements);
                $totalInterests = [];
                $interestEarns = [];
                $lastCalculatedAmount = 0;
                $maxPlacement = array_last(array_sort($maxRanges));
                $minPlacement = array_last(array_sort($minRanges));

                foreach ($productRanges as $k => $productRange) {
                    $interestEarn = 0;
                    if ($minPlacement == $productRange->min_range && $minPlacement <= $placement) {
                        $totalInterest = $productRange->bonus_interest + $productRange->board_rate;
                        if ($lastCalculatedAmount < $placement) {
                            $interestEarn = round(($placement - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $lastCalculatedAmount = $placement;
                        }
                        $productRange->interest_earn = $interestEarn;
                        $productRange->total_interest = $totalInterest;


                    } else {
                        $totalInterest = $productRange->bonus_interest + $productRange->board_rate;
                        $productRange->total_interest = $totalInterest;
                        if ($productRange->max_range < $placement) {
                            $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $totalInterests[] = $totalInterest;
                            $lastCalculatedAmount = $productRange->max_range;

                        } else {
                            if ($lastCalculatedAmount < $placement) {
                                $interestEarn = round(($placement - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                                $interestEarns[] = $interestEarn;
                                $totalInterests[] = $totalInterest;
                                $lastCalculatedAmount = $placement;
                            }
                        }
                        //if($k==2){dd($interestEarn);};

                        $productRange->interest_earn = $interestEarn;
                        $productRange->total_interest = $totalInterest;

                    }


                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
                    $product->highlight = $highlight;
                    $filterProducts[] = $product;
                } else {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $searchValue;
                    $product->highlight = $highlight;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F5])) {
                $extraMonth = null;
                $rowHeadings = [CUMMULATED_MONTHLY_SAVINGS_AMOUNT, BASE_INTEREST,
                    ADDITIONAL_INTEREST, TOTAL_AMOUNT];
                $product->highlight = false;
                //dd($productRanges);
                foreach ($productRanges as $productRange) {

                    $months = [1];
                    $allInterests = [$productRange->base_interest, $productRange->bonus_interest];
                    $placement = $productRange->max_range;
                    $searchValue = round($searchValue / ((int)$productRange->placement_month));


                    if (count($searchFilter)) {

                        if ($searchValue >= $productRange->min_range) {
                            if ($searchValue >= $productRange->max_range) {
                                $placement = $productRange->max_range;
                            } else {
                                $placement = $searchValue;
                            }
                            if (is_null($brandId) || ($brandId == $product->bank_id)) {
                                $product->highlight = true;
                                $status = true;
                            }

                        } else {
                            $placement = $productRange->max_range;
                        }
                    }
                    $x = (int)$productRange->placement_month;
                    $y = (int)$productRange->display_month;
                    $j = 1;
                    $z = 1;
                    do {
                        $z = $y * $j;
                        if ($z == 1) {
                        } elseif (($x > $z)) {
                            $months[] = $z;
                        } else {
                            $z = $x;
                            $months[] = $z;
                        }
                        $j++;
                    } while ($z != $x);
                    if (!in_array($extraMonth, $months) && (!is_null($extraMonth))) {
                        $months[] = $extraMonth;
                    }
                    $product->months = array_sort($months);


                    //dd($product->months);
                    $monthlySavingAmount = [];
                    $baseInterests = [];
                    $additionalInterests = [];
                    $baseInterestAll = [];
                    $additionalInterestsAll = [];
                    $totalInterestAmount = 0;

                    foreach ($product->months as $month) {
                        $monthlySavingAmount[$month] = $placement * $month;
                    }
                    $monthlySavingAmount[] = $placement * end($months);

                    for ($i = 1; $i <= ($productRange->placement_month); $i++) {

                        $baseInterest = round(($productRange->base_interest / 100) * ($placement * $i) * (31 / 365), 5);
                        $AdditionalInterest = round((($productRange->bonus_interest / 100) * (($placement * $i) + $baseInterest)) * (31 / 365), 5);
                        $baseInterestAll[] = $baseInterest;
                        $additionalInterestsAll[] = $AdditionalInterest;
                        if (in_array($i, $product->months)) {
                            $baseInterests[$i] = round($baseInterest, 2);;
                            $additionalInterests[$i] = round($AdditionalInterest, 2);;
                        }
                    }
                    $baseInterests[] = array_sum($baseInterestAll);
                    $additionalInterests[] = array_sum($additionalInterestsAll);
                    $totalInterestAmount = end($baseInterests) + end($additionalInterests);
                    $product->row_headings = $rowHeadings;
                    $product->monthly_saving_amount = $monthlySavingAmount;
                    $product->base_interests = $baseInterests;
                    $product->additional_interests = $additionalInterests;
                    $product->total_interest_earn = $totalInterestAmount + ($placement * $productRange->placement_month);
                    $product->placement = $placement;
                    $product->total_interest = 0;
                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (empty($product->promotion_formula_id)) {
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                $filterProducts[] = $product;
            }

        }
        $remainingProducts = collect($remainingProducts);
        if (count($searchFilter)) {
            $products = collect($filterProducts);
        }
        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $products->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                    $products2 = $products->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                    $products3 = $products->where('tenure_category', DAYS)->sortBy('min_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $products = $results;
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $products->where('tenure_category', ONGOING)->sortByDesc('max_tenure')->values();
                    $products2 = $products->where('tenure_category', MONTHS)->sortByDesc('max_tenure')->values();
                    $products3 = $products->where('tenure_category', DAYS)->sortByDesc('max_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $products = $results;
                }
            }
            $featured = $products->where('featured', 1)->values();
            $nonFeatured = $products->where('featured', 0)->values();
            $products = $featured->merge($nonFeatured);
            $sliderProducts = $products->where('promotion_formula_id', '!=', null)->values();
        }
        if ($remainingProducts->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $remainingProducts->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                    $products2 = $remainingProducts->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                    $products3 = $remainingProducts->where('tenure_category', DAYS)->sortBy('min_tenure')->values();

                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $remainingProducts = $results;
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $remainingProducts->where('tenure_category', ONGOING)->sortByDesc('max_tenure')->values();
                    $products2 = $remainingProducts->where('tenure_category', MONTHS)->sortByDesc('max_tenure')->values();
                    $products3 = $remainingProducts->where('tenure_category', DAYS)->sortByDesc('max_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $remainingProducts = $results;

                }
            }
            $featured = $remainingProducts->where('featured', 1)->values();
            $nonFeatured = $remainingProducts->where('featured', 0)->values();
            $remainingProducts = $featured->merge($nonFeatured);
        }
        return view('frontend.products.saving-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "sliderProducts", "searchFilter", "legendtable", "remainingProducts", "ads_manage"));
    }

    public function product_search_homepage(Request $request)
    {
//dd($request->all());
        $account_type = $request->account_type;
        $search_value = !empty($request->search_value) ? $request->search_value : '100000';

        $request = [
            'filter' => PLACEMENT,
            'search_value' => $search_value,
        ];

        if ($account_type == 1) {
            return $this->fixed($request);
        } elseif ($account_type == 2) {
            return $this->saving($request);
        } elseif ($account_type == 3) {
            return $this->privilege($request);
        } elseif ($account_type == 4) {
            return $this->foreign_currency($request);
        } elseif ($account_type == 5) {
            return $this->aio($request);
        }
    }

    public function search_foreign_currency_deposit(Request $request)
    {
        return $this->foreign_currency($request->all());
    }

    public function foreign_currency($request)
    {

        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', FOREIGN_CURRENCY_DEPOSIT_MODE)
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads_manage = \Helper::manageAds($adsCollection);
        }
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $currency = isset($request['currency']) ? $request['currency'] : 11;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : INTEREST;

        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', FOREIGN_CURRENCY_DEPOSIT)
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->leftJoin('currency', 'promotion_products.currency', '=', 'currency.id')
            ->leftJoin('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_types.id', '=', FOREIGN_CURRENCY_DEPOSIT)
            //->whereNotNull('promotion_products.formula_id')
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*', 'currency.code as currency_code', 'currency.icon as currency_icon', 'currency.currency as currency_name')
            ->get();


        $details = \Helper::get_page_detail(FOREIGN_CURRENCY_DEPOSIT_MODE);
        $brands = $details['brands'];
        $currencies = null;
        if ($products->count() && $brands->count()) {
            $productsBrandIds = $products->pluck('bank_id')->all();
            $currencyIds = $products->pluck('currency')->all();
            $currencies = Currency::whereIn('id', $currencyIds)->get();
            $brands = $brands->whereIn('id', $productsBrandIds);

        }
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
        $remainingProducts = [];
        $sliderProducts = collect([]);
        //dd($products);
        if (!count($request)) {

            $searchFilter = [];
        } else {
            $searchFilter = $request;
        }
        if ($currency && $currency != 'All') {
            $products = $products->where('currency', $currency);
        }
        foreach ($products as $key => &$product) {
            //dd($product);
            $defaultSearch = DefaultSearch::where('promotion_id', FOREIGN_CURRENCY_DEPOSIT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
            } else {
                $defaultPlacement = 0;
            }
            if (!count($request)) {

                $placement = 0;
                $searchValue = $defaultPlacement;
                $searchFilter['search_value'] = $defaultPlacement;
                $searchFilter['filter'] = INTEREST;
                $searchFilter['sort_by'] = MAXIMUM;
                $searchFilter['currency'] = 11;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
                if (!is_numeric($searchValue)) {
                    $searchValue = $defaultPlacement;
                }
                $searchFilter['search_value'] = $searchValue;
            }
            $productRanges = json_decode($product->product_range);
            $todayDate = Carbon::today();
            $startDate = \Helper::convertToCarbonEndDate($product->promotion_start);
            $endDate = \Helper::convertToCarbonEndDate($product->promotion_end);
            //including end day so 1 day add in end date
            $tenure = $todayDate->diffInDays($endDate); // tenure in days
            $tenureTotal = 365; //by default tenure in days so total days 365
            $tenureType = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
            $product->ads = json_decode($product->ads_placement);
            $product->product_ranges = $productRanges;
            $status = false;
            $product->max_tenure = 0;
            $product->min_tenure = 0;
            $ranges = null;
            if (!is_null($product->until_end_date)) {
                $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                if ($untilEndDate > $todayDate) {
                    $product->remaining_days = $todayDate->diffInDays($untilEndDate); // tenure in days
                } else {
                    $product->remaining_days = EXPIRED;
                }
            } else {
                $product->remaining_days = null;
            }
            if (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F1])) {
                $tenures = json_decode($product->tenure);
                //including end day so 1 day add in end date
                $remainingDays = $todayDate->diffInDays($endDate); // tenure in days
                $monthSuffix = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
                $product->ads = json_decode($product->ads_placement);

                $product->tenure = $tenures;
                $totalInterestPercent = 0;
                $totalInterest = 0;
                $ranges = [];
                $resultKey = null;
                foreach ($productRanges as $k => $productRange) {
                    $bonusInterestHighlight = [];
                    $interestEarnedArray = [];
                    $bonusInterests = $productRange->bonus_interest;
                    $productRange->placement_highlight = false;
                    $productRange->placement_value = false;
                    $interestEarn = 0;
                    $interestPercent = 0;
                    if (count($searchFilter)) {
                        if (count($tenures)) {

                            foreach ($tenures as $tenureKey => $tenure) {

                                $bonusInterestHighlight[$tenureKey] = false;
                                if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                                    if ((is_null($brandId) || ($brandId == $product->bank_id)) && ($currency == 'All' || ($currency == $product->currency))) {
                                        $productRange->placement_highlight = true;
                                        $productRange->placement_value = true;
                                        $status = true;
                                    }

                                    $placement = (float)$searchValue;
                                    $resultKey = $tenureKey;

                                }
                                if (empty($placement)) {
                                    $amount = $productRange->max_range;
                                    if (((count($tenures) - 1) == ($tenureKey)) && ((count($productRanges) - 1) == ($k))) {
                                        $placement = $productRange->max_range;
                                        $resultKey = $tenureKey;
                                    }
                                } else {
                                    $amount = $placement;
                                }
                                $interestEarn = ($amount * $bonusInterests[$tenureKey] * $tenure) / (100 * 12);
                                $interestEarnedArray[$tenureKey] = round($interestEarn, 2);
                            }

                        }

                        $productRange->bonus_interest_highlight = $bonusInterestHighlight;
                        $productRange->interest_earns = $interestEarnedArray;
                    }
                    $ranges[] = $productRange;

                }

                $product->interest_earns = [];
                $product->bonus_interests = [];
                $resultInterestEarn = 0;
                $resultInterestEarnPercent = 0;
                foreach ($ranges as $range) {
                    if ($placement >= $range->min_range && $placement <= $range->max_range) {
                        $product->interest_earns = $range->interest_earns;
                        $product->bonus_interests = $range->bonus_interest;
                    }

                }
                /*if (count($tenures)) {
                    $product->max_tenure = max($tenures);
                } else {
                    $product->max_tenure = 0;
                }*/

                if (count($product->interest_earns)) {
                    $resultInterestEarnArray = $product->interest_earns;
                    $resultInterestEarn = $resultInterestEarnArray[$resultKey];

                }
                if (count($product->bonus_interests)) {
                    $resultInterestEarnPercentArray = $product->interest_earns;
                    $resultInterestEarnPercent = $resultInterestEarnPercentArray[$resultKey];
                }
                $product->product_ranges = $ranges;
                $product->total_interest = $resultInterestEarnPercent;
                $product->total_interest_earn = round($resultInterestEarn, 2);
                $product->placement = $placement;

                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    //dd($product);
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }
            }
            if (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F3])) {
                $maxPlacements = [];

                foreach ($productRanges as $productRange) {
                    //dd($productRange);
                    $maxPlacements[] = $productRange->max_range;
                }
                //$placement = max($maxPlacements);

                foreach ($productRanges as $k => &$productRange) {

                    $productRange->placement_highlight = false;
                    $productRange->tenure_highlight = false;
                    $productRange->bonus_interest_highlight = false;
                    $productRange->board_interest_highlight = false;
                    $productRange->total_interest_highlight = false;
                    $productRange->placement_value = false;
                    $allInterests = [$productRange->bonus_interest, $productRange->board_rate, $productRange->bonus_interest + $productRange->board_rate];

                    if (count($searchFilter)) {
                        if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                            if ((is_null($brandId) || ($brandId == $product->bank_id)) && ($currency == 'All' || ($currency == $product->currency))) {
                                $productRange->placement_highlight = true;
                                $productRange->placement_value = true;
                                $status = true;
                            }
                            $placement = (int)$searchValue;

                        }
                        if (empty($placement) && (count($productRanges) - 1) == ($k)) {
                            $placement = $productRange->max_range;
                        }
                    }

                    if ($placement >= $productRange->min_range &&
                        $placement <= $productRange->max_range
                    ) {
                        if (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F3])) {
                            $tenure = $productRange->tenure;
                            $tenureTotal = 12;
                            $product->tenure_highlight = true;
                            // $product->max_tenure = $tenure;
                        } else {
                            $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                            $tenure = 0;
                            if ($product->promotion_period == ONGOING) {
                                $tenure = 1;
                                $tenureTotal = 1;
                            } elseif ($untilEndDate > $todayDate) {
                                $tenure = $todayDate->diffInDays($untilEndDate); // tenure in days
                            }
                        }
                        $product->duration = $tenure;

                        $product->total_interest = $productRange->bonus_interest + $productRange->board_rate;
                        $totalInterest = (($placement * $productRange->bonus_interest / 100) * ($tenure / $tenureTotal)) + (($placement * $productRange->board_rate / 100) * ($tenure / $tenureTotal));
                        $product->total_interest_earn = round($totalInterest, 2);
                        $product->placement = $placement;
                        //dd($product);
                    }
                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F2, SAVING_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F4])) {

                foreach ($productRanges as $k => &$productRange) {
                    //$placement = $productRange->max_range;
                    $productRange->high_light = false;

                    $productRange->placement_highlight = false;
                    $productRange->tenure_highlight = false;
                    $productRange->bonus_interest_highlight = false;
                    $productRange->board_interest_highlight = false;
                    $productRange->total_interest_highlight = false;
                    $productRange->placement_value = false;

                    $allInterests = [];
                    $allInterests[] = $productRange->sibor_rate;
                    $allInterests[] = $productRange->air;

                    if (count($searchFilter)) {
                        if ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range) {
                            if ((is_null($brandId) || ($brandId == $product->bank_id)) && ($currency = 'All' || ($currency == $product->currency))) {
                                $productRange->high_light = true;
                                $status = true;
                            }
                            $placement = (int)$searchValue;
                        }
                        if (empty($placement) && (count($productRanges) - 1) == ($k)) {
                            $placement = $productRange->max_range;
                        }
                    }

                    if ($placement >= $productRange->min_range &&
                        $placement <= $productRange->max_range
                    ) {
                        $product->total_interest = $productRange->air + $productRange->sibor_rate;
                        $totalInterest = (($product->total_interest / 100) * ($placement));
                        $product->total_interest_earn = round($totalInterest, 2);
                        $product->placement = $placement;
                    }
                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F2, SAVING_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F5])) {
                $status = false;
                $maxPlacements = [];
                $highlight = -1;
                $maxRanges = [];
                $minRanges = [];

                foreach ($productRanges as $k => $productRange) {
                    //dd($productRanges);
                    $allInterests = [$productRange->bonus_interest, $productRange->board_rate, $productRange->bonus_interest + $productRange->board_rate];
                    $maxRanges[] = $productRange->max_range;
                    $minRanges[] = $productRange->min_range;
                    if (count($searchFilter)) {
                        if (($searchValue >= $productRange->min_range) && ($searchValue > 0)) {

                            if ((is_null($brandId) || ($brandId == $product->bank_id)) && ($currency = 'All' || ($currency == $product->currency))) {
                                $highlight = $k;
                                $status = true;
                            }
                            $maxPlacements[] = (int)$searchValue;

                        }
                        if (count($maxPlacements) == 0 && (count($productRanges) - 1) == ($k)) {
                            $maxPlacements[] = $productRange->max_range;

                        }


                    } else {

                        $maxPlacements[] = $placement;
                    }

                }
                $placement = max($maxPlacements);
                $totalInterests = [];
                $interestEarns = [];
                $lastCalculatedAmount = 0;
                $maxPlacement = array_last(array_sort($maxRanges));
                $minPlacement = array_last(array_sort($minRanges));

                foreach ($productRanges as $k => $productRange) {
                    $interestEarn = 0;
                    if ($minPlacement == $productRange->min_range && $minPlacement <= $placement) {
                        $totalInterest = $productRange->bonus_interest + $productRange->board_rate;
                        if ($lastCalculatedAmount < $placement) {
                            $interestEarn = round(($placement - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $lastCalculatedAmount = $placement;
                        }
                        $productRange->interest_earn = $interestEarn;
                        $productRange->total_interest = $totalInterest;


                    } else {
                        $totalInterest = $productRange->bonus_interest + $productRange->board_rate;
                        $productRange->total_interest = $totalInterest;
                        if ($productRange->max_range < $placement) {
                            $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $totalInterests[] = $totalInterest;
                            $lastCalculatedAmount = $productRange->max_range;

                        } elseif ($lastCalculatedAmount < $placement) {
                            $interestEarn = round(($placement - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $totalInterests[] = $totalInterest;
                            $lastCalculatedAmount = $placement;
                        }
                        //if($k==2){dd($interestEarn);};

                        $productRange->interest_earn = $interestEarn;
                        $productRange->total_interest = $totalInterest;

                    }


                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F2, SAVING_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                if ($status == true) {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
                    $product->highlight = $highlight;
                    $filterProducts[] = $product;
                } else {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $searchValue;
                    $product->highlight = $highlight;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F6])) {
                $extraMonth = null;
                $rowHeadings = [CUMMULATED_MONTHLY_SAVINGS_AMOUNT, BASE_INTEREST,
                    ADDITIONAL_INTEREST, TOTAL_AMOUNT];
                $product->highlight = false;
                //dd($productRanges);
                foreach ($productRanges as $productRange) {

                    $months = [1];
                    $allInterests = [$productRange->base_interest, $productRange->bonus_interest];
                    $placement = $productRange->max_range;
                    $searchValue = round($searchValue / ((int)$productRange->placement_month));


                    if (count($searchFilter)) {

                        if ($searchValue >= $productRange->min_range) {
                            if ($searchValue >= $productRange->max_range) {
                                $placement = $productRange->max_range;
                            } else {
                                $placement = $searchValue;
                            }
                            if ((is_null($brandId) || ($brandId == $product->bank_id)) && ($currency = 'All' || ($currency == $product->currency))) {
                                $product->highlight = true;
                                $status = true;
                            }

                        } else {
                            $placement = $productRange->max_range;
                        }
                    }
                    $x = (int)$productRange->placement_month;
                    $y = (int)$productRange->display_month;
                    $j = 1;
                    $z = 1;
                    do {
                        $z = $y * $j;
                        if ($z == 1) {
                        } elseif (($x > $z)) {
                            $months[] = $z;
                        } else {
                            $z = $x;
                            $months[] = $z;
                        }
                        $j++;
                    } while ($z != $x);
                    if (!in_array($extraMonth, $months) && (!is_null($extraMonth))) {
                        $months[] = $extraMonth;
                    }
                    $product->months = array_sort($months);


                    //dd($product->months);
                    $monthlySavingAmount = [];
                    $baseInterests = [];
                    $additionalInterests = [];
                    $baseInterestAll = [];
                    $additionalInterestsAll = [];
                    $totalInterestAmount = 0;

                    foreach ($product->months as $month) {
                        $monthlySavingAmount[$month] = $placement * $month;
                    }
                    $monthlySavingAmount[] = $placement * end($months);

                    for ($i = 1; $i <= ($productRange->placement_month); $i++) {

                        $baseInterest = round(($productRange->base_interest / 100) * ($placement * $i) * (31 / 365), 5);
                        $AdditionalInterest = round((($productRange->bonus_interest / 100) * (($placement * $i) + $baseInterest)) * (31 / 365), 5);
                        $baseInterestAll[] = $baseInterest;
                        $additionalInterestsAll[] = $AdditionalInterest;
                        if (in_array($i, $product->months)) {
                            $baseInterests[$i] = round($baseInterest, 2);;
                            $additionalInterests[$i] = round($AdditionalInterest, 2);;
                        }
                    }
                    $baseInterests[] = array_sum($baseInterestAll);
                    $additionalInterests[] = array_sum($additionalInterestsAll);
                    $totalInterestAmount = end($baseInterests) + end($additionalInterests);
                    $product->row_headings = $rowHeadings;
                    $product->monthly_saving_amount = $monthlySavingAmount;
                    $product->base_interests = $baseInterests;
                    $product->additional_interests = $additionalInterests;
                    $product->total_interest_earn = $totalInterestAmount + ($placement * $productRange->placement_month);
                    $product->placement = $placement;
                    $product->total_interest = 0;
                }
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F2, SAVING_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }

                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $product->placement = $searchValue;
                    $remainingProducts[] = $product;
                }

            } elseif (empty($product->promotion_formula_id)) {
                $maxTenure = 0;
                $minTenure = 0;
                if ($product->promotion_period == ONGOING) {
                    $product->tenure_category = ONGOING;
                } else {
                    $placementPeriod = \Helper::multiExplode(array(",", ".", "|", ":"), $product->promotion_period);
                    if (count($placementPeriod)) {
                        $placementTenures = [];
                        foreach ($placementPeriod as $period) {
                            $value = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            if ($value > 0) {
                                $placementTenures[] = $value;
                            }
                        }
                        if (count($placementTenures)) {
                            $maxTenure = max($placementTenures);
                            $minTenure = min($placementTenures);
                            if (count($placementTenures) > 4) {
                                $product->promotion_period = $minTenure . ' - ' . $maxTenure;
                            }
                        }
                    }
                    if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1])) {
                        $product->tenure_category = DAYS;
                    } else {
                        $product->tenure_category = MONTHS;
                    }
                }

                $product->max_tenure = $maxTenure;
                $product->min_tenure = $minTenure;
                if ($sortBy == MINIMUM) {
                    $product->tenure_value = $maxTenure;
                } elseif ($product->promotion_period == ONGOING) {
                    $product->tenure_value = ONGOING;
                } else {
                    $product->tenure_value = $maxTenure;
                }
                $filterProducts[] = $product;
            }


        }
        $remainingProducts = collect($remainingProducts);
        if (count($searchFilter)) {
            $products = collect($filterProducts);
        }
        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $products->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                    $products2 = $products->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                    $products3 = $products->where('tenure_category', DAYS)->sortBy('min_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $products = $results;
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $products->where('tenure_category', ONGOING)->sortByDesc('max_tenure')->values();
                    $products2 = $products->where('tenure_category', MONTHS)->sortByDesc('max_tenure')->values();
                    $products3 = $products->where('tenure_category', DAYS)->sortByDesc('max_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $products = $results;
                }
            }

            $featured = $products->where('featured', 1)->values();
            $nonFeatured = $products->where('featured', 0)->values();
            $products = $featured->merge($nonFeatured);
            $sliderProducts = $products->where('promotion_formula_id', '!=', null)->values();
        }
        if ($remainingProducts->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $remainingProducts->where('tenure_category', ONGOING)->sortBy('min_tenure')->values();
                    $products2 = $remainingProducts->where('tenure_category', MONTHS)->sortBy('min_tenure')->values();
                    $products3 = $remainingProducts->where('tenure_category', DAYS)->sortBy('min_tenure')->values();

                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $remainingProducts = $results;
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == TENURE) {
                    $results = collect();
                    $products1 = $remainingProducts->where('tenure_category', ONGOING)->sortByDesc('max_tenure')->values();
                    $products2 = $remainingProducts->where('tenure_category', MONTHS)->sortByDesc('max_tenure')->values();
                    $products3 = $remainingProducts->where('tenure_category', DAYS)->sortByDesc('max_tenure')->values();
                    if ($products1->count()) {
                        $results = $results->merge($products1);
                    }
                    if ($products2->count()) {
                        $results = $results->merge($products2);
                    }
                    if ($products3->count()) {
                        $results = $results->merge($products3);
                    }
                    $remainingProducts = $results;

                }
            }
            $featured = $remainingProducts->where('featured', 1)->values();
            $nonFeatured = $remainingProducts->where('featured', 0)->values();
            $remainingProducts = $featured->merge($nonFeatured);
        }
        return view('frontend.products.foreign-currency-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "searchFilter", "sliderProducts", "legendtable", "ads_manage", "remainingProducts", "currencies"));

    }

    public
    function search_aioa_deposit(Request $request)
    {
        return $this->aio($request->all());
    }

    public
    function aio($request)
    {
        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', AIO_DEPOSIT_MODE)
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads_manage = \Helper::manageAds($adsCollection);
        }
        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : INTEREST;

        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', ALL_IN_ONE_ACCOUNT)
            ->where('delete_status', 0)
            ->get();
        $toolTips = ToolTip::where('promotion_id', ALL_IN_ONE_ACCOUNT)->first();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->leftJoin('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            //->whereNotNull('promotion_products.formula_id')
            ->where('promotion_types.id', '=', ALL_IN_ONE_ACCOUNT)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*', 'promotion_products.id as product_id')
            ->get();

        $details = \Helper::get_page_detail(AIO_DEPOSIT_MODE);
        $brands = $details['brands'];
        if ($promotion_products->count() && $brands->count()) {
            $productsBrandIds = $promotion_products->pluck('bank_id')->all();
            $brands = $brands->whereIn('id', $productsBrandIds);
        }
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
        $remainingProducts = [];
        $sliderProducts = collect([]);
        foreach ($promotion_products as $key => $product) {
            $defaultSearch = DefaultSearch::where('promotion_id', ALL_IN_ONE_ACCOUNT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
                $defaultSalary = $defaultSearch->salary;
                $defaultGiro = $defaultSearch->payment;
                $defaultSpend = $defaultSearch->spend;
                $defaultLoan = $defaultSearch->loan;
                $defaultPrivilege = $defaultSearch->privilege;

            } else {
                $defaultPlacement = 0;
                $defaultSalary = 0;
                $defaultGiro = 0;
                $defaultSpend = 0;
                $defaultLoan = 0;
                $defaultPrivilege = 0;

            }
            if (!count($request)) {
                $placement = 0;
                $searchValue = $defaultPlacement;
                $salary = $defaultSalary;
                $giro = $defaultGiro;
                $spend = $defaultSpend;
                $loan = $defaultLoan;
                $privilege = $defaultPrivilege;
                $searchFilter['search_value'] = $defaultPlacement;
                $searchFilter['salary'] = $defaultSalary;
                $searchFilter['giro'] = $defaultGiro;
                $searchFilter['spend'] = $defaultSpend;
                $searchFilter['privilege'] = $defaultPrivilege;
                $searchFilter['loan'] = $defaultLoan;
                $searchFilter['filter'] = INTEREST;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
                if (!is_numeric($searchValue)) {
                    $searchValue = $defaultPlacement;
                }
                $searchFilter['search_value'] = $searchValue;
                $salary = $searchFilter['salary'] = isset($searchFilter['salary']) ? (int)$searchFilter['salary'] : 0;
                $giro = $searchFilter['giro'] = isset($searchFilter['giro']) ? (int)$searchFilter['giro'] : 0;
                $spend = $searchFilter['spend'] = isset($searchFilter['spend']) ? (int)$searchFilter['spend'] : 0;
                $loan = $searchFilter['loan'] = isset($searchFilter['loan']) ? (int)$searchFilter['loan'] : 0;
                $privilege = $searchFilter['privilege'] = isset($searchFilter['privilege']) ? (int)$searchFilter['privilege'] : 0;
                $searchFilter['filter'] = $searchFilter['filter'] ? $searchFilter['filter'] : PLACEMENT;

            }
            $status = false;
            $productRanges = json_decode($product->product_range);

            if ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F1) {
                $totalInterests = [];
                $interestEarns = [];
                $product->highlight = false;
                $product->salary_highlight = false;
                $product->salary_highlight_2 = false;
                $product->payment_highlight = false;
                $product->spend_highlight = false;
                $product->spend_highlight_2 = false;
                $product->privilege_highlight = false;
                $product->loan_highlight = false;
                $product->bonus_highlight = false;
                $criteriaMatchCount = 0;

                foreach ($productRanges as $k => $productRange) {
                    //dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_salary,
                        $productRange->bonus_interest_giro_payment,
                        $productRange->bonus_interest_spend,
                        $productRange->bonus_interest_privilege,
                        //$productRange->bonus_interest_loan,
                        $productRange->bonus_interest,
                        $productRange->bonus_interest_remaining_amount,
                    ];
                    if ($searchValue >= $productRange->min_range) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif (empty($placement) && (count($productRanges) - 1) == ($k)) {
                        $placement = $productRange->max_range;
                    }


                    $totalInterest = 0;
                    if ($status == true) {
                        if (isset($productRange->minimum_salary_2) && $salary > 0 && $productRange->minimum_salary_2 <= $salary) {
                            $product->salary_highlight_2 = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_salary_2;
                            $criteriaMatchCount++;
                        } elseif ($salary > 0 && $productRange->minimum_salary <= $salary) {
                            $product->salary_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_salary;
                            $criteriaMatchCount++;
                        }
                        if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                            $product->payment_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_giro_payment;
                            $criteriaMatchCount++;
                        }
                        if (isset($productRange->minimum_spend_2) && $spend > 0 && $productRange->minimum_spend_2 <= $spend) {
                            $product->spend_highlight_2 = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_spend_2;
                            $criteriaMatchCount++;
                        } elseif ($spend > 0 && $productRange->minimum_spend <= $spend) {
                            $product->spend_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_spend;
                            $criteriaMatchCount++;
                        }
                        if ($privilege > 0 && $productRange->minimum_privilege_pa <= $privilege / 12) {
                            $product->privilege_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_privilege;
                            $criteriaMatchCount++;
                        }
                        if ($placement > 0 && $productRange->bonus_amount <= $placement && (in_array(true, [$product->salary_highlight, $product->payment_highlight, $product->spend_highlight, $product->privilege_highlight]))) {
                            $product->bonus_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest;
                            $criteriaMatchCount++;
                        }
                    }
                    if ($criteriaMatchCount == 0) {
                        $status = false;
                        $totalInterest = $productRange->bonus_interest_salary + $productRange->bonus_interest_giro_payment + $productRange->bonus_interest_spend +
                            $productRange->bonus_interest_privilege;
                        $criteriaMatchCount = 4;
                        if ($placement > 0 && $productRange->bonus_amount <= $placement) {
                            $totalInterest = $totalInterest + $productRange->bonus_interest;
                            $criteriaMatchCount++;
                        }

                    }

                    $totalInterests[] = $totalInterest;
                    if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                        $interestEarns[] = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                    } else {
                        $interestEarns[] = $placement * ($totalInterest / 100);
                    }
                    $productRange->placement = $placement;
                }
                $product->criteriaCount = $criteriaMatchCount;
                $product->total_interest = array_sum($totalInterests);
                $product->interest_earned = array_sum($interestEarns);
                $product->placement = $placement;
                $product->product_range = $productRanges;
                if ($status == true) {
                    $product->highlight = true;
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F2) {

                //dd($productRanges);
                $criteriaMatchCount = 0;
                $product->highlight_index = 0;
                $product->highlight = false;
                $product->criteria_a_highlight = false;
                $product->criteria_b_highlight = false;
                $maxRanges = [];
                $minRanges = [];
                $totalInterests = [];
                $interestEarns = [];
                $criteria = null;
                //$placement = 0;
                if ((($spend >= $productRanges[0]->minimum_spend)) && (($salary >= $productRanges[0]->minimum_salary) || ($giro >= $productRanges[0]->minimum_giro_payment))) {
                    $criteriaMatchCount = 1;
                    if ($salary > 0 && $productRanges[0]->minimum_salary <= $salary) {
                        $criteriaMatchCount++;
                    }
                    if ($giro >= $productRanges[0]->minimum_giro_payment) {
                        $criteriaMatchCount++;
                    }
                    $criteria = "bonus_interest_criteria_b";
                    $product->criteria_b_highlight = true;
                    $status = true;

                } elseif (($spend >= $productRanges[0]->minimum_spend)) {
                    $criteria = "bonus_interest_criteria_a";
                    $product->criteria_a_highlight = true;
                    $status = true;
                    $criteriaMatchCount = 1;
                } else {
                    $criteria = "bonus_interest_criteria_b";
                    $product->criteria_a_highlight = false;
                    $product->criteria_b_highlight = false;
                    $status = false;
                    $criteriaMatchCount = 3;
                }

                foreach ($productRanges as $key => $productRange) {
                    $allInterests = [
                        $productRange->bonus_interest_criteria_a,
                        $productRange->bonus_interest_criteria_b,
                    ];
                    $maxRanges[] = $productRange->max_range;
                    $minRanges[] = $productRange->min_range;
                    if ($searchValue >= $productRange->min_range && $status == true) {
                        $placement = (int)$searchValue;
                    } elseif (empty($placement) && (count($productRanges) - 1) == ($key)) {
                        $placement = $productRange->max_range;
                        $criteria = "bonus_interest_criteria_b";
                        $product->criteria_a_highlight = false;
                        $product->criteria_b_highlight = false;
                        $status = false;
                        $criteriaMatchCount = 3;
                    }
                }
                $maxPlacement = array_last(array_sort($maxRanges));
                $minPlacement = array_last(array_sort($minRanges));
                $lastRange = array_last($productRanges);
                $lastCalculatedAmount = 0;

                foreach ($productRanges as $k => $productRange) {
                    $interestEarn = 0;
                    if ($minPlacement == $productRange->min_range && $minPlacement <= $placement) {
                        if ($lastCalculatedAmount < $placement) {
                            $interestEarn = round(($placement - $lastCalculatedAmount) * ($lastRange->$criteria / 100), 2);
                            $interestEarns[] = $interestEarn;
                            $productRange->above_range = true;
                            $product->highlight_index = $k;
                            $lastCalculatedAmount = $placement;
                        }
                        $productRange->interest_earn = $interestEarn;
                        $productRange->criteria = $productRange->$criteria;

                    } else {

                        if ($productRange->max_range < $placement) {
                            $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->$criteria / 100), 2);
                            $product->highlight_index = $k;
                            $interestEarns[] = $interestEarn;
                            $totalInterests[] = $productRange->$criteria;
                            $lastCalculatedAmount = $productRange->max_range;


                        } else {
                            if ($lastCalculatedAmount < $placement) {
                                $interestEarn = round(($placement - $lastCalculatedAmount) * ($productRange->$criteria / 100), 2);
                                $product->highlight_index = $k;
                                $interestEarns[] = $interestEarn;
                                $totalInterests[] = $productRange->$criteria;
                                $lastCalculatedAmount = $productRange->max_range;
                            }

                        }
                        $productRange->interest_earn = $interestEarn;
                        $productRange->criteria = $productRange->$criteria;
                        $productRange->above_range = false;
                    }
                }

                if (count($totalInterests)) {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                } else {
                    $product->total_interest = 0;
                }

                $product->interest_earned = array_sum($interestEarns);
                $product->placement = $placement;
                $product->product_range = $productRanges;
                $product->criteriaCount = $criteriaMatchCount;

                //dd($filterProducts);
                if ($status == true) {
                    $product->highlight = true;
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }


            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F3) {
                $criteriaMatchCount = 0;
                $product->highlight = false;
                $product->criteria_1 = false;
                $product->criteria_2 = false;
                $product->criteria_3 = false;
                $product->life_insurance = false;
                $product->housing_loan = false;
                $product->education_loan = false;
                $product->hire_loan = false;
                $product->renovation_loan = false;
                $product->unit_trust = false;
                $product->salary_highlight = false;
                $product->salary_highlight_2 = false;
                $product->payment_highlight = false;
                $product->spend_highlight = false;
                $product->spend_highlight_2 = false;
                $product->housing_loan_highlight = false;
                $product->education_loan_highlight = false;
                $product->hire_loan_highlight = false;
                $product->renovation_loan_highlight = false;
                $product->life_insurance_highlight = false;
                $product->unit_trust_highlight = false;
                $totalInterests = [];
                $interestEarns = [];

                foreach ($productRanges as $k => $productRange) {
                    // dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_criteria1,
                        $productRange->bonus_interest_criteria2,
                        $productRange->bonus_interest_criteria3,
                    ];

                    if ($searchValue >= $productRange->min_range) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif (empty($placement) && (count($productRanges) - 1) == ($k)) {
                        $placement = $productRange->max_range;
                    }
                    $totalInterest = 1;
                    if ($status == true) {

                        if ($salary > 0 && $productRange->minimum_salary <= $salary) {
                            $criteriaMatchCount++;
                            $product->salary_highlight = true;
                        }
                        if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                            $criteriaMatchCount++;
                            $product->payment_highlight = true;
                        }
                        if ($spend > 0 && $productRange->minimum_spend <= $spend) {
                            $criteriaMatchCount++;
                            $product->spend_highlight = true;
                        }
                        if ($privilege > 0 && $productRange->minimum_insurance <= ($privilege / 12)) {
                            $criteriaMatchCount++;
                            $product->life_insurance = true;
                            $product->life_insurance_highlight = true;
                        }
                        if ($privilege > 0 && $productRange->minimum_unit_trust <= ($privilege / 12)) {
                            $criteriaMatchCount++;
                            $product->unit_trust = true;
                            $product->unit_trust_highlight = true;
                        }
                        if ($loan > 0 && $productRange->minimum_hire_purchase_loan <= ($loan)) {
                            $criteriaMatchCount++;
                            $product->hire_loan = true;
                            $product->hire_loan_highlight = true;

                        }
                        if ($loan > 0 && $productRange->minimum_renovation_loan <= ($loan)) {
                            $criteriaMatchCount++;
                            $product->renovation_loan = true;
                            $product->renovation_loan_highlight = true;
                        }
                        if ($loan > 0 && $productRange->minimum_home_loan <= ($loan)) {
                            $criteriaMatchCount++;
                            $product->housing_loan = true;
                            $product->housing_loan_highlight = true;
                        }
                        if ($loan > 0 && $productRange->minimum_education_loan <= ($loan)) {
                            $criteriaMatchCount++;
                            $product->education_loan = true;
                            $product->education_loan_highlight = true;
                        }

                        if ($criteriaMatchCount == 1) {
                            $totalInterest = $productRange->bonus_interest_criteria1;
                            $product->criteria_1 = true;

                        } elseif ($criteriaMatchCount == 2) {
                            $totalInterest = $productRange->bonus_interest_criteria2;
                            $product->criteria_2 = true;

                        } elseif ($criteriaMatchCount >= 3) {
                            $totalInterest = $productRange->bonus_interest_criteria3;
                            $product->criteria_3 = true;
                        }
                    }
                    if ($criteriaMatchCount == 0) {
                        $product->life_insurance = true;
                        $product->unit_trust = true;
                        $product->hire_loan = true;
                        $product->renovation_loan = true;
                        $product->housing_loan = true;
                        $product->education_loan = true;
                        $criteriaMatchCount = 9;
                        $totalInterest = $productRange->bonus_interest_criteria3;
                        $placement = $productRange->max_range;
                        $status = false;
                    }
                    $totalInterests[] = $totalInterest;
                    if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                        $interestEarns[] = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                    } else {
                        $interestEarns[] = $placement * ($totalInterest / 100);
                    }
                    $productRange->placement = $placement;

                }
                $product->total_interest = array_sum($totalInterests);
                $product->interest_earned = array_sum($interestEarns);
                $product->product_range = $productRanges;
                $product->criteriaCount = $criteriaMatchCount;
                if ($status == true) {
                    $product->highlight = true;
                    $filterProducts[] = $product;
                } elseif ($status == false) {
                    $remainingProducts[] = $product;
                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F4) {
                //dd($product);
                $product->highlight = false;
                $product->criteria_a_highlight = false;
                $product->criteria_b_highlight = false;
                $maxRanges = [];
                $totalInterest = 0;
                $interestEarn = 0;
                //$placement = 0;
                $baseDetail = $productRanges[0];
                $status = false;
                $criteria = null;
                $highlight = null;
                $criteriaCount = 0;
                $criteriaMatchCount = 0;
                $criteriaValue = 0;


                if ($salary > 0 && ($baseDetail->minimum_salary <= $salary)) {
                    $criteriaValue = $criteriaValue + $salary;
                    $criteriaCount++;
                    if ($spend > 0 && $baseDetail->minimum_spend <= $spend) {
                        $criteriaCount++;
                        $criteriaMatchCount++;
                        $criteriaValue = $criteriaValue + $spend;
                    }
                    if ($spend > 0 && $baseDetail->minimum_insurance <= ($privilege / 2)) {
                        $criteriaCount++;
                        $criteriaMatchCount++;
                        $criteriaValue = $criteriaValue + ($privilege / (2 * 12));
                    }
                    if ($spend > 0 && $baseDetail->minimum_investment <= ($privilege / 2)) {
                        $criteriaCount++;
                        $criteriaMatchCount++;
                        $criteriaValue = $criteriaValue + ($privilege / (2 * 12));
                    }
                    if ($loan > 0 && $baseDetail->minimum_home_loan <= $loan) {
                        $criteriaCount++;
                        $criteriaMatchCount++;
                        $criteriaValue = $criteriaValue + ($loan / (12 * 25));
                    }

                    if ($criteriaMatchCount == 1) {
                        $status = true;
                        $criteria = "bonus_interest_criteria_a";
                        $highlight = "criteria_a_highlight";
                        $product->criteria_a_highlight = true;


                    } elseif ($criteriaMatchCount >= 2) {
                        $status = true;
                        $criteria = "bonus_interest_criteria_b";
                        $highlight = "criteria_b_highlight";
                        $product->criteria_b_highlight = true;

                    } else {
                        $status = false;
                        $criteria = "bonus_interest_criteria_b";
                        $criteriaCount = 5;
                        $criteriaMatchCount = 4;
                    }


                } else {
                    $status = false;
                    $criteria = "bonus_interest_criteria_b";
                    $criteriaCount = 5;
                    $criteriaMatchCount = 4;
                }
                if ($criteriaMatchCount > 0) {
                    $placement = $searchValue;
                    foreach ($productRanges as $key => $productRange) {
                        $allInterests = [
                            $productRange->bonus_interest_criteria_a,
                            $productRange->bonus_interest_criteria_b,
                        ];

                        $maxRanges[] = $productRange->max_range;
                        if ($criteriaValue >= $productRange->min_range && $status == true) {
                            $criteriaValue = (int)$criteriaValue;
                        } elseif (empty($criteriaValue) && (count($productRanges) - 1) == ($key)) {
                            $criteriaValue = $productRange->min_range;
                            $criteria = "bonus_interest_criteria_b";
                            $criteriaCount = 5;
                            $status = false;
                        }
                    }
                }

                if ($criteriaValue > 0) {
                    foreach ($productRanges as $productRangesKey => $productRange) {
                        $productRange->criteria_a_highlight = false;
                        $productRange->criteria_b_highlight = false;
                        if (($criteriaValue) > $productRange->max_range && ((count($productRanges) - 1) == $productRangesKey)) {
                            if ($status == true) {
                                $productRange->$highlight = true;
                            }
                            $totalInterest = $productRange->$criteria;
                            if (($placement) >= $productRange->first_cap_amount) {
                                $interestEarn = (($productRange->first_cap_amount) * ($totalInterest / 100) + ((($placement) - $productRange->first_cap_amount) * ($productRange->board_rate / 100)));

                            } else {
                                $interestEarn = (($productRange->first_cap_amount) * ($totalInterest / 100) + ((($placement) - $productRange->first_cap_amount) * ($productRange->board_rate / 100)));

                            }
                        } elseif ($criteriaValue >= $productRange->min_range && $criteriaValue <= $productRange->max_range) {
                            if ($status == true) {
                                $productRange->$highlight = true;
                            }
                            $totalInterest = $productRange->$criteria;
                            $interestEarn = round(($placement) * ($totalInterest / 100), 2);
                        }
                    }

                }
                $product->total_interest = $totalInterest;
                $product->interest_earned = $interestEarn;
                $product->placement = $placement;
                $product->product_range = $productRanges;
                $product->criteriaCount = $criteriaCount;
                if ($status == true) {
                    $product->highlight = true;
                    $filterProducts[] = $product;
                } elseif ($status == false) {
                    $remainingProducts[] = $product;
                }
            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F5) {
                $totalInterests = [];
                $interestEarns = [];
                $product->highlight = false;
                $product->salary_highlight = false;
                $product->payment_highlight = false;
                $product->spend_1_highlight = false;
                $product->spend_2_highlight = false;
                $product->privilege_highlight = false;
                $product->loan_highlight = false;
                $product->other1_highlight = false;
                $product->other2_highlight = false;

                $criteriaMatchCount = 0;

                foreach ($productRanges as $k => $productRange) {
                    //dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_spend_1,
                        $productRange->bonus_interest_spend_2,
                        $productRange->bonus_interest_salary,
                        $productRange->bonus_interest_giro_payment,
                        $productRange->bonus_interest_privilege,
                        $productRange->bonus_interest_loan,
                    ];
                    if ($searchValue >= $productRange->min_range) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif (empty($placement) && (count($productRanges) - 1) == ($k)) {
                        $placement = $productRange->max_range;
                    }


                    $totalInterest = 0;
                    $colSpan = 0;
                    if (!empty($productRange->minimum_spend_2)) {
                        $colSpan++;
                    } elseif (!empty($productRange->minimum_spend_1)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->minimum_salary)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->minimum_giro_payment)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->minimum_privilege_pa)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->minimum_loan_pa)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->other_minimum_amount1) && ($productRange->status_other1 == 1)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->other_minimum_amount2) && ($productRange->status_other2 == 1)) {
                        $colSpan++;
                    }
                    $productRange->colspan = $colSpan;
                    if ($status == true) {
                        if (!empty($productRange->minimum_spend_2)) {
                            if ($spend > 0 && $productRange->minimum_spend_2 <= $spend) {
                                $product->spend_2_highlight = true;
                                $totalInterest = $totalInterest + $productRange->bonus_interest_spend_2;
                                $criteriaMatchCount++;
                            }
                        }
                        if (!empty($productRange->minimum_spend_1) && ($product->spend_2_highlight == false)) {
                            if ($spend > 0 && $productRange->minimum_spend_1 <= $spend) {
                                $product->spend_1_highlight = true;
                                $totalInterest = $totalInterest + $productRange->bonus_interest_spend_1;
                                $criteriaMatchCount++;
                            }
                        }
                        if (isset($productRange->minimum_salary_2) && $salary > 0 && $productRange->minimum_salary_2 <= $salary) {
                            $product->salary_highlight_2 = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_salary_2;
                            $criteriaMatchCount++;
                        } elseif ($salary > 0 && $productRange->minimum_salary <= $salary) {
                            $product->salary_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_salary;
                            $criteriaMatchCount++;
                        }
                        if (!empty($productRange->minimum_giro_payment)) {
                            if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                                $product->payment_highlight = true;
                                $totalInterest = $totalInterest + $productRange->bonus_interest_giro_payment;
                                $criteriaMatchCount++;
                            }
                        }

                        if (!empty($productRange->minimum_privilege_pa)) {
                            if ($privilege > 0 && $productRange->minimum_privilege_pa <= $privilege / 12) {
                                $product->privilege_highlight = true;
                                $totalInterest = $totalInterest + $productRange->bonus_interest_privilege;
                                $criteriaMatchCount++;
                            }
                        }
                        if (!empty($productRange->minimum_loan_pa)) {
                            if ($loan > 0 && $productRange->minimum_loan_pa <= $loan) {
                                $product->loan_highlight = true;
                                $totalInterest = $totalInterest + $productRange->bonus_interest_loan;
                                $criteriaMatchCount++;
                            }
                        }
                        if (!empty($productRange->other_minimum_amount1) && ($productRange->status_other1 == 1) && (isset($productRange->checked_status_other1) && $productRange->checked_status_other1 == 1)) {
                            if ($placement > 0 && $productRange->other_minimum_amount1 <= $placement) {
                                $product->other_highlight1 = true;
                                $totalInterest = $totalInterest + $productRange->other_interest1;
                                $criteriaMatchCount++;
                            }
                        }
                        if (!empty($productRange->other_minimum_amount2) && ($productRange->status_other2 == 1) && (isset($productRange->checked_status_other2) && $productRange->checked_status_other2 == 1)) {
                            if ($placement > 0 && $productRange->other_minimum_amount2 <= $placement) {
                                $product->other_highlight2 = true;
                                $totalInterest = $totalInterest + $productRange->other_interest2;
                                $criteriaMatchCount++;
                            }
                        }
                    }
                    if ($criteriaMatchCount == 0) {
                        $status = false;
                        $totalInterest = $productRange->bonus_interest_salary + $productRange->bonus_interest_giro_payment + $productRange->bonus_interest_spend_1 + $productRange->bonus_interest_spend_2 +
                            $productRange->bonus_interest_privilege + $productRange->other_interest1 + $productRange->other_interest2 + $productRange->bonus_interest_loan;
                        $criteriaMatchCount = 4;

                    }

                    $totalInterests[] = $totalInterest;
                    if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                        $interestEarns[] = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                    } else {
                        $interestEarns[] = $placement * ($totalInterest / 100);
                    }
                    $productRange->placement = $placement;
                }
                $product->criteriaCount = $criteriaMatchCount;
                $product->total_interest = array_sum($totalInterests);
                $product->interest_earned = array_sum($interestEarns);
                $product->placement = $placement;
                $product->product_range = $productRanges;
                if ($status == true) {
                    $product->highlight = true;
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F6) {

                //dd($productRanges);
                $criteriaMatchCount = 0;
                $product->highlight_index = 0;
                $product->highlight = false;

                $product->salary_highlight = false;
                $product->spend_highlight = false;
                $product->other_highlight = false;
                $product->wealth_highlight = false;
                $product->grow_highlight = false;
                $product->boost_highlight = false;
                $maxRanges = [];
                $minRanges = [];
                $totalInterests = [];
                $interestEarns = [];
                $criteria = null;
                $salaryStatus = false;
                $spendStatus = false;
                $otherStatus = false;
                $wealthStatus = false;
                $growStatus = true;
                $boostStatus = false;
                $baseInterest = true;


                //$placement = 0;
                if ($salary >= $productRanges[0]->minimum_salary) {
                    $salaryStatus = true;
                }
                if ($spend >= $productRanges[0]->minimum_spend) {
                    $spendStatus = true;
                }
                if ($productRanges[0]->status_other == 1 && !is_null($productRanges[0]->other_interest_name)) {
                    $otherStatus = true;
                    $product->other_highlight = true;
                }
                if ($privilege > 0 && ($productRanges[0]->minimum_wealth <= ($privilege / 12))) {
                    $wealthStatus = true;
                }

                foreach ($productRanges as $key => $productRange) {
                    $productRange->salary_highlight = false;
                    $productRange->spend_highlight = false;
                    $productRange->other_highlight = false;
                    $productRange->wealth_highlight = false;
                    $maxRanges[] = $productRange->max_range;
                    $minRanges[] = $productRange->min_range;
                    if ($searchValue >= $productRange->min_range) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif (empty($placement) && (count($productRanges) - 1) == ($key)) {
                        $placement = $productRange->max_range;
                        $status = false;
                    }
                }
                $maxPlacement = array_last(array_sort($maxRanges));
                $minPlacement = array_last(array_sort($minRanges));
                $lastRange = array_last($productRanges);
                $lastCalculatedAmount = 0;
                $interestRangeCount = 1;
                $interestPercentTotal = 0;
                foreach ($productRanges as $k => $productRange) {
                    $interestEarn = 0;
                    if ($minPlacement == $productRange->min_range && $minPlacement <= $placement) {
                        if ($lastCalculatedAmount < $placement) {
                            if ($salaryStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($lastRange->bonus_interest_salary / 100), 2);
                                $productRange->salary_highlight = true;
                                $product->salary_highlight = true;
                                $interestPercentTotal += $lastRange->bonus_interest_salary;
                            }
                            if ($spendStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($lastRange->bonus_interest_spend / 100), 2);
                                $productRange->spend_highlight = true;
                                $product->spend_highlight = true;
                                $interestPercentTotal += $lastRange->bonus_interest_spend;
                            }
                            if ($otherStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($lastRange->bonus_interest_other / 100), 2);
                                $productRange->other_highlight = true;
                                $product->other_highlight = true;
                                $interestPercentTotal += $lastRange->bonus_interest_other;

                            }
                            if ($wealthStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($lastRange->bonus_interest_wealth / 100), 2);
                                $productRange->wealth_highlight = true;
                                $product->wealth_highlight = true;
                                $interestPercentTotal += $lastRange->bonus_interest_wealth;
                            }

                            $interestEarns[] = $interestEarn;


                            $productRange->above_range = true;
                            $product->highlight_index = $k;
                            $lastCalculatedAmount = $placement;
                        }
                        $productRange->interest_earn = $interestEarn;
                    } else {
                        if ($productRange->max_range < $placement) {
                            if ($salaryStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_salary / 100), 2);
                                $productRange->salary_highlight = true;
                                $product->salary_highlight = true;
                                $interestPercentTotal += $productRange->bonus_interest_salary;
                            }
                            if ($spendStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_spend / 100), 2);
                                $productRange->spend_highlight = true;
                                $product->spend_highlight = true;
                                $interestPercentTotal += $productRange->bonus_interest_spend;
                            }
                            if ($otherStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_other / 100), 2);
                                $productRange->other_highlight = true;
                                $product->other_highlight = true;
                                $interestPercentTotal += $productRange->bonus_interest_other;

                            }
                            if ($wealthStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_wealth / 100), 2);
                                $productRange->wealth_highlight = true;
                                $product->wealth_highlight = true;
                                $interestPercentTotal += $productRange->bonus_interest_wealth;
                            }

                            $interestEarns[] = $interestEarn;
                            $product->highlight_index = $k;
                            //dd($wealthStatus,$privilege);
                            //$totalInterests[] = $productRange->$criteria;
                            $lastCalculatedAmount = $productRange->max_range;
                        } else {
                            if ($lastCalculatedAmount < $placement) {

                                if ($salaryStatus == true) {
                                    $interestEarn += round(($placement - $lastCalculatedAmount) * ($productRange->bonus_interest_salary / 100), 2);
                                    $productRange->salary_highlight = true;
                                    $product->salary_highlight = true;
                                    $interestPercentTotal += $productRange->bonus_interest_salary;
                                }
                                if ($spendStatus == true) {
                                    $interestEarn += round(($placement - $lastCalculatedAmount) * ($productRange->bonus_interest_spend / 100), 2);
                                    $productRange->spend_highlight = true;
                                    $product->spend_highlight = true;
                                    $interestPercentTotal += $productRange->bonus_interest_spend;
                                }
                                if ($otherStatus == true) {
                                    $interestEarn += round(($placement - $lastCalculatedAmount) * ($productRange->bonus_interest_other / 100), 2);
                                    $productRange->other_highlight = true;
                                    $product->other_highlight = true;
                                    $interestPercentTotal += $productRange->bonus_interest_other;
                                }
                                if ($wealthStatus == true) {
                                    $interestEarn += round(($placement - $lastCalculatedAmount) * ($productRange->bonus_interest_wealth / 100), 2);
                                    $productRange->wealth_highlight = true;
                                    $product->wealth_highlight = true;
                                    $interestPercentTotal += $productRange->bonus_interest_wealth;
                                }

                                $product->highlight_index = $k;
                                $interestEarns[] = $interestEarn;
                                $lastCalculatedAmount = $productRange->max_range;
                            }
                        }
                        $productRange->interest_earn = $interestEarn;
                        //$productRange->criteria = $productRange->$criteria;
                        $productRange->above_range = false;
                    }
                    $interestRangeCount++;
                }
                $product->grow_interest_total;
                $product->boost_interest_total;
                $product->base_interest_total;
                if ($placement >= $productRanges[0]->minimum_grow) {
                    if ($placement > $productRanges[0]->cap_grow) {
                        $product->grow_interest_total = round($productRanges[0]->cap_grow * ($productRanges[0]->bonus_interest_grow / 100), 2);
                    } else {
                        $product->grow_interest_total = round($placement * ($productRanges[0]->bonus_interest_grow / 100), 2);
                    }
                    $product->interest_earned += $product->grow_interest_total;
                    $product->grow_highlight = true;
                    $product->total_interest += $productRanges[0]->bonus_interest_grow;
                }
                if ($boostStatus == true) {
                    if ($placement > $productRanges[0]->cap_boost) {
                        $product->boost_interest_total = round($productRanges[0]->cap_boost * ($productRanges[0]->bonus_interest_boost / 100), 2);
                    } else {
                        $product->boost_interest_total = round($placement * ($productRanges[0]->bonus_interest_boost / 100), 2);
                    }
                    $product->interest_earned += $product->boost_interest_total;
                    $product->boost_highlight = true;
                    $product->total_interest += $productRanges[0]->bonus_interest_boost;
                }
                if ($maxPlacement < $placement) {
                    $product->base_interest_total = round(($placement - $maxPlacement) * ($productRanges[0]->bonus_interest_remaining_amount / 100), 2);
                    $product->interest_earned += $product->base_interest_total;
                    $product->base_highlight = true;
                    $product->total_interest += $productRanges[0]->bonus_interest_remaining_amount;
                }
                $product->total_interest += round($interestPercentTotal / $interestRangeCount, 2);
                $product->interest_earned += array_sum($interestEarns);
                $product->placement = $placement;
                $product->product_range = $productRanges;
                if ($status == true) {
                    $product->highlight = true;
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }
            } elseif (empty($product->promotion_formula_id)) {
                $filterProducts[] = $product;
            }

        }
        $products = collect($filterProducts);
        $remainingProducts = collect($remainingProducts);
        //dd($sortBy,$filter);
        if ($products->count()) {
            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == CRITERIA) {
                    $products = $products->sortBy('promotion_period')->values();
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == CRITERIA) {
                    $products = $products->sortByDesc('promotion_period')->values();
                }
            }
            $featured = $products->where('featured', 1)->values();
            $nonFeatured = $products->where('featured', 0)->values();
            $products = $featured->merge($nonFeatured);
            $sliderProducts = $products->where('promotion_formula_id', '!=', null)->values();
        }
        if ($remainingProducts->count()) {
            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('maximum_interest_rate')->values();
                } elseif ($filter == CRITERIA) {
                    $remainingProducts = $remainingProducts->sortBy('promotion_period')->values();
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('maximum_interest_rate')->values();
                } elseif ($filter == CRITERIA) {
                    $remainingProducts = $remainingProducts->sortByDesc('promotion_period')->values();
                }
            }
            $featured = $remainingProducts->where('featured', 1)->values();
            $nonFeatured = $remainingProducts->where('featured', 0)->values();
            $remainingProducts = $featured->merge($nonFeatured);
        }

        //dd($products);
        return view('frontend.products.aio-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "remainingProducts", "sliderProducts", "searchFilter", "legendtable", "ads_manage", "toolTips"));
    }

    public
    function searchLoan(Request $request)
    {
        return $this->loan($request->all());
    }

    public
    function loan($request)
    {

        $ads_manage = [];
        $adsCollection = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', LOAN_MODE)
            ->inRandomOrder()
            ->get();
        if ($adsCollection->count()) {
            $ads_manage = \Helper::manageAds($adsCollection);
        }
        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MINIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : INTEREST;
        $pageNo = isset($request['page_no']) ? $request['page_no'] : 1;
        $type = isset($request['type']) ? $request['type'] : '';
        $firstTimeLoad = isset($request['first_time']) ? $request['first_time'] : 0;

        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        DB::connection()->enableQueryLog();

        $toolTips = ToolTip::where('promotion_id', LOAN)->first();

        $query = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->leftJoin('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            //->whereNotNull('promotion_products.formula_id')
            ->where('promotion_types.id', '=', LOAN)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*', 'promotion_products.id as product_id', 'promotion_products.id as product_id');
        if (isset($request['type']) && in_array($request['type'], ['loan_load_more', 'loan_load_more_by_id'])) {
            $query = $query->whereIn('promotion_products.id', $request['product_ids']);
        }
        $promotion_products = $query->get();

        $details = \Helper::get_page_detail(LOAN_MODE);
        $brands = $details['brands'];
        if ($promotion_products->count() && $brands->count()) {
            $productsBrandIds = $promotion_products->pluck('bank_id')->all();
            $brands = $brands->whereIn('id', $productsBrandIds);
        }
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
        $remainingProducts = [];
        $sliderProducts = collect([]);
        if ($promotion_products->count()) {
            foreach ($promotion_products as $key => $product) {

                $defaultSearch = DefaultSearch::where('promotion_id', LOAN)->first();
                if ($defaultSearch) {
                    $defaultPlacement = $defaultSearch->placement;
                    $defaultRateType = $defaultSearch->rate_type;
                    $defaultTenure = $defaultSearch->tenure;
                    $defaultPropertyType = $defaultSearch->property_type;
                    $defaultCompletion = $defaultSearch->completion;

                } else {
                    $defaultPlacement = 0;
                    $defaultRateType = BOTH_VALUE;
                    $defaultTenure = 35;
                    $defaultPropertyType = HDB_PROPERTY;
                    $defaultCompletion = COMPLETE;
                }
                if (isset($request['first_time']) && $request['first_time'] == 1) {
                    $placement = 0;
                    $searchValue = $defaultPlacement;
                    $rateType = $defaultRateType;

                    $tenure = $defaultTenure;
                    $propertyType = $defaultPropertyType;
                    $completion = $defaultCompletion;
                    $searchFilter['search_value'] = $defaultPlacement;
                    $searchFilter['rate_type'] = $defaultRateType;
                    $searchFilter['tenure'] = $defaultTenure;
                    $searchFilter['property_type'] = $defaultPropertyType;
                    $searchFilter['completion'] = $defaultCompletion;
                    $searchFilter['filter'] = INTEREST;
                    $searchFilter['sort_by'] = MINIMUM;
                    $pageNo = 1;
                } else {
                    $placement = 0;
                    $searchFilter = $request;
                    $searchValue = str_replace(',', '', $searchFilter['search_value']);
                    if (!is_numeric($searchValue)) {
                        $searchValue = $defaultPlacement;
                    }
                    $searchFilter['search_value'] = $searchValue;
                    $rateType = $searchFilter['rate_type'] = isset($searchFilter['rate_type']) ? $searchFilter['rate_type'] : null;
                    $tenure = $searchFilter['tenure'] = isset($searchFilter['tenure']) ? (int)$searchFilter['tenure'] : null;
                    $propertyType = $searchFilter['property_type'] = isset($searchFilter['property_type']) ? $searchFilter['property_type'] : null;
                    $completion = $searchFilter['completion'] = isset($searchFilter['completion']) ? $searchFilter['completion'] : null;
                    $searchFilter['filter'] = $searchFilter['filter'] ? $searchFilter['filter'] : PLACEMENT;
                    $pageNo = $searchFilter['page_no'] ? $searchFilter['page_no'] : 1;

                }
                $status = true;
                $remainingStatus = false;
                $productRanges = json_decode($product->product_range);
                if ($product->promotion_formula_id == LOAN_F1) {
                    $tenure = (int)$tenure;
                    $totalInterests = [];
                    $interestEarns = [];
                    $product->highlight = false;
                    $firstProductRange = $productRanges[0];
                    if ($product->minimum_loan_amount > $searchValue) {
                        $status = false;
                        $remainingStatus = true;
                    }
                    if ($rateType != BOTH_VALUE && ($rateType != $firstProductRange->rate_type)) {
                        $status = false;
                        $remainingStatus = false;
                    }

                    $bucProperty = [BUC, COMPLETE_BUC];
                    $completionProperty = [COMPLETE, COMPLETE_BUC];
                    $commonCompletion = [];

                    if ($completion == BUC) {
                        $commonCompletion = $bucProperty;
                    } elseif ($completion == COMPLETE) {
                        $commonCompletion = $completionProperty;
                    }
                    if (!in_array($firstProductRange->completion_status, $commonCompletion)) {
                        $status = false;
                        $remainingStatus = false;
                    }

                    $hdbProperty = [HDB_PROPERTY, HDB_PRIVATE_PROPERTY];
                    $privateProperty = [PRIVATE_PROPERTY, HDB_PRIVATE_PROPERTY];
                    $commonProperty = [];
                    if (in_array($propertyType, [HDB_PROPERTY, PRIVATE_PROPERTY])) {
                        if ($propertyType == HDB_PROPERTY) {
                            $commonProperty = $hdbProperty;
                        } elseif ($propertyType == PRIVATE_PROPERTY) {
                            $commonProperty = $privateProperty;
                        }
                        if (!in_array($firstProductRange->property_type, $commonProperty)) {
                            $status = false;
                            $remainingStatus = false;
                        }
                    } elseif ($propertyType != $firstProductRange->property_type) {
                        $status = false;
                        $remainingStatus = false;
                    }
                    /*if (($searchValue < $firstProductRange->min_range) || ($searchValue > $firstProductRange->max_range)) {
                        $status = false;
                    }*/
                    $productRangeCount = count($productRanges);
                    $totalInterest = 0;
                    $totalMonthlyInstallment = 0;
                    $totalTenure = 0;
                    $j = 0;
                    foreach ($productRanges as $k => $productRange) {
                        $productRange->tenure_highlight = false;
                        $interest = $productRange->bonus_interest + $productRange->rate_interest_other;
                        if ($interest <= 0) {
                            $productRange->monthly_payment = 0;
                        } else {
                            $mortage = new Defr\MortageRequest($searchValue, $interest, $tenure);
                            $result = $mortage->calculate();
                            $productRange->monthly_payment = $result->monthlyPayment;
                        }

                        if ($tenure > $totalTenure) {
                            if ($j <= 2) {
                                $totalInterest += $interest;
                                $totalTenure++;
                                $totalMonthlyInstallment += $productRange->monthly_payment;
                            }
                            $productRange->tenure_highlight = true;
                        }

                        $j++;
                    }

                    while ($j <= 2) {
                        $interest = $firstProductRange->there_after_bonus_interest + $firstProductRange->there_after_rate_interest_other;
                        if ($interest <= 0) {
                            $monthlyThereAfterPayment = 0;
                        } else {
                            $mortage = new Defr\MortageRequest($searchValue, $interest, $tenure);
                            $result = $mortage->calculate();
                            $monthlyThereAfterPayment = $result->monthlyPayment;
                        }

                        $totalInterest += $interest;
                        $totalTenure++;
                        $totalMonthlyInstallment += $monthlyThereAfterPayment;
                        $j++;
                    }
                    $interest = $firstProductRange->there_after_bonus_interest + $firstProductRange->there_after_rate_interest_other;
                    if ($interest <= 0) {
                        $product->there_after_installment = 0;
                    } else {
                        $mortage = new Defr\MortageRequest($searchValue, $interest, $tenure);
                        $result = $mortage->calculate();
                        $product->there_after_installment = $result->monthlyPayment;
                    }

                    $product->placement = $searchValue;
                    $product->tenure = $tenure;

                    if ($tenure > $productRangeCount) {
                        //$totalInterest += ($tenure - $productRangeCount) * $interest;
                        // $totalMonthlyInstallment += ($tenure - $productRangeCount) * $result->monthlyPayment;
                        $product->highlight = true;;

                    }
                    $product->avg_interest = round(($totalInterest / $totalTenure), 2);
                    $product->monthly_installment = $totalMonthlyInstallment / $totalTenure;
                    $product->avg_tenure = $totalTenure;
                    $product->product_range = $productRanges;
                    $product->eligible = true;
                    if ($status == true) {

                        $filterProducts[] = $product;
                    } elseif ($remainingStatus == true && $status == false) {
                        $product->eligible = false;
                        $remainingProducts[] = $product;
                    }

                } elseif (empty($product->promotion_formula_id)) {
                    $filterProducts[] = $product;
                }
            }
        }
        $products = collect($filterProducts);
        $productPerPage = 8;
        $totalProductNo = 1;
        $remainingProducts = collect($remainingProducts);
        if ($products->count()) {
            if ($sortBy == MINIMUM) {
                if ($filter == INSTALLMENT) {
                    $products = $products->sortBy('minimum_loan_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('avg_interest')->values();
                } elseif ($filter == TENURE) {
                    $products = $products->sortBy('lock_in')->values();
                }
            } else {
                if ($filter == INSTALLMENT) {
                    $products = $products->sortByDesc('minimum_loan_amount')->values();
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('avg_interest')->values();
                } elseif ($filter == TENURE) {
                    $products = $products->sortByDesc('lock_in')->values();
                }
            }

            $featured = $products->where('featured', 1)->values();
            $nonFeatured = $products->where('featured', 0)->values();
            $products = $featured->merge($nonFeatured);


            $sliderProducts = $products->where('promotion_formula_id', '!=', null)->values();


        }

        if ($remainingProducts->count()) {
            if ($sortBy == MINIMUM) {
                if ($filter == INSTALLMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_loan_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('avg_interest')->values();
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortBy('lock_in')->values();
                }
            } else {
                if ($filter == INSTALLMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_loan_amount')->values();
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('avg_interest')->values();
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortByDesc('lock_in')->values();
                }
            }
            $featured = $remainingProducts->where('featured', 1)->values();
            $nonFeatured = $remainingProducts->where('featured', 0)->values();
            $remainingProducts = $featured->merge($nonFeatured);

        }
        $products = $products->merge($remainingProducts);
        $productsIds = $products->pluck('product_id');

        $totalProductNo = $products->count();
        $pages = ceil($totalProductNo / $productPerPage);
        $productIdsPerPage = [];
        if (isset($request['type']) && in_array($request['type'], ['loan_load_more', 'loan_load_more_by_id'])) {
            //$products = $products->merge($nonFeatured);
            return $products;
        }
        for ($i = 1; $i <= $pages; $i++) {
            $productIdsPerPage[] = array_values($productsIds->forPage($i, $productPerPage)->all());

        }

        /*  $products = $products->merge($remainingProducts);
         dd($products->pluck('product_id')->all(),$remainingProducts->pluck('product_id')->all());*/

        $products = $products->forPage($pageNo, $productPerPage);

        //dd($products);

        return view('frontend.products.loan', compact("firstTimeLoad","productIdsPerPage", "pageNo", "pages", "brands", "page", "systemSetting", "banners", "products", "remainingProducts", "sliderProducts", "searchFilter", "ads_manage", "toolTips"));
    }

    public function combineCriteriaFilter(Request $request)
    {

        $searchDetail = [];
        $checkBoxDetail = [];
        parse_str($request->search_detail, $searchDetail);
        parse_str($request->check_box_detail, $checkBoxDetail);
        $brandId = null;
        $sortBy = isset($searchDetail['sort_by']) ? $searchDetail['sort_by'] : MAXIMUM;
        $filter = isset($searchDetail['filter']) ? $searchDetail['filter'] : PLACEMENT;
        $highlightStatus = isset($request->status) ? $request->status : 1;

        $product = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_formula.promotion_id', '=', ALL_IN_ONE_ACCOUNT)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->where('promotion_products.id', '=', $request->product_id)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*', 'promotion_products.id as product_id')
            ->first();


        if ($product) {
            $defaultSearch = DefaultSearch::where('promotion_id', ALL_IN_ONE_ACCOUNT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
                $defaultSalary = $defaultSearch->salary;
                $defaultGiro = $defaultSearch->payment;
                $defaultSpend = $defaultSearch->spend;
                $defaultLoan = $defaultSearch->loan;
                $defaultPrivilege = $defaultSearch->privilege;

            } else {
                $defaultPlacement = 0;
                $defaultSalary = 0;
                $defaultGiro = 0;
                $defaultSpend = 0;
                $defaultLoan = 0;
                $defaultPrivilege = 0;

            }
            $placement = 0;

            $searchValue = str_replace(',', '', $searchDetail['search_value']);

            if ($highlightStatus == 0) {
                $salary = (int)$searchDetail['salary'];
                $giro = (int)$searchDetail['giro'];
                $spend = (int)$searchDetail['spend'];
                $minimumInsurance = 0;
                $minimumUnitTrust = 0;
                $minimumHirePurchaseLoan = 0;
                $minimumRenovationLoan = 0;
                $minimumHomeLoan = 0;
                $minimumEducationLoan = 0;
                $productRanges = json_decode($product->product_range);
                if (count($productRanges)) {
                    $productRange = $productRanges[0];
                    $searchValue = $productRange->max_range;
                    if (isset($checkBoxDetail['life_insurance'])) {
                        $minimumInsurance = (int)$productRange->minimum_insurance;
                    }
                    if (isset($checkBoxDetail['unit_trust'])) {
                        $minimumUnitTrust = (int)$productRange->minimum_unit_trust;
                    }
                    if (isset($checkBoxDetail['hire_loan'])) {
                        $minimumHirePurchaseLoan = (int)$productRange->minimum_hire_purchase_loan;
                    }
                    if (isset($checkBoxDetail['renovation_loan'])) {
                        $minimumRenovationLoan = (int)$productRange->minimum_renovation_loan;
                    }
                    if (isset($checkBoxDetail['housing_loan'])) {
                        $minimumHomeLoan = (int)$productRange->minimum_home_loan;
                    }
                    if (isset($checkBoxDetail['education_loan'])) {
                        $minimumEducationLoan = (int)$productRange->minimum_education_loan;
                    }
                }


            } else {
                $salary = (int)$searchDetail['salary'];
                $giro = (int)$searchDetail['giro'];
                $spend = (int)$searchDetail['spend'];
                $minimumInsurance = ((int)$searchDetail['privilege']) / 12;
                $minimumUnitTrust = ((int)$searchDetail['privilege']) / 12;
                $minimumHirePurchaseLoan = (int)$searchDetail['loan'];
                $minimumRenovationLoan = (int)$searchDetail['loan'];
                $minimumHomeLoan = (int)$searchDetail['loan'];
                $minimumEducationLoan = (int)$searchDetail['loan'];
            }
            $status = false;
            $productRanges = json_decode($product->product_range);
            if ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F3) {
                $criteriaMatchCount = 0;
                $product->highlight = false;
                $product->criteria_1 = false;
                $product->criteria_2 = false;
                $product->criteria_3 = false;
                $product->life_insurance = false;
                $product->housing_loan = false;
                $product->education_loan = false;
                $product->hire_loan = false;
                $product->renovation_loan = false;
                $product->unit_trust = false;
                $product->salary_highlight = false;
                $product->salary_highlight_2 = false;
                $product->payment_highlight = false;
                $product->spend_highlight = false;
                $product->spend_highlight_2 = false;
                $product->housing_loan_highlight = false;
                $product->education_loan_highlight = false;
                $product->hire_loan_highlight = false;
                $product->renovation_loan_highlight = false;
                $product->life_insurance_highlight = false;
                $product->unit_trust_highlight = false;
                $totalInterests = [];
                $interestEarns = [];

                foreach ($productRanges as $k => $productRange) {
                    // dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_criteria1,
                        $productRange->bonus_interest_criteria2,
                        $productRange->bonus_interest_criteria3,
                    ];

                    if ($searchValue >= $productRange->min_range) {
                        $placement = (float)$searchValue;
                        $status = true;
                    } elseif (empty($placement) && (count($productRanges) - 1) == ($k)) {
                        $placement = $productRange->max_range;
                    }
                    $totalInterest = 1;
                    if ($status == true) {

                        if ($salary > 0 && $productRange->minimum_salary <= $salary) {
                            $criteriaMatchCount++;
                            $product->salary_highlight = true;
                        }
                        if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                            $criteriaMatchCount++;
                            $product->payment_highlight = true;
                        }
                        if ($spend > 0 && $productRange->minimum_spend <= $spend) {
                            $criteriaMatchCount++;
                            $product->spend_highlight = true;
                        }
                        if ((isset($checkBoxDetail['life_insurance'])) && ($minimumInsurance > 0 && $productRange->minimum_insurance <= ($minimumInsurance))) {
                            $criteriaMatchCount++;
                            $product->life_insurance = true;
                            $product->life_insurance_highlight = true;
                        }
                        if ((isset($checkBoxDetail['unit_trust'])) && ($minimumUnitTrust > 0 && $productRange->minimum_unit_trust <= ($minimumUnitTrust))) {

                            $criteriaMatchCount++;
                            $product->unit_trust = true;
                            $product->unit_trust_highlight = true;
                        }
                        if ((isset($checkBoxDetail['hire_loan'])) && ($minimumHirePurchaseLoan > 0 && $productRange->minimum_hire_purchase_loan <= ($minimumHirePurchaseLoan))) {
                            $criteriaMatchCount++;
                            $product->hire_loan = true;
                            $product->hire_loan_highlight = true;
                        }
                        if ((isset($checkBoxDetail['renovation_loan'])) && ($minimumRenovationLoan > 0 && $productRange->minimum_renovation_loan <= ($minimumRenovationLoan))) {
                            $criteriaMatchCount++;
                            $product->renovation_loan = true;
                            $product->renovation_loan_highlight = true;
                        }
                        if ((isset($checkBoxDetail['housing_loan'])) && ($minimumHomeLoan > 0 && $productRange->minimum_home_loan <= ($minimumHomeLoan))) {
                            $criteriaMatchCount++;
                            $product->housing_loan = true;
                            $product->housing_loan_highlight = true;
                        }
                        if ((isset($checkBoxDetail['education_loan'])) && ($minimumEducationLoan > 0 && $productRange->minimum_education_loan <= ($minimumEducationLoan))) {
                            $criteriaMatchCount++;
                            $product->education_loan = true;
                            $product->education_loan_highlight = true;
                        }

                        if ($criteriaMatchCount == 1) {
                            $totalInterest = $productRange->bonus_interest_criteria1;
                            if ($highlightStatus == 1) {
                                $product->criteria_1 = true;
                            }

                        } elseif ($criteriaMatchCount == 2) {
                            $totalInterest = $productRange->bonus_interest_criteria2;
                            if ($highlightStatus == 1) {
                                $product->criteria_2 = true;
                            }

                        } elseif ($criteriaMatchCount >= 3) {
                            $totalInterest = $productRange->bonus_interest_criteria3;
                            if ($highlightStatus == 1) {
                                $product->criteria_3 = true;
                            }
                        }
                    }

                    if ($criteriaMatchCount == 0) {
                        $product->life_insurance = true;
                        $product->unit_trust = true;
                        $product->hire_loan = true;
                        $product->renovation_loan = true;
                        $product->housing_loan = true;
                        $product->education_loan = true;
                        $criteriaMatchCount = 9;
                        $totalInterest = $productRange->bonus_interest_criteria3;
                        $placement = $productRange->max_range;
                        $status = false;
                    }
                    $totalInterests[] = $totalInterest;
                    if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                        $interestEarns[] = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                    } else {
                        $interestEarns[] = $placement * ($totalInterest / 100);
                    }
                    $productRange->placement = $placement;

                }
                $product->total_interest = array_sum($totalInterests);
                $product->interest_earned = array_sum($interestEarns);
                $product->product_range = $productRanges;
                $product->criteriaCount = $criteriaMatchCount;
                if ($status == true) {
                    if ($highlightStatus == 1) {
                        $product->highlight = true;
                    }
                }
                ?>

                <table class="ps-table ps-table--product ps-table--product-3">
                    <thead>
                    <tr>
                        <th class="combine-criteria-padding" style="width:19%">CRITERIA</th>
                        <th class="combine-criteria-padding <?php if ($product->salary_highlight == true || $product->salary_highlight_2 == true) {
                            echo 'active';
                        } ?>" style="width:9%">SALARY
                        </th>
                        <th class="combine-criteria-padding <?php if ($product->payment_highlight == true) {
                            echo 'active';
                        } ?>" style="width:9%">PAYMENT
                        </th>
                        <th class="combine-criteria-padding <?php if ($product->spend_highlight == true || $product->spend_highlight_2 == true) {
                            echo 'active';
                        } ?>" style="width:9%">SPEND
                        </th>
                        <th class="combine-criteria-padding " style="width:27%">
                            Loan
                            <div class="row">
                                <div class="width-50">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                               onchange="changeCriteria(this);"
                                            <?php if ($product->housing_loan) {
                                                echo "checked = checked";
                                            } ?>
                                               name="housing_loan"
                                               data-status="<?php echo $highlightStatus; ?>"
                                               data-product-id="<?php echo $product->product_id; ?>"
                                               value="true"
                                               id="housing-loan-<?php echo $product->product_id; ?>">
                                        <label
                                            for="housing-loan-<?php echo $product->product_id; ?>"
                                            class="<?php if ($product->housing_loan_highlight == true) {
                                                echo 'active';
                                            } ?>">Housing</label>
                                    </div>
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                               data-status="<?php echo $highlightStatus; ?>"
                                               name="education_loan" onchange="changeCriteria(this);"
                                               data-product-id="<?php echo $product->product_id; ?>"
                                               value="true"
                                               id='education-loan-<?php echo $product->product_id; ?>'
                                            <?php if ($product->education_loan) {
                                                echo "checked = checked";
                                            } ?>/>
                                        <label
                                            for="education-loan-<?php echo $product->product_id; ?>"
                                            class="<?php if ($product->education_loan_highlight == true) {
                                                echo 'active';
                                            } ?>">Education</label>
                                    </div>
                                </div>
                                <div class="width-50">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                               onchange="changeCriteria(this);"
                                               name="hire_loan" value="true"
                                               data-status="<?php echo $highlightStatus; ?>"
                                               data-product-id="<?php echo $product->product_id; ?>"
                                               id="hire-loan-<?php echo $product->product_id; ?>"
                                            <?php if ($product->hire_loan) {
                                                echo "checked = checked";
                                            } ?>/>
                                        <label for="hire-loan-<?php echo $product->product_id; ?>"
                                               class="<?php if ($product->hire_loan_highlight == true) {
                                                   echo 'active';
                                               } ?>">HIRE PURCHASE</label>
                                    </div>
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                               data-status="<?php echo $highlightStatus; ?>"
                                               name="renovation_loan" onchange="changeCriteria(this);"
                                               data-product-id="<?php echo $product->product_id; ?>"
                                               value="true"
                                               id="renovation-loan-<?php echo $product->product_id; ?>"
                                            <?php if ($product->renovation_loan) {
                                                echo "checked = checked";
                                            } ?>/>
                                        <label
                                            for="renovation-loan-<?php echo $product->product_id; ?>"
                                            class="<?php if ($product->renovation_loan_highlight == true) {
                                                echo 'active';
                                            } ?>">Renovation</label>
                                    </div>

                                </div>
                            </div>
                        </th>
                        <th class="combine-criteria-padding" style="width:15%">
                            Wealth
                            <div class="row">
                                <div class="width-50">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                               data-product-id="<?php echo $product->product_id; ?>"
                                               data-status="<?php echo $highlightStatus; ?>"
                                               name="life_insurance" onchange="changeCriteria(this);"
                                            <?php if ($product->life_insurance) {
                                                echo "checked = checked";
                                            } ?> value="true"
                                               id="life-insurance-<?php echo $product->product_id; ?>"/>
                                        <label
                                            for="life-insurance-<?php echo $product->product_id; ?>"
                                            class="<?php if ($product->life_insurance_highlight == true) {
                                                echo 'active';
                                            } ?>">Insurance</label>
                                    </div>
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                               onchange="changeCriteria(this);"
                                               name="unit_trust" value="true"
                                               data-status="<?php echo $highlightStatus; ?>"
                                               data-product-id="<?php echo $product->product_id; ?>"
                                               id="unit-trust-<?php echo $product->product_id; ?>"
                                            <?php if ($product->unit_trust) {
                                                echo "checked = checked";
                                            } ?>/>
                                        <label for="unit-trust-<?php echo $product->product_id; ?>"
                                               class="<?php if ($product->unit_trust_highlight == true) {
                                                   echo 'active';
                                               } ?>">Unit</label>
                                    </div>
                                </div>
                            </div>

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($productRanges as $range) { ?>
                        <tr>
                            <td>Bonus Interest PA</td>
                            <td colspan="5" style="padding:0;">
                                <table class="3-col-eq">
                                    <tr>
                                        <td class="text-center <?php if ($product->criteria_1 == true) {
                                            echo "highlight";
                                        } ?> "
                                            colspan="3">1 Criteria
                                            - <?php if ($range->bonus_interest_criteria1 <= 0) {
                                                echo "-";
                                            } else {
                                                echo "$range->bonus_interest_criteria1" . '%';
                                            } ?>
                                        </td>
                                        <td class=" text-center  <?php if ($product->criteria_2 == true) {
                                            echo "highlight";
                                        } ?> "
                                            colspan="1">2 Criteria
                                            - <?php if ($range->bonus_interest_criteria2 <= 0) {
                                                echo "-";
                                            } else {
                                                echo "$range->bonus_interest_criteria2" . '%';
                                            } ?>

                                        </td>
                                        <td class="text-center  <?php if ($product->criteria_3 == true) {
                                            echo "highlight";
                                        } ?>"
                                            colspan="1">3 Criteria - <?php if ($range->bonus_interest_criteria3 <= 0) {
                                                echo " - ";
                                            } else {
                                                echo "$range->bonus_interest_criteria3" . '%';
                                            } ?>

                                        </td>
                                    </tr>
                                </table>
                        </tr>
                        <?php if ($status == true) { ?>
                            <tr>
                                <td colspan="1">Total Bonus Interest Earned for SGD
                                    <?php echo "$" . \Helper::inThousand($range->placement); ?>
                                </td>
                                <td class=" text-center <?php if ($product->highlight == true) {
                                    echo 'highlight';
                                } ?>"
                                    colspan="5">

                                    <?php if ($range->placement > $range->first_cap_amount) {
                                        echo "First ";
                                        echo "$" . \Helper::inThousand($range->first_cap_amount) . ' - ' .
                                            '$' . \Helper::inThousand(($range->first_cap_amount * ($product->total_interest / 100))) .
                                            ' (' . $product->total_interest . '%), next $' .
                                            \Helper::inThousand(($range->placement - $range->first_cap_amount)) . ' - '
                                            . '$' . \Helper::inThousand((($range->bonus_interest_remaining_amount / 100) * ($range->placement - $range->first_cap_amount))) .
                                            ' (' . $range->bonus_interest_remaining_amount . '%)<br/> Total = $'
                                            . \Helper::inThousand($product->interest_earned);
                                    } else {
                                        echo "Total = $" . \Helper::inThousand($product->interest_earned);
                                    } ?>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="1">Total Bonus Interest Earned for SGD
                                    <?php echo "$" . \Helper::inThousand($range->placement); ?></td>
                                <td class="text-center <?php if ($product->highlight == true) {
                                    echo 'highlight';
                                } ?>"
                                    colspan="<?php echo $range->colspan; ?>">

                                    <span class="nill"> <?php echo NILL; ?></span><br/>

                                    <p><?php echo NOT_ELIGIBLE; ?></p>

                                </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>

                <?php
                $range = $productRanges[0];
                if ($status == true) { ?>
                    <div class="ps-product__panel aio-product">

                        <h4>Total Bonus Interest Earned for SGD
                            <?php echo "$" . \Helper::inThousand($range->placement); ?></h4>

                        <p class="center">
                                <span
                                    class="nill"><?php echo "$" . \Helper::inThousand($product->interest_earned); ?>  </span><br/>
                            <?php if ($range->placement > $range->first_cap_amount) {
                                echo "First ";
                                echo "$" . \Helper::inThousand($range->first_cap_amount) . ' - ' .
                                    '$' . \Helper::inThousand(($range->first_cap_amount * ($product->total_interest / 100))) .
                                    ' (' . $product->total_interest . '%), next $' .
                                    \Helper::inThousand(($range->placement - $range->first_cap_amount)) . ' - '
                                    . '$' . \Helper::inThousand((($range->bonus_interest_remaining_amount / 100) * ($range->placement - $range->first_cap_amount))) .
                                    ' (' . $range->bonus_interest_remaining_amount . '%)<br/> Total = $'
                                    . \Helper::inThousand($product->interest_earned);
                            } else {
                                echo "Total = $" . \Helper::inThousand($product->interest_earned);
                            } ?>
                        </p>
                    </div>
                <?php } else { ?>
                    <div class="ps-product__panel aio-product">

                        <h4>Total Bonus Interest Earned for SGD
                            <?php echo "$" . \Helper::inThousand($range->placement); ?></h4>

                        <span class="nill"> <?php echo NILL; ?></span><br/>

                        <p><?php echo NOT_ELIGIBLE; ?></p>
                    </div>
                    <?php
                }
            }
        }

    }

    public function generalIndividualCriteriaFilter(Request $request)
    {
        $searchDetail = [];
        $checkBoxDetail = [];
        parse_str($request->search_detail, $searchDetail);
        parse_str($request->check_box_detail, $checkBoxDetail);
        $brandId = null;
        $sortBy = isset($searchDetail['sort_by']) ? $searchDetail['sort_by'] : MAXIMUM;
        $filter = isset($searchDetail['filter']) ? $searchDetail['filter'] : PLACEMENT;
        $highlightStatus = isset($request->status) ? $request->status : 1;

        $product = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->leftJoin('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_formula.promotion_id', '=', ALL_IN_ONE_ACCOUNT)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->where('promotion_products.id', '=', $request->product_id)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*', 'promotion_products.id as product_id')
            ->first();


        if ($product) {
            $defaultSearch = DefaultSearch::where('promotion_id', ALL_IN_ONE_ACCOUNT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
                $defaultSalary = $defaultSearch->salary;
                $defaultGiro = $defaultSearch->payment;
                $defaultSpend = $defaultSearch->spend;
                $defaultLoan = $defaultSearch->loan;
                $defaultPrivilege = $defaultSearch->privilege;

            } else {
                $defaultPlacement = 0;
                $defaultSalary = 0;
                $defaultGiro = 0;
                $defaultSpend = 0;
                $defaultLoan = 0;
                $defaultPrivilege = 0;

            }
            $placement = 0;

            $searchValue = str_replace(',', '', $searchDetail['search_value']);
            if ($highlightStatus == 0) {
                $salary = (int)$searchDetail['salary'];
                $giro = (int)$searchDetail['giro'];
                $spend = (int)$searchDetail['spend'];
                $privilege = isset($searchDetail['privilege']) ? (int)$searchDetail['privilege'] : 0;
                $loan = isset($searchDetail['loan']) ? (int)$searchDetail['loan'] : 0;

                $other1MinimumAmount = 0;
                $other2MinimumAmount = 0;

                $productRanges = json_decode($product->product_range);
                if (count($productRanges)) {
                    $productRange = $productRanges[0];
                    $searchValue = $productRange->max_range;
                    if (isset($checkBoxDetail['other_interest1'])) {
                        $other1MinimumAmount = (int)$productRange->other_minimum_amount1;
                    }
                    if (isset($checkBoxDetail['other_interest2'])) {
                        $other2MinimumAmount = (int)$productRange->other_minimum_amount2;
                    }
                }


            } else {

                $salary = (int)$searchDetail['salary'];
                $giro = (int)$searchDetail['giro'];
                $spend = (int)$searchDetail['spend'];
                $privilege = isset($searchDetail['privilege']) ? (int)$searchDetail['privilege'] : 0;
                $loan = isset($searchDetail['loan']) ? (int)$searchDetail['loan'] : 0;
                $other1MinimumAmount = 0;
                $other2MinimumAmount = 0;

                $productRanges = json_decode($product->product_range);
                if (count($productRanges)) {
                    $productRange = $productRanges[0];
                    if (isset($checkBoxDetail['other_interest1'])) {
                        $other1MinimumAmount = (int)$productRange->other_minimum_amount1;
                    }
                    if (isset($checkBoxDetail['other_interest2'])) {
                        $other2MinimumAmount = (int)$productRange->other_minimum_amount2;
                    }
                }
            }
            $status = false;
            $productRanges = json_decode($product->product_range);
            if ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F5) {
                $totalInterests = [];
                $interestEarns = [];
                $product->highlight = false;
                $product->salary_highlight = false;
                $product->salary_highlight_2 = false;
                $product->payment_highlight = false;
                $product->spend_1_highlight = false;
                $product->spend_2_highlight = false;
                $product->privilege_highlight = false;
                $product->loan_highlight = false;
                $product->other1_highlight = false;
                $product->other2_highlight = false;
                $criteriaMatchCount = 0;

                foreach ($productRanges as $k => $productRange) {

                    $allInterests = [
                        $productRange->bonus_interest_spend_1,
                        $productRange->bonus_interest_spend_2,
                        $productRange->bonus_interest_salary,
                        $productRange->bonus_interest_giro_payment,
                        $productRange->bonus_interest_privilege,
                        $productRange->bonus_interest_loan,
                    ];
                    if ($searchValue >= $productRange->min_range) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif (empty($placement) && (count($productRanges) - 1) == ($k)) {
                        $placement = $productRange->max_range;
                    }
                    $totalInterest = 0;
                    $colSpan = 0;
                    if (!empty($productRange->minimum_spend_2)) {
                        $colSpan++;
                    } elseif (!empty($productRange->minimum_spend_1)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->minimum_salary)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->minimum_giro_payment)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->minimum_privilege_pa)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->minimum_loan_pa)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->other_minimum_amount1) && ($productRange->status_other1 == 1)) {
                        $colSpan++;
                    }
                    if (!empty($productRange->other_minimum_amount2) && ($productRange->status_other2 == 1)) {
                        $colSpan++;
                    }
                    $productRange->colspan = $colSpan;
                    if ($status == true) {
                        if (!empty($productRange->minimum_spend_2)) {
                            if ($spend > 0 && $productRange->minimum_spend_2 <= $spend) {
                                $product->spend_2_highlight = true;
                                $totalInterest += $productRange->bonus_interest_spend_2;
                                $criteriaMatchCount++;
                            }
                        }

                        if (!empty($productRange->minimum_spend_1) && ($product->spend_2_highlight == false)) {
                            if ($spend > 0 && $productRange->minimum_spend_1 <= $spend) {

                                if ($highlightStatus == 1) {
                                    $product->spend_1_highlight = true;
                                }
                                $totalInterest += $productRange->bonus_interest_spend_1;
                                $criteriaMatchCount++;
                            }
                        }

                        if (isset($productRange->minimum_salary_2) && $salary > 0 && $productRange->minimum_salary_2 <= $salary) {
                            $product->salary_highlight_2 = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_salary_2;
                            $criteriaMatchCount++;
                        } elseif ($salary > 0 && $productRange->minimum_salary <= $salary) {
                            $product->salary_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_salary;
                            $criteriaMatchCount++;
                        }
                        if (!empty($productRange->minimum_giro_payment)) {
                            if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                                if ($highlightStatus == 1) {
                                    $product->payment_highlight = true;
                                }
                                $totalInterest += $productRange->bonus_interest_giro_payment;
                                $criteriaMatchCount++;
                            }
                        }

                        if (!empty($productRange->minimum_privilege_pa)) {
                            if ($privilege > 0 && $productRange->minimum_privilege_pa <= $privilege / 12) {
                                if ($highlightStatus == 1) {
                                    $product->privilege_highlight = true;
                                }
                                $totalInterest += $productRange->bonus_interest_privilege;
                                $criteriaMatchCount++;
                            }
                        }
                        if (!empty($productRange->minimum_loan_pa)) {
                            if ($loan > 0 && $productRange->minimum_loan_pa <= $loan) {
                                if ($highlightStatus == 1) {
                                    $product->loan_highlight = true;
                                }
                                $totalInterest += $productRange->bonus_interest_loan;
                                $criteriaMatchCount++;
                            }
                        }
                        if ((isset($checkBoxDetail['other_interest1'])) && ($other1MinimumAmount > 0) && ($productRange->status_other1 == 1)) {
                            if ($placement > 0 && $productRange->other_minimum_amount1 <= $placement) {
                                if ($highlightStatus == 1) {
                                    $product->other_highlight1 = true;
                                }
                                $totalInterest += $productRange->other_interest1;
                                $criteriaMatchCount++;
                            }
                        }
                        if ((isset($checkBoxDetail['other_interest2'])) && ($other2MinimumAmount > 0) && ($productRange->status_other2 == 1)) {
                            if ($placement > 0 && $productRange->other_minimum_amount2 <= $placement) {

                                if ($highlightStatus == 1) {
                                    $product->other_highlight2 = true;
                                }
                                $totalInterest += $productRange->other_interest2;
                                $criteriaMatchCount++;
                            }
                        }
                    }
                    if ($criteriaMatchCount == 0) {
                        $status = false;
                        $totalInterest = $productRange->bonus_interest_salary + $productRange->bonus_interest_giro_payment + $productRange->bonus_interest_spend_1 + $productRange->bonus_interest_spend_2 +
                            $productRange->bonus_interest_privilege + $productRange->other_interest1 + $productRange->other_interest2 + $productRange->bonus_interest_loan;
                        $criteriaMatchCount = 4;

                    }

                    $totalInterests[] = $totalInterest;
                    if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                        $interestEarns[] = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                    } else {
                        $interestEarns[] = $placement * ($totalInterest / 100);
                    }
                    $productRange->placement = $placement;
                }
                $product->criteriaCount = $criteriaMatchCount;
                $product->total_interest = array_sum($totalInterests);
                $product->interest_earned = array_sum($interestEarns);
                $product->placement = $placement;
                $product->product_range = $productRanges;
                if ($status == true) {
                    if ($highlightStatus == 1) {
                        $product->highlight = true;
                    }
                }
                ?>

                <table class="ps-table ps-table--product ps-table--product-3">
                    <thead>
                    <tr>
                        <th class="">CRITERIA</th>
                        <?php $firstRange = $productRanges[0];
                        if (!empty($firstRange->minimum_spend_1) || !empty($firstRange->minimum_spend_2)) { ?>
                            <th class="<?php if ($product->spend_2_highlight == true || $product->spend_1_highlight == true) {
                                echo 'active';
                            } ?>">SPEND
                            </th>
                        <?php }
                        if (!empty($firstRange->minimum_salary)) { ?>
                            <th class="<?php if ($product->salary_highlight == true || $product->salary_highlight_2 == true) {
                                echo 'active';
                            } ?>">SALARY
                            </th> <?php }
                        if (!empty($firstRange->minimum_giro_payment)) { ?>

                            <th class="<?php if ($product->payment_highlight == true) {
                                echo 'active';
                            } ?>">PAYMENT
                            </th> <?php }
                        if (!empty($firstRange->minimum_privilege_pa)) { ?>

                            <th class="<?php if ($product->privilege_highlight == true) {
                                echo 'active';
                            } ?>">PRIVILEGE
                            </th> <?php }
                        if (!empty($firstRange->minimum_loan_pa)) { ?>
                            <th class="<?php if ($product->loan_highlight == true) {
                                echo 'active';
                            } ?>">LOAN
                            </th> <?php }
                        if (!empty($firstRange->other_minimum_amount1) && ($firstRange->status_other1 == 1)) { ?>
                            <th class="combine-criteria-padding">
                                <div class="">
                                    <div class="width-50">
                                        <div class="ps-checkbox">
                                            <input class="form-control" type="checkbox"
                                                   onchange="changeIndividualCriteria(this);"
                                                   data-status="<?php echo $highlightStatus; ?>"
                                                   name="other_interest1"
                                                   data-product-id="<?php echo $product->product_id; ?>"
                                                   value="true"
                                                <?php if ($product->other_highlight1) {
                                                    echo "checked = checked";
                                                } ?>
                                                   id="other-interest1-<?php echo $product->product_id; ?>">
                                            <label
                                                for="other-interest1-<?php echo $product->product_id; ?>"
                                                class="<?php if ($product->other_highlight1 == true) {
                                                    echo 'active';
                                                } ?>"><?php echo $firstRange->other_interest1_name; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        <?php }
                        if (!empty($firstRange->other_minimum_amount2) && ($firstRange->status_other2 == 1)) { ?>
                            <th class="combine-criteria-padding">
                                <div class="">
                                    <div class="width-50">
                                        <div class="ps-checkbox">
                                            <input class="form-control" type="checkbox"
                                                   onchange="changeIndividualCriteria(this);"
                                                   data-status="<?php echo $highlightStatus; ?>"
                                                   name="other_interest2"
                                                   data-product-id="<?php echo $product->product_id; ?>"
                                                   value="true"
                                                <?php if ($product->other_highlight2) {
                                                    echo "checked = checked";
                                                } ?>
                                                   id="other-interest2-<?php echo $product->product_id; ?>">
                                            <label
                                                for="other-interest2-<?php echo $product->product_id; ?>"
                                                class="<?php if ($product->other_highlight2 == true) {
                                                    echo 'active';
                                                } ?>"><?php echo $firstRange->other_interest2_name; ?></label>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        <?php } ?>
                    </thead>
                    <tbody>
                    <?php foreach ($productRanges as $range) { ?>
                        <tr>
                            <td class="text-left">Bonus Interest PA</td>
                            <?php if (!empty($firstRange->minimum_spend_1) || !empty($firstRange->minimum_spend_2)) { ?>
                                <td class=" pt-0 pb-0 pl-0 pr-0 text-center <?php if ($product->spend_2_highlight == true || $product->spend_1_highlight == true) {
                                    echo "highlight";
                                } ?> ">
                                    <table cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class=" text-center <?php if ($product->spend_1_highlight == true) {
                                                echo "highlight";
                                            } ?> ">
                                                <?php if ($range->bonus_interest_spend_1 <= 0) {
                                                    echo "-";
                                                } else {
                                                    echo $range->bonus_interest_spend_1 . "%";
                                                } ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=" text-center <?php if ($product->spend_2_highlight == true) {
                                                echo "highlight";
                                            } ?>">
                                                <?php if ($range->bonus_interest_spend_2 <= 0) {
                                                    echo "-";
                                                } else {
                                                    echo $range->bonus_interest_spend_2 . "%";
                                                } ?>
                                            </td>
                                        </tr>
                                    </table>


                                </td>
                            <?php }
                            if (!empty($firstRange->minimum_salary) || !empty($firstRange->minimum_salary_2)) { ?>
                                <td class=" pt-0 pb-0 pl-0 pr-0 text-center <?php if ($product->salary_highlight == true || $product->salary_highlight_2 == true) {
                                    echo "highlight";
                                } ?> ">
                                    <table cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class=" text-center <?php if ($product->salary_highlight == true) {
                                                echo "highlight";
                                            } ?> ">
                                                <?php if ($range->bonus_interest_salary <= 0) {
                                                    echo "-";
                                                } else {
                                                    echo $range->bonus_interest_salary . "%";
                                                } ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class=" text-center <?php if ($product->salary_highlight_2 == true) {
                                                echo "highlight";
                                            } ?>">
                                                <?php if ($range->bonus_interest_salary_2 <= 0) {
                                                    echo "-";
                                                } else {
                                                    echo $range->bonus_interest_salary_2 . "%";
                                                } ?>
                                            </td>
                                        </tr>
                                    </table>


                                </td>
                            <?php }
                            if (!empty($firstRange->minimum_giro_payment)) { ?>
                                <td class=" text-center  <?php if ($product->payment_highlight == true) {
                                    echo "highlight";
                                } ?> ">
                                    <?php if ($range->bonus_interest_giro_payment <= 0) {
                                        echo "-";
                                    } else {
                                        echo "$range->bonus_interest_giro_payment" . '%';
                                    } ?>

                                </td>
                            <?php }
                            if (!empty($firstRange->minimum_privilege_pa)) { ?>
                                <td class=" text-center  <?php if ($product->privilege_highlight == true) {
                                    echo "highlight";
                                } ?> ">
                                    Up to <?php if ($range->bonus_interest_privilege <= 0) {
                                        echo "-";
                                    } else {
                                        echo "$range->bonus_interest_privilege" . '%';
                                    } ?>

                                </td>
                            <?php }
                            if (!empty($firstRange->minimum_loan_pa)) { ?>
                                <td class=" text-center  <?php if ($product->loan_highlight == true) {
                                    echo "highlight";
                                } ?> ">
                                    <?php if ($range->bonus_interest_loan <= 0) {
                                        echo "-";
                                    } else {
                                        echo "$range->bonus_interest_loan" . '%';
                                    } ?>

                                </td>
                            <?php }
                            if (!empty($firstRange->other_minimum_amount1) && ($firstRange->status_other1 == 1)) { ?>
                                <td class=" text-center  <?php if ($product->other_highlight1 == true) {
                                    echo "highlight";
                                } ?> ">
                                    <?php if ($range->other_interest1 <= 0) {
                                        echo "-";
                                    } else {
                                        echo "$range->other_interest1" . '%';
                                    } ?>

                                </td>
                            <?php }
                            if (!empty($firstRange->other_minimum_amount2) && ($firstRange->status_other2 == 1)) { ?>
                                <td class=" text-center  <?php if ($product->other_highlight2 == true) {
                                    echo "highlight";
                                } ?> ">
                                    <?php if ($range->other_interest2 <= 0) {
                                        echo "-";
                                    } else {
                                        echo "$range->other_interest2" . '%';
                                    } ?>

                                </td>
                            <?php } ?>
                        </tr>
                        <?php if ($status == true) { ?>
                            <tr>
                                <td colspan="1" class="text-left">Total Bonus Interest Earned for SGD
                                    <?php echo "$" . \Helper::inThousand($range->placement); ?>
                                </td>
                                <td class=" text-center <?php if ($product->highlight == true) {
                                    echo 'highlight';
                                } ?>" colspan="<?php echo $range->colspan; ?>">

                                    <?php if ($range->placement > $range->first_cap_amount) {
                                        echo "First ";
                                        echo "$" . \Helper::inThousand($range->first_cap_amount) . ' - ' .
                                            '$' . \Helper::inRoundTwoDecimal(($range->first_cap_amount * ($product->total_interest / 100))) .
                                            ' (' . $product->total_interest . '%), remaining $' .
                                            \Helper::inThousand(($range->placement - $range->first_cap_amount)) . ' - '
                                            . '$' . \Helper::inRoundTwoDecimal((($range->bonus_interest_remaining_amount / 100) * ($range->placement - $range->first_cap_amount))) .
                                            ' (' . $range->bonus_interest_remaining_amount . '%)<br/> Total = $'
                                            . \Helper::inRoundTwoDecimal($product->interest_earned);
                                    } else {
                                        echo "Total = $" . \Helper::inRoundTwoDecimal($product->interest_earned);
                                        echo "(" . $product->total_interest . "%)";
                                    } ?>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="1">Total Bonus Interest Earned for SGD
                                    <?php echo "$" . \Helper::inThousand($range->placement); ?></td>
                                <td class="text-center <?php if ($product->highlight == true) {
                                    echo 'highlight';
                                } ?>"
                                    colspan="<?php echo $range->colspan; ?>">

                                    <span class="nill"> <?php echo NILL; ?></span><br/>

                                    <p><?php echo NOT_ELIGIBLE; ?></p>

                                </td>
                            </tr>
                        <?php }
                    } ?>
                    </tbody>
                </table>

                <?php
                $range = $productRanges[0];
                if ($status == true) { ?>
                    <div class="ps-product__panel aio-product">

                        <h4>Total Bonus Interest Earned for SGD
                            <?php echo "$" . \Helper::inThousand($range->placement); ?></h4>

                        <p class="center">
                                <span
                                    class="nill"><?php echo "$" . \Helper::inThousand($product->interest_earned); ?>  </span><br/>
                            <?php if ($range->placement > $range->first_cap_amount) {
                                echo "First ";
                                echo "$" . \Helper::inThousand($range->first_cap_amount) . ' - ' .
                                    '$' . \Helper::inRoundTwoDecimal(($range->first_cap_amount * ($product->total_interest / 100))) .
                                    ' (' . $product->total_interest . '%), remaining $' .
                                    \Helper::inThousand(($range->placement - $range->first_cap_amount)) . ' - '
                                    . '$' . \Helper::inRoundTwoDecimal((($range->bonus_interest_remaining_amount / 100) * ($range->placement - $range->first_cap_amount))) .
                                    ' (' . $range->bonus_interest_remaining_amount . '%)<br/> Total = $'
                                    . \Helper::inRoundTwoDecimal($product->interest_earned);
                            } else {
                                echo "Total = $" . \Helper::inRoundTwoDecimal($product->interest_earned);
                                echo "(" . $product->total_interest . "%)";
                            } ?>
                        </p>
                    </div>
                <?php } else { ?>
                    <div class="ps-product__panel aio-product">

                        <h4>Total Bonus Interest Earned for SGD
                            <?php echo "$" . \Helper::inThousand($range->placement); ?></h4>

                        <span class="nill"> <?php echo NILL; ?></span><br/>

                        <p><?php echo NOT_ELIGIBLE; ?></p>
                    </div>
                    <?php
                }
            }
        }

    }

    public
    function forgotPassword($details)
    {
//        $details = \Helper::get_page_detail(TERMS_CONDITION);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        return view('frontend.user.forgot-password', compact("brands", "page", "systemSetting", "banners"));
    }

    public
    function resetPassword($details)
    {
//        $details = \Helper::get_page_detail(TERMS_CONDITION);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        return view('frontend.user.reset-new-password', compact("brands", "page", "systemSetting", "banners"));
    }

    public
    function getProductSliderDetails(Request $request)
    {
        $products = \Helper::getHomeProducts($request->promotion_type, $request->by_order_value);
        $i = 1;
        $featured = [];
        if ($products->count()) {

            if ($request->target == "pc-slider") {
                foreach ($products as $product) {
                    if ($product->featured == 1 && $product->product_url!=FOREIGN_CURRENCY_DEPOSIT_MODE) {
                        $featured[] = $i; ?>
                        <div class="product-col-01 home-featured">
                            <div class="ps-slider--feature-product saving">
                                <div class="ps-block--short-product second highlight"
                                     data-mh="product">
                                    <div class="slider-img">
                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                    </div>
                                    <h4 class="slider-heading">
                                        <strong>
                                            <?php if ($product->by_order_value == INTEREST) { ?>
                                                Up to <span
                                                    class="highlight-slider"> <?php echo $product->maximum_interest_rate; ?>
                                                    %</span>
                                            <?php }
                                            if ($product->by_order_value == PLACEMENT) { ?>
                                                Min:   <span class="highlight-slider">
                                                                <?php if ($product->promotion_type_id == FOREIGN_CURRENCY_DEPOSIT) {
                                                                    echo $product->currency_code;
                                                                } else {
                                                                    echo SGD;
                                                                }
                                                                echo '$' . \Helper::inThousand($product->minimum_placement_amount); ?> </span>
                                            <?php }
                                            if ($product->by_order_value == TENURE) {
                                                if ($product->promotion_period == ONGOING) {
                                                    echo '<span class="highlight-slider"> ' . $product->promotion_period . '</span>';
                                                } else {
                                                    if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) { ?>
                                                        <span
                                                            class="highlight-slider"> <?php echo $product->remaining_days; ?> </span>
                                                        <?php echo \Helper::daysOrMonthForSlider(1, $product->remaining_days);
                                                    } elseif ($product->tenure_value > 0) { ?>
                                                        <span
                                                            class="highlight-slider"> <?php echo $product->promotion_period; ?> </span> <?php echo \Helper::daysOrMonthForSlider(2,
                                                            $product->tenure_value);
                                                    } elseif (is_numeric($product->promotion_period)) { ?>
                                                        <span
                                                            class="highlight-slider"> <?php echo $product->promotion_period; ?> </span>
                                                        <?php echo \Helper::daysOrMonthForSlider(2, $product->promotion_period);
                                                    } else { ?>
                                                        <span
                                                            class="highlight-slider"> <?php echo $product->promotion_period; ?> </span>
                                                    <?php }

                                                }
                                            }
                                            if ($product->by_order_value == CRITERIA) { ?>
                                                Up to  <span
                                                    class="highlight-slider"> <?php echo $product->promotion_period; ?>
                                                    Criteria </span>
                                            <?php } ?>
                                        </strong>
                                    </h4>

                                    <div class="ps-block__info">
                                        <p class=" <?php if ($product->by_order_value == INTEREST)
                                            echo 'highlight highlight-bg'; ?> ">
                        <span class="slider-font">
                                Rate: </span><?php echo $product->maximum_interest_rate; ?>%</p>

                                        <p class=" <?php if ($product->by_order_value == PLACEMENT)
                                            echo 'highlight highlight-bg'; ?>">
                                                <span
                                                    class="slider-font">Min:</span> <?php if ($product->promotion_type_id
                                                == FOREIGN_CURRENCY_DEPOSIT
                                            ) {
                                                echo $product->currency_code;
                                            } else {
                                                echo SGD;
                                            }
                                            echo '$' . \Helper::inThousand($product->minimum_placement_amount); ?>
                                        </p>
                                        <?php if ($product->product_url == AIO_DEPOSIT_MODE) { ?>
                                            <p class="<?php if ($product->by_order_value == CRITERIA) echo 'highlight highlight-bg'; ?>">
                                                <?php echo $product->promotion_period . ' ' . CRITERIA; ?>
                                            </p>
                                        <?php } else { ?>
                                            <p class="<?php if ($product->by_order_value == TENURE) echo 'highlight highlight-bg'; ?>">
                                                <?php if ($product->promotion_period == ONGOING) {
                                                    echo $product->promotion_period;
                                                } else { ?>
                                                    <?php if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                                                        echo $product->remaining_days; ?>
                                                        <span
                                                            class="slider-font"> <?php echo \Helper::daysOrMonthForSlider(1, $product->remaining_days); ?> </span>
                                                    <?php } else { ?>
                                                        <?php echo $product->promotion_period;
                                                        if ($product->tenure_value > 0) { ?>
                                                            <span
                                                                class="slider-font"> <?php echo \Helper::daysOrMonthForSlider(2, $product->tenure_value); ?> </span>
                                                        <?php }
                                                    }
                                                } ?>

                                            </p>
                                        <?php } ?>
                                    </div>
                                    <a class="ps-btn"
                                       href="<?php echo url($product->product_url); ?>">
                                        More info
                                    </a>

                                </div>
                            </div>
                        </div>
                        <?php $i++;
                    }
                }
                $i = 1;
                $featured_item = 5 - count($featured);
                $featured_count = count($featured);
                $featured_width = 0;
                if ($featured_count == 1) {
                    $featured_width = 2;
                } elseif ($featured_count == 2) {
                    $featured_width = 3;
                } elseif ($featured_count == 3) {
                    $featured_width = 4;
                }

                ?>

                <div class="product-col-0<?php echo $featured_width; ?> dump-padding-left">
                    <div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
                         data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                         data-owl-gap="10" data-owl-item="<?php echo $featured_item; ?>"
                         data-owl-item-lg="<?php echo $featured_item; ?>"
                         data-owl-item-md="<?php echo $featured_item; ?>" data-owl-item-sm="2"
                         data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                         data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                         data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                         data-owl-speed="5000">
                        <?php foreach ($products as $product) {
                            if ($product->featured == 0 || $product->product_url==FOREIGN_CURRENCY_DEPOSIT_MODE) { ?>

                                <div class="ps-block--short-product second">
                                    <div class="slider-img">
                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                    </div>
                                    <h4 class="slider-heading">
                                        <strong>
                                            <?php if ($product->by_order_value == INTEREST) { ?>
                                                Up to <span
                                                    class="highlight-slider"> <?php echo $product->maximum_interest_rate; ?>
                                                    %</span>
                                            <?php } ?>
                                            <?php if ($product->by_order_value == PLACEMENT) { ?>
                                                Min:   <span class="highlight-slider">
                                                                <?php if ($product->promotion_type_id == FOREIGN_CURRENCY_DEPOSIT) {
                                                                    echo $product->currency_code;
                                                                } else {
                                                                    echo SGD;
                                                                }
                                                                echo '$' . \Helper::inThousand($product->minimum_placement_amount); ?>
                                    </span>
                                            <?php }
                                            if ($product->by_order_value == TENURE) {
                                                if ($product->promotion_period == ONGOING) {
                                                    echo '<span class="highlight-slider"> ' . $product->promotion_period . '</span>';
                                                } else {
                                                    if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) { ?>
                                                        <span
                                                            class="highlight-slider"> <?php echo $product->remaining_days; ?> </span>
                                                        <?php echo \Helper::daysOrMonthForSlider(1, $product->remaining_days);
                                                    } elseif ($product->tenure_value > 0) { ?>
                                                        <span
                                                            class="highlight-slider"> <?php echo $product->promotion_period; ?> </span> <?php echo \Helper::daysOrMonthForSlider(2,
                                                            $product->tenure_value);
                                                    } elseif (is_numeric($product->promotion_period)) { ?>
                                                        <span
                                                            class="highlight-slider"> <?php echo $product->promotion_period; ?> </span>
                                                        <?php echo \Helper::daysOrMonthForSlider(2, $product->promotion_period);
                                                    } else { ?>
                                                        <span
                                                            class="highlight-slider"> <?php echo $product->promotion_period; ?> </span>
                                                    <?php }

                                                }
                                            }
                                            if ($product->by_order_value == CRITERIA) { ?>
                                                Up to  <span
                                                    class="highlight-slider"> <?php echo $product->promotion_period; ?>
                                                    Criteria </span>
                                            <?php } ?>
                                        </strong>
                                    </h4>

                                    <div class="ps-block__info">
                                        <p class=" <?php if ($product->by_order_value == INTEREST) echo 'highlight highlight-bg'; ?>">
                             <span class="slider-font">
                                Rate: </span><?php echo $product->maximum_interest_rate; ?>%</p>

                                        <p class=" <?php if ($product->by_order_value == PLACEMENT) echo 'highlight highlight-bg'; ?>">
                                                <span
                                                    class="slider-font">Min:</span> <?php if ($product->promotion_type_id
                                                == FOREIGN_CURRENCY_DEPOSIT
                                            ) {
                                                echo $product->currency_code;
                                            } else {
                                                echo SGD;
                                            }
                                            echo '$' . \Helper::inThousand($product->minimum_placement_amount); ?>
                                        </p>

                                        <?php if ($product->product_url == AIO_DEPOSIT_MODE) { ?>
                                            <p class="<?php if ($product->by_order_value == CRITERIA) echo 'highlight highlight-bg'; ?>">
                                                <?php echo $product->promotion_period . ' ' . CRITERIA; ?>
                                            </p>
                                        <?php } else { ?>
                                            <p class="<?php if ($product->by_order_value == TENURE) echo 'highlight highlight-bg'; ?>">
                                                <?php if ($product->promotion_period == ONGOING) {
                                                    echo $product->promotion_period;
                                                } else { ?>
                                                    <?php if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                                                        echo $product->remaining_days; ?>
                                                        <span
                                                            class="slider-font"> <?php echo \Helper::daysOrMonthForSlider(1, $product->remaining_days); ?> </span>
                                                    <?php } else { ?>
                                                        <?php echo $product->promotion_period;
                                                        if ($product->tenure_value > 0) { ?>
                                                            <span
                                                                class="slider-font"> <?php echo \Helper::daysOrMonthForSlider(2, $product->tenure_value); ?> </span>
                                                        <?php }
                                                    }
                                                } ?>

                                            </p>
                                        <?php } ?>
                                    </div>
                                    <a class="ps-btn"
                                       href="<?php echo url($product->product_url); ?>">
                                        More info
                                    </a>

                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <?php
            } else if ($request->target == "sp-slider") {

                foreach ($products as $product) {
                    if ($product->featured == 1) {
                        $featured[] = $i;
                        $i++;
                    }
                }
                $i = 1;
                $featured_item = 5 - count($featured);
                $featured_count = count($featured);
                $featured_width = 0;
                /*if ($featured_count == 1) {
                    $featured_width = 2;
                } elseif ($featured_count == 2) {
                    $featured_width = 3;
                } elseif ($featured_count == 3) {
                    $featured_width = 4;
                }*/
                ?>
                <div class="product-col-0<?php echo $featured_width; ?> dump-padding-left">
                    <div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
                         data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                         data-owl-gap="10" data-owl-item="<?php echo $featured_item; ?>"
                         data-owl-item-lg="<?php echo $featured_item; ?>"
                         data-owl-item-md="3" data-owl-item-sm="2"
                         data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                         data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                         data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                         data-owl-speed="5000">
                        <?php foreach ($products as $product) {
                            ?>

                            <div
                                class='ps-block--short-product second  <?php if ($product->featured == 1) echo "highlight"; ?> '>
                                <div class="slider-img">
                                    <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                </div>
                                <h4 class="slider-heading">
                                    <strong>
                                        <?php if ($product->by_order_value == INTEREST) { ?>
                                            Up to <span
                                                class="highlight-slider"> <?php echo $product->maximum_interest_rate; ?>
                                                %</span>
                                        <?php } ?>
                                        <?php if ($product->by_order_value == PLACEMENT) { ?>
                                            Min:   <span class="highlight-slider">
                                                                <?php if ($product->promotion_type_id == FOREIGN_CURRENCY_DEPOSIT) {
                                                                    echo $product->currency_code;
                                                                } else {
                                                                    echo SGD;
                                                                }
                                                                echo '$' . \Helper::inThousand($product->minimum_placement_amount); ?>
                                    </span>
                                        <?php }
                                        if ($product->by_order_value == TENURE) {
                                            if ($product->promotion_period == ONGOING) {
                                                echo '<span class="highlight-slider"> ' . $product->promotion_period . '</span>';
                                            } else {
                                                if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) { ?>
                                                    <span
                                                        class="highlight-slider"> <?php echo $product->remaining_days; ?> </span>
                                                    <?php echo \Helper::daysOrMonthForSlider(1, $product->remaining_days);
                                                } elseif ($product->tenure_value > 0) { ?>
                                                    <span
                                                        class="highlight-slider"> <?php echo $product->promotion_period; ?> </span> <?php echo \Helper::daysOrMonthForSlider(2,
                                                        $product->tenure_value);
                                                } elseif (is_numeric($product->promotion_period)) { ?>
                                                    <span
                                                        class="highlight-slider"> <?php echo $product->promotion_period; ?> </span>
                                                    <?php echo \Helper::daysOrMonthForSlider(2, $product->promotion_period);
                                                } else { ?>
                                                    <span
                                                        class="highlight-slider"> <?php echo $product->promotion_period; ?> </span>
                                                <?php }

                                            }
                                        }
                                        if ($product->by_order_value == CRITERIA) { ?>
                                            Up to  <span
                                                class="highlight-slider"> <?php echo $product->promotion_period; ?>
                                                Criteria </span>
                                        <?php } ?>
                                    </strong>
                                </h4>

                                <div class="ps-block__info">
                                    <p class=" <?php if ($product->by_order_value == INTEREST) echo 'highlight highlight-bg'; ?>">
                             <span class="slider-font">
                                Rate: </span><?php echo $product->maximum_interest_rate; ?>%</p>

                                    <p class=" <?php if ($product->by_order_value == PLACEMENT) echo 'highlight highlight-bg'; ?>">
                                        <span class="slider-font">Min:</span> <?php if ($product->promotion_type_id
                                            == FOREIGN_CURRENCY_DEPOSIT
                                        ) {
                                            echo $product->currency_code;
                                        } else {
                                            echo SGD;
                                        }
                                        echo '$' . \Helper::inThousand($product->minimum_placement_amount); ?>
                                    </p>

                                    <?php if ($product->product_url == AIO_DEPOSIT_MODE) { ?>
                                        <p class="<?php if ($product->by_order_value == CRITERIA) echo 'highlight highlight-bg'; ?>">
                                            <?php echo $product->promotion_period . ' ' . CRITERIA; ?>
                                        </p>
                                    <?php } else { ?>
                                        <p class="<?php if ($product->by_order_value == TENURE) echo 'highlight highlight-bg'; ?>">
                                            <?php if ($product->promotion_period == ONGOING) {
                                                echo $product->promotion_period;
                                            } else { ?>
                                                <?php if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1])) {
                                                    echo $product->remaining_days; ?>
                                                    <span
                                                        class="slider-font"> <?php echo \Helper::daysOrMonthForSlider(1, $product->remaining_days); ?> </span>
                                                <?php } else { ?>
                                                    <?php echo $product->promotion_period;
                                                    if ($product->tenure_value > 0) { ?>
                                                        <span
                                                            class="slider-font"> <?php echo \Helper::daysOrMonthForSlider(2, $product->tenure_value); ?> </span>
                                                    <?php }
                                                }
                                            } ?>

                                        </p>
                                    <?php } ?>
                                </div>
                                <a class="ps-btn"
                                   href="<?php echo url($product->product_url); ?>">
                                    More info
                                </a>

                            </div>
                            <?php
                        } ?>
                    </div>
                </div>
                <?php

            }
        }
    }

    public
    function getLoanProductSliderDetails(Request $request)
    {
        $products = \Helper::getLoanProducts($request->promotion_type, $request->by_order_value);
        $i = 1;
        $featured = [];
        if ($products->count()) {

            if ($request->target == "loan-pc-slider") {
                foreach ($products as $product) {
                    if ($product->featured == 1) {
                        $featured[] = $i; ?>
                        <div class="product-col-01 home-featured">
                            <div class="ps-slider--feature-product saving">
                                <div class="ps-block--short-product second highlight"
                                     data-mh="product">
                                    <div class="slider-img">
                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                    </div>
                                    <h4 class="slider-heading">
                                        <strong>
                                            <?php if ($product->by_order_value == INTEREST) { ?>
                                                Avg. rate:  <span
                                                    class="highlight-slider"> <?php echo $product->avg_interest; ?>
                                                    %</span>
                                            <?php }
                                            if ($product->by_order_value == TENURE) {
                                                ?>
                                                Lock in: <span
                                                    class="highlight-slider"> <?php echo $product->lock_in; ?>
                                                    YRS </span>
                                            <?php }
                                            if ($product->by_order_value == INSTALLMENT) { ?>
                                                Min:  <span
                                                    class="highlight-slider"> SGD $<?php echo \Helper::inThousand($product->minimum_loan_amount); ?>
                                                </span>
                                            <?php } ?>
                                        </strong>
                                    </h4>

                                    <div class="ps-block__info">
                                        <p class=" <?php if ($product->by_order_value == INTEREST)
                                            echo 'highlight highlight-bg'; ?> ">
                                            <span class="slider-font">
                                            Rate: </span><?php echo $product->avg_interest; ?>%</p>

                                        <p class=" <?php if ($product->by_order_value == TENURE)
                                            echo 'highlight highlight-bg'; ?>">
                                                <span
                                                    class="slider-font">Lock in:</span> <?php
                                            echo $product->lock_in; ?> YRS
                                        </p>

                                        <p class="<?php if ($product->by_order_value == INSTALLMENT) echo 'highlight highlight-bg'; ?>">
                                                    <span
                                                        class="slider-font"> Min: SGD $<?php echo \Helper::inThousand($product->minimum_loan_amount); ?> </span>
                                        </p>
                                    </div>
                                    <a class="ps-btn"
                                       href="<?php echo url($product->product_url); ?>">
                                        More info
                                    </a>

                                </div>
                            </div>
                        </div>
                        <?php $i++;

                    }
                }

                $i = 1;
                $featured_item = 5 - count($featured);
                $featured_count = count($featured);
                $featured_width = 0;
                if ($featured_count == 1) {
                    $featured_width = 2;
                } elseif ($featured_count == 2) {
                    $featured_width = 3;
                } elseif ($featured_count == 3) {
                    $featured_width = 4;
                }

                ?>

                <div class="product-col-0<?php echo $featured_width; ?> dump-padding-left">
                    <div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
                         data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                         data-owl-gap="10" data-owl-item="<?php echo $featured_item; ?>"
                         data-owl-item-lg="<?php echo $featured_item; ?>"
                         data-owl-item-md="<?php echo $featured_item; ?>" data-owl-item-sm="2"
                         data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                         data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                         data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                         data-owl-speed="5000">
                        <?php foreach ($products as $product) {
                            if ($product->featured == 0) { ?>

                                <div class="ps-block--short-product second">
                                    <div class="slider-img">
                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                    </div>
                                    <h4 class="slider-heading">
                                        <strong>
                                            <?php if ($product->by_order_value == INTEREST) { ?>
                                                Avg. rate:  <span
                                                    class="highlight-slider"> <?php echo $product->avg_interest; ?>
                                                    %</span>
                                            <?php }
                                            if ($product->by_order_value == TENURE) {
                                                ?>
                                                Lock in: <span
                                                    class="highlight-slider"> <?php echo $product->lock_in; ?>
                                                    YRS </span>
                                            <?php }
                                            if ($product->by_order_value == INSTALLMENT) { ?>
                                                Min:  <span
                                                    class="highlight-slider"> SGD $<?php echo \Helper::inThousand($product->minimum_loan_amount); ?>
                                                </span>
                                            <?php } ?>
                                        </strong>
                                    </h4>

                                    <div class="ps-block__info">
                                        <p class=" <?php if ($product->by_order_value == INTEREST)
                                            echo 'highlight highlight-bg'; ?> ">
                                            <span class="slider-font">
                                            Rate: </span><?php echo $product->avg_interest; ?>%</p>

                                        <p class=" <?php if ($product->by_order_value == TENURE)
                                            echo 'highlight highlight-bg'; ?>">
                                                <span
                                                    class="slider-font">Lock in:</span> <?php
                                            echo $product->lock_in; ?> YRS
                                        </p>

                                        <p class="<?php if ($product->by_order_value == INSTALLMENT) echo 'highlight highlight-bg'; ?>">
                                                    <span
                                                        class="slider-font"> Min: SGD $<?php echo \Helper::inThousand($product->minimum_loan_amount); ?> </span>
                                        </p>
                                    </div>
                                    <a class="ps-btn"
                                       href="<?php echo url($product->product_url); ?>">
                                        More info
                                    </a>

                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <?php
            } else if ($request->target == "loan-sp-slider") {

                foreach ($products as $product) {
                    if ($product->featured == 1) {
                        $featured[] = $i;
                        $i++;
                    }
                }
                $i = 1;
                $featured_item = 5 - count($featured);
                $featured_count = count($featured);
                $featured_width = 0;
                /*if ($featured_count == 1) {
                    $featured_width = 2;
                } elseif ($featured_count == 2) {
                    $featured_width = 3;
                } elseif ($featured_count == 3) {
                    $featured_width = 4;
                }*/
                ?>
                <div class="product-col-0<?php echo $featured_width; ?> dump-padding-left">
                    <div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
                         data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                         data-owl-gap="10" data-owl-item="<?php echo $featured_item; ?>"
                         data-owl-item-lg="<?php echo $featured_item; ?>"
                         data-owl-item-md="3" data-owl-item-sm="2"
                         data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                         data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                         data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                         data-owl-speed="5000">
                        <?php foreach ($products as $product) {
                            ?>

                            <div
                                class='ps-block--short-product second  <?php if ($product->featured == 1) echo "highlight"; ?> '>
                                <div class="slider-img">
                                    <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                </div>
                                <h4 class="slider-heading">
                                    <strong>
                                        <?php if ($product->by_order_value == INTEREST) { ?>
                                            Avg. rate:  <span
                                                class="highlight-slider"> <?php echo $product->avg_interest; ?>
                                                %</span>
                                        <?php }
                                        if ($product->by_order_value == TENURE) {
                                            ?>
                                            Lock in: <span
                                                class="highlight-slider"> <?php echo $product->lock_in; ?> YRS </span>
                                        <?php }
                                        if ($product->by_order_value == INSTALLMENT) { ?>
                                            Min:  <span
                                                class="highlight-slider"> SGD $<?php echo \Helper::inThousand($product->minimum_loan_amount); ?>
                                                </span>
                                        <?php } ?>
                                    </strong>
                                </h4>

                                <div class="ps-block__info">
                                    <p class=" <?php if ($product->by_order_value == INTEREST)
                                        echo 'highlight highlight-bg'; ?> ">
                                            <span class="slider-font">
                                            Rate: </span><?php echo $product->avg_interest; ?>%</p>

                                    <p class=" <?php if ($product->by_order_value == TENURE)
                                        echo 'highlight highlight-bg'; ?>">
                                                <span
                                                    class="slider-font">Lock in:</span> <?php
                                        echo $product->lock_in; ?> YRS
                                    </p>

                                    <p class="<?php if ($product->by_order_value == INSTALLMENT) echo 'highlight highlight-bg'; ?>">
                                                    <span
                                                        class="slider-font"> Min: SGD $<?php echo \Helper::inThousand($product->minimum_loan_amount); ?> </span>
                                    </p>
                                </div>
                                <a class="ps-btn"
                                   href="<?php echo url($product->product_url); ?>">
                                    More info
                                </a>

                            </div>
                            <?php
                        } ?>
                    </div>
                </div>
                <?php

            }
        }
    }

    public function loanLoadMore(Request $request)
    {
        parse_str($request->search_form, $searchForm);
        $searchForm['type'] = $request->type;
        $searchForm['page_no'] = $request->page_no;
        $searchForm['product_ids'] = $request->product_ids;
        $products = $this->loan($searchForm);

        $j = 1;
        if ($products->count()) {
            foreach ($products as $product) {
                $productRanges = $product->product_range;
                $ads = json_decode($product->ads_placement);
                if (isset($ads[3]->ad_horizontal_image_popup_top)) {
                    ?>
                    <div class="ps-poster-popup">
                        <div class="close-popup">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                        <a href="<?php echo isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)'; ?>"
                           target="_blank"><img
                                src="<?php echo isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : ''; ?>"
                                alt=""></a>
                    </div>
                    <?php
                }
                ?>
                <div class="ps-product loaded <?php if ($product->featured == 1) echo featured - 1; ?>"
                     id="p-<?php echo $product->product_id; ?>">
                    <div class="ps-product__header">
                        <div class="slider-img"><img alt=""
                                                     src="<?php echo asset($product->brand_logo); ?>"></div>
                        <div class="ps-product__promo left">
                            <?php
                            if ($product->shortlist_status == 1) {
                                ?>
                                <label class="ps-btn--checkbox ">
                                    <input type="checkbox" id="" name="short_list_ids[]"
                                           value="<?php echo $product->product_id; ?>"
                                           class="checkbox short-list"><span></span>Shortlist
                                    this
                                    Loan
                                </label>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="ps-loan__text1"><?php echo $product->bank_sub_title; ?></div>
                    <div class="ps-loan-content ps-loan-content1">
                        <?php
                        if (!empty($product->ads_placement)) {

                            $ads = json_decode($product->ads_placement);
                            if (!empty($ads[0]->ad_image_horizontal)) {
                                ?>
                                <div class="ps-product__poster"><a
                                        href="<?php echo isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)'; ?>"
                                        target="_blank"><img
                                            src="<?php echo isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : ''; ?>"
                                            alt=""></a></div>
                                <?php
                            }
                        }
                        if ($product->formula_id == LOAN_F1) {
                            ?>
                            <div class="ps-product__table loan_table">
                                <div class="ps-table-wrap">
                                    <table class="ps-table ps-table--product">
                                        <thead>
                                        <tr>
                                            <th>YEARS</th>
                                            <th>INTEREST RATE (PA)</th>
                                            <th>Monthly Installment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($productRanges as $key => $productRange) {
                                            ?>
                                            <tr>
                                                <td class="<?php if ($productRange->tenure_highlight == true && $product->eligible == true) {
                                                    echo 'highlight';
                                                } ?>">
                                                    YEAR <?php echo $productRange->tenure; ?></td>
                                                <td><?php echo $productRange->bonus_interest + $productRange->rate_interest_other; ?>
                                                    %
                                                    <?php
                                                    if (!empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && empty($productRange->rate_interest_other)) {
                                                        echo '= ' . $productRange->floating_rate_type;
                                                    } elseif (empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && !empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other)) {
                                                        echo '= ' . $productRange->bonus_interest . ' %';
                                                        if ($productRange->rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        echo abs($productRange->rate_interest_other) . ' %';
                                                        echo '(' . $productRange->rate_name_other . ')';
                                                    } elseif (!empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && !empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other)) {
                                                        echo '= ' . $productRange->floating_rate_type;
                                                        if ($productRange->rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        echo abs($productRange->rate_interest_other) . ' %';
                                                        echo '(' . $productRange->rate_name_other . ')';
                                                    } elseif (empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && empty($productRange->rate_interest_other)) {
                                                        if
                                                        (empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other)
                                                        ) {
                                                            echo '= ' . $productRange->bonus_interest . ' %';
                                                            if ($productRange->rate_interest_other < 0) {
                                                                echo '-';
                                                            } else {
                                                                echo '+';
                                                            }
                                                            echo abs($productRange->rate_interest_other) . ' %';
                                                        }
                                                    } elseif (empty($productRange->floating_rate_type) && empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other)) {
                                                        if (!empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other))
                                                            echo '= ' . $productRange->floating_rate_type;
                                                        if ($productRange->rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        echo abs($productRange->rate_interest_other) . ' %';
                                                    }
                                                    ?>
                                                </td>
                                                <td class=" <?php if ($productRange->tenure_highlight == true && $product->eligible == true) {
                                                    echo 'highlight';
                                                } ?> ">
                                                    <?php echo '$' . round($productRange->monthly_payment) . ' / mth'; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td class=" <?php if ($product->highlight == true && $product->eligible == true) {
                                                echo 'highlight';
                                            } ?>">THEREAFTER
                                            </td>
                                            <td>
                                                <?php echo($productRanges[0]->there_after_bonus_interest + $productRanges[0]->there_after_rate_interest_other); ?>
                                                %
                                                <?php
                                                if (!empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    echo '= ' . $productRanges[0]->there_after_rate_type;
                                                } elseif (empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && !empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    echo '= ' . $productRanges[0]->there_after_bonus_interest . '%';
                                                    if ($productRange->there_after_rate_interest_other < 0) {
                                                        echo '-';
                                                    } else {
                                                        echo '+';
                                                    }
                                                    echo abs($productRange->there_after_rate_interest_other) . '%';
                                                    echo '(' . $productRanges[0]->there_after_rate_name_other . ')';
                                                } elseif (!empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && !empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    echo '= ' . $productRanges[0]->there_after_rate_type;
                                                    if ($productRange->there_after_rate_interest_other < 0) {
                                                        echo '-';
                                                    } else {
                                                        echo '+';
                                                    }
                                                    echo abs($productRange->there_after_rate_interest_other) . '%';
                                                    echo '(' . $productRanges[0]->there_after_rate_name_other . ')';
                                                } elseif (empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    if
                                                    (empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)
                                                    ) {
                                                        echo '= ' . $productRanges[0]->there_after_bonus_interest . '%';
                                                        if ($productRange->there_after_rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        echo abs($productRange->there_after_rate_interest_other) . '%';
                                                    }
                                                } elseif (empty($productRanges[0]->there_fter_rate_type) && empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    if
                                                    (!empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)
                                                    ) {
                                                        echo '= ' . $productRanges[0]->there_after_rate_type;
                                                        if ($productRange->there_after_rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        abs($productRange->there_after_rate_interest_other) . '%';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class=" <?php if ($product->highlight == true && $product->eligible == true) {
                                                echo 'highlight';
                                            } ?>">
                                                $<?php echo round($product->there_after_installment); ?> / mth
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                            if (isset($ads[1])) {
                                if (!empty($ads[1]->ad_image_vertical)) {
                                    ?>
                                    <div class="ps-product__poster">
                                        <a href="<?php echo isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)'; ?>"
                                           target="_blank"><img class="img-center"
                                                                src="<?php echo isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : ''; ?>"
                                                                alt=""></a>
                                    </div>
                                <?php }
                            }
                            ?>
                            <div class="ps-loan-right <?php if (!$product->eligible) {
                                echo 'disable';
                            } ?>">
                                <h4>For $<?php echo \Helper::inThousand($product->placement); ?> loan
                                    with <?php echo $product->tenure; ?>
                                    years&emsp;Loan Tenure</h4>
                                <?php if (!$product->eligible) { ?>
                                    <p style="color:#303030 !important; padding:15px; font-weight: 800; ">Loan amount is
                                        not eligible for this Loan Package</p>
                                <?php } ?>
                                <div class="width-50">
                                    <p>Rate Type : <br/><strong><?php echo $productRanges[0]->rate_type; ?>
                                            <?php if ($productRanges[0]->rate_type_name) {
                                                echo '(' . $productRanges[0]->rate_type_name . ')';
                                            } ?></strong></p>

                                    <p>Lock In : <br/><strong><?php echo $product->lock_in; ?> Years</strong></p>

                                    <p>Property : <br/><strong><?php echo $productRanges[0]->property_type; ?></strong>
                                    </p>
                                </div>
                                <div class="width-50">
                                    <p>Rate : <br/><strong><?php echo $product->avg_interest; ?>%
                                            (<?php echo $product->avg_tenure; ?>
                                            yrs avg)</strong></p>

                                    <p>Mthly Instalment :<br/>
                                        <strong>$<?php echo round($product->monthly_installment); ?>
                                            (<?php echo $product->avg_tenure; ?>
                                            yrs avg)</strong>
                                    </p>

                                    <p>Minimum Loan :
                                        <br/>
                                        <strong>$<?php echo \Helper::inThousand($product->minimum_loan_amount); ?>
                                        </strong>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    if (!empty($product->ads_placement)) {
                        $ads = json_decode($product->ads_placement);
                        if (!empty($ads[2]->ad_horizontal_image_popup)) {
                            ?>
                            <div class="ps-poster-popup">
                                <div class="close-popup">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                                <a target="_blank"
                                   href="<?php echo isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'; ?>"><img
                                        src="<?php echo isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : ''; ?>"
                                        alt="" target="_blank"></a>
                            </div>
                        <?php }
                    }
                    ?>
                    <div class="ps-product__detail">
                        <?php echo $product->product_footer; ?>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Details<i
                                class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only"
                                                                    href="#">More data<i
                                class="fa fa-angle-down"></i></a></div>
                </div>
                <?php

            }
        } else {
            ?>
            <div class="ps-block--legend-table1 " style="margin-top: 20px;">
                <div class="ps-block__content text-center">
                    <p><?php echo CRITERIA_ERROR; ?></p>
                </div>
            </div>
            <?php
        }
    }

    public function loanLoadMoreById(Request $request)
    {
        parse_str($request->search_form, $searchForm);
        $searchForm['type'] = $request->type;
        $searchForm['page_no'] = $request->page_no;
        $searchForm['product_ids'] = array_collapse($request->product_ids);
        $products = $this->loan($searchForm);
        $j = 1;
        if ($products->count()) {
            foreach ($products as $product) {
                $productRanges = $product->product_range;
                $ads = json_decode($product->ads_placement);
                if (isset($ads[3]->ad_horizontal_image_popup_top)) {
                    ?>
                    <div class="ps-poster-popup">
                        <div class="close-popup">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                        <a href="<?php echo isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)'; ?>"
                           target="_blank"><img
                                src="<?php echo isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : ''; ?>"
                                alt=""></a>
                    </div>
                    <?php
                }
                ?>
                <div class="ps-product loaded <?php if ($product->featured == 1) echo featured - 1; ?>"
                     id="p-<?php echo $product->product_id; ?>">
                    <div class="ps-product__header">
                        <div class="slider-img"><img alt=""
                                                     src="<?php echo asset($product->brand_logo); ?>"></div>
                        <div class="ps-product__promo left">
                            <?php
                            if ($product->shortlist_status == 1) {
                                ?>
                                <label class="ps-btn--checkbox ">
                                    <input type="checkbox" id="" name="short_list_ids[]"
                                           value="<?php echo $product->product_id; ?>"
                                           class="checkbox short-list"><span></span>Shortlist
                                    this
                                    Loan
                                </label>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="ps-loan__text1"><?php echo $product->bank_sub_title; ?></div>
                    <div class="ps-loan-content ps-loan-content1">
                        <?php
                        if (!empty($product->ads_placement)) {

                            $ads = json_decode($product->ads_placement);
                            if (!empty($ads[0]->ad_image_horizontal)) {
                                ?>
                                <div class="ps-product__poster"><a
                                        href="<?php echo isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)'; ?>"
                                        target="_blank"><img
                                            src="<?php echo isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : ''; ?>"
                                            alt=""></a></div>
                                <?php
                            }
                        }
                        if ($product->formula_id == LOAN_F1) {
                            ?>
                            <div class="ps-product__table loan_table">
                                <div class="ps-table-wrap">
                                    <table class="ps-table ps-table--product">
                                        <thead>
                                        <tr>
                                            <th>YEARS</th>
                                            <th>INTEREST RATE (PA)</th>
                                            <th>Monthly Installment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach ($productRanges as $key => $productRange) {
                                            ?>
                                            <tr>
                                                <td class="<?php if ($productRange->tenure_highlight == true && $product->eligible == true) {
                                                    echo 'highlight';
                                                } ?>">
                                                    YEAR <?php echo $productRange->tenure; ?></td>
                                                <td><?php echo $productRange->bonus_interest + $productRange->rate_interest_other; ?>
                                                    %
                                                    <?php
                                                    if (!empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && empty($productRange->rate_interest_other)) {
                                                        echo '= ' . $productRange->floating_rate_type;
                                                    } elseif (empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && !empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other)) {
                                                        echo '= ' . $productRange->bonus_interest . ' %';
                                                        if ($productRange->rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        echo abs($productRange->rate_interest_other) . ' %';
                                                        echo '(' . $productRange->rate_name_other . ')';
                                                    } elseif (!empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && !empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other)) {
                                                        echo '= ' . $productRange->floating_rate_type;
                                                        if ($productRange->rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        echo abs($productRange->rate_interest_other) . ' %';
                                                        echo '(' . $productRange->rate_name_other . ')';
                                                    } elseif (empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && empty($productRange->rate_interest_other)) {
                                                        if
                                                        (empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other)
                                                        ) {
                                                            echo '= ' . $productRange->bonus_interest . ' %';
                                                            if ($productRange->rate_interest_other < 0) {
                                                                echo '-';
                                                            } else {
                                                                echo '+';
                                                            }
                                                            echo abs($productRange->rate_interest_other) . ' %';
                                                        }
                                                    } elseif (empty($productRange->floating_rate_type) && empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other)) {
                                                        if (!empty($productRange->floating_rate_type) && !empty($productRange->bonus_interest) && empty($productRange->rate_name_other) && !empty($productRange->rate_interest_other))
                                                            echo '= ' . $productRange->floating_rate_type;
                                                        if ($productRange->rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        echo abs($productRange->rate_interest_other) . ' %';
                                                    }
                                                    ?>
                                                </td>
                                                <td class=" <?php if ($productRange->tenure_highlight == true && $product->eligible == true) {
                                                    echo 'highlight';
                                                } ?> ">
                                                    <?php echo '$' . round($productRange->monthly_payment) . ' / mth'; ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td class=" <?php if ($product->highlight == true && $product->eligible == true) {
                                                echo 'highlight';
                                            } ?>">THEREAFTER
                                            </td>
                                            <td>
                                                <?php echo($productRanges[0]->there_after_bonus_interest + $productRanges[0]->there_after_rate_interest_other); ?>
                                                %
                                                <?php
                                                if (!empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    echo '= ' . $productRanges[0]->there_after_rate_type;
                                                } elseif (empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && !empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    echo '= ' . $productRanges[0]->there_after_bonus_interest . '%';
                                                    if ($productRange->there_after_rate_interest_other < 0) {
                                                        echo '-';
                                                    } else {
                                                        echo '+';
                                                    }
                                                    echo abs($productRange->there_after_rate_interest_other) . '%';
                                                    echo '(' . $productRanges[0]->there_after_rate_name_other . ')';
                                                } elseif (!empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && !empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    echo '= ' . $productRanges[0]->there_after_rate_type;
                                                    if ($productRange->there_after_rate_interest_other < 0) {
                                                        echo '-';
                                                    } else {
                                                        echo '+';
                                                    }
                                                    echo abs($productRange->there_after_rate_interest_other) . '%';
                                                    echo '(' . $productRanges[0]->there_after_rate_name_other . ')';
                                                } elseif (empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    if
                                                    (empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)
                                                    ) {
                                                        echo '= ' . $productRanges[0]->there_after_bonus_interest . '%';
                                                        if ($productRange->there_after_rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        echo abs($productRange->there_after_rate_interest_other) . '%';
                                                    }
                                                } elseif (empty($productRanges[0]->there_fter_rate_type) && empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)) {
                                                    if
                                                    (!empty($productRanges[0]->there_after_rate_type) && !empty($productRanges[0]->there_after_bonus_interest) && empty($productRanges[0]->there_after_rate_name_other) && !empty($productRanges[0]->there_after_rate_interest_other)
                                                    ) {
                                                        echo '= ' . $productRanges[0]->there_after_rate_type;
                                                        if ($productRange->there_after_rate_interest_other < 0) {
                                                            echo '-';
                                                        } else {
                                                            echo '+';
                                                        }
                                                        abs($productRange->there_after_rate_interest_other) . '%';
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class=" <?php if ($product->highlight == true && $product->eligible == true) {
                                                echo 'highlight';
                                            } ?>">
                                                $<?php echo round($product->there_after_installment); ?> / mth
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php
                            if (isset($ads[1])) {
                                if (!empty($ads[1]->ad_image_vertical)) {
                                    ?>
                                    <div class="ps-product__poster">
                                        <a href="<?php echo isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)'; ?>"
                                           target="_blank"><img class="img-center"
                                                                src="<?php echo isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : ''; ?>"
                                                                alt=""></a>
                                    </div>
                                <?php }
                            }
                            ?>
                            <div class="ps-loan-right <?php if (!$product->eligible) {
                                echo 'disable';
                            } ?>">
                                <h4>For $<?php echo \Helper::inThousand($product->placement); ?> loan
                                    with <?php echo $product->tenure; ?>
                                    years&emsp;Loan Tenure</h4>
                                <?php if (!$product->eligible) { ?>
                                    <p style="color:#303030 !important; padding:15px; font-weight: 800; ">Loan amount is
                                        not eligible for this Loan Package</p>
                                <?php } ?>
                                <div class="width-50">
                                    <p>Rate Type : <br/><strong><?php echo $productRanges[0]->rate_type; ?>
                                            <?php if ($productRanges[0]->rate_type_name) {
                                                echo '(' . $productRanges[0]->rate_type_name . ')';
                                            } ?></strong></p>

                                    <p>Lock In : <br/><strong><?php echo $product->lock_in; ?> Years</strong></p>

                                    <p>Property : <br/><strong><?php echo $productRanges[0]->property_type; ?></strong>
                                    </p>
                                </div>
                                <div class="width-50">
                                    <p>Rate : <br/><strong><?php echo $product->avg_interest; ?>%
                                            (<?php echo $product->avg_tenure; ?>
                                            yrs avg)</strong></p>

                                    <p>Mthly Instalment :<br/>
                                        <strong>$<?php echo round($product->monthly_installment); ?>
                                            (<?php echo $product->avg_tenure; ?>
                                            yrs avg)</strong>
                                    </p>

                                    <p>Minimum Loan :
                                        <br/>
                                        <strong>$<?php echo \Helper::inThousand($product->minimum_loan_amount); ?>
                                        </strong>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <?php
                    if (!empty($product->ads_placement)) {
                        $ads = json_decode($product->ads_placement);
                        if (!empty($ads[2]->ad_horizontal_image_popup)) {
                            ?>
                            <div class="ps-poster-popup">
                                <div class="close-popup">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                                <a target="_blank"
                                   href="<?php echo isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'; ?>"><img
                                        src="<?php echo isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : ''; ?>"
                                        alt="" target="_blank"></a>
                            </div>
                        <?php }
                    }
                    ?>
                    <div class="ps-product__detail">
                        <?php echo $product->product_footer; ?>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Details<i
                                class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only"
                                                                    href="#">More data<i
                                class="fa fa-angle-down"></i></a></div>
                </div>
                <?php

            }
        } else {
            ?>
            <div class="ps-block--legend-table1 " style="margin-top: 20px;">
                <div class="ps-block__content text-center">
                    <p><?php echo CRITERIA_ERROR; ?></p>
                </div>
            </div>
            <?php
        }
    }
}
