<?php

namespace App\Http\Controllers\CMS;

use App\Brand;
use App\Currency;
use App\Http\Controllers\Controller;
use App\Page;
use App\ProductManagement;
use App\PromotionProducts;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DateTime;

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
        $user_products = ProductManagement::join('brands', 'product_managements.bank_id', '=', 'brands.id')
            ->get();
//dd($user_products);

        DB::enableQueryLog();
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

            $slug = $page->slug;
//get banners
            $banners = \Helper::getBanners($slug);

//get slug
            $brands = Brand::where('delete_status', 0)->orderBy('view_order', 'asc')->get();

            if ($page->is_dynamic == 1) {

                if ($slug == CONTACT_SLUG) {
                    return view('frontend.CMS.contact', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == HEALTH_INSURANCE_ENQUIRY) {
                    return view('frontend.CMS.health-insurance-enquiry', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == LIFE_INSURANCE_ENQUIRY) {
                    return view('frontend.CMS.life-insurance-enquiry', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == REGISTRATION) {
                    return view('frontend.CMS.registration', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == PROFILEDASHBOARD) {
                    if (AUTH::check()) {
                        return view('frontend.user.profile-dashboard', compact("brands", "page", "systemSetting", "banners"));
                    } else {
                        return redirect('/login');
                    }
                } elseif ($slug == ACCOUNTINFO) {
                    if (AUTH::check()) {
                        return view('frontend.user.account-information', compact("brands", "page", "systemSetting", "banners"));
                    } else {
                        return redirect('/login');
                    }

                } elseif ($slug == PRODUCTMANAGEMENT) {
                    if (AUTH::check()) {
                        return view('frontend.user.product-management', compact("brands", "page", "systemSetting", "banners", "user_products"));
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
                        if (count(array_intersect($page->tags, $detail->tags))) {
                            $relatedBlog[] = $detail;
                        }
                    }
                }
                return view("frontend.Blog.blog-detail", compact("page", "systemSetting", "banners", "relatedBlog", 'tags'));
            } else {
                return view("frontend.CMS.page", compact("page", "systemSetting", "banners"));
            }
        }

    }

    public function fixDepositMode($details)
    {

        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();
//dd($startDate);
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 1)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->get();
//dd(DB::getQueryLog());
        //dd($page);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "slider_products"));
    }

    public function savingDepositMode()
    {
        return $this->saving([]);
    }

    public function wealthDepositMode($details)
    {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 4)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

//dd(DB::getQueryLog());
        //dd($promotion_products);
        $details = \Helper::get_page_detail(WEALTH_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        return view('frontend.products.wealth-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products"));
    }

    public function foreignCurrencyDepositMode($details)
    {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();
//dd($startDate);
        DB::connection()->enableQueryLog();
        $currency_list = Currency::get();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 5)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

//dd(DB::getQueryLog());
        //dd($promotion_products);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        return view('frontend.products.foreign-currency-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "currency_list"));
    }

    public function aioDepositMode($details)
    {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();
        DB::connection()->enableQueryLog();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 3)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        $filterProducts = [];
        foreach ($promotion_products as &$product) {
            $status = false;
            $placement = 0;
            $productRanges = json_decode($product->product_range);

            if ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F1) {
                foreach ($productRanges as &$productRange) {
// dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_salary,
                        $productRange->bonus_interest_giro_payment,
                        $productRange->bonus_interest_spend,
                        $productRange->bonus_interest_wealth,
                        $productRange->bonus_interest_loan,
                        $productRange->bonus_interest,
                        $productRange->bonus_interest_remaining_amount,
                    ];

                    $placement = $productRange->bonus_amount;

                    $totalInterest = array_sum($allInterests);
                    $productRange->total_interest = $totalInterest;
                    if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                        $productRange->total_interest_earned = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                    } else {
                        $productRange->total_interest_earned = $placement * ($totalInterest / 100);
                    }
                    $productRange->placement = $placement;

                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F2) {
//dd($productRanges);
                $maxRanges = [];
                $totalInterests = [];
                $interestEarns = [];
                $lastCalculatedAmount = 0;
                foreach ($productRanges as &$productRange) {
                    $productRange->above_range = false;
                    $maxRanges[] = $productRange->max_range;
                    $totalInterests[] = $productRange->bonus_interest_criteria_b;
                    $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_criteria_b / 100), 2);
                    $productRange->interest_earn = $interestEarn;
                    $productRange->criteria = $productRange->bonus_interest_criteria_b;
                    $interestEarns[] = $interestEarn;
                    $lastCalculatedAmount = $productRange->max_range;

                }

                $product->total_interest = array_sum($totalInterests);
                $product->interest_earned = array_sum($interestEarns);
                $product->placement = array_last(array_sort($maxRanges));

            }
            if ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F3) {
                foreach ($productRanges as &$productRange) {
//dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_criteria1,
                        $productRange->bonus_interest_criteria2,
                        $productRange->bonus_interest_criteria3,
                    ];

                    $placement = $productRange->first_cap_amount;

                    $totalInterest = $productRange->bonus_interest_criteria3;
                    $productRange->total_interest = $totalInterest;
                    if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                        $productRange->total_interest_earned = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                    } else {
                        $productRange->total_interest_earned = $placement * ($totalInterest / 100);
                    }
                    $productRange->placement = $placement;

                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F4) {
//dd($productRanges);
                $maxRanges = [];
                $totalInterests = [];
                $interestEarns = [];
                $lastCalculatedAmount = 0;
                /*foreach ($productRanges as &$productRange) {
                $productRange->above_range = false;
                $maxRanges[] = $productRange->max_range;
                $totalInterests[] = $productRange->bonus_interest_criteria_b;
                $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_criteria_b / 100), 2);
                $productRange->interest_earn = $interestEarn;
                $productRange->criteria = $productRange->bonus_interest_criteria_b;
                $interestEarns[] = $interestEarn;
                $lastCalculatedAmount = $productRange->max_range;

                }*/
                $lastRange = array_last($productRanges);
                $product->placement = $lastRange->max_range;
                $product->total_interest = $lastRange->bonus_interest_criteria_b;
                $product->total_interest_earned = $lastRange->min_range * ($lastRange->bonus_interest_criteria_b / 100);

            }
            $product->product_range = $productRanges;

        }

