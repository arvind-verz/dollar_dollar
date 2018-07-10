<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Helpers\Helper;
use App\Page;
use App\PromotionProducts;
use App\systemSettingHomepage;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'getContactForm', 'depositType']]);
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
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
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

    public function depositType(Request $request)
    {
        $start_date = \Helper::startOfDayBefore();
        $end_date   = \Helper::endOfDayAfter();

        $search_filter = isset($request->type) ? $request->type : '';
//dd($brand_id);
        DB::connection()->enableQueryLog();
        if ($search_filter == 'Interest') {
            $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
                ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
                ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
                ->where('promotion_products.promotion_type_id', '=', 1)
                ->where('promotion_products.promotion_start', '<=', $start_date)
                ->where('promotion_products.promotion_end', '>=', $end_date)
                ->where('promotion_products.delete_status', '=', 0)
                ->where('promotion_products.status', '=', 1)
                ->orderBy('promotion_products.maximum_interest_rate', 'DESC')
                ->select('brands.id as brand_id', 'promotion_products.id as promotion_product_id', 'promotion_products.*', 'promotion_types.*', 'promotion_formula.*', 'brands.*')
                ->get();
        }
        elseif ($search_filter == 'Placement') {
            $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
                ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
                ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
                ->where('promotion_products.promotion_type_id', '=', 1)
                ->where('promotion_products.promotion_start', '<=', $start_date)
                ->where('promotion_products.promotion_end', '>=', $end_date)
                ->where('promotion_products.delete_status', '=', 0)
                ->where('promotion_products.status', '=', 1)
                ->orderBy('promotion_products.minimum_placement_amount', 'ASC')
                ->select('brands.id as brand_id', 'promotion_products.id as promotion_product_id', 'promotion_products.*', 'promotion_types.*', 'promotion_formula.*', 'brands.*')
                ->get();
        }
        else {
            $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
                ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
                ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
                ->where('promotion_products.promotion_type_id', '=', 1)
                ->where('promotion_products.promotion_start', '<=', $start_date)
                ->where('promotion_products.promotion_end', '>=', $end_date)
                ->where('promotion_products.delete_status', '=', 0)
                ->where('promotion_products.status', '=', 1)
                ->orderBy('promotion_products.promotion_period', 'ASC')
                ->select('brands.id as brand_id', 'promotion_products.id as promotion_product_id', 'promotion_products.*', 'promotion_types.*', 'promotion_formula.*', 'brands.*')
                ->get();
        }

        
//dd($result_data);
        $i = 1;
        foreach ($promotion_products as $products) {
            if ($products->promotion_type_id == 1 && $i <= 4) {
                ?>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                <div class="ps-block--short-product"><img src="<?php echo asset($products->brand_logo); ?>" alt="">
                    <h4>up to <strong> <?php echo $products->maximum_interest_rate; ?>%</strong></h4>

                    <div class="ps-block__info">
                    <p><strong> rate: </strong>1.3%</p>

                    <p><strong>Min:</strong> SGD $<?php echo $products->minimum_placement_amount; ?></p>

                    <p class="highlight"><?php echo $products->promotion_period; ?> Months</p>
                    </div>
                <a class="ps-btn" href="<?php echo url('fixed-deposit-mode'); ?>">More info</a>
                </div>
            </div>
            <?php
            $i++;
            }}
    }

}
