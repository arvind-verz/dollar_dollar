<?php

namespace App\Http\Controllers\CMS;

use App\Brand;
use App\Currency;
use App\DefaultSearch;
use App\Http\Controllers\Controller;
use App\Page;
use App\ProductManagement;
use App\PromotionProducts;
use App\systemSettingLegendTable;
use App\ToolTip;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\AdsManagement;

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
            $brands = Brand::where('delete_status', 0)->orderBy('view_order', 'asc')->get();

            if ($page->is_dynamic == 1) {

                if ($slug == CONTACT_SLUG) {
                    return view('frontend.CMS.contact', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == HEALTH_INSURANCE_ENQUIRY) {
                    $redirect_url = 'health-insurance-enquiry';
                    if (Auth::check()) {
                        return view('frontend.CMS.health-insurance-enquiry', compact("brands", "page", "systemSetting", "banners"));
                    } else {
                        return view('auth.login', compact("redirect_url"));
                    }
                } elseif ($slug == LIFE_INSURANCE_ENQUIRY) {
                    $redirect_url = 'life-insurance-enquiry';
                    if (Auth::check()) {
                        return view('frontend.CMS.life-insurance-enquiry', compact("brands", "page", "systemSetting", "banners"));
                    } else {
                        return view('auth.login', compact("redirect_url"));
                    }
                } elseif ($slug == REGISTRATION) {
                    return view('frontend.CMS.registration', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == PROFILEDASHBOARD) {
                    $ads = AdsManagement::where('delete_status', 0)
                        ->where('display', 1)
                        ->where('page', 'account')
                        ->inRandomOrder()
                        ->limit(1)
                        ->get();
                    if (AUTH::check()) {
                        return view('frontend.user.profile-dashboard', compact("brands", "page", "systemSetting", "banners", "user_products", "user_products_ending", "ads"));
                    } else {
                        return redirect('/login');
                    }
                } elseif ($slug == ACCOUNTINFO) {
                    $ads = AdsManagement::where('delete_status', 0)
                        ->where('display', 1)
                        ->where('page', 'account')
                        ->inRandomOrder()
                        ->limit(1)
                        ->get();
                    if (AUTH::check()) {
                        return view('frontend.user.account-information', compact("brands", "page", "systemSetting", "banners", 'ads'));
                    } else {
                        return redirect('/login');
                    }

                } elseif ($slug == PRODUCTMANAGEMENT) {
                    $ads = AdsManagement::where('delete_status', 0)
                        ->where('display', 1)
                        ->where('page', 'account')
                        ->inRandomOrder()
                        ->limit(1)
                        ->get();
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

                } elseif ($slug == WEALTH_DEPOSIT_MODE) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->wealthDepositMode($details);

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

                } elseif ($slug == TERMS_CONDITION) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->termsCondition($details);

                }
                elseif ($slug == FORGOT_PASSWORD) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->forgotPassword($details);

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

                $ads = AdsManagement::where('delete_status', 0)
                    ->where('display', 1)
                    ->where('page', 'blog')
                    ->inRandomOrder()
                    ->limit(1)
                    ->get();

//unserialize tags
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
                $relatedBlog = array_random($relatedBlog, 3);
                return view("frontend.Blog.blog-detail", compact("page", "systemSetting", "banners", "relatedBlog", 'tags', 'ads'));
            } else {
                return view("frontend.CMS.page", compact("page", "systemSetting", "banners"));
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
        return $this->fixed($request = null);
    }

    public function search_fixed_deposit(Request $request)
    {
        return $this->fixed($request->all());
    }

    public function fixed($request)
    {

        $ads_manage = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', FIXED_DEPOSIT_MODE)
            ->inRandomOrder()
            ->limit(1)
            ->get();
//dd($ads_manage);
        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : PLACEMENT;


        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', FIX_DEPOSIT)
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', FIX_DEPOSIT)
            // ->where('promotion_products.formula_id', '=', 6)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

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
                $searchFilter['filter'] = PLACEMENT;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
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
            $product->remaining_days = $remainingDays; // remaining in days
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
                $product->placement = $placement;

                if ($status == true) {
                    //dd($product);
                    $filterProducts[] = $product;
                } else {

                    $remainingProducts[] = $product;
                }
            }

            $placementPeriod = explode("|", $product->promotion_period);

            $maxTenure = 0;
            if (count($placementPeriod)) {
                $placementTenures = [0];
                foreach ($placementPeriod as $period) {
                    $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                }
                $maxTenure = max($placementTenures);
            }
            $product->max_tenure = $maxTenure;


        }
        $remainingProducts = collect($remainingProducts);
        if (count($searchFilter)) {

            $products = collect($filterProducts);
        }

        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $products = $products->sortBy('max_tenure');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $products = $products->sortByDesc('max_tenure');

                }
            }

        }
        if ($remainingProducts->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortBy('max_tenure');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortByDesc('max_tenure');

                }
            }

        }

        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "searchFilter", "legendtable", "remainingProducts", 'ads_manage'));

    }

    public function savingDepositMode()
    {
        return $this->saving([]);
    }

    public function wealthDepositMode($details)
    {
        return $this->wealth([]);
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

    public function getContactForm()
    {
        $page = Page::where('delete_status', 0)->where('slug', CONTACT_SLUG)->first();
        if (!$page) {
            return back()->with('error', OPPS_ALERT);
        }
        $brands = Brand::where('delete_status', 0)->orderBy('view_order', 'asc')->get();

        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            return back()->with('error', OPPS_ALERT);
        }
        $slug = $page->slug;
//get banners
        $banners = \Helper::getBanners($slug);

        return view('frontend.contact', compact("brands", "page", "systemSetting", "banners"));
    }

    public function getBlogByCategories($id = null)
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

        $query = Page::join('menus', 'pages.menu_id', '=', 'menus.id')
            ->where('pages.delete_status', 0)
            ->where('pages.is_blog', 1)
            ->select('pages.*', 'menus.title as menu_title')
            ->orderBy('pages.id', 'DESC');
        if (!is_null($id)) {
            $query = $query->where('pages.menu_id', $id);
        }

        if (Auth::guest()) {
            $details = $query->whereIn('after_login', [0, null])->paginate(5);

        } else {
            $details = $query->paginate(5);
        }

        return view("frontend.Blog.blog-list", compact("details", "page", "banners", 'systemSetting', 'id'));
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
            $details = $sel_query->whereIn('after_login', [0, null])->paginate(5);

        } else {
            $details = $sel_query->paginate(5);
        }
        $id = null;

        return view("frontend.Blog.blog-list", compact("details", "page", "banners", 'systemSetting', 'id'));

    }

    public function search_wealth_deposit(Request $request)
    {
        return $this->wealth($request->all());
    }

    public function wealth($request)
    {
        $ads_manage = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', WEALTH_DEPOSIT_MODE)
            ->inRandomOrder()
            ->limit(1)
            ->get();
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : PLACEMENT;


        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', WEALTH_DEPOSIT)
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', WEALTH_DEPOSIT)
            // ->where('promotion_products.formula_id', '=', 6)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        $details = \Helper::get_page_detail(WEALTH_DEPOSIT_MODE);
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
        //dd($products);
        if (!count($request)) {

            $searchFilter = [];
        } else {
            $searchFilter = $request;
        }
        foreach ($products as $key => &$product) {
            //dd($product);
            $defaultSearch = DefaultSearch::where('promotion_id', WEALTH_DEPOSIT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
            } else {
                $defaultPlacement = 0;
            }
            if (!count($request)) {

                $placement = 0;
                $searchValue = $defaultPlacement;
                $searchFilter['search_value'] = $defaultPlacement;
                $searchFilter['filter'] = PLACEMENT;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
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
            $product->remaining_days = $tenure; // remaining in days
            $status = false;
            $product->max_tenure = 0;

            if (in_array($product->promotion_formula_id, [WEALTH_DEPOSIT_F6])) {
                $tenures = json_decode($product->tenure);
                //including end day so 1 day add in end date
                $remainingDays = $todayDate->diffInDays($endDate); // tenure in days
                $monthSuffix = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
                $product->ads = json_decode($product->ads_placement);

                $product->tenure = $tenures;
                $product->remaining_days = $remainingDays; // remaining in days
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
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;

                if ($status == true) {
                    //dd($product);
                    $filterProducts[] = $product;
                } else {

                    $remainingProducts[] = $product;
                }
            }
            if (in_array($product->promotion_formula_id, [WEALTH_DEPOSIT_F1, WEALTH_DEPOSIT_F2])) {
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
                            $product->max_tenure = $tenure;
                        }

                        $product->total_interest = $productRange->bonus_interest + $productRange->board_rate;
                        $totalInterest = (($placement * $productRange->bonus_interest / 100) * ($tenure / $tenureTotal)) + (($placement * $productRange->board_rate / 100) * ($tenure / $tenureTotal));
                        $product->total_interest_earn = $totalInterest;
                        $product->placement = $placement;


                    }
                }
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;

                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [WEALTH_DEPOSIT_F3])) {

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
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [WEALTH_DEPOSIT_F4])) {
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

                        } elseif($lastCalculatedAmount < $placement) {

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
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;

                if ($status == true) {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
                    $product->highlight = $highlight;
                    $filterProducts[] = $product;
                } else {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
                    $product->highlight = $highlight;
                    $remainingProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [WEALTH_DEPOSIT_F5])) {
                $extraMonth = null;
                $rowHeadings = [CUMMULATED_MONTHLY_SAVINGS_AMOUNT, BASE_INTEREST,
                    ADDITIONAL_INTEREST, TOTAL_AMOUNT];
                $product->highlight = false;
                //dd($productRanges);
                foreach ($productRanges as $productRange) {

                    $months = [1];
                    $allInterests = [$productRange->base_interest, $productRange->bonus_interest];
                    $placement = $productRange->max_range;
                    $searchValue = round($searchValue / ((int)$productRange->placement_month), 2);


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
                    $totalInterestAmount = 0;

                    foreach ($product->months as $month) {
                        $monthlySavingAmount[$month] = $placement * $month;
                    }
                    $monthlySavingAmount[] = $placement * end($months);

                    for ($i = 1; $i <= ($productRange->placement_month); $i++) {

                        $baseInterest = round($productRange->base_interest * $placement * $i * 31 / (365 * 100), 2);
                        $AdditionalInterest = round($productRange->bonus_interest * ($placement + $baseInterest) * $i * 31 / (365 * 100), 2);
                        if (in_array($i, $product->months)) {
                            $baseInterests[$i] = $baseInterest;
                            $additionalInterests[$i] = $AdditionalInterest;
                        }
                    }
                    $baseInterests[] = array_sum($baseInterests);
                    $additionalInterests[] = array_sum($additionalInterests);
                    $totalInterestAmount = end($baseInterests) + end($additionalInterests);
                    $product->row_headings = $rowHeadings;
                    $product->monthly_saving_amount = $monthlySavingAmount;
                    $product->base_interests = $baseInterests;
                    $product->additional_interests = $additionalInterests;
                    $product->total_interest_earn = $totalInterestAmount + ($placement * $productRange->placement_month);
                    $product->placement = $placement;
                    $product->total_interest = 0;
                }
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }

            }
        }
        $remainingProducts = collect($remainingProducts);
        if (count($searchFilter)) {
            $products = collect($filterProducts);
        }
        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $products = $products->sortBy('max_tenure');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $products = $products->sortByDesc('max_tenure');

                }
            }

        }
        if ($remainingProducts->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortBy('max_tenure');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortByDesc('max_tenure');

                }
            }

        }
        return view('frontend.products.wealth-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "searchFilter", "legendtable", "ads_manage", "remainingProducts"));

    }

    public function search_saving_deposit(Request $request)
    {
        return $this->saving($request->all());
    }

    public function saving($request)
    {
        //dd($request);
        $ads_manage = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', SAVING_DEPOSIT_MODE)
            ->inRandomOrder()
            ->limit(1)
            ->get();
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : PLACEMENT;


        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', SAVING_DEPOSIT)
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', SAVING_DEPOSIT)
            //->where('promotion_products.formula_id', '=', 2)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
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
                $searchFilter['filter'] = PLACEMENT;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
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
            $product->remaining_days = $tenure; // remaining in days
            $status = false;
            $product->max_tenure = 0;

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
                            //$product->max_tenure = $tenure;
                        }

                        $product->total_interest = $productRange->bonus_interest + $productRange->board_rate;
                        $totalInterest = (($placement * $productRange->bonus_interest / 100) * ($tenure / $tenureTotal)) + (($placement * $productRange->board_rate / 100) * ($tenure / $tenureTotal));
                        $product->total_interest_earn = round($totalInterest, 2);
                        $product->placement = $placement;
                        //dd($totalInterest);
                    }
                }

                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;

                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
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
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;

                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
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
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;

                if ($status == true) {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
                    $product->highlight = $highlight;
                    $filterProducts[] = $product;
                } else {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
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
                    $searchValue = round($searchValue / ((int)$productRange->placement_month), 2);


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
                    $totalInterestAmount = 0;

                    foreach ($product->months as $month) {
                        $monthlySavingAmount[$month] = $placement * $month;
                    }
                    $monthlySavingAmount[] = $placement * end($months);

                    for ($i = 1; $i <= ($productRange->placement_month); $i++) {

                        $baseInterest = round($productRange->base_interest * $placement * $i * 31 / (365 * 100), 2);
                        $AdditionalInterest = round($productRange->bonus_interest * ($placement + $baseInterest) * $i * 31 / (365 * 100), 2);
                        if (in_array($i, $product->months)) {
                            $baseInterests[$i] = $baseInterest;
                            $additionalInterests[$i] = $AdditionalInterest;
                        }
                    }
                    $baseInterests[] = array_sum($baseInterests);
                    $additionalInterests[] = array_sum($additionalInterests);
                    $totalInterestAmount = end($baseInterests) + end($additionalInterests);
                    $product->row_headings = $rowHeadings;
                    $product->monthly_saving_amount = $monthlySavingAmount;
                    $product->base_interests = $baseInterests;
                    $product->additional_interests = $additionalInterests;
                    $product->total_interest_earn = $totalInterestAmount + ($placement * $productRange->placement_month);
                    $product->placement = $placement;
                    $product->total_interest = 0;
                }
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }

            }
        }
        $remainingProducts = collect($remainingProducts);
        if (count($searchFilter)) {
            $products = collect($filterProducts);
        }
        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $products = $products->sortBy('max_tenure');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $products = $products->sortByDesc('max_tenure');

                }
            }

        }
        if ($remainingProducts->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortBy('max_tenure');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortByDesc('max_tenure');

                }
            }

        }
        return view('frontend.products.saving-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "searchFilter", "legendtable", "remainingProducts", "ads_manage"));
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
            return $this->wealth($request);
        } elseif ($account_type == 4) {
            return $this->foreign_currency($request);
        } elseif ($account_type == 5) {
            return $this->aio($request);
        }
    }

    public function search_foreign_currency_deposit(Request $request)
    {
        return $this->foreign_currency($request);
    }

    public function foreign_currency($request)
    {
        $ads_manage = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', FOREIGN_CURRENCY_DEPOSIT_MODE)
            ->inRandomOrder()
            ->limit(1)
            ->get();
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $currency = isset($request['currency']) ? $request['currency'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : PLACEMENT;


        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', FOREIGN_CURRENCY_DEPOSIT)
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->leftJoin('currency', 'promotion_products.currency', '=', 'currency.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', FOREIGN_CURRENCY_DEPOSIT)
            // ->where('promotion_products.formula_id', '=', 6)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*', 'currency.code as currency_code', 'currency.icon as currency_icon', 'currency.currency as currency_namer')
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
        //dd($products);
        if (!count($request)) {

            $searchFilter = [];
        } else {
            $searchFilter = $request;
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
                $searchFilter['filter'] = PLACEMENT;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
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
            $product->remaining_days = $tenure; // remaining in days
            $status = false;
            $product->max_tenure = 0;

            if (in_array($product->promotion_formula_id, [FOREIGN_CURRENCY_DEPOSIT_F1])) {
                $tenures = json_decode($product->tenure);
                //including end day so 1 day add in end date
                $remainingDays = $todayDate->diffInDays($endDate); // tenure in days
                $monthSuffix = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
                $product->ads = json_decode($product->ads_placement);

                $product->tenure = $tenures;
                $product->remaining_days = $remainingDays; // remaining in days
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
                                    if ((is_null($brandId) || ($brandId == $product->bank_id)) && (is_null($currency) || ($currency == $product->currency))) {
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
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;
                if ($status == true) {
                    //dd($product);
                    $filterProducts[] = $product;
                } else {

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
                            if ((is_null($brandId) || ($brandId == $product->bank_id)) && (is_null($currency) || ($currency == $product->currency))) {
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
                            $product->max_tenure = $tenure;
                        }

                        $product->total_interest = $productRange->bonus_interest + $productRange->board_rate;
                        $totalInterest = (($placement * $productRange->bonus_interest / 100) * ($tenure / $tenureTotal)) + (($placement * $productRange->board_rate / 100) * ($tenure / $tenureTotal));
                        $product->total_interest_earn = round($totalInterest, 2);
                        $product->placement = $placement;
                        //dd($product);
                    }
                }
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;

                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
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
                            if ((is_null($brandId) || ($brandId == $product->bank_id)) && (is_null($currency) || ($currency == $product->currency))) {
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
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
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

                        } elseif($lastCalculatedAmount < $placement) {
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
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;

                if ($status == true) {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
                    $product->highlight = $highlight;
                    $filterProducts[] = $product;
                } else {
                    $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
                    $product->total_interest_earn = array_sum($interestEarns);
                    $product->placement = $placement;
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
                    $searchValue = round($searchValue / ((int)$productRange->placement_month), 2);


                    if (count($searchFilter)) {

                        if ($searchValue >= $productRange->min_range) {
                            if ($searchValue >= $productRange->max_range) {
                                $placement = $productRange->max_range;
                            } else {
                                $placement = $searchValue;
                            }
                            if ((is_null($brandId) || ($brandId == $product->bank_id)) && (is_null($currency) || ($currency == $product->currency))) {
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
                    $totalInterestAmount = 0;

                    foreach ($product->months as $month) {
                        $monthlySavingAmount[$month] = $placement * $month;
                    }
                    $monthlySavingAmount[] = $placement * end($months);

                    for ($i = 1; $i <= ($productRange->placement_month); $i++) {

                        $baseInterest = round($productRange->base_interest * $placement * $i * 31 / (365 * 100), 2);
                        $AdditionalInterest = round($productRange->bonus_interest * ($placement + $baseInterest) * $i * 31 / (365 * 100), 2);
                        if (in_array($i, $product->months)) {
                            $baseInterests[$i] = $baseInterest;
                            $additionalInterests[$i] = $AdditionalInterest;
                        }
                    }
                    $baseInterests[] = array_sum($baseInterests);
                    $additionalInterests[] = array_sum($additionalInterests);
                    $totalInterestAmount = end($baseInterests) + end($additionalInterests);
                    $product->row_headings = $rowHeadings;
                    $product->monthly_saving_amount = $monthlySavingAmount;
                    $product->base_interests = $baseInterests;
                    $product->additional_interests = $additionalInterests;
                    $product->total_interest_earn = $totalInterestAmount + ($placement * $productRange->placement_month);
                    $product->placement = $placement;
                    $product->total_interest = 0;
                }
                $placementPeriod = explode("|", $product->promotion_period);

                $maxTenure = 0;
                if (count($placementPeriod)) {
                    $placementTenures = [0];
                    foreach ($placementPeriod as $period) {
                        $placementTenures[] = (int)filter_var($period, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    }
                    $maxTenure = max($placementTenures);
                }
                $product->max_tenure = $maxTenure;
                if ($status == true) {
                    $filterProducts[] = $product;
                } else {
                    $remainingProducts[] = $product;
                }

            }
        }
        $remainingProducts = collect($remainingProducts);
        if (count($searchFilter)) {
            $products = collect($filterProducts);
        }
        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $products = $products->sortBy('max_tenure');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $products = $products->sortByDesc('max_tenure');

                }
            }

        }
        if ($remainingProducts->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortBy('max_tenure');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('upto_interest_rate');
                } elseif ($filter == TENURE) {
                    $remainingProducts = $remainingProducts->sortByDesc('max_tenure');

                }
            }

        }
        return view('frontend.products.foreign-currency-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "searchFilter", "legendtable", "ads_manage", "remainingProducts", "currencies"));

    }

    public
    function search_aioa_deposit(Request $request)
    {
        return $this->aio($request->all());
    }

    public
    function aio($request)
    {
        //dd($request);
        $ads_manage = AdsManagement::where('delete_status', 0)
            ->where('display', 1)
            ->where('page', 'product')
            ->where('page_type', AIO_DEPOSIT_MODE)
            ->inRandomOrder()
            ->limit(1)
            ->get();
        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : PLACEMENT;

        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', ALL_IN_ONE_ACCOUNT)
            ->where('delete_status', 0)
            ->get();
        $toolTips = ToolTip::where('promotion_id', ALL_IN_ONE_ACCOUNT)->first();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            //->where('promotion_products.formula_id', '=', 7)
            ->where('promotion_formula.promotion_id', '=', ALL_IN_ONE_ACCOUNT)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
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
        foreach ($promotion_products as $key => $product) {
            $defaultSearch = DefaultSearch::where('promotion_id', ALL_IN_ONE_ACCOUNT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
                $defaultSalary = $defaultSearch->salary;
                $defaultGiro = $defaultSearch->payment;
                $defaultSpend = $defaultSearch->spend;
                $defaultLoan = $defaultSearch->loan;
                $defaultWealth = $defaultSearch->wealth;

            } else {
                $defaultPlacement = 0;
                $defaultSalary = 0;
                $defaultGiro = 0;
                $defaultSpend = 0;
                $defaultLoan = 0;
                $defaultWealth = 0;

            }
            if (!count($request)) {
                $placement = 0;
                $searchValue = $defaultPlacement;
                $salary = $defaultSalary;
                $giro = $defaultGiro;
                $spend = $defaultSpend;
                $loan = $defaultLoan;
                $wealth = $defaultWealth;
                $searchFilter['search_value'] = $defaultPlacement;
                $searchFilter['salary'] = $defaultSalary;
                $searchFilter['giro'] = $defaultGiro;
                $searchFilter['spend'] = $defaultSpend;
                $searchFilter['wealth'] = $defaultLoan;
                $searchFilter['loan'] = $defaultWealth;
                $searchFilter['filter'] = PLACEMENT;
                $searchFilter['sort_by'] = MAXIMUM;
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = str_replace(',', '', $searchFilter['search_value']);
                $searchFilter['search_value'] = $searchValue;
                $salary = $searchFilter['salary'] = isset($searchFilter['salary']) ? (int)$searchFilter['salary'] : $defaultSalary;
                $giro = $searchFilter['giro'] = isset($searchFilter['giro']) ? (int)$searchFilter['giro'] : $defaultGiro;
                $spend = $searchFilter['spend'] = isset($searchFilter['spend']) ? (int)$searchFilter['spend'] : $defaultSpend;
                $loan = $searchFilter['loan'] = isset($searchFilter['loan']) ? (int)$searchFilter['loan'] : $defaultLoan;
                $wealth = $searchFilter['wealth'] = isset($searchFilter['wealth']) ? (int)$searchFilter['wealth'] : $defaultWealth;
                $searchFilter['filter'] = $searchFilter['filter'] ? $searchFilter['filter'] : PLACEMENT;

            }
            $status = false;
            $productRanges = json_decode($product->product_range);
            //dd($searchFilter);
            if ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F1) {
                $totalInterests = [];
                $interestEarns = [];
                $product->highlight = false;
                $product->salary_highlight = false;
                $product->payment_highlight = false;
                $product->spend_highlight = false;
                $product->wealth_highlight = false;
                $product->loan_highlight = false;
                $product->bonus_highlight = false;
                $criteriaMatchCount = 0;

                foreach ($productRanges as $k => $productRange) {
                    //dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_salary,
                        $productRange->bonus_interest_giro_payment,
                        $productRange->bonus_interest_spend,
                        $productRange->bonus_interest_wealth,
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
                        if ($salary > 0 && $productRange->minimum_salary <= $salary) {
                            $product->salary_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_salary;
                            $criteriaMatchCount++;
                        }
                        if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                            $product->payment_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_giro_payment;
                            $criteriaMatchCount++;
                        }
                        if ($spend > 0 && $productRange->minimum_spend <= $spend) {
                            $product->spend_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_spend;
                            $criteriaMatchCount++;
                        }
                        if ($wealth > 0 && $productRange->minimum_wealth_pa <= $wealth / 12) {
                            $product->wealth_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_wealth;
                            $criteriaMatchCount++;
                        }
                        if ($placement > 0 && $productRange->bonus_amount <= $placement) {
                            $product->bonus_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest;
                            $criteriaMatchCount++;
                        }
                    }
                    if ($criteriaMatchCount == 0) {
                        $status = false;
                        $totalInterest = $productRange->bonus_interest_salary + $productRange->bonus_interest_giro_payment + $productRange->bonus_interest_spend +
                            $productRange->bonus_interest_wealth;
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
                if (($spend >= $productRanges[0]->minimum_spend) && ($salary >= $productRanges[0]->minimum_salary || $giro >= $productRanges[0]->minimum_giro_payment)) {
                    $criteriaMatchCount = 1;
                    if ($salary >= $productRanges[0]->minimum_salary) {
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

                $product->total_interest = round(array_sum($totalInterests) / count($totalInterests), 2);
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
                        }
                        if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                            $criteriaMatchCount++;
                        }
                        if ($spend > 0 && $productRange->minimum_spend <= $spend) {
                            $criteriaMatchCount++;
                        }
                        if ($wealth > 0 && $productRange->minimum_insurance <= ($wealth / 12)) {
                            $criteriaMatchCount++;
                            $product->life_insurance = true;
                        }
                        if ($wealth > 0 && $productRange->minimum_unit_trust <= ($wealth / 12)) {
                            $criteriaMatchCount++;
                            $product->unit_trust = true;
                        }
                        if ($loan > 0 && $productRange->minimum_hire_purchase_loan <= ($loan)) {
                            $criteriaMatchCount++;
                            $product->hire_loan = true;

                        }
                        if ($loan > 0 && $productRange->minimum_renovation_loan <= ($loan)) {
                            $criteriaMatchCount++;
                            $product->renovation_loan = true;
                        }
                        if ($loan > 0 && $productRange->minimum_home_loan <= ($loan)) {
                            $criteriaMatchCount++;
                            $product->housing_loan = true;
                        }
                        if ($loan > 0 && $productRange->minimum_education_loan <= ($loan)) {
                            $criteriaMatchCount++;
                            $product->education_loan = true;
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
                if ($salary > 0 && $baseDetail->minimum_salary <= $salary) {
                    $criteriaCount++;
                    if ($spend > 0 && $baseDetail->minimum_spend <= $spend) {
                        $criteriaCount++;
                        $criteriaMatchCount++;
                    }
                    if ($spend > 0 && $baseDetail->minimum_insurance <= ($wealth / 2)) {
                        $criteriaCount++;
                        $criteriaMatchCount++;
                    }
                    if ($spend > 0 && $baseDetail->minimum_investment <= ($wealth / 2)) {
                        $criteriaCount++;
                        $criteriaMatchCount++;
                    }
                    if ($loan > 0 && $baseDetail->minimum_home_loan <= $loan) {
                        $criteriaCount++;
                        $criteriaMatchCount++;
                    }

                    if ($criteriaMatchCount == 1) {
                        $status = true;
                        $criteria = "bonus_interest_criteria_a";
                        $highlight = "criteria_a_highlight";

                    } elseif ($criteriaMatchCount >= 2) {
                        $status = true;
                        $criteria = "bonus_interest_criteria_b";
                        $highlight = "criteria_b_highlight";

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
                    foreach ($productRanges as $key => $productRange) {
                        $allInterests = [
                            $productRange->bonus_interest_criteria_a,
                            $productRange->bonus_interest_criteria_b,
                        ];

                        $maxRanges[] = $productRange->max_range;
                        if ($searchValue >= $productRange->min_range && $status == true) {
                            if ($searchValue > 0) {
                                $placement = (int)$searchValue / 12;
                            } else {
                                $placement = (int)$searchValue;
                            }
                        } elseif (empty($placement) && (count($productRanges) - 1) == ($key)) {
                            $placement = $productRange->min_range;
                            $criteria = "bonus_interest_criteria_b";
                            $criteriaCount = 5;
                            $status = false;
                        }
                    }
                }
                //dd($placement);
                if ($placement > 0) {
                    foreach ($productRanges as $productRange) {
                        $productRange->criteria_a_highlight = false;
                        $productRange->criteria_b_highlight = false;
                        if ($placement >= $productRange->min_range && $placement <= $productRange->max_range) {
                            $productRange->$highlight = true;
                            $totalInterest = $productRange->$criteria;
                            $interestEarn = round(($placement * 12) * ($totalInterest / 100), 2);
                        }
                    }

                }
                $product->total_interest = $totalInterest;
                $product->interest_earned = $interestEarn;
                $product->placement = $placement * 12;
                $product->product_range = $productRanges;
                $product->criteriaCount = $criteriaCount;
                if ($status == true) {
                    $product->highlight = true;
                    $filterProducts[] = $product;
                } elseif ($status == false) {
                    $remainingProducts[] = $product;
                }
            }
        }
        $products = collect($filterProducts);
        $remainingProducts = collect($remainingProducts);
        //dd($sortBy,$filter);
        if ($products->count()) {
            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $products = $products->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('upto_interest_rate');
                } elseif ($filter == CRITERIA) {
                    $products = $products->sortBy('promotion_period');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $products = $products->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('upto_interest_rate');
                } elseif ($filter == CRITERIA) {
                    $products = $products->sortByDesc('promotion_period');
                }
            }
        }
        if ($remainingProducts->count()) {
            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortBy('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortBy('upto_interest_rate');
                } elseif ($filter == CRITERIA) {
                    $remainingProducts = $remainingProducts->sortBy('promotion_period');
                }
            } else {
                if ($filter == PLACEMENT) {
                    $remainingProducts = $remainingProducts->sortByDesc('minimum_placement_amount');
                } elseif ($filter == INTEREST) {
                    $remainingProducts = $remainingProducts->sortByDesc('upto_interest_rate');
                } elseif ($filter == CRITERIA) {
                    $remainingProducts = $remainingProducts->sortByDesc('promotion_period');
                }
            }
        }

        //dd($products);
        return view('frontend.products.aio-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "remainingProducts", "searchFilter", "legendtable", "ads_manage","toolTips"));
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
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
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
                $defaultWealth = $defaultSearch->wealth;

            } else {
                $defaultPlacement = 0;
                $defaultSalary = 0;
                $defaultGiro = 0;
                $defaultSpend = 0;
                $defaultLoan = 0;
                $defaultWealth = 0;

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
                $minimumInsurance = ((int)$searchDetail['wealth']) / 12;
                $minimumUnitTrust = ((int)$searchDetail['wealth']) / 12;
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
                        }
                        if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                            $criteriaMatchCount++;
                        }
                        if ($spend > 0 && $productRange->minimum_spend <= $spend) {
                            $criteriaMatchCount++;
                        }
                        if ((isset($checkBoxDetail['life_insurance'])) && ($minimumInsurance > 0 && $productRange->minimum_insurance <= ($minimumInsurance))) {
                            $criteriaMatchCount++;
                            $product->life_insurance = true;
                        }
                        if ((isset($checkBoxDetail['unit_trust'])) && ($minimumUnitTrust > 0 && $productRange->minimum_unit_trust <= ($minimumUnitTrust))) {

                            $criteriaMatchCount++;
                            $product->unit_trust = true;
                        }
                        if ((isset($checkBoxDetail['hire_loan'])) && ($minimumHirePurchaseLoan > 0 && $productRange->minimum_hire_purchase_loan <= ($minimumHirePurchaseLoan))) {
                            $criteriaMatchCount++;
                            $product->hire_loan = true;
                        }
                        if ((isset($checkBoxDetail['renovation_loan'])) && ($minimumRenovationLoan > 0 && $productRange->minimum_renovation_loan <= ($minimumRenovationLoan))) {
                            $criteriaMatchCount++;
                            $product->renovation_loan = true;
                        }
                        if ((isset($checkBoxDetail['housing_loan'])) && ($minimumHomeLoan > 0 && $productRange->minimum_home_loan <= ($minimumHomeLoan))) {
                            $criteriaMatchCount++;
                            $product->housing_loan = true;
                        }
                        if ((isset($checkBoxDetail['education_loan'])) && ($minimumEducationLoan > 0 && $productRange->minimum_education_loan <= ($minimumEducationLoan))) {
                            $criteriaMatchCount++;
                            $product->education_loan = true;
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
                <form id="form-<?php echo $product->product_id; ?>" class="ps-form--filter" method="post">
                    <table class="ps-table ps-table--product ps-table--product-3">
                        <thead>
                        <tr>
                            <th>CRITERIA</th>
                            <th>SALARY</th>
                            <th>Giro</th>
                            <th>SPEND</th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox"
                                           data-product-id="<?php echo $product->product_id; ?>"
                                           data-status="<?php echo $highlightStatus; ?>"
                                           name="life_insurance" onchange="changeCriteria(this);"
                                        <?php if ($product->life_insurance) {
                                            echo "checked = checked";
                                        } ?> value="true" id="life-insurance-<?php echo $product->product_id; ?>"/>
                                    <label for="life-insurance-<?php echo $product->product_id; ?>">Life
                                        Insurance</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" onchange="changeCriteria(this);"
                                        <?php if ($product->housing_loan) {
                                            echo "checked = checked";
                                        } ?>
                                           name="housing_loan"
                                           data-status="<?php echo $highlightStatus; ?>"
                                           data-product-id="<?php echo $product->product_id; ?>"
                                           value="true" id="housing-loan-<?php echo $product->product_id; ?>">
                                    <label for="housing-loan-<?php echo $product->product_id; ?>">Housing Loan</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox"
                                           data-status="<?php echo $highlightStatus; ?>"
                                           name="education_loan" onchange="changeCriteria(this);"
                                           data-product-id="<?php echo $product->product_id; ?>"
                                           value="true" id='education-loan-<?php echo $product->product_id; ?>'
                                        <?php if ($product->education_loan) {
                                            echo "checked = checked";
                                        } ?>/>
                                    <label for="education-loan-<?php echo $product->product_id; ?>">Education
                                        Loan</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" onchange="changeCriteria(this);"
                                           name="hire_loan" value="true"
                                           data-status="<?php echo $highlightStatus; ?>"
                                           data-product-id="<?php echo $product->product_id; ?>"
                                           id="hire-loan-<?php echo $product->product_id; ?>"
                                        <?php if ($product->hire_loan) {
                                            echo "checked = checked";
                                        } ?>/>
                                    <label for="hire-loan-<?php echo $product->product_id; ?>">Hire Purchase
                                        loan</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox"
                                           data-status="<?php echo $highlightStatus; ?>"
                                           name="renovation_loan" onchange="changeCriteria(this);"
                                           data-product-id="<?php echo $product->product_id; ?>"
                                           value="true" id="renovation-loan-<?php echo $product->product_id; ?>"
                                        <?php if ($product->renovation_loan) {
                                            echo "checked = checked";
                                        } ?>/>
                                    <label for="renovation-loan-<?php echo $product->product_id; ?>">Renovation
                                        loan</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" onchange="changeCriteria(this);"
                                           name="unit_trust" value="true"
                                           data-status="<?php echo $highlightStatus; ?>"
                                           data-product-id="<?php echo $product->product_id; ?>"
                                           id="unit-trust-<?php echo $product->product_id; ?>"
                                        <?php if ($product->unit_trust) {
                                            echo "checked = checked";
                                        } ?>/>
                                    <label for="unit-trust-<?php echo $product->product_id; ?>">Unit Trust</label>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($productRanges as $range) { ?>
                            <tr>
                                <td>Bonus Interest PA</td>
                                <td class="text-center <?php if ($product->criteria_1 == true) {
                                    echo "highlight";
                                } ?> "
                                    colspan="3">1 Criteria Met
                                    - <?php if ($range->bonus_interest_criteria1 <= 0) {
                                        echo "-";
                                    } else {
                                        echo "$range->bonus_interest_criteria1" . '%';
                                    } ?>
                                </td>
                                <td class=" text-center  <?php if ($product->criteria_2 == true) {
                                    echo "highlight";
                                } ?> "
                                    colspan="3">2 Criteria
                                    - <?php if ($range->bonus_interest_criteria2 <= 0) {
                                        echo "-";
                                    } else {
                                        echo "$range->bonus_interest_criteria2" . '%';
                                    } ?>

                                </td>
                                <td class="text-center  <?php if ($product->criteria_3 == true) {
                                    echo "highlight";
                                } ?>"
                                    colspan="3">3 Criteria - <?php if ($range->bonus_interest_criteria3 <= 0) {
                                        echo " - ";
                                    } else {
                                        echo "$range->bonus_interest_criteria3" . '%';
                                    } ?>

                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Total Bonus Interest Earned for
                                    <?php echo "$" . \Helper::inThousand($range->placement); ?>
                                </td>
                                <td class=" text-center <?php if ($product->highlight == true) {
                                    echo 'highlight';
                                } ?>"
                                    colspan="8">

                                    <?php if ($range->placement > $range->first_cap_amount) {
                                        echo "First ";
                                        echo "$" . \Helper::inThousand($range->first_cap_amount) . ' - ' .
                                            '$' . \Helper::inThousand(($range->first_cap_amount * ($product->total_interest / 100))) .
                                            ' (' . $product->total_interest . '%), next $' .
                                            \Helper::inThousand(($range->placement - $range->first_cap_amount)) . ' - '
                                            . '$' . \Helper::inThousand((($range->bonus_interest_remaining_amount / 100) * ($range->placement - $range->first_cap_amount))) .
                                            ' (' . $range->bonus_interest_remaining_amount . '%) Total = $'
                                            . \Helper::inThousand($product->interest_earned);
                                    } else {
                                        echo "Total = $" . \Helper::inThousand($product->interest_earned);
                                    } ?>
                                </td>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </form>
                <?php

            }
        }

    }

    public function forgotPassword($details)
    {
//        $details = \Helper::get_page_detail(TERMS_CONDITION);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        return view('frontend.user.forgot-password', compact("brands", "page", "systemSetting", "banners"));
    }
}