//dd(DB::getQueryLog());
        //dd($promotion_products);
        $details = \Helper::get_page_detail(AIO_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        return view('frontend.products.aio-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products"));
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
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();

        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';
        $sort_by = isset($request['sort_by']) ? $request['sort_by'] : '';

        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 4)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        $details = \Helper::get_page_detail(WEALTH_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = $filterNewProducts = [];
        //dd($promotion_products);
        foreach ($promotion_products as $product) {
            $status = false;
            $product_range = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            $P = $request['search_value'];
            //dd($tenures);
            foreach ($product_range as $range) {
                if (!empty($brand_id) && $brand_id == $product->brand_id) {
                    $status = true;
                }
                //echo $brand_id;
                if ($search_filter['filter'] == 'Placement') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range)) {
                            $status = true;
                        }
                    }
                } elseif ($search_filter['filter'] == 'Interest') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $range->bonus_interest)) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $range->bonus_interest))) {
                            $status = true;
                        }
                    }
                } elseif ($search_filter['filter'] == 'Tenor') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $tenures)) && (!empty($brand_id) && $brand_id == $product->brand_id) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $tenures))) {
                            $status = true;
                        }
                    }
                }


            }

            if ($status == true) {
                $filterProducts[] = $product;
            }
        }
        //dd($filterProducts);
        foreach ($filterProducts as $product) {
            $date1 = Carbon::now();
            $date1_start = new Carbon($product->promotion_start);
            $date2 = new Carbon($product->promotion_end);
            $interval = $date2->diffInDays($date1);
            //dd($interval);
            $interval_spent = $date2->diffInDays($date1_start);
            $sort_by_arr = [];
            $product_range = json_decode($product->product_range);
            foreach ($product_range as $key => $range) {
                if ($search_filter['filter'] == 'Placement') {
                    if ($P >= $range->min_range && $P <= $range->max_range) {
                        if ($product->promotion_formula_id == 11) {
                            $PI = ($range->board_rate / 100);
                            $BI = ($range->bonus_interest / 100);
                            $TD = $interval_spent;
                        } elseif ($product->promotion_formula_id == 12) {
                            $PI = ($range->board_rate / 100);
                            $BI = ($range->bonus_interest / 100);
                            $TM = $range->tenor;
                        } elseif ($product->promotion_formula_id == 13) {
                            $AIR = ($range->air / 100);
                            $SBR = ($range->sibor_rate / 100);
                        } elseif ($product->promotion_formula_id == 14) {

                        }
                        $calc = eval('return ' . $product->formula . ';');
                        //print_r($calc);echo '<br>';
                        $sort_by_arr[] = round($calc);
                    }
                } elseif ($search_filter['filter'] == 'Interest') {

                } elseif ($search_filter['filter'] == 'Tenor') {

                }
            }
            if (count($sort_by_arr)) {
                $sort_by_new_arr = max($sort_by_arr);
                if ($sort_by == 1) {
                    $sort_by_new_arr = min($sort_by_arr);
                }
                $filterNewProducts[$sort_by_new_arr] = $product;
            }
        }

        if (!empty($filterNewProducts)) {
            if ($sort_by == 1) {
                ksort($filterNewProducts);
            } elseif ($sort_by == 2) {
                krsort($filterNewProducts);
            }
        }
        //dd($filterNewProducts);
        $promotion_products = $filterNewProducts;
