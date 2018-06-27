<?php

namespace App\Http\Controllers\CMS;

use App\Brand;
use App\Currency;
use App\Http\Controllers\Controller;
use App\Page;
use App\ProductManagement;
use App\PromotionProducts;
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
            ->get();

        //dd(DB::getQueryLog());
        //dd($promotion_products);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products"));
    }

    public function savingDepositMode($details)
    {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 2)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();

        //dd(DB::getQueryLog());
        //dd($promotion_products);
        $details = \Helper::get_page_detail(SAVING_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        return view('frontend.products.saving-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products"));
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
        $currency = Currency::get();

        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 5)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();


        //dd(DB::getQueryLog());
        //dd($promotion_products);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        return view('frontend.products.foreign-currency-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "currency"));
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
                $lastRange = array_last($productRanges);;
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

    public function  getContactForm()
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

    public function  getBlogByCategories($id = null)
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

    public function wealth($request) {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();

        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';

        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')

        ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
        ->join('promotion_formula', 'promotion_products.formula_id','=', 'promotion_formula.id')
        ->where('promotion_products.promotion_type_id', '=', 2)
        ->where('promotion_products.promotion_start', '<=', $start_date)
        ->where('promotion_products.promotion_end', '>=', $end_date)
        ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
        ->get();


        $details = \Helper::get_page_detail(WEALTH_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];

        foreach ($promotion_products as $product) {
            $status = false;
            $product_range = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            if (($search_filter['filter'] == 'Placement' || $search_filter['filter'] == 'Interest') && $product->promotion_formula_id != 14 && $product->promotion_formula_id != 13) {
                //echo $brand_id;
                if (!empty($brand_id) && $brand_id == $product->brand_id) {
                    $status = true;
                    //echo "arv";

                }
                foreach ($product_range as $range) {
                    if (!empty($brand_id)) {

                        if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Placement' && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) && !empty($brand_id) && $brand_id == $product->brand_id) {
                            $status = true;
                        } elseif (!empty($search_filter['search_value']) && ($search_filter['filter'] == 'Interest') && !empty($brand_id) && $brand_id == $product->brand_id && ($product->promotion_formula_id == 11 || $product->promotion_formula_id == 12)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Placement' && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) || (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        } elseif (!empty($search_filter['search_value']) && ($search_filter['filter'] == 'Interest') || (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 11 || $product->promotion_formula_id == 12)) {
                            $status = true;
                        }
                    }
                }
            } else {
                if (!empty($brand_id)) {
                    if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Tenor' && (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 12 || $product->promotion_formula_id == 15)) {
                        $status = true;
                    }
                } else {
                    if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Tenor' || (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 12 || $product->promotion_formula_id == 15)) {
                        $status = true;
                    }
                }

            }
            if ((($search_filter['filter'] == 'Placement')) && $product->promotion_formula_id == 13 && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                $status = true;
            }
            if ($status == true) {
                $filterProducts[] = $product;
            }
        }

        $promotion_products = $filterProducts;
        //dd($promotion_products);
        return view('frontend.products.wealth-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter"));
    }

    public function search_fixed_deposit(Request $request)
    {
        return $this->fixed($request->all());
    }

    public function fixed($request) {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();

        //dd($request->all());
        $details = \Helper::get_page_detail(FIXED_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';
        //dd($brand_id);
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 1)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->select('brands.id as brand_id', 'promotion_products.*', 'promotion_types.*', 'promotion_formula.*', 'brands.*')
            ->get();


        $filterProducts = [];

        foreach ($promotion_products as $product) {
            $status = false;
            $product_range = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            if (($search_filter['filter'] == 'Placement') || ($search_filter['filter'] == 'Interest')) {
                if (!empty($brand_id) && $brand_id == $product->brand_id) {
                    $status = true;
                }
                foreach ($product_range as $range) {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Placement' && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) && !empty($brand_id) && $brand_id == $product->brand_id) {
                            $status = true;
                        } elseif (!empty($search_filter['search_value']) && ($search_filter['filter'] == 'Interest') && (in_array($search_filter['search_value'], $range->bonus_interest)) && !empty($brand_id) && $brand_id == $product->brand_id) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Placement' && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) || (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        } elseif (!empty($search_filter['search_value']) && ($search_filter['filter'] == 'Interest') && (in_array($search_filter['search_value'], $range->bonus_interest)) || (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        }
                    }
                }
            } else {
                if (!empty($brand_id)) {
                    if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Tenor' && (in_array($search_filter['search_value'], $tenures)) && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                        $status = true;
                    }
                } else {
                    if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Tenor' && (in_array($search_filter['search_value'], $tenures)) || (!empty($brand_id) && $brand_id == $product->brand_id)) {
                        $status = true;
                    }
                }

            }
            if ($status == true) {
                $filterProducts[] = $product;
            }
        }

        $promotion_products = $filterProducts;
        //dd($promotion_products);

        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter"));
    }

    public function search_saving_deposit(Request $request)
    {
        return $this->saving($request);
    }

    public function saving($request) {
        //dd($request->all());
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();

        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';

        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 2)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
            ->get();


        $details = \Helper::get_page_detail(SAVING_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];

        foreach ($promotion_products as $product) {
            $status = false;
            $product_range = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            if (($search_filter['filter'] == 'Placement' || $search_filter['filter'] == 'Interest') && $product->promotion_formula_id != 5 && $product->promotion_formula_id != 4) {
                //echo $brand_id;
                if (!empty($brand_id) && $brand_id == $product->brand_id) {
                    $status = true;
                    //echo "arv";

                }
                foreach ($product_range as $range) {
                    if (!empty($brand_id)) {

                        if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Placement' && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) && !empty($brand_id) && $brand_id == $product->brand_id) {
                            $status = true;
                        } elseif (!empty($search_filter['search_value']) && ($search_filter['filter'] == 'Interest') && !empty($brand_id) && $brand_id == $product->brand_id && ($product->promotion_formula_id == 2 || $product->promotion_formula_id == 3)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Placement' && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) || (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        } elseif (!empty($search_filter['search_value']) && ($search_filter['filter'] == 'Interest') || (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 2 || $product->promotion_formula_id == 3)) {
                            $status = true;
                        }
                    }
                }
            } else {
                if (!empty($brand_id)) {
                    if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Tenor' && (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 3 || $product->promotion_formula_id == 6)) {
                        $status = true;
                    }
                } else {
                    if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Tenor' || (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 3 || $product->promotion_formula_id == 6)) {
                        $status = true;
                    }
                }

            }
            if ((($search_filter['filter'] == 'Placement')) && $product->promotion_formula_id == 4 && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                $status = true;
            }
            if ($status == true) {
                $filterProducts[] = $product;
            }
        }

        $promotion_products = $filterProducts;
        //dd($promotion_products);
        return view('frontend.products.saving-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter"));
    }

    public function product_search_homepage(Request $request)
    {
        //dd($request->all());
        $account_type = $request->account_type;

        $request = [
            'filter'    =>  'Placement',
            'search_value'  =>  $request->search_value
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

    public function foreign_currency($request) {
        $start_date = \Helper::startOfDayBefore();
        $end_date = \Helper::endOfDayAfter();

        $currency = isset($request->currency) ? $request->currency : '';
        $search_filter = [];
        $search_filter = $request;
        $brand_id = isset($request['brand_id']) ? $request['brand_id'] : '';

        $currency_list = Currency::get();
        $search_currency = Currency::find($currency);

        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
        ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
        ->join('promotion_formula', 'promotion_products.formula_id','=', 'promotion_formula.id')
        ->where('promotion_products.promotion_type_id', '=', 5)
        ->where('promotion_products.promotion_start', '<=', $start_date)
        ->where('promotion_products.promotion_end', '>=', $end_date)
        ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
        ->get();

        $details = \Helper::get_page_detail(FOREIGN_CURRENCY_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        $filterProducts = [];

        //dd($promotion_products);

        foreach ($promotion_products as $product) {
            //dd($product);
            $status = false;
            $product_range = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            if (!empty($request->currency)) {
                $status = true;
            }
            if (($search_filter['filter'] == 'Placement' || $search_filter['filter'] == 'Interest') && $product->promotion_formula_id != 20 && $product->promotion_formula_id != 19) {
                if (!empty($brand_id) && $brand_id == $product->brand_id) {
                    $status = true;
                }

                foreach ($product_range as $range) {
                    if (!empty($brand_id)) {
                        if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Placement' && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) && !empty($brand_id) && $brand_id == $product->brand_id) {
                            $status = true;
                        } elseif (!empty($search_filter['search_value']) && ($search_filter['filter'] == 'Interest') && !empty($brand_id) && $brand_id == $product->brand_id && ($product->promotion_formula_id == 17 || $product->promotion_formula_id == 18)) {
                            $status = true;
                        }
                    } else {
                        if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Placement' && ($search_filter['search_value'] >= $range->min_range && $search_filter['search_value'] <= $range->max_range) || (!empty($brand_id) && $brand_id == $product->brand_id)) {
                            $status = true;
                        } elseif (!empty($search_filter['search_value']) && ($search_filter['filter'] == 'Interest') || (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 17 || $product->promotion_formula_id == 18)) {
                            $status = true;
                        }
                    }
                }
            } else {
                if (!empty($brand_id)) {
                    if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Tenor' && (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 18 || $product->promotion_formula_id == 21)) {
                        $status = true;
                    }
                } else {
                    if (!empty($search_filter['search_value']) && $search_filter['filter'] == 'Tenor' || (!empty($brand_id) && $brand_id == $product->brand_id) && ($product->promotion_formula_id == 18 || $product->promotion_formula_id == 21)) {
                        $status = true;
                    }
                }

            }
            if ((($search_filter['filter'] == 'Placement')) && $product->promotion_formula_id == 19 && (!empty($brand_id) && $brand_id == $product->brand_id)) {
                $status = true;
            }
            if ($status == true) {
                $filterProducts[] = $product;
            }
        }



        $promotion_products = $filterProducts;
        //dd($search_currency);
        return view('frontend.products.foreign-currency-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter", "currency_list", "search_currency"));
    }


    public function search_aioa_deposit(Request $request)
    {
        return $this->aio($request);
    }

    public function aio($request) {
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
                            $placement = ($productRange->min_range -1);

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
