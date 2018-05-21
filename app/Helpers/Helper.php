<?php
namespace App\Helpers\Helper;

use App\Banner;
use App\Brand;
use App\Category;
use App\Homepage;
use App\Menu;
use App\Pricelist;
use App\Product;
use App\SystemSetting;
use Auth;
use App\BlogCategory;
use App\Blog;
use App\Tag;
use App\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class Helper
{
    //get all categories
    public static function getCategories($id)
    {
        $details = [];
        $categories = Category::orderBy('view_order', 'ASC')
            ->where('parent', $id)
            ->where('delete_status', 0)
            ->get();
        $categoriesCount = $categories->count();
        $details['categories'] = $categories;
        $details['count'] = $categoriesCount;

        return $details;
    }

    /* //get all parent categories with count
     public static function getParentCategories($id)
     {
         $details = [];
         $categories = Category::orderBy('view_order', 'ASC')
             ->where('parent', $id)
             ->get();
         $categoriesCount = $categories->count();
         if ($categoriesCount > 4) {
             $categories = $categories->all();
         }
         $details['categories'] = $categories;
         $details['count'] = $categoriesCount;

         return $details;
     }*/

    //get all parent categories with count
    public static function getBreadCumsCategory($id)
    {
        $categories = [];
        $category = Category::find($id);
        array_push($categories, ['id' => $category->id, 'category' => $category->category]);

        $parentId = $category->parent;
        while ($parentId != 0) {
            $category = Category::find($parentId);
            array_push($categories, ['id' => $category->id, 'category' => $category->category]);
            $parentId = $category->parent;
        }


        return array_reverse($categories);

    }

    //get all parent categories by division
    public static function getBreadCumsCategoryByDivision($division)
    {
        $categories = [];
        $category = Category::where('division', $division)->first();
        array_push($categories, ['division' => $category->division, 'category' => $category->category]);

        $parentId = $category->parent;
        while ($parentId != 0) {
            $category = Category::find($parentId);
            array_push($categories, ['division' => $category->division, 'category' => $category->category]);
            $parentId = $category->parent;
        }


        return array_reverse($categories);

    }

    //get all parent categories by division
    public static function getBreadCumsCategoryByMenus($menuId)
    {
        $menus = [];
        $menu = Menu::join('pages', 'menus.id', '=', 'pages.menu_id')->where('menus.id', $menuId)->select('pages.*')->first();

        array_push($menus, ['id' => $menu->id, 'title' => $menu->name, 'slug' => $menu->slug]);

        $parentMenuId = $menu->parent;
        while ($parentMenuId != 0) {
            $menu = Menu::find($parentMenuId);
            array_push($menus, ['id' => $menu->id, 'title' => $menu->title, 'slug' => $menu->slug]);
            $parentMenuId = $menu->parent;
        }

        return array_reverse($menus);

    }

    /*get pages from page table this pages are manually add in database */
    public static function getPages()
    {
        $pages = DB::table('pages')
            ->orderBy('name', 'asc')
            ->where('delete_status', 0)
            ->where('status', 1)
            ->get();

        return $pages;
    }

    /*get homepage id*/
    public static function getHomePage()
    {
        $homePage = Homepage::where('delete_status', 0)->first();
        return $homePage;
    }

    /*get banners*/
    public static function getBanners($slug)
    {
        $banners = Banner::join('pages', 'pages.id', '=', 'banners.page_id')
            ->where('banners.delete_status', 0)
            ->where('pages.delete_status', 0)
            ->where('pages.slug', $slug)
            ->select('banners.*', 'pages.slug')
            ->orderBy('banners.view_order', 'ASC')
            ->get();
        //dd($slug);
        return $banners;
    }

    /*get Brands*/
    public static function getBrands()
    {
        $brands = Brand::where('delete_status', 0)
            ->orderBy('view_order', 'ASC')
            ->get();
        return $brands;
    }

    /*get banners*/
    public static function getHomeCategories()
    {
        $homePage = Homepage::where('delete_status', 0)
            ->first();
        if ($homePage['categories'] != null) {

            $homePage['categories'] = unserialize($homePage['categories']);
            foreach ($homePage['categories'] as $k => $v) {

                $homePage[$k] = $v;
            }
        }
        if ($homePage['promotion'] != null) {

            $homePage['promotion'] = unserialize($homePage['promotion']);
            foreach ($homePage['promotion'] as $k => $v) {

                $homePage[$k] = $v;
            }
            $homePage = (object)$homePage;
        }
        return $homePage;
    }

    static function  getDownload($file_path, $file_name)
    {
        //PDF file is stored under project/public/download/info.pdf
        $file = public_path() . '/' . $file_path;
        $headers = array(
            'Content-Type: application/pdf',
        );

        return Response::download($file, $file_name, $headers);
    }

    static function getProductUnserialize($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', OPPS_ALERT);
        }
        //dd($product);
        if ($product->image_array != null) {
            $product->image_array = unserialize($product->image_array);
        } else {
            $product->image_array = [];
        }
        if ($product->brochure_array != null) {
            $product->brochure_array = unserialize($product->brochure_array);
        } else {
            $product->brochure_array = [];
        }
        if ($product->manual_array != null) {
            $product->manual_array = unserialize($product->manual_array);
        } else {
            $product->manual_array = [];
        }
        if ($product->related_products != null) {
            $product->related_products = unserialize($product->related_products);
        } else {
            $product->related_products = [];
        }
        return $product;
    }

    static function getPriceByProduct($id, $priceListName = 'USD-A')
    {
        //dd($priceList);
        $productPrice = null;
        //find price list
        if ((Auth::user()) && (Auth::user()->price_list != null)) {
            $priceList = Pricelist::find(Auth::user()->price_list);
        } else {
            $priceList = Pricelist::where('label', $priceListName)->first();
        }
        //dd($priceList);
        //find product and then if find product then get product price by price list.
        $product = Product::select($priceList->name)->where('id', $id)->first();


        if ($product) {
            $product = $product->toArray();
            $productPrice = $product[$priceList->name];
        }


        return $productPrice;
    }

    static function getMainPriceCat()
    {
        $priceList = [];
        $priceList['USD'] = Pricelist::where('label', 'LIKE', 'USD%')->pluck('id')->all();
        $priceList['SGD'] = Pricelist::where('label', 'LIKE', 'SGD%')->pluck('id')->all();

        return $priceList;
    }

    //get all menus
    public static function getMenus()
    {
        $menus = [];
        DB::enableQueryLog();
        $details = Menu::leftJoin('pages', 'pages.menu_id', '=', 'menus.id')
            ->orderBy('menus.view_order', 'ASC')
            ->where('menus.delete_status', 0)
            ->select('menus.*', 'pages.name', 'pages.slug', 'pages.after_login')
            ->get();
        //dd(DB::getQueryLog());
        //dd(json_encode($details));
        if (Auth::guest()) {
            if ($details->count()) {
                $details = $details->whereIn('pages.after_login', [0, null]);
            }
        }

        if ($details->count()) {
            $filter_data = $details->filter(function ($detail) {
                if (($detail->child != 0) || ($detail->slug != null))
                    return $detail;
            });

            $menus = $filter_data->groupBy('parent')->toArray();
        }
        
        //dd($menus);
        return $menus;
    }

    public static function getBlogMenus()
    {
        $details = [];
        $categories = Menu::orderBy('view_order', 'ASC')
            ->where('delete_status', 0)
            ->where('main', BLOG_MENU_ID)
            ->get();
        if ($categories->count()) {
            $details = $categories->groupBy('parent')->toArray();

        }
        // dd($details);
        return $details;
    }

    public static function getMenuCategories()
    {
        $details = [];
        $categories = BlogCategory::orderBy('view_order', 'ASC')
            ->where('delete_status', 0)
            ->get();
        if ($categories->count()) {
            $details = $categories->groupBy('parent')->toArray();

        }

        return $details;
    }

    public static function getSystemSetting()
    {
        $systemSetting = SystemSetting::where('delete_status', 0)
            ->orderBy('id', 'desc')
            ->first();
        if (!$systemSetting) {
            return back()->with('error', OPPS_ALERT);
        }
        return $systemSetting;
    }

    public static function getBackEndMenu()
    {
        $checkMenuPermission = \DB::table('role_type_access')
            ->join('modules', 'role_type_access.module_id', '=', 'modules.id')
            ->where(['role_type_access.role_type_id' => @Auth::user()->role_type_id, 'role_type_access.view' => 1])
            ->select('role_type_access.module_id', 'modules.name', 'modules.label', 'modules.icon')
            ->orderBy('modules.view_order', 'asc')
            ->get();

        return $checkMenuPermission;

    }


    /* TAGS */
    public static function getTags($tags_id) {
        $sel_query = Tag::whereIn('id', $tags_id)->get();
        return $sel_query;
        //dd($sel_query);
    }

    public static function searchTags($slug) {
        //dd($slug);
        $sel_query = Tag::where('title', '=', $slug)->get();
        $tag_id = $sel_query[0]->id;
        $tags_found = [];
        $sel_query = Page::whereNotNull('tags')->get();
        //dd($sel_query[0]->tags);
        foreach($sel_query as $value) {
            $mytags = json_decode($value->tags);
            //print_r($tag_id);
            if(in_array($tag_id, $mytags)) {
                $tags_found[] = $value->id;
            }
        }
        return $tags_found;
        
    }
    /* END TAGS */

    /* PRODUCTS */
    public function getProducts($slug=NULL) {
        //$sel_query = PromotionProducts::join('pages')
    }
    /* END PRODUCTS */

}