//dd($promotion_products);
        return view('frontend.products.wealth-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter"));
    }

    public function search_fixed_deposit(Request $request)
    {
        return $this->fixed($request->all());
    }

    public function fixed($request)
    {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();

//dd($request);
        $details = \Helper::get_page_detail(FIXED_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';
        $sort_by = isset($request['sort_by']) ? $request['sort_by'] : '';
//dd($brand_id);
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 1)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->select('brands.id as brand_id', 'promotion_products.id as promotion_product_id', 'promotion_products.*', 'promotion_types.*', 'promotion_formula.*', 'brands.*')
            ->get();

        $filterProducts = $filterNewProducts = [];
        //dd($promotion_products);
        foreach ($promotion_products as $product) {
            $status = false;
            $product_range = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            $P = $request['search_value'];
            //dd($tenures);
            foreach ($product_range as $range) {
                if (!empty($brand_id) && $brand_id == $product->brand_id) {
                    $status = true;
                }
                //echo $brand_id;
                if ($search_filter['filter'] == 'Placement') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range)) {
                            $status = true;
                        }
                    }
                } elseif ($search_filter['filter'] == 'Interest') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $range->bonus_interest)) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $range->bonus_interest))) {
                            $status = true;
                        }
                    }
                } elseif ($search_filter['filter'] == 'Tenor') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $tenures)) && (!empty($brand_id) && $brand_id == $product->brand_id) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $tenures))) {
                            $status = true;
                        }
                    }
                }


            }

            if ($status == true) {
                $filterProducts[] = $product;
            }
        }

        //dd($filterProducts);
        foreach ($filterProducts as $product) {
            $sort_by_arr = [];
            $product_range = json_decode($product->product_range);
            foreach ($product_range as $range) {
                if ($search_filter['filter'] == 'Placement') {
                    if ($P >= $range->min_range && $P <= $range->max_range) {
                        for ($i = 0; $i < count($tenures); $i++) {
                            $BI = ($range->bonus_interest[$i] / 100);
                            $TM = $tenures[$i];
                            $calc = eval('return ' . $product->formula . ';');
                            $days_type = \Helper::days_or_month_or_year(2, $tenures[$i]);
                            //print_r($calc);echo '<br>';
                            $sort_by_arr[] = round($calc);
                        }
                    }
                } elseif ($search_filter['filter'] == 'Interest') {

                } elseif ($search_filter['filter'] == 'Tenor') {

                }
            }
            if (count($sort_by_arr)) {
                $sort_by_new_arr = max($sort_by_arr);
                if ($sort_by == 1) {
                    $sort_by_new_arr = min($sort_by_arr);
                }
                $filterNewProducts[$sort_by_new_arr] = $product;
            }
        }

        if (!empty($filterNewProducts)) {
            if ($sort_by == 1) {
                ksort($filterNewProducts);
            } elseif ($sort_by == 2) {
                krsort($filterNewProducts);
            }
        }
        //dd($filterNewProducts);
        $promotion_products = $filterNewProducts;
        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter"));
    }

    public function search_saving_deposit(Request $request)
    {
        return $this->saving($request->all());
    }

    public function saving($request)
    {

        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();
        $searchFilter = $request;

        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : null;
        $searchValue = isset($request['search_value']) ? $request['search_value'] : 0;
        $filter = isset($request['filter']) ? $request['filter'] : PLACEMENT;

        DB::connection()->enableQueryLog();
        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 2)
            ->where('promotion_products.formula_id', '=', 6)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        $details = \Helper::get_page_detail(SAVING_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
        //dd($products);

        foreach ($products as &$product) {
            //dd($product);
            $placement = 0;
            $productRanges = json_decode($product->product_range);
            $todayDate = Carbon::today();
            $startDate = \Helper::convertToCarbonEndDate($product->promotion_start);
            $endDate = \Helper::convertToCarbonEndDate($product->promotion_end);
            //including end day so 1 day add in end date
            $tenure = $todayDate->diffInDays($endDate->copy()->addDay()); // tenure in days
            $tenureTotal = 365; //by default tenure in days so total days 365
            $tenureType = \Helper::days_or_month_or_year(2, $startDate->diffInMonths($endDate->copy()->addDay()));
            $product->ads = json_decode($product->ads_placement);
            $product->product_ranges = $productRanges;
            $product->remaining_days = $tenure; // remaining in days
            $status = false;

            if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, SAVING_DEPOSIT_F2])) {
                $maxPlacements = [];

                foreach ($productRanges as $productRange) {
                    //dd($productRange);
                    $maxPlacements[] = $productRange->max_range;
                }
                $placement = max($maxPlacements);
                //dd($placement);
                foreach ($productRanges as $k => &$productRange) {

                    $productRange->placement_highlight = false;
                    $productRange->tenure_highlight = false;
                    $productRange->bonus_interest_highlight = false;
                    $productRange->board_interest_highlight = false;
                    $productRange->total_interest_highlight = false;
                    $productRange->placement_value = false;
                    $allInterests = [$productRange->bonus_interest, $productRange->board_rate, $productRange->bonus_interest + $productRange->board_rate];

                    if (count($searchFilter)) {
                        if ($filter == PLACEMENT && ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range)) {
                            $productRange->placement_highlight = true;
                            $productRange->placement_value = true;
                            $placement = (int)$searchValue;

                            $status = true;
                        } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {
                            if ($searchValue == $productRange->bonus_interest) {
                                $productRange->placement_highlight = true;
                                $productRange->bonus_interest_highlight = true;
                            } elseif ($searchValue == $productRange->board_rate) {
                                $productRange->placement_highlight = true;
                                $productRange->board_interest_highlight = true;
                            } elseif ($searchValue == $productRange->bonus_interest + $productRange->board_rate) {
                                $productRange->placement_highlight = true;
                                $productRange->total_interest_highlight = true;
                            }
                            $placement = $productRange->max_range;
                            $status = true;
                        } elseif ($filter == TENURE) {

                            if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F2]) && $searchValue == $productRange->tenor) {
                                $productRange->tenure_highlight = true;
                                $productRange->placement_highlight = true;
                                $placement = $productRange->max_range;
                                $status = true;

                            } else {
                                $status = false;
                            }

                        }


                    }

                    if ($placement >= $productRange->min_range &&
                        $placement <= $productRange->max_range
                    ) {
                        if (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F2])) {
                            $tenure = $productRange->tenor;
                            $tenureTotal = 12;
                        }

                        $product->total_interest = $productRange->bonus_interest + $productRange->board_rate;
                        $totalInterest = (($placement * $productRange->bonus_interest / 100) * ($tenure / $tenureTotal)) + (($placement * $productRange->board_rate / 100) * ($tenure / $tenureTotal));
                        $product->total_interest_earn = round($totalInterest, 2);
                        $product->placement = $placement;
                    }
                }

                if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                    $status = false;
                }

                if ($status == true) {
                    $filterProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F3])) {

                foreach ($productRanges as $k => &$productRange) {
                    $placement = $productRange->max_range;
                    $productRange->high_light = false;

                    $productRange->placement_highlight = false;
                    $productRange->tenure_highlight = false;
                    $productRange->bonus_interest_highlight = false;
                    $productRange->board_interest_highlight = false;
                    $productRange->total_interest_highlight = false;
                    $productRange->placement_value = false;

                    $allInterests = (array)$productRange->counter;
                    $allInterests[] = $productRange->sibor_rate;
                    $allInterests[] = $productRange->air;

                    if (count($searchFilter)) {
                        if ($filter == PLACEMENT && ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range)) {
                            $productRange->high_light = true;
                            $placement = (int)$searchValue;
                            $status = true;
                        } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {
                            $productRange->high_light = true;
                            $status = true;
                        } elseif ($filter == TENURE) {
                            $status = false;
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

                if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                    $status = false;
                }

                if ($status == true) {
                    $filterProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F4])) {
                $maxPlacements = [0];
                $highlight = 0;


                foreach ($productRanges as $k => $productRange) {
                    //dd($productRanges);
                    $allInterests = [$productRange->bonus_interest, $productRange->board_rate, $productRange->bonus_interest + $productRange->board_rate];

                    if (count($searchFilter)) {
                        if ($filter == PLACEMENT && ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range)) {
                            $highlight++;
                            $maxPlacements[] = (int)$searchValue;
                            $status = true;
                        } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {
                            $highlight++;
                            $maxPlacements[] = $productRange->max_range;
                            $status = true;
                        } elseif ($filter == TENURE) {
                            $status = false;
                        }


                    } else {

                        $maxPlacements[] = $productRange->max_range;
                    }

                }

                $placement = max($maxPlacements);
                $totalInterests = [];
                $interestEarns = [];
                $lastCalculatedAmount = 0;

                foreach ($productRanges as $k => &$productRange) {

                    $interestEarn = 0;
                    if ($placement >= $productRange->max_range) {
                        $totalInterest = $productRange->bonus_interest + $productRange->board_rate;
                        if ($lastCalculatedAmount < $placement) {
                            $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                        }
                        $productRange->interest_earn = $interestEarn;
                        $productRange->total_interest = $totalInterest;
                        $interestEarns[] = $interestEarn;
                        $lastCalculatedAmount = $lastCalculatedAmount + ($productRange->max_range - $lastCalculatedAmount);
                        //dd($interestEarns);
                    } else {
                        $totalInterest = $productRange->bonus_interest + $productRange->board_rate;
                        $productRange->total_interest = $totalInterest;
                        if ($lastCalculatedAmount < $placement) {
                            $interestEarn = round(($placement - $lastCalculatedAmount) * ($totalInterest / 100), 2);
                        }
                        $productRange->interest_earn = $interestEarn;
                        $interestEarns[] = $interestEarn;
                        $lastCalculatedAmount = $lastCalculatedAmount + ($placement - $lastCalculatedAmount);

                    }


                }
                $product->total_interest = null;
                $product->total_interest_earn = array_sum($interestEarns);
                $product->placement = $placement;
                $product->highlight = $highlight;
                if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                    $status = false;
                }

                if ($status == true) {
                    $filterProducts[] = $product;
                }

            } elseif (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F5])) {

                $rowHeadings = [CUMMULATED_MONTHLY_SAVINGS_AMOUNT, BASE_INTEREST,
                    ADDITIONAL_INTEREST, TOTAL_AMOUNT];
                $product->highlight = false;
                foreach ($productRanges as $productRange) {
                    //dd($productRange);
                    $months = [1];
                    $allInterests = [$productRange->base_interest, $productRange->bonus_interest];

                    if (count($searchFilter)) {
                        if ($filter == PLACEMENT && ($searchValue >= $productRange->min_range && $searchValue <= $productRange->max_range)) {
                            $product->highlight = true;
                            $status = true;
                        } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {

                            $product->highlight = true;
                            $status = true;
                        } elseif ($filter == TENURE && ($searchValue > 0 && $searchValue <= $productRange->placement_month)) {
                            $product->highlight = true;
                            $months[] = $searchValue;
                            $status = true;
                        }


                    }
                    $x = (int)$productRange->placement_month;
                    $y = (int)$productRange->display_month;
                    $j = 1;
                    $z = 1;
                    do {
                        $z = $y * $j;

                        if (($x > $z)) {
                            $months[] = $z;
                        } else {
                            $z = $x;
                            $months[] = $z;
                        }
                        $j++;
                    } while ($z != $x);
                    $product->months = array_sort($months);


                    //dd($productRange, $months);
                    $details = [];
                    foreach ($rowHeadings as $k => $row) {
                        $monthlySavingAmount = [];
                        $baseInterests = [];
                        $totalBaseInterest = 0;
                        $totalAdditionalInterest = 0;
                        if ($k == 0) {
                            foreach ($months as $month) {
                                $monthlySavingAmount['month_' . $month] = $productRange->min_range * $month;
                            }
                            $monthlySavingAmount['end_of_years'] = $productRange->min_range * end($months);
                            $details[0] = $monthlySavingAmount;
                        } elseif ($k == 1 || $k == 2) {
                            for ($i = 1; $i <= ($productRange->placement_month); $i++) {
                                /*if($i==6){//dd(round($productRange->base_interest * $productRange->min_range * $i * 31 / (365 * 100), 2));
                                    }*/
                                $baseInterest = round($productRange->base_interest * $productRange->min_range * $i * 31 / (365 * 100), 2);
                                $AdditionalInterest = round($productRange->bonus_interest * ($productRange->min_range + $baseInterest) * $i * 31 / (365 * 100), 2);
                                if (in_array($i, $months)) {
                                    $baseInterests['month_' . $i] = $baseInterest;
                                    $AdditionalInterests['month_' . $i] = $AdditionalInterest;
                                }

                                $totalBaseInterest = $totalBaseInterest + $baseInterest;
                                $totalAdditionalInterest = $totalAdditionalInterest + $AdditionalInterest;

                            }
                            $baseInterests['total_base_interest'] = $totalBaseInterest;
                            $details[1] = $baseInterests;
                            $AdditionalInterests['total_additional_interest'] = $totalAdditionalInterest;
                            $details[2] = $AdditionalInterests;

                        }
                    }
                    //dd($details, $productRange);
                    $product->total_interest = $productRange->bonus_interest + $productRange->base_interest;
                    $totalInterest = (($placement * $productRange->bonus_interest / 100) * ($tenure / $tenureTotal)) + (($placement * $productRange->board_rate / 100) * ($tenure / $tenureTotal));
                    $product->total_interest_earn = round($totalInterest, 2);
                    $product->placement = $placement;
                }


                if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                    $status = false;
                }

                if ($status == true) {
                    $filterProducts[] = $product;
                }

            }
        }
        if (count($searchFilter)) {
            $products = collect($filterProducts);
        }
        //dd($products);
        return view('frontend.products.saving-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "searchFilter"));
    }

    public function product_search_homepage(Request $request)
    {
//dd($request->all());
        $account_type = $request->account_type;

        $request = [
            'filter' => 'Placement',
            'search_value' => $request->search_value,
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
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();

        $currency = isset($request->currency) ? $request->currency : '';
        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';
        $sort_by = isset($request['sort_by']) ? $request['sort_by'] : '';

        $currency_list = Currency::get();
        $search_currency = Currency::find($currency);

        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 5)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        $details = \Helper::get_page_detail(FOREIGN_CURRENCY_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = $filterNewProducts = [];
        //dd($promotion_products);
        foreach ($promotion_products as $product) {
            $status = false;
            $product_range = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            $P = $request['search_value'];
            //dd($tenures);
            foreach ($product_range as $range) {
                if (!empty($brand_id) && $brand_id == $product->brand_id) {
                    $status = true;
                }
                //echo $brand_id;
                if ($search_filter['filter'] == 'Placement') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range)) {
                            $status = true;
                        }
                    }
                } elseif ($search_filter['filter'] == 'Interest') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $range->bonus_interest)) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $range->bonus_interest))) {
                            $status = true;
                        }
                    }
                } elseif ($search_filter['filter'] == 'Tenor') {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $tenures)) && (!empty($brand_id) && $brand_id == $product->brand_id) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && (in_array($search_filter['search_value'], $tenures))) {
                            $status = true;
                        }
                    }
                }


            }

            if ($status == true) {
                $filterProducts[] = $product;
            }
        }

        foreach ($filterProducts as $product) {
            $date1 = Carbon::now();
            $date1_start = new Carbon($product->promotion_start);
            $date2 = new Carbon($product->promotion_end);
            $interval = $date2->diffInDays($date1);
            //dd($interval);
            $interval_spent = $date2->diffInDays($date1_start);
            $sort_by_arr = [];
            $product_range = json_decode($product->product_range);
            foreach ($product_range as $key => $range) {
                if ($search_filter['filter'] == 'Placement') {
                    if ($P >= $range->min_range && $P <= $range->max_range) {
                        if ($product->promotion_formula_id == 16) {
                            for ($i = 0; $i < count($tenures); $i++) {
                                $BI = ($range->bonus_interest[$i] / 100);
                                $TM = $tenures[$i];
                                $calc = eval('return ' . $product->formula . ';');
                                $days_type = \Helper::days_or_month_or_year(2, $tenures[$i]);
                            }
                        } elseif ($product->promotion_formula_id == 17) {
                            $PI = ($range->board_rate / 100);
                            $BI = ($range->bonus_interest / 100);
                            $TD = $interval_spent;
                        } elseif ($product->promotion_formula_id == 18) {
                            $PI = ($range->board_rate / 100);
                            $BI = ($range->bonus_interest / 100);
                            $TM = $range->tenor;
                        } elseif ($product->promotion_formula_id == 19) {
                            $AIR = ($range->air / 100);
                            $SBR = ($range->sibor_rate / 100);
                        } elseif ($product->promotion_formula_id == 20) {

                        }
                        $calc = eval('return ' . $product->formula . ';');
                        //print_r($calc);echo '<br>';
                        $sort_by_arr[] = round($calc);
                    }
                } elseif ($search_filter['filter'] == 'Interest') {

                } elseif ($search_filter['filter'] == 'Tenor') {

                }
            }
            if (count($sort_by_arr)) {
                $sort_by_new_arr = max($sort_by_arr);
                if ($sort_by == 1) {
                    $sort_by_new_arr = min($sort_by_arr);
                }
                $filterNewProducts[$sort_by_new_arr] = $product;
            }
        }

        if (!empty($filterNewProducts)) {
            if ($sort_by == 1) {
                ksort($filterNewProducts);
            } elseif ($sort_by == 2) {
                krsort($filterNewProducts);
            }
        }
        //dd($filterNewProducts);
        $promotion_products = $filterNewProducts;
