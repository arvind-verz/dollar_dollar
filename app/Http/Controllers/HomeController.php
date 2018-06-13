<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Page;
use App\Helpers\Helper;
use App\SystemSetting;


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
        return view('home', compact("brands", "page", "systemSetting", "blogs"));
    }



}
