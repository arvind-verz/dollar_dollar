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
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user_products = null;
        if (Auth::check()) {
            $user_products = ProductManagement::join('brands', 'product_managements.bank_id', '=', 'brands.id')
                ->where('user_id', Auth::user()->id)
                ->get();
        }


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

                } elseif ($slug == TERMS_CONDITION) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->termsCondition($details);

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
                        $relatedBlog[] = $detail;
                    }
                }
                $relatedBlog = array_random($relatedBlog, 3);
                return view("frontend.Blog.blog-detail", compact("page", "systemSetting", "banners", "relatedBlog", 'tags'));
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
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        $details = \Helper::get_page_detail(FIXED_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';
        $sort_by = isset($request['sort_by']) ? $request['sort_by'] : '';

        $legendtable = systemSettingLegendTable::where('page_type', '=',FIX_DEPOSIT)
            ->where('delete_status', 0)
            ->get();
        //dd($request);
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 1)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('brands.id as brand_id', 'promotion_products.id as promotion_product_id', 'promotion_products.*', 'promotion_types.*', 'promotion_formula.*', 'brands.*')
            ->get();

        $filterProducts = $filterNewProducts = $orginalProducts = $result_data = [];

        $defaultSearch = DefaultSearch::where('promotion_id', FIX_DEPOSIT)->first();
        if ($defaultSearch) {
            $defaultPlacement = $defaultSearch->placement;
        } else {
            $defaultPlacement = 0;
        }
        //dd($defaultPlacement);
        if (empty($request)) {
            $search_filter['search_value'] = $defaultPlacement;
            $search_filter['filter'] = PLACEMENT;
            $search_filter['sort_by'] = MAXIMUM;
        }
        //dd($search_filter);
            foreach ($promotion_products as $product) {
                $status = false;
                $product_range = json_decode($product->product_range);
                $tenures = json_decode($product->tenure);
                $P = $search_filter['search_value'];
//dd($tenures);
                foreach ($product_range as $range) {

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
                    /*if(!empty($brand_id) && $brand_id == $product->brand_id) {
                    $status = true;
                    }*/

                }

                if ($status == true) {
                    $filterProducts[] = $product;
                }
            }

            foreach ($filterProducts as $product) {
                $promotion_product_id = $product->promotion_product_id;
                $sort_by_arr = $result_data_old = [];
                $product_range = json_decode($product->product_range);
                $tenures = json_decode($product->tenure);
                $P = $search_filter['search_value'];

                foreach ($product_range as $key => $range) {
//print_r($range);
                    if ($search_filter['filter'] == 'Placement') {
                        if ($P >= $range->min_range && $P <= $range->max_range) {
                            for ($i = 0; $i < count($tenures); $i++) {
                                $BI = ($range->bonus_interest[$i] / 100);
                                $TM = $tenures[$i];
                                $calc = eval('return ' . $product->formula . ';');
                                $days_type = \Helper::days_or_month_or_year(2, $tenures[$i]);
//print_r($calc);echo '<br>';
                                $sort_by_arr[] = round($calc);
                                $result_data_old[] = [
                                    'calc' => $calc,
                                    'interest' => $range->bonus_interest[$i],
                                    'amount' => $P,
                                ];
                            }
                        }
                    } elseif ($search_filter['filter'] == 'Interest') {
                        $P = $product_range[0]->max_range;
                        if ($key == 0) {
                            for ($i = 0; $i < count($tenures); $i++) {
                                $BI = ($range->bonus_interest[$i] / 100);
                                $TM = $tenures[$i];
                                $calc = eval('return ' . $product->formula . ';');
                                $days_type = \Helper::days_or_month_or_year(2, $tenures[$i]);

                                $sort_by_arr[] = $range->bonus_interest[$i];
                                $result_data_old[] = [
                                    'calc' => $calc,
                                    'interest' => $range->bonus_interest[$i],
                                    'amount' => $P,
                                ];
                            }
                        }
                    } elseif ($search_filter['filter'] == 'Tenor') {
                        $P = $product_range[0]->max_range;
                        if ($P >= $range->min_range && $P <= $range->max_range) {
                            for ($i = 0; $i < count($tenures); $i++) {
                                $BI = ($range->bonus_interest[$i] / 100);
                                $TM = $tenures[$i];
                                $calc = eval('return ' . $product->formula . ';');
                                $days_type = \Helper::days_or_month_or_year(2, $tenures[$i]);
//print_r($calc);echo '<br>';
                                $sort_by_arr[] = round($calc);
                                $result_data_old[] = [
                                    'calc' => $calc,
                                    'interest' => $range->bonus_interest[$i],
                                    'amount' => $P,
                                ];
                            }
                        }
                    }
                    $result_data_old['tenor'] = $tenures;
                }
//dd($result_data);
                if (count($sort_by_arr)) {
                    $sort_by_new_arr = max($sort_by_arr);
                    if ($sort_by == 1) {
                        $sort_by_new_arr = min($sort_by_arr);
                    }
//print_r($sort_by_new_arr);echo '<br>';
                    $filterNewProducts[$promotion_product_id] = $sort_by_new_arr;
                }
                $result_data[$promotion_product_id] = $result_data_old;
            }
