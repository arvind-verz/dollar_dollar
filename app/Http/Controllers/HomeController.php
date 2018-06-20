<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Page;
use App\Helpers\Helper;
use App\SystemSetting;
use App\PromotionProducts;
use App\systemSettingHomepage;
use DB;


class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','getContactForm']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $systemSettingHomepage = systemSettingHomepage::where('delete_status', 0)
            ->get();
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
        ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
        ->join('promotion_formula', 'promotion_products.formula_id','=', 'promotion_formula.id')
        ->where('promotion_products.promotion_start', '<=', DB::raw('CURDATE()'))
        ->where('promotion_products.promotion_end', '>=', DB::raw('CURDATE()'))
        ->select('promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*')
        ->get();
        //dd($promotion_products);
        $blogs = Page::where('delete_status', 0)
        ->where('is_blog', 1)
        ->inRandomOrder()
        ->limit(5)
        ->get();
        //dd($blogs);
        $page = Page::where('delete_status', 0)->where('slug', HOME_SLUG)->first();
        if (!$page) {
            return back()->with('error', OPPS_ALERT);
        }
        $brands = Brand::where('delete_status', 0)->orderBy('view_order', 'asc')->get();

        $systemSetting = \Helper::getSystemSetting();
        if (!$systemSetting) {
            return back()->with('error', OPPS_ALERT);
        }
        return view('home', compact("brands", "page", "systemSetting", "blogs", "promotion_products", "systemSettingHomepage"));
    }



}
