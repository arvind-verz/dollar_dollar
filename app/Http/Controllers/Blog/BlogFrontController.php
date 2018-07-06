<?php

namespace App\Http\Controllers\Blog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use App\Menu;
use Illuminate\Support\Facades\Auth;

class BlogFrontController extends Controller
{
    /**
     * @param $id
     * @return array
     */
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

        return view("frontend.Blog.blog-list", compact("details", "page", "banners", 'systemSetting'));
    }

    public function  getBlogDetail($slug)
    {
        $page = Page::where('pages.slug', $slug)
            ->where('delete_status', 0)->first();
        if (!$page) {
            return redirect()->action('Blog\BlogController@index')->with('error', OPPS_ALERT);
        } else {
            //dd($page);
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
        if (Auth::guest()) {
            $details = $query->whereIn('after_login', [0, null])->get();

        } else {
            $details = $query->get();
        }


        return view("frontend.Blog.blog-detail", compact("details", "page", "banners", 'systemSetting'));
    }
}