//dd($result_data);

            if (!empty($filterNewProducts)) {
                if ($sort_by == 1) {
                    asort($filterNewProducts);
                } elseif ($sort_by == 2) {
                    arsort($filterNewProducts);
                }
            }

            foreach ($filterNewProducts as $key => $value) {
                $orginalProducts[] = $promotion_products->where('promotion_product_id', $key)->first();
            }
        //dd($orginalProducts);
        $promotion_products = $orginalProducts;

        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter", "result_data", "legendtable"));
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
        $legendtable = systemSettingLegendTable::where('page_type', '=', 'Wealth Deposit')
            ->where('delete_status', 0)
            ->get();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 4)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
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
        return view('frontend.products.wealth-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "legendtable"));
    }

    public function foreignCurrencyDepositMode($details)
    {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();
//dd($startDate);
        DB::connection()->enableQueryLog();
        $currency_list = Currency::get();

        $legendtable = systemSettingLegendTable::where('page_type', '=', 'Foreign Currency Deposit')
            ->where('delete_status', 0)
            ->get();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 5)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
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
        return view('frontend.products.foreign-currency-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "currency_list", "legendtable"));
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
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();

        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';
        $sort_by = isset($request['sort_by']) ? $request['sort_by'] : '';

        $legendtable = systemSettingLegendTable::where('page_type', '=', 'Wealth Deposit')
            ->where('delete_status', 0)
            ->get();

        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 4)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
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
        return view('frontend.products.wealth-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter", "legendtable"));
    }

    public function search_saving_deposit(Request $request)
    {
        return $this->saving($request->all());
    }

    public function saving($request)
    {

        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : 1;
        $filter = isset($request['filter']) ? $request['filter'] : PLACEMENT;


        //dd($searchValue,$searchFilter);
        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', 'Saving Deposit')
            ->where('delete_status', 0)
            ->get();

        $products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', SAVING_DEPOSIT)
            // ->where('promotion_products.formula_id', '=', 6)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
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
            } else {
                $placement = 0;
                $searchFilter = $request;
                $searchValue = isset($request['search_value']) ? $request['search_value'] : 0;
            }
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
                    //$placement = $productRange->max_range;
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
                            $placement = $defaultPlacement;
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

                        $maxPlacements[] = $placement;
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
                $product->total_interest = 0;
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
                //dd($productRanges);
                foreach ($productRanges as $productRange) {

                    $months = [1];
                    $allInterests = [$productRange->base_interest, $productRange->bonus_interest];
                    //$placement = $productRange->max_range;
                    if ($filter == PLACEMENT) {
                        $searchValue = round($searchValue / ((int)$productRange->placement_month), 2);
                    } else {
                        $placement = round($placement / ((int)$productRange->placement_month), 2);
                    }

                    if (count($searchFilter)) {

                        if ($filter == PLACEMENT && ($searchValue >= $productRange->min_range)) {
                            if ($searchValue >= $productRange->max_range) {
                                $placement = $productRange->max_range;
                            } else {
                                $placement = $searchValue;
                            }
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
                        if ($z == 1) {
                        } elseif (($x > $z)) {
                            $months[] = $z;
                        } else {
                            $z = $x;
                            $months[] = $z;
                        }
                        $j++;
                    } while ($z != $x);
                    $product->months = array_sort($months);


                    //dd($productRange, $months);
                    $monthlySavingAmount = [];
                    $baseInterests = [];
                    $additionalInterests = [];
                    $totalInterestAmount = 0;

                    foreach ($months as $month) {
                        $monthlySavingAmount[$month] = $placement * $month;
                    }
                    $monthlySavingAmount[] = $placement * end($months);

                    for ($i = 1; $i <= ($productRange->placement_month); $i++) {

                        $baseInterest = round($productRange->base_interest * $placement * $i * 31 / (365 * 100), 2);
                        $AdditionalInterest = round($productRange->bonus_interest * ($placement + $baseInterest) * $i * 31 / (365 * 100), 2);
                        if (in_array($i, $months)) {
                            $baseInterests[$i] = $baseInterest;
                            $additionalInterests[$i] = $AdditionalInterest;
                        }
                    }
                    $baseInterests[] = array_sum($baseInterests);
                    $additionalInterests[] = array_sum($additionalInterests);
                    $totalInterestAmount = end($baseInterests) + end($additionalInterests);
                    $product->row_headings = $rowHeadings;
                    $product->months = $months;
                    $product->monthly_saving_amount = $monthlySavingAmount;
                    $product->base_interests = $baseInterests;
                    $product->additional_interests = $additionalInterests;
                    $product->total_interest_earn = $totalInterestAmount + ($placement * $productRange->placement_month);
                    $product->placement = $placement;
                    $product->total_interest = 0;
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
        if ($products->count()) {

            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT || $filter == TENURE) {
                    $products = $products->sortBy('total_interest_earn');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortBy('total_interest');

                }
            } else {
                if ($filter == PLACEMENT || $filter == TENURE) {
                    $products = $products->sortByDesc('total_interest_earn');
                } elseif ($filter == INTEREST) {
                    $products = $products->sortByDesc('total_interest');

                }
            }

        }
        return view('frontend.products.saving-deposit-products', compact("brands", "page", "systemSetting", "banners", "products", "searchFilter", "legendtable"));
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
        $legendtable = systemSettingLegendTable::where('page_type', '=', 'Foreign Currency Deposit')
            ->where('delete_status', 0)
            ->get();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 5)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
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
        return view('frontend.products.foreign-currency-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter", "currency_list", "search_currency", "legendtable"));
    }

    public
    function search_aioa_deposit(Request $request)
    {
        return $this->aio($request->all());
    }

    public
    function aio($request)
    {
        $brandId = isset($request['brand_id']) ? $request['brand_id'] : null;
        $sortBy = isset($request['sort_by']) ? $request['sort_by'] : MAXIMUM;
        $filter = isset($request['filter']) ? $request['filter'] : PLACEMENT;

        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();


        DB::connection()->enableQueryLog();
        $legendtable = systemSettingLegendTable::where('page_type', '=', 'AIO Deposit')
            ->where('delete_status', 0)
            ->get();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            //->where('promotion_products.formula_id', '=', 8)
            ->where('promotion_formula.promotion_id', '=', ALL_IN_ONE_ACCOUNT)
            //->where('promotion_products.promotion_start', '<=', $start_date)
            //->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*','promotion_products.id as product_id')
            ->get();

        $details = \Helper::get_page_detail(AIO_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];
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
                $search_filter['search_value'] = $defaultPlacement;
                $search_filter['salary'] = $defaultSalary;
                $search_filter['giro'] = $defaultGiro;
                $search_filter['spend'] = $defaultSpend;
                $search_filter['wealth'] = $defaultLoan;
                $search_filter['loan'] = $defaultWealth;
                $search_filter['filter'] = PLACEMENT;
            } else {
                $placement = 0;
                $search_filter = $request;
                $searchValue = isset($search_filter['search_value']) ? $search_filter['search_value'] : 0;
                $salary = (int)$search_filter['salary'];
                $giro = (int)$search_filter['giro'];
                $spend = (int)$search_filter['spend'];
                $loan = (int)$search_filter['loan'];
                $wealth = (int)$search_filter['wealth'];
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

                foreach ($productRanges as $productRange) {
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
                    if (($filter == PLACEMENT) && ($searchValue >= $productRange->min_range)) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif ($filter == INTEREST && (in_array((float)$searchValue, $allInterests))) {
                        $placement = $defaultPlacement;
                        $status = true;
                    } elseif ($filter == TENURE) {
                        //$placement = $productRange->bonus_amount;
                        $status = false;
                    }
                    if ($status == true) {

                        $totalInterest = 0;
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
                        /*if ($loan > 0 && $productRange->bonus_interest_loan <= $loan) {
                            $product->loan_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest_loan;
                            $criteriaMatchCount++;
                        }*/
                        if ($placement > 0 && $productRange->bonus_amount <= $placement) {
                            $product->bonus_highlight = true;
                            $totalInterest = $totalInterest + $productRange->bonus_interest;
                            $criteriaMatchCount++;
                        }
                        $totalInterests[] = $totalInterest;
                        if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                            $interestEarns[] = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                        } else {
                            $interestEarns[] = $placement * ($totalInterest / 100);
                        }
                        $productRange->placement = $placement;
                    }
                }
                $product->total_interest = array_sum($totalInterests);
                $product->interest_earned = array_sum($interestEarns);
                $product->placement = $placement;
                if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                    $status = false;
                }
                if ($status == true && $criteriaMatchCount > 0) {
                    $product->highlight = true;
                    $product->product_range = $productRanges;
                    $filterProducts[] = $product;

                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F2) {

                //dd($productRanges);

                $product->highlight_index = 0;
                $product->highlight = false;
                $product->criteria_a_highlight = false;
                $product->criteria_b_highlight = false;
                $maxRanges = [];
                $totalInterests = [];
                $interestEarns = [];
                //$placement = 0;
                if (($spend >= $productRanges[0]->minimum_spend) && ($salary >= $productRanges[0]->minimum_salary || $giro >= $productRanges[0]->minimum_giro_payment)) {
                    $criteria = "bonus_interest_criteria_b";
                    $product->criteria_b_highlight = true;
                    $status = true;

                } elseif (($spend >= $productRanges[0]->minimum_spend)) {
                    $criteria = "bonus_interest_criteria_a";
                    $product->criteria_a_highlight = true;
                    $status = true;
                }
                if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                    $status = false;
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
                                $product->highlight_index++;
                            } else {
                                $totalInterests[] = $productRange->$criteria;
                                $interestEarn = round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->$criteria / 100), 2);
                                $productRange->interest_earn = $interestEarn;
                                $productRange->criteria = $productRange->$criteria;
                                $interestEarns[] = $interestEarn;
                                $productRange->above_range = false;
                                $product->highlight_index++;

                            }
                            $lastCalculatedAmount = $productRange->max_range;

                        }

                        $product->total_interest = array_sum($totalInterests);
                        $product->interest_earned = array_sum($interestEarns);
                        $product->placement = $placement;
                        $product->product_range = $productRanges;
                        $product->highlight = true;
                        $filterProducts[] = $product;
                        /*if($key ==2){
                        dd($filterProducts);
                        }*/
                    }
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
                        $placement = $defaultPlacement;
                        $status = true;
                    } elseif ($filter == TENURE) {
                        //$placement = $productRange->first_cap_amount;
                        $status = false;
                    }
                    if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                        $status = false;
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
                        $totalInterest = 1;
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
                        $totalInterests[] = $totalInterest;
                        if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                            $interestEarns[] = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                        } else {
                            $interestEarns[] = $placement * ($totalInterest / 100);
                        }
                        $productRange->placement = $placement;
                    }
                }
                if ($criteriaMatchCount >= 1) {
                    $product->highlight = true;
                    $product->total_interest = array_sum($totalInterests);
                    $product->interest_earned = array_sum($interestEarns);
                    $product->product_range = $productRanges;
                    $filterProducts[] = $product;


                }

            } elseif ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F4) {
                $product->highlight = false;
                $maxRanges = [];
                $totalInterest = 0;
                $interestEarn = 0;
                //$placement = 0;
                $baseDetail = $productRanges[0];
                $status = false;
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
                        $highlight = "criteria_a_highlight";

                    } elseif ($criteriaMatchCount >= 2) {
                        $criteria = "bonus_interest_criteria_b";
                        $highlight = "criteria_b_highlight";

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
                                $placement = 0;

                            }
                        }
                    }

                }

                if ($placement > 0) {
                    foreach ($productRanges as &$productRange) {
                        $productRange->criteria_a_highlight = false;
                        $productRange->criteria_b_highlight = false;
                        if ($productRange->min_range <= $placement && $productRange->max_range >= $placement) {
                            $product->highlight = true;
                            $productRange->$highlight = true;
                            $totalInterest = $productRange->$criteria;
                            $interestEarn = round(($placement) * ($totalInterest / 100), 2);

                        }
                    }
                    $status = true;
                }
                if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                    $status = false;
                }
                if ($totalInterest > 0 && $status == true) {
                    $product->total_interest = $totalInterest;
                    $product->interest_earned = $interestEarn;
                    $product->placement = $placement;
                    $product->product_range = $productRanges;
                    $filterProducts[] = $product;

                }

            }

        }
        $promotion_products = $filterProducts;
        if (count($promotion_products)) {
            $promotion_products = collect($promotion_products);
            if ($sortBy == MINIMUM) {
                if ($filter == PLACEMENT || $filter == TENURE) {
                    $promotion_products = $promotion_products->sortBy('interest_earned');
                } elseif ($filter == INTEREST) {
                    $promotion_products = $promotion_products->sortBy('total_interest');

                }
            } else {
                if ($filter == PLACEMENT || $filter == TENURE) {
                    $promotion_products = $promotion_products->sortByDesc('interest_earned');
                } elseif ($filter == INTEREST) {
                    $promotion_products = $promotion_products->sortByDesc('total_interest');

                }
            }

        }
        //dd($promotion_products);
        return view('frontend.products.aio-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter", "legendtable"));
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


        $product = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_formula.promotion_id', '=', ALL_IN_ONE_ACCOUNT)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->where('promotion_products.id', '=', $request->product_id)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*','promotion_products.id as product_id')
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
            $searchValue = isset($searchDetail['search_value']) ? $searchDetail['search_value'] : 0;
            $salary = (int)$searchDetail['salary'];
            $giro = (int)$searchDetail['giro'];
            $spend = (int)$searchDetail['spend'];
            $loan = (int)$searchDetail['loan'];
            $wealth = (int)$searchDetail['wealth'];

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
                        $placement = $defaultPlacement;
                        $status = true;
                    } elseif ($filter == TENURE) {
                        //$placement = $productRange->first_cap_amount;
                        $status = false;
                    }
                    if (!is_null($brandId) && ($brandId != $product->bank_id)) {
                        $status = false;
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
                        if ((isset($checkBoxDetail['life_insurance'])) && ($wealth > 0 && $productRange->minimum_insurance <= ($wealth / 12))) {
                            $criteriaMatchCount++;
                            $product->life_insurance = true;
                        }
                        if ((isset($checkBoxDetail['unit_trust'])) && ($wealth > 0 && $productRange->minimum_unit_trust <= ($wealth / 12))) {
                            $criteriaMatchCount++;
                            $product->unit_trust = true;
                        }
                        if ((isset($checkBoxDetail['hire_loan'])) && ($loan > 0 && $productRange->minimum_hire_purchase_loan <= ($loan))) {
                            $criteriaMatchCount++;
                            $product->hire_loan = true;
                        }
                        if ((isset($checkBoxDetail['renovation_loan'])) && ($loan > 0 && $productRange->minimum_renovation_loan <= ($loan))) {
                            $criteriaMatchCount++;
                            $product->renovation_loan = true;
                        }
                        if ((isset($checkBoxDetail['housing_loan'])) && ($loan > 0 && $productRange->minimum_home_loan <= ($loan))) {
                            $criteriaMatchCount++;
                            $product->housing_loan = true;
                        }
                        if ((isset($checkBoxDetail['education_loan'])) && ($loan > 0 && $productRange->minimum_education_loan <= ($loan))) {
                            $criteriaMatchCount++;
                            $product->education_loan = true;
                        }
                        $totalInterest = 1;
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
                        $totalInterests[] = $totalInterest;
                        if ($placement > 0 && ($placement > $productRange->first_cap_amount)) {
                            $interestEarns[] = (($productRange->first_cap_amount * ($totalInterest / 100)) + (($productRange->bonus_interest_remaining_amount / 100) * ($placement - $productRange->first_cap_amount)));
                        } else {
                            $interestEarns[] = $placement * ($totalInterest / 100);
                        }
                        $productRange->placement = $placement;
                    }
                }
                if ($criteriaMatchCount >= 1) {
                    $product->highlight = true;
                    $product->total_interest = array_sum($totalInterests);
                    $product->interest_earned = array_sum($interestEarns);
                    $product->product_range = $productRanges;
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
                                           name="life_insurance" onchange="changeCriteria(this);"
                                        <?php if ($product->life_insurance) {
                                            echo "checked = checked";
                                        } ?> value="true" id="life-insurance-<?php echo $product->product_id; ?>"/>
                                    <label for="life-insurance-<?php echo $product->product_id; ?>">Life Insurance</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" onchange="changeCriteria(this);"
                                        <?php if ($product->housing_loan) {
                                            echo "checked = checked";
                                        } ?>
                                    name="housing_loan"
                                    data-product-id = "<?php echo $product->product_id; ?>"
                                    value="true" id="housing-loan-<?php echo $product->product_id; ?>">
                                    <label for="housing-loan-<?php echo $product->product_id; ?>">Housing Loan</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox"
                                           name="education_loan" onchange="changeCriteria(this);"
                                           data-product-id="<?php echo $product->product_id; ?>"
                                           value="true" id='education-loan-<?php echo $product->product_id; ?>'
                                        <?php if ($product->education_loan) {
                                            echo "checked = checked";
                                        } ?>/>
                                    <label for="education-loan-<?php echo $product->product_id; ?>">Education Loan</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" onchange="changeCriteria(this);"
                                           name="hire_loan" value="true"
                                           data-product-id="<?php echo $product->product_id; ?>" id="hire-loan-<?php echo $product->product_id; ?>"
                                           <?php if ($product->hire_loan) {
                                               echo "checked = checked";
                                           } ?>/>
                                    <label for="hire-loan-<?php echo $product->product_id; ?>">Hire Purchase loan</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox"
                                           name="renovation_loan" onchange="changeCriteria(this);"
                                           data-product-id="<?php echo $product->product_id; ?>"
                                           value="true" id="renovation-loan-<?php echo $product->product_id; ?>"
                                        <?php if ($product->renovation_loan) {
                                            echo "checked = checked";
                                        } ?>/>
                                    <label for="renovation-loan-<?php echo $product->product_id; ?>">Renovation loan</label>
                                </div>
                            </th>
                            <th>
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" onchange="changeCriteria(this);"
                                           name="unit_trust" value="true"
                                           data-product-id="<?php echo $product->product_id; ?>" id="unit-trust-<?php echo $product->product_id; ?>"
                                        <?php if ($product->unit_trust) {
                                            echo "checked = checked";
                                        } ?>/>
                                    <label for="unit-trust-<?php echo $product->product_id; ?>">Unit Trust</label>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($productRanges as $range) { ?>
                        <tr>
                            <td>Bonus Interest PA</td>
                            <td class="text-center <?php if($product->criteria_1==true ) { echo "highlight";} ?> "
                                colspan="3">1 Criteria Met
                                - <?php if($range->bonus_interest_criteria1<=0) { echo "-";}
                                else { echo "$range->bonus_interest_criteria1".'%'; } ?>
                            </td>
                            <td class=" text-center  <?php if($product->criteria_2==true ) { echo "highlight";} ?> "
                                colspan="3">2 Criteria
                                - <?php if($range->bonus_interest_criteria2<=0) { echo "-";}
                                else { echo "$range->bonus_interest_criteria2".'%'; } ?>

                            </td>
                            <td class="text-center  <?php if($product->criteria_3==true ) { echo "highlight";} ?>"
                                colspan="3">3 Criteria - <?php if($range->bonus_interest_criteria3<=0) { echo " - ";}
                                else { echo "$range->bonus_interest_criteria3".'%'; } ?>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Total Bonus Interest Earned for
                                <?php echo "$".\Helper::inThousand($range->placement); ?>
                                </td>
                            <td class=" text-center @if($product->highlight==true ) highlight @endif"
                                colspan="8">

                                <?php if($range->placement > $range->first_cap_amount) {
                                echo "First ";
                                echo"$".\Helper::inThousand($range->first_cap_amount).' - '.
                                '$'.\Helper::inThousand(($range->first_cap_amount*($product->total_interest/100))).
                                ' ('.$product->total_interest.'%), next $'.
                                    \Helper::inThousand(($range->placement-$range->first_cap_amount)).' - '
                                .'$'.\Helper::inThousand((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))).
                                ' ('.$range->bonus_interest_remaining_amount.'%) Total = $'
                                .\Helper::inThousand($product->interest_earned); }
                                else {
                                    echo"Total = $".\Helper::inThousand($product->interest_earned);
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
}
