<?php

namespace App\Http\Controllers\Products;

use App\Brand;
use App\FormulaVariable;
use App\Http\Controllers\Controller;
use App\Mail\Reminder;
use App\PlacementRange;
use App\ProductName;
use App\PromotionFormula;
use App\PromotionProducts;
use App\RateType;
use App\Rules\MaxRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\DefaultSearch;
use App\ToolTip;
use App\systemSettingLegendTable;
use App\Currency;
use App\ProductManagement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use DateTime;
use Exception;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function promotion_products($productTypeId = FIX_DEPOSIT)
    {

        $defaultSearch = DefaultSearch::where('promotion_id', $productTypeId)->first();
        $products = \Helper::getProducts($productTypeId);
        $productType = $this->productType($productTypeId);
        $toolTips = ToolTip::where('promotion_id', $productTypeId)->first();
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_products', compact('CheckLayoutPermission', 'defaultSearch', 'products', 'productType', 'productTypeId', 'toolTips'));
    }

    public function promotion_products_add($productTypeId)
    {
        //dd($productTypeId);
        $legends = systemSettingLegendTable::where('delete_status', 0)->where('page_type', $productTypeId)->get();
        $promotion_types = \Helper::getPromotionType($productTypeId);
        $formulas = \Helper::getAllFormula($productTypeId);
        $banks = Brand::where('delete_status', 0)->where('display', 1)->orderBy('title', 'asc')->get();
        $productType = $this->productType($productTypeId);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        $currencies = Currency::where('delete_status', 0)->get();
        if ($productTypeId == LOAN) {
            $rateTypes = RateType::where('delete_status', 0)->get();
            return view('backend.products.loan_products_add', compact('rateTypes', 'CheckLayoutPermission', 'promotion_types', 'formulas', 'banks', 'productType', 'productTypeId', 'legends', 'currencies'));
        } else {
            return view('backend.products.promotion_products_add', compact('CheckLayoutPermission', 'promotion_types', 'formulas', 'banks', 'productType', 'productTypeId', 'legends', 'currencies'));

        }
    }

    public function promotion_products_get_formula(Request $request)
    {
        $sel_query = \Helper::getAllFormula($request->promotion_type);


        //print_r($sel_query);
        ?>
        <option value="">None</option>
        <?php
        if ($sel_query->count()) {
            foreach ($sel_query as $value) { ?>
                <option
                    value="<?php echo $value->id; ?>" <?php if ($value->id == $request->formula) echo "selected=selected"; ?> ><?php echo $value->name ?></option>
            <?php }
        }
    }

    public function promotion_products_add_db(Request $request)
    {

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);

        $destinationPath = 'uploads/products'; // upload path
        $adHorizontalImage = $adHorizontalPopupImage = $adHorizontalPopupImageTop = null;
        $adVerticalImage = null;
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/products')) {
            mkdir('uploads/products');
        }


        if ($request->hasFile('ad_horizontal_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image')->move($destinationPath, $adHorizontalImage);
        }
        if ($request->hasFile('ad_image_vertical')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_image_vertical')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_image_vertical')->getClientOriginalExtension();
            // Filename to store
            $adVerticalImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_image_vertical')->move($destinationPath, $adVerticalImage);
        }
        if ($request->hasFile('ad_horizontal_image_popup')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image_popup')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image_popup')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalPopupImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image_popup')->move($destinationPath, $adHorizontalPopupImage);
        }
        if ($request->hasFile('ad_horizontal_image_popup_top')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image_popup_top')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image_popup_top')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalPopupImageTop = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image_popup_top')->move($destinationPath, $adHorizontalPopupImageTop);
        }

        $product = new PromotionProducts();
        if(isset($request->shortlist_status))
        {
            $product->shortlist_status = $request->shortlist_status;
        }
        $product->product_name = $request->name;
        $product->bank_id = $request->bank;
        $product->bank_sub_title = $request->bank_sub_title;
        $product->apply_link = $request->apply_link;
        $product->apply_link_status = $request->apply_link_status;
        $product->promotion_type_id = $request->product_type;
        $product->formula_id = $request->formula;
        if (isset($request->until_end_date)) {
            $product->until_end_date = $request->until_end_date;
        } else {
            $product->until_end_date = null;
        }

        if ($request->product_type == LOAN) {
            $product->minimum_loan_amount = $request->minimum_loan_amount;
            $product->lock_in = $request->lock_in;
        } else {
            $product->maximum_interest_rate = $request->maximum_interest_rate;
            $product->promotion_period = $request->promotion_period;
            $product->minimum_placement_amount = $request->minimum_placement_amount;
        }
        $ranges = null;

        if ($product->promotion_type_id == FOREIGN_CURRENCY_DEPOSIT) {
            $product->currency = $request->currency;
        }
        if ($request->formula) {
            $ranges = [];
            if (in_array($product->formula_id, [FIX_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F6, FOREIGN_CURRENCY_DEPOSIT_F1])) {
                foreach ($request->min_placement as $k => $v) {
                    $max = $request->max_placement;
                    $legends = $request->legend;
                    $bonusInterest = $request->bonus_interest;
                    $range = [];
                    $range['min_range'] = (int)$v;
                    $range['max_range'] = (int)$max[$k];
                    $range['legend'] = (int)$legends[$k];
                    $range['bonus_interest'] = array_values(array_map('floatVal', $bonusInterest[$k]));
                    $ranges[] = $range;

                }

                $tenure = $request->tenure;
                $tenure = json_encode(array_values(array_map('intVal', $tenure[0])));
                $ranges = json_encode(array_values($ranges));
                //dd($ranges);
                $product->tenure = $tenure;
            }
            if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, SAVING_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F3])) {
                foreach ($request->min_placement_sdp1 as $k => $v) {
                    $max = $request->max_placement_sdp1;
                    $bonusInterest = $request->bonus_interest_sdp1;
                    $boardInterest = $request->board_rate_sdp1;
                    $range = [];
                    if (in_array($product->formula_id, [SAVING_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F3])) {
                        $range['tenure'] = $request->tenure_sdp1;

                    }
                    $range['min_range'] = (int)$v;
                    $range['max_range'] = (int)$max[$k];
                    $range['bonus_interest'] = (float)$bonusInterest[$k];
                    $range['board_rate'] = (float)$boardInterest[$k];
                    $ranges[] = $range;
                }
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [SAVING_DEPOSIT_F3, PRIVILEGE_DEPOSIT_F3, FOREIGN_CURRENCY_DEPOSIT_F4])) {
                $range['min_range'] = (int)$request->min_placement_sdp3;
                $range['max_range'] = (int)$request->max_placement_sdp3;
                $range['air'] = (float)$request->air_sdp3;
                $range['sibor_rate'] = (float)$request->sibor_rate_sdp3;
                $ranges[] = $range;

                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [SAVING_DEPOSIT_F4, PRIVILEGE_DEPOSIT_F4, FOREIGN_CURRENCY_DEPOSIT_F5])) {
                $min = 1;
                $previousMax = 0;
                foreach ($request->max_placement_sdp4 as $k => $v) {
                    $bonusInterest = $request->bonus_interest_sdp4;
                    $boardInterest = $request->board_rate_sdp4;
                    $range = [];
                    $range['min_range'] = (int)$min;
                    $range['max_range'] = (int)$v + $previousMax;
                    $range['bonus_interest'] = (float)$bonusInterest[$k];
                    $range['board_rate'] = (float)$boardInterest[$k];
                    $ranges[] = $range;
                    $min = $range['max_range'] + 1;
                    $previousMax = $range['max_range'];
                }
                $ranges = json_encode($ranges);

            }
            if (in_array($product->formula_id, [SAVING_DEPOSIT_F5, PRIVILEGE_DEPOSIT_F5, FOREIGN_CURRENCY_DEPOSIT_F6])) {
                $range['min_range'] = (int)$request->min_placement_sdp5;
                $range['max_range'] = (int)$request->max_placement_sdp5;
                $range['base_interest'] = (float)$request->base_interest_sdp5;
                $range['bonus_interest'] = (float)$request->bonus_interest_sdp5;
                $range['placement_month'] = (int)$request->placement_month_sdp5;
                $range['display_month'] = (int)$request->display_month_sdp5;
                $ranges[] = $range;
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F1])) {
                $range['min_range'] = (int)$request->min_placement_aioa1;
                $range['max_range'] = (int)$request->max_placement_aioa1;

                $range['minimum_salary'] = (int)$request->minimum_salary_aioa1;
                $range['minimum_salary_2'] = (int)$request->minimum_salary_aioa1_2;
                $range['bonus_interest_salary'] = (float)$request->bonus_interest_salary_aioa1;
                $range['bonus_interest_salary_2'] = (float)$request->bonus_interest_salary_aioa1_2;
                $range['minimum_giro_payment'] = (int)$request->minimum_giro_payment_aioa1;
                $range['bonus_interest_giro_payment'] = (float)$request->bonus_interest_giro_payment_aioa1;
                $range['minimum_spend'] = (int)$request->minimum_spend_aioa1;
                $range['minimum_spend_2'] = (int)$request->minimum_spend_aioa1_2;
                $range['bonus_interest_spend'] = (float)$request->bonus_interest_spend_aioa1;
                $range['bonus_interest_spend_2'] = (float)$request->bonus_interest_spend_aioa1_2;
                $range['minimum_privilege_pa'] = (int)$request->minimum_privilege_pa_aioa1;
                $range['bonus_interest_privilege'] = (float)$request->bonus_interest_privilege_aioa1;
                //$range['minimum_loan_pa'] = (int)$request->minimum_loan_pa_aioa1;
                //$range['bonus_interest_loan'] = (float)$request->bonus_interest_loan_aioa1;
                $range['bonus_amount'] = (int)$request->minimum_bonus_aioa1;
                $range['bonus_interest'] = (float)$request->bonus_interest_bonus_aioa1;
                $range['first_cap_amount'] = (int)$request->first_cap_amount_aioa1;
                $range['bonus_interest_remaining_amount'] = (float)$request->bonus_interest_remaining_amount_aioa1;

                $ranges[] = $range;
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F2])) {
                $min = 1;
                $previousMax = 0;
                foreach ($request->max_placement_aioa2 as $k => $v) {

                    $bonusInterestA = $request->bonus_interest_criteria_a_aioa2;
                    $bonusInterestB = $request->bonus_interest_criteria_b_aioa2;
                    $range = [];
                    $range['minimum_spend'] = (int)$request->minimum_spend_aioa2;
                    //$range['minimum_spend_2'] = (int)$request->minimum_spend_aioa2_2;
                    $range['minimum_giro_payment'] = (int)$request->minimum_giro_payment_aioa2;
                    $range['minimum_salary'] = (int)$request->minimum_salary_aioa2;
                    //$range['minimum_salary_2'] = (int)$request->minimum_salary_aioa2_2;
                    $range['min_range'] = (int)$min;
                    $range['max_range'] = (int)$v + $previousMax;
                    $range['bonus_interest_criteria_a'] = (float)$bonusInterestA[$k];
                    $range['bonus_interest_criteria_b'] = (float)$bonusInterestB[$k];
                    $ranges[] = $range;
                    $min = $range['max_range'] + 1;
                    $previousMax = $range['max_range'];
                }
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F3])) {
                $range['min_range'] = (int)$request->min_placement_aioa3;
                $range['max_range'] = (int)$request->max_placement_aioa3;

                $range['minimum_salary'] = (int)$request->minimum_salary_aioa3;
                //$range['minimum_salary_2'] = (int)$request->minimum_salary_aioa3_2;
                $range['minimum_giro_payment'] = (int)$request->minimum_giro_payment_aioa3;
                $range['minimum_spend'] = (int)$request->minimum_spend_aioa3;
                //$range['minimum_spend_2'] = (int)$request->minimum_spend_aioa3_2;
                $range['minimum_hire_purchase_loan'] = (int)$request->minimum_hire_purchase_loan_aioa3;
                $range['minimum_renovation_loan'] = (int)$request->minimum_renovation_loan_aioa3;
                $range['minimum_home_loan'] = (int)$request->minimum_home_loan_aioa3;
                $range['minimum_education_loan'] = (int)$request->minimum_education_loan_aioa3;
                $range['minimum_insurance'] = (int)$request->minimum_insurance_aioa3;
                $range['minimum_unit_trust'] = (int)$request->minimum_unit_trust_aioa3;
                $range['requirement_criteria1'] = (int)$request->requirement_criteria1_aioa3;
                $range['bonus_interest_criteria1'] = (float)$request->bonus_interest_criteria1_aioa3;
                $range['requirement_criteria2'] = (int)$request->requirement_criteria2_aioa3;
                $range['bonus_interest_criteria2'] = (float)$request->bonus_interest_criteria2_aioa3;
                $range['requirement_criteria3'] = (int)$request->requirement_criteria3_aioa3;
                $range['bonus_interest_criteria3'] = (float)$request->bonus_interest_criteria3_aioa3;
                $range['first_cap_amount'] = (int)$request->first_cap_amount_aioa3;
                $range['bonus_interest_remaining_amount'] = (float)$request->bonus_interest_remaining_amount_aioa3;

                $ranges[] = $range;
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F4])) {
                foreach ($request->min_placement_aioa4 as $k => $v) {
                    $max = $request->max_placement_aioa4;
                    $bonusInterestA = $request->bonus_interest_criteria_a_aioa4;
                    $bonusInterestB = $request->bonus_interest_criteria_b_aioa4;
                    $range = [];
                    $range['minimum_salary'] = (int)$request->minimum_salary_aioa4;
                    $range['minimum_spend'] = (int)$request->minimum_spend_aioa4;
                    //$range['minimum_salary_2'] = (int)$request->minimum_salary_aioa4_2;
                    //$range['minimum_spend_2'] = (int)$request->minimum_spend_aioa4_2;
                    $range['minimum_home_loan'] = (int)$request->minimum_home_loan_aioa4;
                    $range['minimum_insurance'] = (int)$request->minimum_insurance_aioa4;
                    $range['minimum_investment'] = (int)$request->minimum_investment_aioa4;
                    $range['first_cap_amount'] = (int)$request->first_cap_amount_aioa4;
                    $range['board_rate'] = (float)$request->board_rate_aioa4;
                    $range['min_range'] = (int)$v;
                    $range['max_range'] = (int)$max[$k];
                    $range['bonus_interest_criteria_a'] = (float)$bonusInterestA[$k];
                    $range['bonus_interest_criteria_b'] = (float)$bonusInterestB[$k];
                    $ranges[] = $range;
                }
                $ranges = json_encode($ranges);
            }

            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F5])) {
                $range['min_range'] = (int)$request->min_placement_aioa5;
                $range['max_range'] = (int)$request->max_placement_aioa5;
                $range['minimum_spend_1'] = $request->minimum_spend_1_aioa5 ? (int)$request->minimum_spend_1_aioa5 : null;
                $range['bonus_interest_spend_1'] = $request->bonus_interest_spend_1_aioa5 ? (float)$request->bonus_interest_spend_1_aioa5 : null;
                $range['minimum_spend_2'] = $request->minimum_spend_2_aioa5 ? (int)$request->minimum_spend_2_aioa5 : null;
                $range['bonus_interest_spend_2'] = $request->bonus_interest_spend_2_aioa5 ? (float)$request->bonus_interest_spend_2_aioa5 : null;
                $range['minimum_salary'] = $request->minimum_salary_aioa5 ? (int)$request->minimum_salary_aioa5 : null;
                $range['bonus_interest_salary'] = $request->bonus_interest_salary_aioa5 ? (float)$request->bonus_interest_salary_aioa5 : null;
                $range['minimum_salary_2'] = $request->minimum_salary_aioa5_2 ? (int)$request->minimum_salary_aioa5_2 : null;
                $range['bonus_interest_salary_2'] = $request->bonus_interest_salary_aioa5_2 ? (float)$request->bonus_interest_salary_aioa5_2 : null;
                $range['minimum_giro_payment'] = $request->minimum_giro_payment_aioa5 ? (int)$request->minimum_giro_payment_aioa5 : null;
                $range['bonus_interest_giro_payment'] = $request->bonus_interest_giro_payment_aioa5 ? (float)$request->bonus_interest_giro_payment_aioa5 : null;
                $range['minimum_privilege_pa'] = $request->minimum_privilege_pa_aioa5 ? (int)$request->minimum_privilege_pa_aioa5 : null;
                $range['bonus_interest_privilege'] = $request->bonus_interest_privilege_aioa5 ? (float)$request->bonus_interest_privilege_aioa5 : null;
                $range['minimum_loan_pa'] = $request->minimum_loan_pa_aioa5 ? (int)$request->minimum_loan_pa_aioa5 : null;
                $range['bonus_interest_loan'] = $request->bonus_interest_loan_aioa5 ? (float)$request->bonus_interest_loan_aioa5 : null;

                $range['other_interest1_name'] = $request->other_interest1_name_aioa5 ? $request->other_interest1_name_aioa5 : null;
                $range['other_minimum_amount1'] = $request->other_minimum_amount1_aioa5 ? (int)$request->other_minimum_amount1_aioa5 : null;
                $range['other_interest1'] = $request->other_interest1_aioa5 ? (float)$request->other_interest1_aioa5 : null;
                $range['status_other1'] = $request->status_other1_aioa5 ? (int)$request->status_other1_aioa5 : 0;
                $range['checked_status_other1'] = $request->checked_status_other1_aioa5 ? (int)$request->checked_status_other1_aioa5 : 0;

                $range['other_interest2_name'] = $request->other_interest2_name_aioa5 ? $request->other_interest2_name_aioa5 : null;
                $range['other_minimum_amount2'] = $request->other_minimum_amount2_aioa5 ? (int)$request->other_minimum_amount2_aioa5 : null;
                $range['other_interest2'] = $request->other_interest2_aioa5 ? (float)$request->other_interest2_aioa5 : null;
                $range['status_other2'] = $request->status_other2_aioa5 ? (int)$request->status_other2_aioa5 : 0;
                $range['checked_status_other2'] = $request->checked_status_other2_aioa5 ? (int)$request->checked_status_other2_aioa5 : 0;

                $range['first_cap_amount'] = $request->first_cap_amount_aioa5 ? (int)$request->first_cap_amount_aioa5 : null;
                $range['bonus_interest_remaining_amount'] = $request->bonus_interest_remaining_amount_aioa5 ? (float)$request->bonus_interest_remaining_amount_aioa5 : null;
                $ranges[] = $range;
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [LOAN_F1])) {
                $floatingRateTypes = $request->floating_rate_type_f1;
                $bonusInterests = $request->bonus_interest_f1;
                $rateNameOthers = $request->rate_name_other_f1;
                $rateInterestOthers = $request->rate_interest_other_f1;

                foreach ($request->tenure_f1 as $k => $v) {
                    $range = [];
                    $range['tenure'] = (int)$v;
                    if ($floatingRateTypes[$k] == "null") {
                        $range['floating_rate_type'] = null;
                    } else {
                        $range['floating_rate_type'] = $floatingRateTypes[$k];
                    }
                    if ($request->there_after_rate_type == "null") {
                        $range['there_after_rate_type'] = null;
                    } else {
                        $range['there_after_rate_type'] = $request->there_after_rate_type;
                    }

                    $range['bonus_interest'] = (float)$bonusInterests[$k];
                    $range['rate_name_other'] = $rateNameOthers[$k];
                    $range['rate_interest_other'] = (float)$rateInterestOthers[$k];


                    $range['rate_type'] = $request->rate_type_f1;
                    $range['rate_type_name'] = $request->rate_type_name_f1;
                    $range['property_type'] = $request->property_type_f1;
                    $range['completion_status'] = $request->completion_status_f1;
                    $range['there_after_bonus_interest'] = (float)$request->there_after_bonus_interest;
                    $range['there_after_rate_name_other'] = $request->there_after_rate_name_other;
                    $range['there_after_rate_interest_other'] = (float)$request->there_after_rate_interest_other;
                    $ranges[] = $range;
                }
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F6])) {
                $min = 1;
                $previousMax = 0;

                $minSalaryInterests = $request->bonus_interest_salary_aioa6;
                $minSpendInterests = $request->bonus_interest_spend_aioa6;
                $minOtherInterests = $request->bonus_interest_other_aioa6;
                $minWealthInterests = $request->bonus_interest_wealth_aioa6;
                foreach ($request->max_placement_aioa6 as $k => $v) {

                    $range = [];
                    $range['minimum_grow'] = $request->minimum_grow_aioa6;
                    $range['cap_grow'] = $request->cap_grow_aioa6;
                    $range['bonus_interest_grow'] = (float)$request->bonus_interest_grow_aioa6;
                    $range['cap_boost'] = $request->cap_boost_aioa6;
                    $range['bonus_interest_boost'] = (float)$request->bonus_interest_boost_aioa6;
                    $range['other_interest_name'] = $request->other_interest_name_aioa6;
                    $range['status_other'] = $request->status_other_aioa6;
                    $range['first_cap_amount'] = $request->first_cap_amount_aioa6;
                    $range['bonus_interest_remaining_amount'] = (float)$request->bonus_interest_remaining_amount_aioa6;

                    $range['minimum_salary'] = $request->minimum_salary_aioa6;
                    $range['bonus_interest_salary'] = (float)$minSalaryInterests[$k];
                    $range['minimum_spend'] = $request->minimum_spend_aioa6;
                    $range['bonus_interest_spend'] = (float)$minSpendInterests[$k];
                    $range['minimum_other'] = $request->minimum_other_aioa6;
                    $range['bonus_interest_other'] = (float)$minOtherInterests[$k];
                    $range['minimum_wealth'] = $request->minimum_wealth_aioa6;
                    $range['bonus_interest_wealth'] = (float)$minWealthInterests[$k];
                    $range['min_range'] = (int)$min;
                    $range['max_range'] = (int)$v + $previousMax;
                    $ranges[] = $range;
                    $min = $range['max_range'] + 1;
                    $previousMax = $range['max_range'];
                }
                $ranges = json_encode($ranges);

            }
        }
        function intVal($x)
        {
            return (int)$x;
        }

        function floatVal($x)
        {
            return (float)$x;
        }

        $product->product_range = $ranges;
        if ($request->promotion_start_date) {
            $product->promotion_start = \Helper::startOfDayBefore($request->promotion_start_date);
        } else {
            $product->promotion_start = null;
        }
        if ($request->promotion_end_date) {
            $product->promotion_end = \Helper::endOfDayAfter($request->promotion_end_date);
        } else {
            $product->promotion_end = null;
        }
        $product->product_footer = $request->product_footer;

        if ($request->hasFile('ad_horizontal_image')) {
            $adHorizontal['ad_image_horizontal'] = $destinationPath . '/' . $adHorizontalImage;
        }
        if ($request->hasFile('ad_image_vertical')) {

            $adVertical['ad_image_vertical'] = $destinationPath . '/' . $adVerticalImage;
        }
        if ($request->hasFile('ad_horizontal_image_popup')) {

            $adHorizontalPopup['ad_horizontal_image_popup'] = $destinationPath . '/' . $adHorizontalPopupImage;
        }
        if ($request->hasFile('ad_horizontal_image_popup_top')) {

            $adHorizontalPopupTop['ad_horizontal_image_popup_top'] = $destinationPath . '/' . $adHorizontalPopupImageTop;
        }

        $adHorizontal['ad_link_horizontal'] = $request->ad_horizontal_link;
        $adVertical['ad_link_vertical'] = $request->ad_vertical_link;
        $adHorizontalPopup['ad_link_horizontal_popup'] = $request->ad_horizontal_link_popup;
        $adHorizontalPopupTop['ad_link_horizontal_popup_top'] = $request->ad_horizontal_link_popup_top;
        $adsPlacement = [$adHorizontal, $adVertical, $adHorizontalPopup, $adHorizontalPopupTop];

        $product->ads_placement = json_encode($adsPlacement);
        //dd($product->ads_placement);
        $product->status = $request->status;
        $product->featured = $request->featured;
        if (!is_null($request->formula)) {
            $product->slider_status = 1;
        } else {
            $product->slider_status = $request->slider_status;
        }
        $product->save();

        //store activity log
        activity()
            ->performedOn($product)
            ->withProperties(['ip' => \Request::ip(),
                'module' => PRODUCT_MODULE,
                'msg' => $product->product_name . ADDED_ALERT,
                'old' => $product,
                'new' => null])
            ->log(CREATE);

        return redirect()->route('promotion-products', ["productTypeId" => $product->promotion_type_id])->with('success', $product->product_name . ADDED_ALERT);
        //return $this->promotion_formula();

    }

    public function promotion_products_edit($id, Request $request)
    {
        $legends = systemSettingLegendTable::where('delete_status', 0)->where('page_type', $request->product_type_id)->get();
        $promotion_types = \Helper::getPromotionType($request->product_type_id);
        $product = \Helper::getProduct($id);
        if (!$product) {
            return redirect()->route('promotion-products', ['productTypeId' => $request->product_type_id])->with('error', OPPS_ALERT);
        }
        $product->product_range = json_decode($product->product_range);
        $productType = $this->productType($request->product_type_id);
        //dd($product->product_range);
        $formula = \Helper::productType($id);
        $banks = Brand::where('delete_status', 0)->where('display', 1)->orderBy('title', 'asc')->get();
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        $currencies = Currency::where('delete_status', 0)->get();
        if ($request->product_type_id == LOAN) {
            $rateTypes = RateType::where('delete_status', 0)->get();
            return view('backend.products.loan_products_edit', compact('rateTypes', 'CheckLayoutPermission', 'promotion_types', 'product', 'formula', 'banks', 'productType', 'legends', 'currencies'));
        } else {
            return view('backend.products.promotion_products_edit', compact('CheckLayoutPermission', 'promotion_types', 'product', 'formula', 'banks', 'productType', 'legends', 'currencies'));
        }
    }

    public function promotion_products_update(Request $request, $id)
    {
        $product = \Helper::getProduct($id);
        $ads = $product->ads_placement;

        if (!$product) {
            return redirect()->route('promotion-products', ['productTypeId' => $request->product_type])->with('error', OPPS_ALERT);
        }

        $oldProduct = $product;

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);

        $destinationPath = 'uploads/products'; // upload path
        $adHorizontalImage = $adHorizontalPopupImage = $adHorizontalPopupImageTop = null;
        $adVerticalImage = null;
        if (!is_dir('uploads')) {
            mkdir('uploads');
        }

        if (!is_dir('uploads/products')) {
            mkdir('uploads/products');
        }


        if ($request->hasFile('ad_horizontal_image')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image')->move($destinationPath, $adHorizontalImage);
        }
        if ($request->hasFile('ad_image_vertical')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_image_vertical')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_image_vertical')->getClientOriginalExtension();
            // Filename to store
            $adVerticalImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_image_vertical')->move($destinationPath, $adVerticalImage);
        }
        if ($request->hasFile('ad_horizontal_image_popup')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image_popup')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image_popup')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalPopupImage = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image_popup')->move($destinationPath, $adHorizontalPopupImage);
        }
        if ($request->hasFile('ad_horizontal_image_popup_top')) {

            // Get filename with the extension
            $filenameWithExt = $request->file('ad_horizontal_image_popup_top')->getClientOriginalName();
            // Get just filename
            $filename = preg_replace('/\s+/', '_', pathinfo($filenameWithExt, PATHINFO_FILENAME));
            // Get just ext
            $extension = $request->file('ad_horizontal_image_popup_top')->getClientOriginalExtension();
            // Filename to store
            $adHorizontalPopupImageTop = $filename . '_' . time() . '.' . $extension;
            // Upload Image
            $request->file('ad_horizontal_image_popup_top')->move($destinationPath, $adHorizontalPopupImageTop);
        }

        if(isset($request->shortlist_status))
        {
            //dd($request->shortlist_status);
            $product->shortlist_status = $request->shortlist_status;
        }
        $product->product_name = $request->name;
        $product->bank_id = $request->bank;
        $product->bank_sub_title = $request->bank_sub_title;
        $product->apply_link = $request->apply_link;
        $product->apply_link_status = $request->apply_link_status;
        $product->promotion_type_id = $request->product_type;
        $product->formula_id = $request->formula;
        if (isset($request->until_end_date)) {
            $product->until_end_date = $request->until_end_date;
        } else {
            $product->until_end_date = null;
        }

        if ($request->product_type == LOAN) {
            $product->minimum_loan_amount = $request->minimum_loan_amount;
            $product->lock_in = $request->lock_in;
        } else {
            $product->maximum_interest_rate = $request->maximum_interest_rate;
            $product->promotion_period = $request->promotion_period;
            $product->minimum_placement_amount = $request->minimum_placement_amount;
        }
        $ranges = null;
        if ($product->promotion_type_id == FOREIGN_CURRENCY_DEPOSIT) {
            $product->currency = $request->currency;
        }
        if ($request->formula) {
            $ranges = [];
            if (in_array($product->formula_id, [FIX_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F6, FOREIGN_CURRENCY_DEPOSIT_F1])) {
                foreach ($request->min_placement as $k => $v) {
                    $max = $request->max_placement;
                    $legends = $request->legend;
                    $bonusInterest = $request->bonus_interest;
                    $range = [];
                    $range['min_range'] = (int)$v;
                    $range['max_range'] = (int)$max[$k];
                    $range['legend'] = (int)$legends[$k];
                    $range['bonus_interest'] = array_values(array_map('floatVal', $bonusInterest[$k]));
                    $ranges[] = $range;

                }

                $tenure = $request->tenure;
                $tenure = json_encode(array_values(array_map('intVal', $tenure[0])));
                $ranges = json_encode(array_values($ranges));
                //dd($ranges);
                $product->tenure = $tenure;
            }
            if (in_array($product->formula_id, [SAVING_DEPOSIT_F1, SAVING_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F3])) {
                foreach ($request->min_placement_sdp1 as $k => $v) {
                    $max = $request->max_placement_sdp1;
                    $bonusInterest = $request->bonus_interest_sdp1;
                    $boardInterest = $request->board_rate_sdp1;
                    $range = [];
                    if (in_array($product->formula_id, [SAVING_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F3])) {
                        $range['tenure'] = $request->tenure_sdp1;

                    }
                    $range['min_range'] = (int)$v;
                    $range['max_range'] = (int)$max[$k];
                    $range['bonus_interest'] = (float)$bonusInterest[$k];
                    $range['board_rate'] = (float)$boardInterest[$k];
                    $ranges[] = $range;
                }
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [SAVING_DEPOSIT_F3, PRIVILEGE_DEPOSIT_F3, FOREIGN_CURRENCY_DEPOSIT_F4])) {
                $range['min_range'] = (int)$request->min_placement_sdp3;
                $range['max_range'] = (int)$request->max_placement_sdp3;
                $range['air'] = (float)$request->air_sdp3;
                $range['sibor_rate'] = (float)$request->sibor_rate_sdp3;
                $ranges[] = $range;

                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [SAVING_DEPOSIT_F4, PRIVILEGE_DEPOSIT_F4, FOREIGN_CURRENCY_DEPOSIT_F5])) {
                $min = 1;
                $previousMax = 0;
                foreach ($request->max_placement_sdp4 as $k => $v) {
                    $bonusInterest = $request->bonus_interest_sdp4;
                    $boardInterest = $request->board_rate_sdp4;
                    $range = [];
                    $range['min_range'] = (int)$min;
                    $range['max_range'] = (int)$v + $previousMax;
                    $range['bonus_interest'] = (float)$bonusInterest[$k];
                    $range['board_rate'] = (float)$boardInterest[$k];
                    $ranges[] = $range;
                    $min = $range['max_range'] + 1;
                    $previousMax = $range['max_range'];
                }
                $ranges = json_encode($ranges);

            }
            if (in_array($product->formula_id, [SAVING_DEPOSIT_F5, PRIVILEGE_DEPOSIT_F5, FOREIGN_CURRENCY_DEPOSIT_F6])) {
                $range['min_range'] = (int)$request->min_placement_sdp5;
                $range['max_range'] = (int)$request->max_placement_sdp5;
                $range['base_interest'] = (float)$request->base_interest_sdp5;
                $range['bonus_interest'] = (float)$request->bonus_interest_sdp5;
                $range['placement_month'] = (int)$request->placement_month_sdp5;
                $range['display_month'] = (int)$request->display_month_sdp5;
                $ranges[] = $range;
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F1])) {
                $range['min_range'] = (int)$request->min_placement_aioa1;
                $range['max_range'] = (int)$request->max_placement_aioa1;

                $range['minimum_salary'] = (int)$request->minimum_salary_aioa1;
                $range['minimum_salary_2'] = (int)$request->minimum_salary_aioa1_2;
                $range['bonus_interest_salary'] = (float)$request->bonus_interest_salary_aioa1;
                $range['bonus_interest_salary_2'] = (float)$request->bonus_interest_salary_aioa1_2;
                $range['minimum_giro_payment'] = (int)$request->minimum_giro_payment_aioa1;
                $range['bonus_interest_giro_payment'] = (float)$request->bonus_interest_giro_payment_aioa1;
                $range['minimum_spend'] = (int)$request->minimum_spend_aioa1;
                $range['minimum_spend_2'] = (int)$request->minimum_spend_aioa1_2;
                $range['bonus_interest_spend'] = (float)$request->bonus_interest_spend_aioa1;
                $range['bonus_interest_spend_2'] = (float)$request->bonus_interest_spend_aioa1_2;
                $range['minimum_privilege_pa'] = (int)$request->minimum_privilege_pa_aioa1;
                $range['bonus_interest_privilege'] = (float)$request->bonus_interest_privilege_aioa1;
                //$range['minimum_loan_pa'] = (int)$request->minimum_loan_pa_aioa1;
                //$range['bonus_interest_loan'] = (float)$request->bonus_interest_loan_aioa1;
                $range['bonus_amount'] = (int)$request->minimum_bonus_aioa1;
                $range['bonus_interest'] = (float)$request->bonus_interest_bonus_aioa1;
                $range['first_cap_amount'] = (int)$request->first_cap_amount_aioa1;
                $range['bonus_interest_remaining_amount'] = (float)$request->bonus_interest_remaining_amount_aioa1;

                $ranges[] = $range;
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F2])) {
                $min = 1;
                $previousMax = 0;
                foreach ($request->max_placement_aioa2 as $k => $v) {

                    $bonusInterestA = $request->bonus_interest_criteria_a_aioa2;
                    $bonusInterestB = $request->bonus_interest_criteria_b_aioa2;
                    $range = [];
                    $range['minimum_spend'] = (int)$request->minimum_spend_aioa2;
                    //$range['minimum_spend_2'] = (int)$request->minimum_spend_aioa2_2;
                    $range['minimum_giro_payment'] = (int)$request->minimum_giro_payment_aioa2;
                    $range['minimum_salary'] = (int)$request->minimum_salary_aioa2;
                    //$range['minimum_salary_2'] = (int)$request->minimum_salary_aioa2_2;
                    $range['min_range'] = (int)$min;
                    $range['max_range'] = (int)$v + $previousMax;
                    $range['bonus_interest_criteria_a'] = (float)$bonusInterestA[$k];
                    $range['bonus_interest_criteria_b'] = (float)$bonusInterestB[$k];
                    $ranges[] = $range;
                    $min = $range['max_range'] + 1;
                    $previousMax = $range['max_range'];
                }


                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F3])) {
                $range['min_range'] = (int)$request->min_placement_aioa3;
                $range['max_range'] = (int)$request->max_placement_aioa3;

                $range['minimum_salary'] = (int)$request->minimum_salary_aioa3;
                //$range['minimum_salary_2'] = (int)$request->minimum_salary_aioa3_2;
                $range['minimum_giro_payment'] = (int)$request->minimum_giro_payment_aioa3;
                $range['minimum_spend'] = (int)$request->minimum_spend_aioa3;
                //$range['minimum_spend_2'] = (int)$request->minimum_spend_aioa3_2;
                $range['minimum_hire_purchase_loan'] = (int)$request->minimum_hire_purchase_loan_aioa3;
                $range['minimum_renovation_loan'] = (int)$request->minimum_renovation_loan_aioa3;
                $range['minimum_home_loan'] = (int)$request->minimum_home_loan_aioa3;
                $range['minimum_education_loan'] = (int)$request->minimum_education_loan_aioa3;
                $range['minimum_insurance'] = (int)$request->minimum_insurance_aioa3;
                $range['minimum_unit_trust'] = (int)$request->minimum_unit_trust_aioa3;
                $range['requirement_criteria1'] = (int)$request->requirement_criteria1_aioa3;
                $range['bonus_interest_criteria1'] = (float)$request->bonus_interest_criteria1_aioa3;
                $range['requirement_criteria2'] = (int)$request->requirement_criteria2_aioa3;
                $range['bonus_interest_criteria2'] = (float)$request->bonus_interest_criteria2_aioa3;
                $range['requirement_criteria3'] = (int)$request->requirement_criteria3_aioa3;
                $range['bonus_interest_criteria3'] = (float)$request->bonus_interest_criteria3_aioa3;
                $range['first_cap_amount'] = (int)$request->first_cap_amount_aioa3;
                $range['bonus_interest_remaining_amount'] = (float)$request->bonus_interest_remaining_amount_aioa3;
                $ranges[] = $range;
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F4])) {
                foreach ($request->min_placement_aioa4 as $k => $v) {
                    $max = $request->max_placement_aioa4;
                    $bonusInterestA = $request->bonus_interest_criteria_a_aioa4;
                    $bonusInterestB = $request->bonus_interest_criteria_b_aioa4;
                    $range = [];
                    $range['minimum_salary'] = (int)$request->minimum_salary_aioa4;
                    $range['minimum_spend'] = (int)$request->minimum_spend_aioa4;
                   // $range['minimum_salary_2'] = (int)$request->minimum_salary_aioa4_2;
                    //$range['minimum_spend_2'] = (int)$request->minimum_spend_aioa4_2;
                    $range['minimum_home_loan'] = (int)$request->minimum_home_loan_aioa4;
                    $range['minimum_insurance'] = (int)$request->minimum_insurance_aioa4;
                    $range['minimum_investment'] = (int)$request->minimum_investment_aioa4;
                    $range['first_cap_amount'] = (int)$request->first_cap_amount_aioa4;
                    $range['board_rate'] = (float)$request->board_rate_aioa4;
                    $range['min_range'] = (int)$v;
                    $range['max_range'] = (int)$max[$k];
                    $range['bonus_interest_criteria_a'] = (float)$bonusInterestA[$k];
                    $range['bonus_interest_criteria_b'] = (float)$bonusInterestB[$k];
                    $ranges[] = $range;
                }

                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F5])) {
                $range['min_range'] = (int)$request->min_placement_aioa5;
                $range['max_range'] = (int)$request->max_placement_aioa5;
                $range['minimum_spend_1'] = $request->minimum_spend_1_aioa5 ? (int)$request->minimum_spend_1_aioa5 : null;
                $range['bonus_interest_spend_1'] = $request->bonus_interest_spend_1_aioa5 ? (float)$request->bonus_interest_spend_1_aioa5 : null;
                $range['minimum_spend_2'] = $request->minimum_spend_2_aioa5 ? (int)$request->minimum_spend_2_aioa5 : null;
                $range['bonus_interest_spend_2'] = $request->bonus_interest_spend_2_aioa5 ? (float)$request->bonus_interest_spend_2_aioa5 : null;
                $range['minimum_salary'] = $request->minimum_salary_aioa5 ? (int)$request->minimum_salary_aioa5 : null;
                $range['bonus_interest_salary'] = $request->bonus_interest_salary_aioa5 ? (float)$request->bonus_interest_salary_aioa5 : null;
                $range['minimum_salary_2'] = $request->minimum_salary_aioa5_2 ? (int)$request->minimum_salary_aioa5_2 : null;
                $range['bonus_interest_salary_2'] = $request->bonus_interest_salary_aioa5_2 ? (float)$request->bonus_interest_salary_aioa5_2 : null;
                $range['minimum_giro_payment'] = $request->minimum_giro_payment_aioa5 ? (int)$request->minimum_giro_payment_aioa5 : null;
                $range['bonus_interest_giro_payment'] = $request->bonus_interest_giro_payment_aioa5 ? (float)$request->bonus_interest_giro_payment_aioa5 : null;
                $range['minimum_privilege_pa'] = $request->minimum_privilege_pa_aioa5 ? (int)$request->minimum_privilege_pa_aioa5 : null;
                $range['bonus_interest_privilege'] = $request->bonus_interest_privilege_aioa5 ? (float)$request->bonus_interest_privilege_aioa5 : null;
                $range['minimum_loan_pa'] = $request->minimum_loan_pa_aioa5 ? (int)$request->minimum_loan_pa_aioa5 : null;
                $range['bonus_interest_loan'] = $request->bonus_interest_loan_aioa5 ? (float)$request->bonus_interest_loan_aioa5 : null;

                $range['other_interest1_name'] = $request->other_interest1_name_aioa5 ? $request->other_interest1_name_aioa5 : null;
                $range['other_minimum_amount1'] = $request->other_minimum_amount1_aioa5 ? (int)$request->other_minimum_amount1_aioa5 : null;
                $range['other_interest1'] = $request->other_interest1_aioa5 ? (float)$request->other_interest1_aioa5 : null;
                $range['status_other1'] = $request->status_other1_aioa5 ? (int)$request->status_other1_aioa5 : 0;
                $range['checked_status_other1'] = $request->checked_status_other1_aioa5 ? (int)$request->checked_status_other1_aioa5 : 0;

                $range['other_interest2_name'] = $request->other_interest2_name_aioa5 ? $request->other_interest2_name_aioa5 : null;
                $range['other_minimum_amount2'] = $request->other_minimum_amount2_aioa5 ? (int)$request->other_minimum_amount2_aioa5 : null;
                $range['other_interest2'] = $request->other_interest2_aioa5 ? (float)$request->other_interest2_aioa5 : null;
                $range['status_other2'] = $request->status_other2_aioa5 ? (int)$request->status_other2_aioa5 : 0;
                $range['checked_status_other2'] = $request->checked_status_other2_aioa5 ? (int)$request->checked_status_other2_aioa5 : 0;

                $range['first_cap_amount'] = $request->first_cap_amount_aioa5 ? (int)$request->first_cap_amount_aioa5 : null;
                $range['bonus_interest_remaining_amount'] = $request->bonus_interest_remaining_amount_aioa5 ? (float)$request->bonus_interest_remaining_amount_aioa5 : null;
                $ranges[] = $range;
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [LOAN_F1])) {
                $floatingRateTypes = $request->floating_rate_type_f1;
                $bonusInterests = $request->bonus_interest_f1;
                $rateNameOthers = $request->rate_name_other_f1;
                $rateInterestOthers = $request->rate_interest_other_f1;

                foreach ($request->tenure_f1 as $k => $v) {
                    $range = [];
                    $range['tenure'] = (int)$v;
                    if ($floatingRateTypes[$k] == "null") {
                        $range['floating_rate_type'] = null;
                    } else {
                        $range['floating_rate_type'] = $floatingRateTypes[$k];
                    }
                    if ($request->there_after_rate_type == "null") {
                        $range['there_after_rate_type'] = null;
                    } else {
                        $range['there_after_rate_type'] = $request->there_after_rate_type;
                    }

                    $range['bonus_interest'] = (float)$bonusInterests[$k];
                    $range['rate_name_other'] = $rateNameOthers[$k];
                    $range['rate_interest_other'] = (float)$rateInterestOthers[$k];


                    $range['rate_type'] = $request->rate_type_f1;
                    $range['rate_type_name'] = $request->rate_type_name_f1;
                    $range['property_type'] = $request->property_type_f1;
                    $range['completion_status'] = $request->completion_status_f1;
                    $range['there_after_bonus_interest'] = (float)$request->there_after_bonus_interest;
                    $range['there_after_rate_name_other'] = $request->there_after_rate_name_other;
                    $range['there_after_rate_interest_other'] = (float)$request->there_after_rate_interest_other;
                    $ranges[] = $range;
                }
                $ranges = json_encode($ranges);
            }
            if (in_array($product->formula_id, [ALL_IN_ONE_ACCOUNT_F6])) {
                $min = 1;
                $previousMax = 0;

                $minSalaryInterests = $request->bonus_interest_salary_aioa6;
                $minSpendInterests = $request->bonus_interest_spend_aioa6;
                $minOtherInterests = $request->bonus_interest_other_aioa6;
                $minWealthInterests = $request->bonus_interest_wealth_aioa6;
                foreach ($request->max_placement_aioa6 as $k => $v) {

                    $range = [];
                    $range['minimum_grow'] = $request->minimum_grow_aioa6;
                    $range['cap_grow'] = $request->cap_grow_aioa6;
                    $range['bonus_interest_grow'] = (float)$request->bonus_interest_grow_aioa6;
                    $range['cap_boost'] = $request->cap_boost_aioa6;
                    $range['bonus_interest_boost'] = (float)$request->bonus_interest_boost_aioa6;
                    $range['other_interest_name'] = $request->other_interest_name_aioa6;
                    $range['status_other'] = $request->status_other_aioa6;
                    $range['first_cap_amount'] = $request->first_cap_amount_aioa6;
                    $range['bonus_interest_remaining_amount'] = (float)$request->bonus_interest_remaining_amount_aioa6;

                    $range['minimum_salary'] = $request->minimum_salary_aioa6;
                    $range['bonus_interest_salary'] = (float)$minSalaryInterests[$k];
                    $range['minimum_spend'] = $request->minimum_spend_aioa6;
                    $range['bonus_interest_spend'] = (float)$minSpendInterests[$k];
                    $range['minimum_other'] = $request->minimum_other_aioa6;
                    $range['bonus_interest_other'] = (float)$minOtherInterests[$k];
                    $range['minimum_wealth'] = $request->minimum_wealth_aioa6;
                    $range['bonus_interest_wealth'] = (float)$minWealthInterests[$k];
                    $range['min_range'] = (int)$min;
                    $range['max_range'] = (int)$v + $previousMax;
                    $ranges[] = $range;
                    $min = $range['max_range'] + 1;
                    $previousMax = $range['max_range'];
                }
                $ranges = json_encode($ranges);

            }
        }
        function intVal($x)
        {
            return (int)$x;
        }

        function floatVal($x)
        {
            return (float)$x;
        }

        $product->product_range = $ranges;
        if ($request->promotion_start_date) {
            $product->promotion_start = \Helper::startOfDayBefore($request->promotion_start_date);
        } else {
            $product->promotion_start = null;
        }
        if ($request->promotion_end_date) {
            $product->promotion_end = \Helper::endOfDayAfter($request->promotion_end_date);
        } else {
            $product->promotion_end = null;
        }
        $product->product_footer = $request->product_footer;

        if ($request->hasFile('ad_horizontal_image')) {
            $adHorizontal['ad_image_horizontal'] = $destinationPath . '/' . $adHorizontalImage;
        } else {
            $adHorizontal['ad_image_horizontal'] = isset($ads[0]->ad_image_horizontal) ? $ads[0]->ad_image_horizontal : null;
        }
        if ($request->hasFile('ad_image_vertical')) {

            $adVertical['ad_image_vertical'] = $destinationPath . '/' . $adVerticalImage;
        } else {
            $adVertical['ad_image_vertical'] = isset($ads[1]->ad_image_vertical) ? $ads[1]->ad_image_vertical : null;
        }
        if ($request->hasFile('ad_horizontal_image_popup')) {

            $adHorizontalPopup['ad_horizontal_image_popup'] = $destinationPath . '/' . $adHorizontalPopupImage;
        } else {
            $adHorizontalPopup['ad_horizontal_image_popup'] = isset($ads[2]->ad_horizontal_image_popup) ? $ads[2]->ad_horizontal_image_popup : null;
        }
        //dd($request->ad_horizontal_image_popup_top);
        if ($request->hasFile('ad_horizontal_image_popup_top')) {

            $adHorizontalPopupTop['ad_horizontal_image_popup_top'] = $destinationPath . '/' . $adHorizontalPopupImageTop;
        } else {
            $adHorizontalPopupTop['ad_horizontal_image_popup_top'] = isset($ads[3]->ad_horizontal_image_popup_top) ? $ads[3]->ad_horizontal_image_popup_top : null;
        }

        $adHorizontal['ad_link_horizontal'] = $request->ad_horizontal_link;
        $adVertical['ad_link_vertical'] = $request->ad_vertical_link;
        $adHorizontalPopup['ad_link_horizontal_popup'] = $request->ad_horizontal_link_popup;
        $adHorizontalPopupTop['ad_link_horizontal_popup_top'] = $request->ad_horizontal_link_popup_top;
        $adsPlacement = [$adHorizontal, $adVertical, $adHorizontalPopup, $adHorizontalPopupTop];

        $product->ads_placement = json_encode($adsPlacement);

        $product->status = $request->status;
        $product->featured = $request->featured;
        if (!is_null($request->formula)) {
            $product->slider_status = 1;
        } else {
            $product->slider_status = $request->slider_status;
        }
        $product->save();

        //store activity log
        activity()
            ->performedOn($product)
            ->withProperties(['ip' => \Request::ip(),
                'module' => PRODUCT_MODULE,
                'msg' => $product->product_name . UPDATED_ALERT,
                'old' => $product,
                'new' => null])
            ->log(UPDATE);

        return redirect()->route('promotion-products', ["productTypeId" => $product->promotion_type_id])->with('success', $product->product_name . UPDATED_ALERT);
    }

    public function promotion_products_remove($id, Request $request)
    {

        $sel_query = PromotionProducts::where('id', $id)->first();
        if (!$sel_query) {
            return redirect()->route('promotion-products', ['productTypeId' => $request->product_type_id])->with('error', OPPS_ALERT);
        }

        $sel_query->delete_status = 1;
        $sel_query->save();
        //dd($sel_query);
        //store activity log
        activity()
            ->performedOn($sel_query)
            ->withProperties(['ip' => \Request::ip(),
                'module' => PRODUCT_MODULE,
                'msg' => $sel_query->product_name . ' ' . DELETED_ALERT,
                'old' => $sel_query,
                'new' => null])
            ->log(DELETE);
        return redirect()->route('promotion-products', ["productTypeId" => $sel_query->promotion_type_id])->with('success', $sel_query->product_name . ' ' . DELETED_ALERT);
    }

    public function promotion_formula()
    {
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula();

        //dd($formulas);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        return view('backend.products.promotion_formula', compact('CheckLayoutPermission', 'promotion_types', 'formulas'));
    }

    public function promotion_formula_db(Request $request)
    {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula();
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);

        $validate = [
            'promotion_type' => 'required',
            'formula_name' => 'required',
            'formula' => 'required'
        ];

        $validator = Validator::make($request->all(), $validate);
        //dd($validator->getMessageBag());
        //$this->validate($request, $validate);
        DB::enableQueryLog();
        $sel_query = PromotionFormula::where('promotion_id', $request->promotion_type)
            ->where('name', $request->formula_name)
            ->where('formula', $request->formula)
            ->where('delete_status', 0)
            ->get();
        //dd(DB::getQueryLog());
        if (count($sel_query) > 0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $formula_store = new PromotionFormula();
            $formula_store->promotion_id = $request->promotion_type;
            $formula_store->name = $request->formula_name;
            $formula_store->formula = $request->formula;
            $formula_store->save();

            //store activity log
            activity()
                ->performedOn($formula_store)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => $formula_store->name . ' ' . ADDED_ALERT,
                    'old' => $formula_store,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_formula')->with('success', $formula_store->name . ' ' . ADDED_ALERT);

            //return $this->promotion_formula();
        }
    }

    public function promotion_formula_edit($id)
    {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formula = \Helper::getFormula($id);
        //dd($formulas);

        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);

        return view('backend.products.promotion_formula_edit', compact('CheckLayoutPermission', 'promotion_types', 'formula'));

    }

    public function promotion_formula_update(Request $request, $id)
    {
        //dd($request->all());
        $promotion_types = \Helper::getPromotionType();
        $formulas = \Helper::getFormula($id);
        //dd($formulas);
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);


        $validate = [
            'promotion_type' => 'required',
            'formula_name' => 'required',
            'formula' => 'required'
        ];

        $validator = Validator::make($request->all(), $validate);
        //dd($validator->getMessageBag());
        //$this->validate($request, $validate);
        DB::enableQueryLog();
        $sel_query = PromotionFormula::where('promotion_id', $request->promotion_type)
            ->where('name', $request->formula_name)
            ->where('formula', $request->formula)
            ->where('delete_status', 0)
            ->where('id', '<>', $id)
            ->get();
        //dd(DB::getQueryLog());
        if (count($sel_query) > 0) {
            $validator->getMessageBag()->add('data', 'Data' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $formulas->promotion_id = $request->promotion_type;
            $formulas->name = $request->formula_name;
            $formulas->formula = $request->formula;
            $formulas->save();

            //store activity log
            activity()
                ->performedOn($formulas)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_MODULE,
                    'msg' => $formulas->name . ' ' . UPDATED_ALERT,
                    'old' => $formulas,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_formula')->with('success', 'Data ' . UPDATED_ALERT);

            //return $this->promotion_formula();
        }

    }

    public function promotion_formula_remove($id)
    {
        $sel_query = PromotionFormula::where('id', $id)->first();
        $sel_query->delete_status = 1;
        $sel_query->save();
        //dd($sel_query);
        //store activity log
        activity()
            ->performedOn($sel_query)
            ->withProperties(['ip' => \Request::ip(),
                'module' => PRODUCT_MODULE,
                'msg' => $sel_query->name . ' ' . DELETED_ALERT,
                'old' => $sel_query,
                'new' => null])
            ->log(CREATE);


        return redirect()->action('Products\ProductsController@promotion_formula')->with('error', "Data" . ' ' . DELETED_ALERT);
    }

    public function addProductName(Request $request)
    {
        $validate = [
            'product_name' => 'required|unique:product_names',
        ];

        $validator = Validator::make($request->all(), $validate);

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $productName = New ProductName();
            $productName->product_name = $request->product_name;
            $productName->save();

            //store activity log
            activity()
                ->performedOn($productName)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PRODUCT_NAME_MODULE_SINGLE,
                    'msg' => $productName->product_name . ' ' . ADDED_ALERT,
                    'old' => $productName,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products_add')->with('success', $productName->product_name . ' ' . ADDED_ALERT);

        }

    }

    public function addPriceRange(Request $request)
    {

        $validate = ['product_name' => 'required'];
        $validate['min_placement'] = ['required', 'not_in:0', 'numeric', new MaxRule($request->max_placement, 'max_placement')];
        $validate['max_placement'] = 'required|not_in:0|numeric';
        $validator = Validator::make($request->all(), $validate);

        $minPlacementRange = $request->min_placement;
        $maxPlacementRange = $request->max_placement;
        $placementRange = PlacementRange::where(function ($query) use ($minPlacementRange, $maxPlacementRange) {
            $query->whereBetween('min_placement_range', [$minPlacementRange, $maxPlacementRange])
                ->orWhereBetween('max_placement_range', [$minPlacementRange, $maxPlacementRange])
                ->orWhere(function ($query) use ($minPlacementRange, $maxPlacementRange) {
                    $query->where('min_placement_range', '<=', $minPlacementRange)
                        ->where('max_placement_range', '>=', $maxPlacementRange);
                });
        })->first();
        if ($placementRange) {
            $validator->getMessageBag()->add('Placement range', 'The placement range' . ' ' . ALREADY_TAKEN_ALERT);
            //return redirect()->action('Products\ProductsController@promotion_formula')->with($error);
        }

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $placementRange = New PlacementRange();
            $placementRange->product_name_id = $request->product_name;
            $placementRange->min_placement_range = $request->min_placement;
            $placementRange->max_placement_range = $request->max_placement;
            $placementRange->save();

            //store activity log
            activity()
                ->performedOn($placementRange)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => PLACEMENT_RANGE_MODULE_SINGLE,
                    'msg' => $placementRange->min_placement_range . ' - ' . $placementRange->max_placement_range . ' range ' . ADDED_ALERT,
                    'old' => $placementRange,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products_add')->with('success', $placementRange->min_placement_range . ' - ' . $placementRange->max_placement_range . ' range ' . ADDED_ALERT);

        }

    }

    public function addFormulaDetail(Request $request)
    {
        $validate = ['product_name' => 'required'];
        $validate['placement_range'] = ['required'];
        $validate['tenure'] = ['required', 'not_in:0', 'integer'];
        $validate['bonus_interest'] = 'required|not_in:0|numeric';
        $validator = Validator::make($request->all(), $validate);

        $oldFormulaDetail = FormulaVariable::where('product_name_id', $request->product_name)
            ->where('placement_range_id', $request->placement_range)
            ->where('tenure', $request->tenure)
            ->where('bonus_interest', $request->bonus_interest)
            ->first();

        if ($oldFormulaDetail) {
            $validator->getMessageBag()->add('Formula detail', 'The formula detail' . ' ' . ALREADY_TAKEN_ALERT);

        }

        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        } else {
            $formulaDetail = New FormulaVariable();
            $formulaDetail->product_name_id = $request->product_name;
            $formulaDetail->placement_range_id = $request->placement_range;
            $formulaDetail->tenure = $request->tenure;
            $formulaDetail->bonus_interest = $request->bonus_interest;
            $formulaDetail->save();

            //store activity log
            activity()
                ->performedOn($formulaDetail)
                ->withProperties(['ip' => \Request::ip(),
                    'module' => FORMULA_DETAIL_MODULE_SINGLE,
                    'msg' => 'Formula detail ' . ADDED_ALERT,
                    'old' => $formulaDetail,
                    'new' => null])
                ->log(CREATE);


            return redirect()->action('Products\ProductsController@promotion_products_add')->with('success', 'Formula detail ' . ADDED_ALERT);

        }

    }

    public function getPlacementRange(Request $request)
    {
        $placementRanges = PlacementRange::where('product_name_id', $request->formula_product_id)->get();
        ?>
        <option value="">None</option>
        <?php
        if ($placementRanges->count()) {
            foreach ($placementRanges as $placementRange) { ?>
                <option
                    value="<?php echo $placementRange->id; ?>" <?php if ($placementRange->id == $request->placement_range) echo "selected=selected"; ?> ><?php echo $placementRange->min_placement_range . ' - ' . $placementRange->max_placement_range ?></option>
            <?php }
        }
    }

    public function getFormulaDetail(Request $request)
    {
        $formulaDetails = FormulaVariable::join('placement_range', 'formula_variables.placement_range_id', 'placement_range.id')
            ->join('product_names', 'formula_variables.product_name_id', 'product_names.id')
            ->where('formula_variables.delete_status', 0)
            ->where('formula_variables.product_name_id', $request->product_name_id)
            ->select('formula_variables.*', 'placement_range.min_placement_range', 'placement_range.max_placement_range', 'product_names.product_name')
            ->get();
        if ($formulaDetails->count()) {
            $formulaDetails = array_values($formulaDetails->groupBy('placement_range_id')->toArray());
        }
        // dd($formulaDetails);
        if (count($formulaDetails)) {
            foreach ($formulaDetails as $formulaDetail) {
                ?>

                <div class="row">
                    <div class="col-md-12">
                        <!-- DIRECT CHAT PRIMARY -->
                        <div class="box box-primary direct-chat direct-chat-primary collapsed-box">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo $formulaDetail[0]['min_placement_range'] . ' - ' . $formulaDetail[0]['max_placement_range'] ?></h3>

                                <div class="box-tools pull-right">

                                    <button type="button" class="btn btn-box-tool list "
                                            data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool edit"
                                            data-toggle="tooltip"
                                            title="Edit" data-widget="chat-pane-toggle">
                                        <i class="fa fa-pencil "></i></button>
                                    <button type="button" class="btn btn-box-tool delete"
                                            data-widget="remove">
                                        <i class="fa fa-trash "></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">

                                <!-- /.direct-chat-pane -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">

                            </div>
                            <!-- /.box-footer-->
                        </div>
                        <!--/.direct-chat -->
                    </div>

                </div>
                <!-- AdminLTE App -->
                <!--<script src="../public/backend/dist/js/adminlte.min.js"></script>-->
                <?php
            }
        }
    }

    public function addMorePlacementRange(Request $request)
    {
        if (in_array($request->formula, [FIX_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F6, FOREIGN_CURRENCY_DEPOSIT_F1])) {
            $tenure = $request->detail;
            $productType = $request->product_type;

            function intVal($x)
            {
                return (int)$x;
            }

            $legends = systemSettingLegendTable::where('delete_status', 0)
                ->where('page_type', $productType)
                ->get();
            //return $legends->count();
            if ($legends->count()) {
                ?>

                <div id="placement_range_<?php echo $request->range_id; ?>">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success">Min
                                        Placement
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric"
                                       name="min_placement[<?php echo $request->range_id; ?>]"
                                       value="">

                            </div>
                        </div>

                        <div class="col-sm-4 ">

                            <div class="input-group date ">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger">Max Placement
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric"
                                       name="max_placement[<?php echo $request->range_id; ?>]"
                                       value="">

                            </div>

                        </div>
                        <div class="col-sm-2">
                            <button type="button"
                                    class="btn btn-danger -pull-right  remove-placement-range-button "
                                    data-range-id="<?php echo $request->range_id; ?>"
                                    onClick="removePlacementRange(this);">
                                <i
                                    class="fa fa-minus"> </i>
                            </button>
                        </div>

                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label">Legend Type</label>

                        <div class="col-sm-8">
                            <select class="form-control" name="legend[<?php echo $request->range_id; ?>]">
                                <option value="">None</option>
                                <?php
                                foreach ($legends as $legend) { ?>
                                    <option value="<?php echo $legend->id; ?>"><?php echo $legend->title; ?></option>
                                    <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                        </div>
                    </div>
                    <?php for ($i = 0; $i < count($request->detail); $i++) { ?>
                        <div class="form-group  <?php echo $i; ?>"
                             id="formula_detail_<?php echo $request->range_id . $i; ?>">
                            <label for="title" class="col-sm-2 control-label"></label>

                            <div class="col-sm-6 ">
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">Tenur</label>
                                        <input type="text" class="form-control only_numeric tenure-<?php echo $i; ?>"
                                               id=""
                                               onchange="changeTenureValue(this)"
                                               data-formula-detail-id="<?php echo $i; ?>"
                                               name="tenure[<?php echo $request->range_id; ?>][<?php echo $i; ?>]"
                                               value="<?php echo $tenure[$i]['value']; ?>"
                                               placeholder="" readonly="readonly">

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Bonus Interest</label>
                                        <input type="text" class="form-control only_numeric" id=""
                                               name="bonus_interest[<?php echo $request->range_id; ?>][<?php echo $i; ?>]"
                                               placeholder="">

                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-1 col-sm-offset-1 ">
                            </div>
                            <div class="col-sm-2">&emsp;</div>
                        </div>

                    <?php } ?>
                    <div id="new-formula-detail-<?php echo $request->range_id; ?>"></div>
                </div>
            <?php }
        } elseif (in_array($request->formula, [SAVING_DEPOSIT_F1, SAVING_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1, PRIVILEGE_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F2, FOREIGN_CURRENCY_DEPOSIT_F3])) {
            ?>
            <div id="saving_placement_range_f1_<?php echo $request->range_id; ?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success">Min
                                    Placement
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="min_placement_sdp1[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>
                    </div>

                    <div class="col-sm-4 ">

                        <div class="input-group date ">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger">Max Placement
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="max_placement_sdp1[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button"
                                class="btn btn-danger -pull-right  remove-placement-range-button "
                                data-range-id="<?php echo $request->range_id; ?>"
                                onClick="removePlacementRange(this);">
                            <i
                                class="fa fa-minus"> </i>
                        </button>
                    </div>

                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_sdp1[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Board Rate</label>
                                <input type="text" class="form-control only_numeric"
                                       id="board_rate_<?php echo $request->range_id; ?>"
                                       name="board_rate_sdp1[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">&emsp;</div>
                </div>
            </div>
            <?php
        } elseif (in_array($request->formula, [SAVING_DEPOSIT_F4, PRIVILEGE_DEPOSIT_F4, FOREIGN_CURRENCY_DEPOSIT_F5])) {
            ?>
            <div id="placement_range_<?php echo $request->range_id; ?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">

                        <div class="input-group date ">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger">Next
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="max_placement_sdp4[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button"
                                class="btn btn-danger -pull-right  remove-placement-range-button "
                                data-range-id="<?php echo $request->range_id; ?>"
                                onClick="removePlacementRange(this);">
                            <i
                                class="fa fa-minus"> </i>
                        </button>
                    </div>

                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_sdp4[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Board Rate</label>
                                <input type="text" class="form-control only_numeric"
                                       id="board_rate_<?php echo $request->range_id; ?>"
                                       name="board_rate_sdp4[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">&emsp;</div>
                </div>
            </div>
            <?php
        } elseif (in_array($request->formula, [ALL_IN_ONE_ACCOUNT_F2])) {
            ?>
            <div id="aioa_placement_range_f2_<?php echo $request->range_id; ?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8">

                        <div class="input-group date ">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger">Next
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="max_placement_aioa2[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button"
                                class="btn btn-danger -pull-right  remove-placement-range-button "
                                data-range-id="<?php echo $request->range_id; ?>"
                                onClick="removePlacementRange(this);">
                            <i
                                class="fa fa-minus"> </i>
                        </button>
                    </div>

                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest (A)</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_criteria_a_aioa2[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest (B)</label>
                                <input type="text" class="form-control only_numeric"
                                       id="board_rate_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_criteria_b_aioa2[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">&emsp;</div>
                </div>
            </div>
            <?php
        } elseif (in_array($request->formula, [ALL_IN_ONE_ACCOUNT_F4])) {
            ?>
            <div id="aioa_placement_range_f4_<?php echo $request->range_id; ?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-4">
                        <div class="input-group date">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success">Min
                                    Placement
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="min_placement_aioa4[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>
                    </div>

                    <div class="col-sm-4 ">

                        <div class="input-group date ">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger">Max Placement
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="max_placement_aioa4[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button"
                                class="btn btn-danger   remove-placement-range-button "
                                data-range-id="<?php echo $request->range_id; ?>"
                                onClick="removePlacementRange(this);">
                            <i
                                class="fa fa-minus"> </i>
                        </button>
                    </div>

                </div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest (A)</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_criteria_a_aioa4[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest (B)</label>
                                <input type="text" class="form-control only_numeric"
                                       id="board_rate_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_criteria_b_aioa4[<?php echo $request->range_id; ?>]"
                                       placeholder="">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">&emsp;</div>
                </div>
            </div>
            <?php
        } elseif (in_array($request->formula, [LOAN_F1])) {

            $rateTypes = RateType::where('delete_status', 0)->get();
            ?>
            <div id="home_loan_range_f1_<?php echo $request->range_id; ?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">

                        <div class="col-md-3 ">
                            <label for="">Year</label>
                            <select class="form-control tenure-0" name="tenure_f1[<?php echo $request->range_id; ?>]">
                                <?php for ($i = 1; $i <= 30; $i++) { ?>
                                    <option
                                        name="tenure_f1[<?php echo $request->range_id; ?>]" <?php if ($i == $request->range_id) {
                                        echo 'selected="selected"';
                                    } ?> ><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Rate type</label>
                            <!--<input type="text" class="form-control" id=""
                                   name="floating_rate_type_f1[<?php /*echo $request->range_id; */ ?>]" value=""
                                   placeholder="">-->
                            <select class="form-control " data-key="bonus-interest-<?php echo $request->range_id; ?>"
                                    name="floating_rate_type_f1[<?php echo $request->range_id; ?>]"
                                    onchange="changeRateType(this);">
                                <option value="null" id="">None</option>
                                <?php if ($rateTypes->count()) {
                                    foreach ($rateTypes as $rateType) { ?>
                                        <option value="<?php echo $rateType->name; ?>"
                                                data-interest="<?php echo $rateType->interest_rate; ?>"><?php echo $rateType->name; ?></option>
                                    <?php }
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="">Bonus Interest</label>
                            <input type="text" class="form-control only_numeric"
                                   id="bonus-interest-<?php echo $request->range_id; ?>" value=""
                                   name="bonus_interest_f1[<?php echo $request->range_id; ?>]"
                                   placeholder="">
                        </div>
                        <div class="col-md-3">
                            <label for="">Rate name (other)</label>
                            <input type="text" class="form-control" id=""
                                   name="rate_name_other_f1[<?php echo $request->range_id; ?>]" value=""
                                   placeholder="">
                        </div>
                        <div class="col-md-2">
                            <label for="">Rate interest (other)</label>
                            <input type="text" class="form-control only_numeric" id="" value=""
                                   name="rate_interest_other_f1[<?php echo $request->range_id; ?>]"
                                   placeholder="">
                        </div>


                    </div>
                    <div class="col-sm-2" id="add-home-loan-placement-range-f1-button">
                        <button type="button"
                                class="btn btn-danger pull-left  mr-15 mt-25  remove-placement-range-button "
                                data-range-id="<?php echo $request->range_id; ?>"
                                onClick="removePlacementRange(this);">
                            <i class="fa fa-minus"> </i>
                        </button>
                    </div>
                </div>
            </div>
            <?php
        } elseif (in_array($request->formula, [ALL_IN_ONE_ACCOUNT_F6])) {
            ?>
            <div id="aioa_placement_range_f6_<?php echo $request->range_id; ?>">
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">

                        <div class="input-group date ">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-danger">Next
                                </button>
                            </div>
                            <input type="text" class="form-control pull-right only_numeric"
                                   name="max_placement_aioa6[<?php echo $request->range_id; ?>]"
                                   value="">

                        </div>

                    </div>
                    <div class="col-sm-2">
                        <button type="button"
                                class="btn btn-danger -pull-right  remove-placement-range-button "
                                data-range-id="<?php echo $request->range_id; ?>"
                                onClick="removePlacementRange(this);">
                            <i class="fa fa-minus"> </i>
                        </button>
                    </div>

                </div>
                <div class="form-group ">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest (Salary)</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_salary_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_salary_aioa6[<?php echo $request->range_id; ?>]"
                                       value=""
                                       placeholder="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest (Spend)</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_spend_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_spend_aioa6[<?php echo $request->range_id; ?>]"
                                       value=""
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">&emsp;</div>
                </div>

                <div class="form-group ">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest (Other)</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_other_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_other_aioa6[<?php echo $request->range_id; ?>]"
                                       value=""
                                       placeholder="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Bonus Interest (Wealth)</label>
                                <input type="text" class="form-control only_numeric"
                                       id="bonus_interest_wealth_<?php echo $request->range_id; ?>"
                                       name="bonus_interest_wealth_aioa6[<?php echo $request->range_id; ?>]"
                                       value=""
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">&emsp;</div>
                </div>
            </div>
            <?php
        }
    }

    public
    function addCounter(Request $request)
    {
        if ($request->counter_value > 0) {

            for ($i = 0; $i < $request->counter_value; $i++) {
                $j = $i + 1; ?>
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="">Counter <?php echo $j; ?></label>
                        <input type="text" class="form-control only_numeric" id="counter_<?php echo $i; ?>"
                               name="counter_sdp3[<?php echo $i; ?>]" value=""
                               placeholder="">
                    </div>
                </div>
                <?php
            }

        } else { ?>
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label for="">Counter 1</label>
                    <input type="text" class="form-control only_numeric" id="counter_1"
                           name="counter[]" value=""
                           placeholder="">
                </div>
            </div>
            <?php
        }
    }

    public
    function checkProduct(Request $request)
    {

        $query = PromotionProducts::where('product_name', $request->name)
            ->where('bank_id', $request->bank)
            ->where('promotion_type_id', $request->productType)
            ->where('delete_status', 0)
            ->where('formula_id', $request->formula);

        if (!empty($request->product_id)) {
            $query = $query->whereNotIn('id', [$request->product_id]);
        }
        $product = $query->first();
        if ($product) {
            return 1;
        } else {
            return 0;
        }

    }

    public
    function checkRange(Request $request)
    {

        foreach ($request->min_placement as $key => $value) {
            $key = count($request->min_placement) - 1 - $key;

            for ($i = 0; $i <= (count($request->min_placement) - 1); $i++) {
                if ($request->min_placement[$key] > $request->max_placement[$key]) {
                    return 2;
                }
                if (!is_null($request->min_placement[$key]) && !is_null($request->min_placement[$i]) && !is_null($request->max_placement[$i]) && ($key != $i)) {
                    if ($this->numberBetween($request->min_placement[$key], $request->min_placement[$i], $request->max_placement[$i])) {
                        return 1;
                    } elseif ($this->numberBetween($request->max_placement[$key], $request->min_placement[$i], $request->max_placement[$i])) {
                        return 1;
                    }
                }
            }
        }
        return 0;
    }

    public
    function numberBetween($varToCheck, $low, $high)
    {
        if ($varToCheck > $high) return false;
        if ($varToCheck < $low) return false;
        return true;
    }

    public
    function checkTenure(Request $request)
    {
        foreach ($request->tenures as $tenure) {
            if (1 < count(array_keys($request->tenures, $tenure))) {
                return 1;
            }
        }
        return 0;
    }

    public
    function productType($productTypeId)
    {
        if ($productTypeId == LOAN) {
            $productType = LOAN_MODULE;
        } elseif ($productTypeId == SAVING_DEPOSIT) {
            $productType = SAVING_DEPOSIT_MODULE;
        } elseif ($productTypeId == ALL_IN_ONE_ACCOUNT) {
            $productType = ALL_IN_ONE_ACCOUNT_DEPOSIT_MODULE;
        } elseif ($productTypeId == FOREIGN_CURRENCY_DEPOSIT) {
            $productType = FOREIGN_CURRENCY_DEPOSIT_MODULE;
        } elseif ($productTypeId == PRIVILEGE_DEPOSIT) {
            $productType = PRIVILEGE_DEPOSIT_MODULE;
        } else {
            $productType = FIX_DEPOSIT_MODULE;
        }
        return $productType;
    }

    public
    function defaultSearch($productTypeId)
    {
        $defaultSearch = DefaultSearch::where('promotion_id', $productTypeId)->first();
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        $productType = $this->productType($productTypeId);

        return view('backend.products.formulaDetail.default_search_value', compact('CheckLayoutPermission', 'productType', 'productTypeId', 'defaultSearch'));

    }

    public
    function defaultSearchUpdate(Request $request)
    {
        $validate = ['placement' => 'required'];
        if ($request->promotion_id == ALL_IN_ONE_ACCOUNT) {
            $validate['salary'] = 'required';
            $validate['payment'] = 'required';
            $validate['spend'] = 'required';
            $validate['privilege'] = 'required';
            $validate['loan'] = 'required';
        }
        if ($request->promotion_id == LOAN) {
            $validate['rate_type'] = 'required';
            $validate['tenure'] = 'required';
            $validate['property_type'] = 'required';
            $validate['completion'] = 'required';

        }

        $validator = Validator::make($request->all(), $validate);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $defaultSearch = DefaultSearch::where('promotion_id', $request->promotion_id)->first();
        $msg = UPDATED_ALERT;
        if (!$defaultSearch) {
            $defaultSearch = new DefaultSearch();
            $msg = ADDED_ALERT;
        }
        $defaultSearch->placement = $request->placement;
        $defaultSearch->promotion_id = $request->promotion_id;

        if ($request->promotion_id == ALL_IN_ONE_ACCOUNT) {
            $defaultSearch->salary = $request->salary;
            $defaultSearch->payment = $request->payment;
            $defaultSearch->spend = $request->spend;
            $defaultSearch->privilege = $request->privilege;
            $defaultSearch->loan = $request->loan;
        }
        if ($request->promotion_id == LOAN) {
            $defaultSearch->rate_type = $request->rate_type;
            $defaultSearch->tenure = $request->tenure;
            $defaultSearch->property_type = $request->property_type;
            $defaultSearch->completion = $request->completion;
        }
        $defaultSearch->save();

        return redirect()->route('promotion-products', ["productTypeId" => $request->promotion_id])->with('success', 'Default Search values ' . $msg);

    }

    public
    function toolTip($productTypeId)
    {
        $toolTips = ToolTip::where('promotion_id', $productTypeId)->first();
        $CheckLayoutPermission = $this->view_all_permission(@Auth::user()->role_type_id, PRODUCT_ID);
        $productType = $this->productType($productTypeId);

        return view('backend.products.formulaDetail.tool_tips', compact('CheckLayoutPermission', 'productType', 'productTypeId', 'toolTips'));

    }

    public
    function toolTipUpdate(Request $request)
    {
        $validate = [];
        if ($request->promotion_id == ALL_IN_ONE_ACCOUNT) {
            $validate['salary'] = 'required';
            $validate['payment'] = 'required';
            $validate['spend'] = 'required';
            $validate['privilege'] = 'required';
            $validate['loan'] = 'required';
        }
        if ($request->promotion_id == LOAN) {
            $validate['rate_type'] = 'required';
            $validate['tenure'] = 'required';
            $validate['property_type'] = 'required';
            $validate['completion'] = 'required';
            $validate['loan'] = 'required';

        }

        $validator = Validator::make($request->all(), $validate);
        if ($validator->getMessageBag()->count()) {
            return back()->withInput()->withErrors($validator->errors());
        }
        $toolTips = ToolTip::where('promotion_id', $request->promotion_id)->first();
        $msg = UPDATED_ALERT;
        if (!$toolTips) {
            $toolTips = new ToolTip();
            $msg = ADDED_ALERT;
        }
        $toolTips->promotion_id = $request->promotion_id;

        if ($request->promotion_id == ALL_IN_ONE_ACCOUNT) {
            $toolTips->salary = $request->salary;
            $toolTips->payment = $request->payment;
            $toolTips->spend = $request->spend;
            $toolTips->privilege = $request->privilege;
            $toolTips->loan = $request->loan;
        }
        if ($request->promotion_id == LOAN) {
            $toolTips->rate_type = $request->rate_type;
            $toolTips->tenure = $request->tenure;
            $toolTips->property_type = $request->property_type;
            $toolTips->completion = $request->completion;
            $toolTips->loan = $request->loan;
        }
        $toolTips->save();

        return redirect()->route('promotion-products', ["productTypeId" => $request->promotion_id])->with('success', 'Tool Tips ' . $msg);

    }

    public function reminder()
    {
        $dtNow = new DateTime();

        $beginOfDay = clone $dtNow;

        // Go to midnight.  ->modify('midnight') does not do this for some reason
        $beginOfDay->modify('today');

        $endOfDay = clone $beginOfDay;
        $endOfDay->modify('tomorrow');

        // adjust from the next day to the end of the day, per original question
        $endDate = $endOfDay->modify('1 second ago');
        $endDate = $endDate->format('Y-m-d H:i:s');
        $reminderData = \DB::table('product_managements')
            ->join('users', 'product_managements.user_id', 'users.id')
            ->where('product_managements.end_date', '>', $endDate)
            ->where('users.status', '=', 1)
            ->get();


        if ($reminderData->count()) {

            foreach ($reminderData as $k => $detail) {
                if (!$detail->product_reminder) {
                    $detail->product_reminder = null;
                } else {
                    $detail->product_reminder = json_decode($detail->product_reminder);
                }
                //dd($detail);
                if ($detail->product_reminder) {
                    foreach ($detail->product_reminder as $dayKey => $reminderDay) {
                        $reminderDate = null;
                        if ($reminderDay == '1 Day') {
                            $reminderDate = date('Y-m-d H:i:s', strtotime($endDate . ' + 1 days'));
                        } elseif ($reminderDay == '1 Week') {
                            $reminderDate = date('Y-m-d H:i:s', strtotime($endDate . ' + 7 days'));
                        } elseif ($reminderDay == '2 Week') {
                            $reminderDate = date('Y-m-d H:i:s', strtotime($endDate . ' + 14 days'));
                        }

                        if (!is_null($reminderDate) && ($reminderDate == $detail->end_date)) {

                            $ads = collect([]);
                            $adsCollection = \DB::table('ads_management')->where('delete_status', 0)
                                ->where('display', 1)
                                ->where('page', 'email')
                                ->inRandomOrder()
                                ->get();

                            if ($adsCollection->count()) {
                                $ads = \Helper::manageAds($adsCollection);
                            }
                            $current_time = strtotime(date('Y-m-d', strtotime('now')));
                            $ad_start_date = strtotime($ads->ad_start_date);
                            $ad_end_date = strtotime($ads->ad_end_date);
                            $ad = null;
                            $adLink = null;

                            if ($ads->paid_ads_status == 1 && $current_time >= $ad_start_date && $current_time <= $ad_end_date && !empty($ads->paid_ad_image)) {
                                $ad = $ads->paid_ad_image;
                                $adLink = $ads->paid_ad_link;

                            } else {
                                $ad = $ads->ad_image;
                                $adLink = $ads->ad_link;
                            }
                            Mail::send('frontend.emails.reminder', [
                                'account_name' => $detail->account_name,
                                'end_date' => $detail->end_date,
                                'ad' => $ad,
                                'adLink' => $adLink
                            ], function ($message) use ($detail) {
                                $message->to($detail->email)->subject('A Product reminder');
                            });

                        }
                    }
                }

            }
        }
    }

    public function  changeRateType(Request $request)
    {
        if ($request->rate_type == FLOATING_RATE) {
            ?>
            <label for="title" class="col-sm-2 control-label">Rate type</label>

            <div class="col-sm-4">
                <select class="form-control" name="rate_type_f1" id="rate-type">
                    <option value="<?php echo FIXED_RATE; ?>"><?php echo FIXED_RATE; ?></option>
                    <option value="<?php echo FLOATING_RATE; ?>"
                            selected="selected"><?php echo FLOATING_RATE; ?></option>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id=""
                       name="rate_type_name_f1" value=""
                       placeholder="Rate name">
            </div>
            <div class="col-sm-2">
            </div>
            <?php

        } else { ?>
            <label for="title" class="col-sm-2 control-label">Rate type</label>

            <div class="col-sm-8">
                <select class="form-control" name="rate_type_f1" id="rate-type">
                    <option value="<?php echo FIXED_RATE; ?>" selected="selected"><?php echo FIXED_RATE; ?></option>
                    <option value="<?php echo FLOATING_RATE; ?>"><?php echo FLOATING_RATE; ?></option>
                </select>
            </div>
            <input type="hidden" class="form-control" id="" name="rate_type_name_f1" value="" placeholder="">
            <div class="col-sm-2">
            </div>
            <?php
        }

    }

    public function pathUpdateInTechAndLong()
    {

        $products = PromotionProducts::all();

        if ($products->count()) {
            $i = 0;
            foreach ($products as $product) {
                $update = false;
                $oldProduct = $product;
                //  str_replace(' ', '%20', $your_string);
                if (strpos($product->product_footer, 'class="ps-btn ps-btn--black"') !== false) {
                    $product->product_footer = str_replace('class="ps-btn ps-btn--black"', 'class="ps-btn ps-btn--black" target="_blank"', $product->product_footer);
                    $update = true;

                }
                if (strpos($product->product_footer, 'class="ps-btn ps-btn--outline"') !== false) {
                    $product->product_footer = str_replace('class="ps-btn ps-btn--outline"', 'class="ps-btn ps-btn--outline" target="_blank"', $product->product_footer);
                    $update = true;

                }
                /*if (strpos($product->long_description, '/speedo/public') !== false) {
                    $product->long_description = str_replace('/speedo/public', '', $product->long_description);
                    $update = true;
                }*/

                if ($update == true) {
                    $product->save();
                    $i++;
                }

            }
            dd($i);
        }

    }
}
