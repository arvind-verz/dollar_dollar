<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Page;
use App\ProductManagement;
use Illuminate\Http\Request;
use App\Brand;
use DB;
use Illuminate\Support\Facades\Auth;


class PagesFrontController extends Controller
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
                    return view('frontend.user.profile-dashboard', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == ACCOUNTINFO) {
                    return view('frontend.user.account-information', compact("brands", "page", "systemSetting", "banners"));
                } elseif ($slug == PRODUCTMANAGEMENT) {
                    return view('frontend.user.product-management', compact("brands", "page", "systemSetting", "banners", "user_products"));
                } elseif ($slug == FIXED_DEPOSIT_MODE) {
                    $details = [];
                    $details['brands'] = $brands;
                    $details['page'] = $page;
                    $details['systemSetting'] = $systemSetting;
                    $details['banners'] = $banners;

                    /*sent all pages detail into this function and than return to blade file*/
                    return $this->fixDepositMode($details);

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
        $brands = $details['brands'];
        $page = $details['page'];
        $systemSetting = $details['systemSetting'];
        $banners = $details['banners'];
        return view('frontend.products.fixed-deposit-products', compact("brands", "page", "systemSetting", "banners"));
    }
}
