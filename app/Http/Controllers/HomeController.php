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
        $promotion_products = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_products.promotion_type_id', '=', 1)
            ->where('promotion_products.promotion_start', '<=', $start_date)
            ->where('promotion_products.promotion_end', '>=', $end_date)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->orderBy('promotion_products.featured', 'DESC')
            ->select('brands.id as brand_id', 'promotion_products.id as promotion_product_id', 'promotion_products.*', 'promotion_types.*', 'promotion_formula.*', 'brands.*')
            ->get();

        $filterNewProducts = $orginalProducts = [];
//dd($promotion_products);
        if (!empty($request)) {
            foreach ($promotion_products as $product) {
                $promotion_product_id = $product->promotion_product_id;
                $sort_by_arr          = $result_data_old          = [];
                $product_range        = json_decode($product->product_range);
                $tenures              = json_decode($product->tenure);
                $P                    = $request['search_value'];
                foreach ($product_range as $key => $range) {
//print_r($range);
                    if ($search_filter == 'Interest') {
                        $P = $product_range[0]->max_range;
                        if ($key == 0) {
                            for ($i = 0; $i < count($tenures); $i++) {
                                $BI        = ($range->bonus_interest[$i] / 100);
                                $TM        = $tenures[$i];
                                $calc      = eval('return ' . $product->formula . ';');
                                $days_type = \Helper::days_or_month_or_year(2, $tenures[$i]);

                                $sort_by_arr[]     = $range->bonus_interest[$i];
                            }
                        }
                    } elseif ($search_filter == 'Tenor' || $search_filter == 'Placement') {
                        $P = $product_range[0]->max_range;
                        if ($P >= $range->min_range && $P <= $range->max_range) {
                            for ($i = 0; $i < count($tenures); $i++) {
                                $BI        = ($range->bonus_interest[$i] / 100);
                                $TM        = $tenures[$i];
                                $calc      = eval('return ' . $product->formula . ';');
                                $days_type = \Helper::days_or_month_or_year(2, $tenures[$i]);
//print_r($calc);echo '<br>';
                                $sort_by_arr[]     = round($calc);
                            }
                        }
                    }
                }
//dd($result_data);
                if (count($sort_by_arr)) {
                    $sort_by_new_arr = min($sort_by_arr);
                    if($search_filter == 'Interest') {
                        $sort_by_new_arr = max($sort_by_arr);                    
                    }
//print_r($sort_by_new_arr);echo '<br>';
                    $filterNewProducts[$promotion_product_id] = $sort_by_new_arr;
                }
            }
//dd($result_data);

            if (!empty($filterNewProducts)) {
                asort($filterNewProducts);
                if($search_filter == 'Interest') {
                    arsort($filterNewProducts);
                }
            }

            foreach ($filterNewProducts as $key => $value) {
                $orginalProducts[] = $promotion_products->where('promotion_product_id', $key)->first();
            }
        }
        $promotion_products = $orginalProducts;
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
