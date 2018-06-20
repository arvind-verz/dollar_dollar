<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Page;
use App\ProductManagement;
use App\PromotionProducts;
use Illuminate\Http\Request;
use App\Brand;
use DB;
use Carbon\Carbon;
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
                    if(AUTH::check()) {
                        return view('frontend.user.profile-dashboard', compact("brands", "page", "systemSetting", "banners"));
                    }                    
                    else {
                        return redirect('/login');
                    }
                } elseif ($slug == ACCOUNTINFO) {
                    if(AUTH::check()) {
                        return view('frontend.user.account-information', compact("brands", "page", "systemSetting", "banners"));
                    }                    
                    else {
                        return redirect('/login');
                    }
                    
                } elseif ($slug == PRODUCTMANAGEMENT) {
                    if(AUTH::check()) {
                         return view('frontend.user.product-management', compact("brands", "page", "systemSetting", "banners", "user_products"));
                    }                    
                    else {
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

    public function fixDepositMode($details)
    {

        $curr_date = Carbon::today();
            //dd($startDate);
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
        ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
        ->join('promotion_formula', 'promotion_products.formula_id','=', 'promotion_formula.id')
        ->where('promotion_formula.promotion_id', '=', 1)
        ->where('promotion_products.promotion_start', '<=', $curr_date)
        ->where('promotion_products.promotion_end', '>=', $curr_date)
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

        $curr_date = Carbon::today();
        
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
        ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
        ->join('promotion_formula', 'promotion_products.formula_id','=', 'promotion_formula.id')
        ->where('promotion_formula.promotion_id', '=', 2)
        ->where('promotion_products.promotion_start', '<=', $curr_date)
        ->where('promotion_products.promotion_end', '>=', $curr_date)
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

    public function search_fixed_deposit(Request $request) {
        $curr_date = Carbon::today();
        
        //dd($request->all());
        $details = \Helper::get_page_detail(FIXED_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        
        $search_filter = [];
        $search_filter = $request->all();
        $brand_id = $request->brand_id;
        //dd($brand_id);
        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
        ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
        ->join('promotion_formula', 'promotion_products.formula_id','=', 'promotion_formula.id')
        ->where('promotion_formula.promotion_id', '=', 1)
        ->where('promotion_products.promotion_start', '<=', $curr_date)
        ->where('promotion_products.promotion_end', '>=', $curr_date)
        ->select('brands.id as brand_id', 'promotion_products.*', 'promotion_types.*', 'promotion_formula.*', 'brands.*')
        ->get();

        if((!is_null($search_filter['filter']) && (!is_null($search_filter['search_value']))) || !is_null($brand_id)){
            $filterProducts = [];
        foreach ($promotion_products as $product) {
            $status= false;
            $product_range = json_decode($product->product_range);
            $tenures = json_decode($product->tenure);
            if(($search_filter['filter']=='Placement') || ($search_filter['filter']=='Interest')){
            foreach ($product_range as $range) {
                
                if(($search_filter['filter']=='Placement') && ($search_filter['search_value']>=$range->min_range && $search_filter['search_value']<=$range->max_range))
                {  
                    $status = true;
                   
                }
                elseif( ($search_filter['filter']=='Interest') && (in_array($search_filter['search_value'],$range->bonus_interest)))
                {
                        $status = true;
                }


            }
        }elseif($search_filter['filter']=='Tenor' && (in_array($search_filter['search_value'],$tenures))){
                $status = true;
            }
            if(!empty($brand_id) && $brand_id==$product->brand_id) {
                
                $status = true;
            }

            if($status==true)
            {
                $filterProducts[]=$product;
            }
        }
        $promotion_products=$filterProducts;


    }
        //dd($promotion_products);

        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter"));
    }

    public function search_saving_deposit(Request $request) {
        //dd($request->all());
        $curr_date = Carbon::today();

        $search_filter = [];
        $search_filter = $request->all();

        DB::connection()->enableQueryLog();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
        ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
        ->join('promotion_formula', 'promotion_products.formula_id','=', 'promotion_formula.id')
        ->where('promotion_formula.promotion_id', '=', 2)
        ->where('promotion_products.promotion_start', '<=', $curr_date)
        ->where('promotion_products.promotion_end', '>=', $curr_date)
        ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
        ->get();

        $details = \Helper::get_page_detail(SAVING_DEPOSIT_MODE);
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];

        if(!is_null($search_filter['filter']) && (!is_null($search_filter['search_value']))) {
            $filterProducts = [];
            foreach ($promotion_products as $product) {
                $status= false;
                $product_range = json_decode($product->product_range);
                   //dd($product); 
                if((($search_filter['filter']=='Placement') || ($search_filter['filter']=='Interest')) && $product->promotion_formula_id!=5 && $product->promotion_formula_id!=4){
                foreach ($product_range as $range) {
                    //var_dump($product_range);
                    if(($search_filter['filter']=='Placement') && ($search_filter['search_value']>=$range->min_range && $search_filter['search_value']<=$range->max_range))
                    {  
                        $status = true;
                       
                    }
                    elseif($search_filter['filter']=='Interest'  && ($product->promotion_formula_id==2 || $product->promotion_formula_id==3))
                    {
                            $status = true;
                    }


                }
            }elseif($search_filter['filter']=='Tenor' && ($product->promotion_formula_id==3 || $product->promotion_formula_id==6)) {
                    $status = true;
                }


                if((($search_filter['filter']=='Placement')) && $product->promotion_formula_id==4) {
                    $status = true;
                }
                if($status==true)
                {
                    $filterProducts[]=$product;
                }
            }
            $promotion_products=$filterProducts;
        }
        //dd($promotion_products);
        return view('frontend.products.saving-deposit-products', compact("brands", "page", "systemSetting", "banners", "promotion_products", "search_filter"));
    }
}