//dd($search_currency);
        return view('frontend.products.foreign-currency-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter", "currency_list", "search_currency"));
    }

    public function search_aioa_deposit(Request $request)
    {
        return $this->aio($request);
    }

    public function aio($request)
    {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();
        $salary = (int)$request->salary;
        $giro = (int)$request->giro;
        $spend = (int)$request->spend;
        $loan = (int)$request->loan;
        $wealth = (int)$request->wealth;
        $searchValue = $request->search_value;
        if (isset($request->filter)) {
            $filter = $request->filter;
        } else {
            $filter = "Placement";
        }

        $search_filter = [];
        $search_filter = $request;
//$brand_id = $request->brand_id;
        $brand_id = null;

        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_formula.promotion_id', '=', ALL_IN_ONE_ACCOUNT)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        $details = \Helper::get_page_detail(AIO_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
        foreach ($promotion_products as $key => $product) {
            $status = false;
            $placement = 0;
            $productRanges = json_decode($product->product_range);

            if ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F1) {

                foreach ($productRanges as $productRange) {
//dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_salary,
                        $productRange->bonus_interest_giro_payment,
                        $productRange->bonus_interest_spend,
                        $productRange->bonus_interest_wealth,
                        $productRange->bonus_interest_loan,
                        $productRange->bonus_interest,
                        $productRange->bonus_interest_remaining_amount,
                    ];
                    if (($filter == PLACEMENT) && ($searchValue >= $productRange->min_range)) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {
                        $placement = $productRange->bonus_amount;
                        $status = true;
                    } elseif ($filter == TENURE) {
                        $placement = $productRange->bonus_amount;
                        $status = true;
                    }

                    if ($status == true) {
                        $totalInterest = 0;
                        if ($salary > 0 && $productRange->minimum_salary <= $salary) {
                            $totalInterest = $totalInterest + $productRange->bonus_interest_salary;
                        }
                        if ($giro > 0 && $productRange->minimum_giro_payment <= $giro) {
                            $totalInterest = $totalInterest + $productRange->bonus_interest_giro_payment;
                        }
                        if ($spend > 0 && $productRange->minimum_spend <= $spend) {
                            $totalInterest = $totalInterest + $productRange->bonus_interest_spend;
                        }
                        if ($wealth > 0 && $productRange->minimum_wealth_pa <= $wealth) {
                            $totalInterest = $totalInterest + $productRange->bonus_interest_wealth;
                        }
                        if ($loan > 0 && $productRange->bonus_interest_loan <= $loan) {
                            $totalInterest = $totalInterest + $productRange->bonus_interest_loan;
                        }
                        if ($placement > 0 && $productRange->bonus_amount <= $placement) {
                            $totalInterest = $totalInterest + $productRange->bonus_interest;
                        }
                        $productRange->total_interest = $totalInterest;
                        if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                            $productRange->total_interest_earned = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                        } else {
                            $productRange->total_interest_earned = $placement * ($totalInterest / 100);
                        }
                        $productRange->placement = $placement;
                    }
                }
                if ($status == true) {
                    $product->product_range = $productRanges;
                    $filterProducts[] = $product;

                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F2) {

//dd($productRanges);
                $maxRanges = [];
                $totalInterests = [];
                $interestEarns = [];
                $placement = 0;
                if (($spend >= $productRanges[0]->minimum_spend) && ($salary >= $productRanges[0]->minimum_salary || $giro >= $productRanges[0]->minimum_giro_payment)) {
                    $criteria = "bonus_interest_criteria_b";
                    $status = true;

                } elseif (($spend >= $productRanges[0]->minimum_spend)) {
                    $criteria = "bonus_interest_criteria_a";
                    $status = true;
                }
                if ($status == true) {
                    foreach ($productRanges as $key => $productRange) {
                        $allInterests = [
                            $productRange->bonus_interest_criteria_a,
                            $productRange->bonus_interest_criteria_b,
                        ];
                        $maxRanges[] = $productRange->max_range;
                        if (($filter == PLACEMENT) && ($searchValue >= $productRange->min_range)) {
                            $placement = (int)$searchValue;
                        } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {
                            $placement = $productRange->max_range;

                        } elseif ($filter == TENURE) {
                            $placement = ($productRange->min_range - 1);

                        }
                    }
                    $maxPlacement = array_last(array_sort($maxRanges));
                    $lastRange = array_last($productRanges);
                    $lastCalculatedAmount = 0;
                    if ($placement > 0) {
                        foreach ($productRanges as $productRange) {
                            if ($filter == PLACEMENT && $maxPlacement == $productRange->max_range && $maxPlacement < $placement) {
                                $totalInterests[] = $lastRange->$criteria;
                                $interestEarn = round(($placement - $lastCalculatedAmount) * ($lastRange->$criteria / 100), 2);
                                $productRange->interest_earn = $interestEarn;
                                $productRange->criteria = $productRange->$criteria;
                                $interestEarns[] = $interestEarn;
                                $productRange->above_range = true;
                            } else {
                                $totalInterests[] = $productRange->$criteria;
                                $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->$criteria / 100), 2);
                                $productRange->interest_earn = $interestEarn;
                                $productRange->criteria = $productRange->$criteria;
                                $interestEarns[] = $interestEarn;
                                $productRange->above_range = false;

                            }
                            $lastCalculatedAmount = $productRange->max_range;

                        }

                        $product->total_interest = array_sum($totalInterests);
                        $product->interest_earned = array_sum($interestEarns);
                        $product->placement = $placement;
                        $product->product_range = $productRanges;
                        $filterProducts[] = $product;
                        /*if($key ==2){
                        dd($filterProducts);
                        }*/
                    }
                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F3) {
                $criteriaMatchCount = 0;
                foreach ($productRanges as $productRange) {
// dd($productRange);
                    $allInterests = [
                        $productRange->bonus_interest_criteria1,
                        $productRange->bonus_interest_criteria2,
                        $productRange->bonus_interest_criteria3,
                    ];

                    if (($filter == PLACEMENT) && ($searchValue >= $productRange->min_range)) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {
                        $placement = $productRange->first_cap_amount;
                        $status = true;
                    } elseif ($filter == TENURE) {
                        $placement = $productRange->first_cap_amount;
                        $status = true;
                    }

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
                        if ($spend > 0 && $productRange->minimum_insurance <= ($wealth / 2)) {
                            $criteriaMatchCount++;
                        }
                        if ($spend > 0 && $productRange->minimum_unit_trust <= ($wealth / 2)) {
                            $criteriaMatchCount++;
                        }
                        if ($loan > 0 && $productRange->minimum_hire_purchase_loan <= ($loan / 4)) {
                            $criteriaMatchCount++;
                        }
                        if ($loan > 0 && $productRange->minimum_renovation_loan <= ($loan / 4)) {
                            $criteriaMatchCount++;
                        }
                        if ($loan > 0 && $productRange->minimum_home_loan <= ($loan / 4)) {
                            $criteriaMatchCount++;
                        }
                        if ($loan > 0 && $productRange->minimum_education_loan <= ($loan / 4)) {
                            $criteriaMatchCount++;
                        }
                        $totalInterest = 1;
                        if ($criteriaMatchCount == 1) {
                            $totalInterest = $productRange->bonus_interest_criteria1;

                        } elseif ($criteriaMatchCount == 2) {
                            $totalInterest = $productRange->bonus_interest_criteria2;

                        } elseif ($criteriaMatchCount >= 3) {
                            $totalInterest = $productRange->bonus_interest_criteria3;

                        }
                        $productRange->total_interest = $totalInterest;
                        if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                            $productRange->total_interest_earned = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                        } else {
                            $productRange->total_interest_earned = $placement * ($totalInterest / 100);
                        }
                        $productRange->placement = $placement;
                    }
                }
                if ($criteriaMatchCount >= 1) {
                    $product->product_range = $productRanges;
                    $filterProducts[] = $product;

                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F4) {

//dd($productRanges);
                $maxRanges = [];
                $totalInterest = 0;
                $interestEarn = 0;
                $placement = 0;
                $baseDetail = $productRanges[0];

                $criteriaMatchCount = 0;
                if ($salary > 0 && $baseDetail->minimum_salary <= $salary) {

                    if ($spend > 0 && $baseDetail->minimum_spend <= $spend) {
                        $criteriaMatchCount++;
                    }
                    if ($spend > 0 && $baseDetail->minimum_insurance <= ($wealth / 2)) {
                        $criteriaMatchCount++;
                    }
                    if ($spend > 0 && $baseDetail->minimum_investment <= ($wealth / 2)) {
                        $criteriaMatchCount++;
                    }
                    if ($loan > 0 && $baseDetail->minimum_home_loan <= $loan) {
                        $criteriaMatchCount++;
                    }

                    if ($criteriaMatchCount == 1) {
                        $criteria = "bonus_interest_criteria_a";

                    } elseif ($criteriaMatchCount >= 2) {
                        $criteria = "bonus_interest_criteria_b";

                    }
                    if ($criteriaMatchCount > 0) {
                        foreach ($productRanges as $key => $productRange) {
                            $allInterests = [
                                $productRange->bonus_interest_criteria_a,
                                $productRange->bonus_interest_criteria_b,
                            ];
                            $maxRanges[] = $productRange->max_range;
                            if (($filter == PLACEMENT) && ($searchValue >= $productRange->min_range)) {
                                $placement = (int)$searchValue;
                            } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {
                                $placement = $productRange->min_range;

                            } elseif ($filter == TENURE) {
                                $placement = $productRange->min_range;

                            }
                        }
                    }

                }

                if ($placement > 0) {
                    foreach ($productRanges as $productRange) {

                        if ($productRange->min_range <= $placement && $productRange->max_range >= $placement) {
                            $totalInterest = $productRange->$criteria;
                            $interestEarn = round(($placement) * ($totalInterest / 100), 2);

                        }
                    }
                }

                if ($totalInterest > 0) {
                    $product->total_interest = $totalInterest;
                    $product->total_interest_earned = $interestEarn;
                    $product->placement = $placement;
                    $product->product_range = $productRanges;
                    $filterProducts[] = $product;

                }

            }

        }

        $promotion_products = $filterProducts;
//dd($promotion_products);
        return view('frontend.products.aio-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter"));
    }
}
