<?php
namespace App\Http\Controllers\CMS;

use App\AdsManagement;
use App\Brand;
use App\Currency;
use App\DefaultSearch;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Page;
use App\ProductManagement;
use App\PromotionProducts;
use App\systemSettingLegendTable;
use App\Tag;
use App\ToolTip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Defr;
use App\Helpers\Helper\Helper as Helper;

class PagesFrontNewController extends Controller
{
    public function ocbcCriteriaFilter(Request $request)
    {
        $searchDetail = [];
        $checkBoxDetail = [];
        parse_str($request->search_detail, $searchDetail);
        parse_str($request->check_box_detail, $checkBoxDetail);

        $brandId = null;
        $sortBy = isset($searchDetail['sort_by']) ? $searchDetail['sort_by'] : MAXIMUM;
        $filter = isset($searchDetail['filter']) ? $searchDetail['filter'] : PLACEMENT;
        $highlightStatus = isset($request->status) ? $request->status : 1;
        $product = PromotionProducts::join('promotion_types', 'promotion_products.promotion_type_id', '=', 'promotion_types.id')
            ->join('brands', 'promotion_products.bank_id', '=', 'brands.id')
            ->join('promotion_formula', 'promotion_products.formula_id', '=', 'promotion_formula.id')
            ->where('promotion_formula.promotion_id', '=', ALL_IN_ONE_ACCOUNT)
            ->where('promotion_products.delete_status', '=', 0)
            ->where('promotion_products.status', '=', 1)
            ->where('promotion_products.id', '=', $request->product_id)
            ->select('brands.id as brand_id', 'promotion_formula.id as promotion_formula_id', 'promotion_formula.*', 'promotion_products.*', 'brands.*', 'promotion_products.id as product_id')
            ->first();

        if ($product) {
            $defaultSearch = DefaultSearch::where('promotion_id', ALL_IN_ONE_ACCOUNT)->first();
            if ($defaultSearch) {
                $defaultPlacement = $defaultSearch->placement;
                $defaultSalary = $defaultSearch->salary;
                $defaultGiro = $defaultSearch->payment;
                $defaultSpend = $defaultSearch->spend;
                $defaultLoan = $defaultSearch->loan;
                $defaultPrivilege = $defaultSearch->privilege;
            } else {
                $defaultPlacement = 0;
                $defaultSalary = 0;
                $defaultGiro = 0;
                $defaultSpend = 0;
                $defaultLoan = 0;
                $defaultPrivilege = 0;
            }
            $placement = 0;
            $searchValue = str_replace(',', '', $searchDetail['search_value']);
            if ($highlightStatus == 0) {
                $salary = (int)$searchDetail['salary'];
                $giro = (int)$searchDetail['giro'];
                $spend = (int)$searchDetail['spend'];
                $privilege = isset($searchDetail['privilege']) ? (int)$searchDetail['privilege'] : 0;
                $loan = isset($searchDetail['loan']) ? (int)$searchDetail['loan'] : 0;
                $growStatus = true;
                $boostStatus = false;
                $otherStatus = false;
                $productRanges = json_decode($product->product_range);
                if (count($productRanges)) {
                    $productRange = $productRanges[0];
                    if (isset($checkBoxDetail['boost_interest'])) {
                        $boostStatus = true;
                    }
                    /*if (isset($checkBoxDetail['grow_interest'])) {
                        $growStatus = true;
                    }*/
                }
            } else {
                $salary = (int)$searchDetail['salary'];
                $giro = (int)$searchDetail['giro'];
                $spend = (int)$searchDetail['spend'];
                $privilege = isset($searchDetail['privilege']) ? (int)$searchDetail['privilege'] : 0;
                $loan = isset($searchDetail['loan']) ? (int)$searchDetail['loan'] : 0;
                $growStatus = true;
                $boostStatus = false;
                $otherStatus = false;
                $productRanges = json_decode($product->product_range);
                if (count($productRanges)) {
                    $productRange = $productRanges[0];
                    if (isset($checkBoxDetail['boost_interest'])) {
                        $boostStatus = true;
                    }
                    /*if (isset($checkBoxDetail['grow_interest'])) {
                        $growStatus = true;
                    }*/
                }
            }
            $status = false;
            $productRanges = json_decode($product->product_range);
            if ($product->promotion_formula_id == ALL_IN_ONE_ACCOUNT_F6) {

                //dd($productRanges);
                $criteriaMatchCount = 0;
                $product->highlight_index = 0;
                $product->highlight = false;
                $product->salary_highlight = false;
                $product->spend_highlight = false;
                $product->other_highlight = false;
                $product->wealth_highlight = false;
                $product->grow_highlight = false;
                $product->boost_highlight = false;
                $maxRanges = [];
                $minRanges = [];
                $totalInterests = [];
                $interestEarns = [];
                $criteria = null;
                $salaryStatus = false;
                $spendStatus = false;
                $wealthStatus = false;
                $baseInterest = true;


                //$placement = 0;
                if ($salary >= $productRanges[0]->minimum_salary) {
                    $salaryStatus = true;
                }
                if ($spend >= $productRanges[0]->minimum_spend) {
                    $spendStatus = true;
                }
                if ($productRanges[0]->status_other == 1 && !is_null($productRanges[0]->other_interest_name) && isset($checkBoxDetail['other_interest'])) {
                    //return $checkBoxDetail;
                    $otherStatus = true;
                    $product->other_highlight = true;
                }

                if ($privilege > 0 && $productRanges[0]->minimum_wealth <= ($privilege / 12)) {
                    $wealthStatus = true;
                }
                foreach ($productRanges as $key => $productRange) {
                    $productRange->salary_highlight = false;
                    $productRange->spend_highlight = false;
                    $productRange->other_highlight = false;
                    $productRange->wealth_highlight = false;
                    $maxRanges[] = $productRange->max_range;
                    $minRanges[] = $productRange->min_range;
                    if ($searchValue >= $productRange->min_range) {
                        $placement = (int)$searchValue;
                        $status = true;
                    } elseif (empty($placement) && (count($productRanges) - 1) == ($key)) {
                        $placement = $productRange->max_range;
                        $status = false;
                    }
                }
                $maxPlacement = array_last(array_sort($maxRanges));
                $minPlacement = array_last(array_sort($minRanges));
                $lastRange = array_last($productRanges);
                $lastCalculatedAmount = 0;
                $interestRangeCount = 1;
                $interestPercentTotal = 0;
                foreach ($productRanges as $k => $productRange) {
                    $interestEarn = 0;
                    if ($minPlacement == $productRange->min_range && $minPlacement <= $placement) {
                        if ($lastCalculatedAmount < $placement) {
                            if ($salaryStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($lastRange->bonus_interest_salary / 100), 2);
                                $productRange->salary_highlight = true;
                                $product->salary_highlight = true;
                                $product->highlight = true;
                                $interestPercentTotal += $lastRange->bonus_interest_salary;
                            }
                            if ($spendStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($lastRange->bonus_interest_spend / 100), 2);
                                $productRange->spend_highlight = true;
                                $product->spend_highlight = true;
                                $product->highlight = true;
                                $interestPercentTotal += $lastRange->bonus_interest_spend;
                            }
                            if ($otherStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($lastRange->bonus_interest_other / 100), 2);
                                $productRange->other_highlight = true;
                                $product->other_highlight = true;
                                $product->highlight = true;
                                $interestPercentTotal += $lastRange->bonus_interest_other;
                            }
                            if ($wealthStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($lastRange->bonus_interest_wealth / 100), 2);
                                $productRange->wealth_highlight = true;
                                $product->highlight = true;
                                $product->wealth_highlight = true;
                                $interestPercentTotal += $lastRange->bonus_interest_wealth;
                            }

                            $interestEarns[] = $interestEarn;


                            $productRange->above_range = true;
                            $product->highlight_index = $k;
                            $lastCalculatedAmount = $placement;
                        }
                        $productRange->interest_earn = $interestEarn;
                    } else {
                        if ($productRange->max_range < $placement) {
                            if ($salaryStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_salary / 100), 2);
                                $productRange->salary_highlight = true;
                                $product->salary_highlight = true;
                                $product->highlight = true;
                                $interestPercentTotal += $productRange->bonus_interest_salary;
                            }
                            if ($spendStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_spend / 100), 2);
                                $productRange->spend_highlight = true;
                                $product->highlight = true;
                                $product->spend_highlight = true;
                                $interestPercentTotal += $productRange->bonus_interest_spend;
                            }
                            if ($otherStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_other / 100), 2);
                                $productRange->other_highlight = true;
                                $product->highlight = true;
                                $product->other_highlight = true;
                                $interestPercentTotal += $productRange->bonus_interest_other;
                            }
                            if ($wealthStatus == true) {
                                $interestEarn += round(($productRange->max_range - $lastCalculatedAmount) * ($productRange->bonus_interest_wealth / 100), 2);
                                $productRange->wealth_highlight = true;
                                $product->wealth_highlight = true;
                                $product->highlight = true;
                                $interestPercentTotal += $productRange->bonus_interest_wealth;
                            }

                            $interestEarns[] = $interestEarn;
                            $product->highlight_index = $k;

                            //$totalInterests[] = $productRange->$criteria;
                            $lastCalculatedAmount = $productRange->max_range;
                        } else {
                            if ($lastCalculatedAmount < $placement) {

                                if ($salaryStatus == true) {
                                    $interestEarn += round(($placement - $lastCalculatedAmount) * ($productRange->bonus_interest_salary / 100), 2);
                                    $productRange->salary_highlight = true;
                                    $product->highlight = true;
                                    $product->salary_highlight = true;
                                    $interestPercentTotal += $productRange->bonus_interest_salary;
                                }
                                if ($spendStatus == true) {
                                    $interestEarn += round(($placement - $lastCalculatedAmount) * ($productRange->bonus_interest_spend / 100), 2);
                                    $productRange->spend_highlight = true;
                                    $product->spend_highlight = true;
                                    $product->highlight = true;
                                    $interestPercentTotal += $productRange->bonus_interest_spend;
                                }
                                if ($otherStatus == true) {
                                    $interestEarn += round(($placement - $lastCalculatedAmount) * ($productRange->bonus_interest_other / 100), 2);
                                    $productRange->other_highlight = true;
                                    $product->highlight = true;
                                    $product->other_highlight = true;
                                    $interestPercentTotal += $productRange->bonus_interest_other;
                                }
                                if ($wealthStatus == true) {
                                    $interestEarn += round(($placement - $lastCalculatedAmount) * ($productRange->bonus_interest_wealth / 100), 2);
                                    $productRange->wealth_highlight = true;
                                    $product->highlight = true;
                                    $product->wealth_highlight = true;
                                    $interestPercentTotal += $productRange->bonus_interest_wealth;
                                }

                                $product->highlight_index = $k;
                                $interestEarns[] = $interestEarn;
                                $lastCalculatedAmount = $productRange->max_range;
                            }
                        }
                        $productRange->interest_earn = $interestEarn;
                        //$productRange->criteria = $productRange->$criteria;
                        $productRange->above_range = false;
                    }
                    $interestRangeCount++;
                }
                $product->grow_interest_total;
                $product->boost_interest_total;
                $product->base_interest_total;
                if ($placement >= $productRanges[0]->minimum_grow && ($growStatus == true)) {
                    if ($placement > $productRanges[0]->cap_grow) {
                        $product->grow_interest_total = round($productRanges[0]->cap_grow * ($productRanges[0]->bonus_interest_grow / 100), 2);
                    } else {
                        $product->grow_interest_total = round($placement * ($productRanges[0]->bonus_interest_grow / 100), 2);
                    }
                    $product->interest_earned += $product->grow_interest_total;
                    $product->grow_highlight = true;
                    $product->highlight = true;
                    $product->total_interest += $productRanges[0]->bonus_interest_grow;
                }
                if ($boostStatus == true) {
                    if ($placement > $productRanges[0]->cap_boost) {
                        $product->boost_interest_total = round($productRanges[0]->cap_boost * ($productRanges[0]->bonus_interest_boost / 100), 2);
                    } else {
                        $product->boost_interest_total = round($placement * ($productRanges[0]->bonus_interest_boost / 100), 2);
                    }
                    $product->interest_earned += $product->boost_interest_total;
                    $product->boost_highlight = true;
                    $product->highlight = true;
                    $product->total_interest += $productRanges[0]->bonus_interest_boost;
                }
                if ($maxPlacement< $placement) {
                    $product->base_interest_total = round(($placement-$maxPlacement) * ($productRanges[0]->bonus_interest_remaining_amount / 100), 2);
                    $product->interest_earned += $product->base_interest_total;
                    $product->base_highlight = true;
                    $product->total_interest += $productRanges[0]->bonus_interest_remaining_amount;
                }
                $product->total_interest += round($interestPercentTotal / $interestRangeCount, 2);
                $product->interest_earned += array_sum($interestEarns);
                $product->placement = $placement;
                $product->product_range = $productRanges;
                //return $product;
                ?>

                    <form id="form-<?php echo $product->product_id; ?>" class="ps-form--filter" method="post">
                        <table class="ps-table ps-table--product ps-table--product-3">
                            <thead>
                            <tr>
                                <th class="text-left">Balance</th>
                                <?php $firstRange = $productRanges[0]; ?>
                                <th class="text-left <?php if($product->salary_highlight==true  ) { echo'active'; } ?>">Salary</th>
                                <th class="text-left <?php if($product->spend_highlight==true  ) { echo'active'; } ?>">Spend</th>
                                <?php
                                if ($firstRange->status_other == 1) { ?>
                                    <th class="combine-criteria-padding <?php if ($product->other_highlight == true) {
                                        echo 'active';
                                    } ?> ">
                                        <div class="">
                                            <div class="width-60">
                                                <div class="ps-checkbox">
                                                    <input class="form-control" type="checkbox"
                                                           onchange="changeOCBC360Criteria(this);"
                                                           name="other_interest"
                                                           data-product-id="<?php echo $product->product_id; ?>"
                                                           value="true"
                                                        <?php if ($product->other_highlight) { ?>
                                                            checked="checked"
                                                        <?php } ?>

                                                           id="other-interest-<?php echo $product->product_id; ?>">
                                                    <label
                                                        for="other-interest-<?php echo $product->product_id; ?>" class="<?php if($product->other_highlight==true  ) { echo'active'; } ?>"><?php echo $firstRange->other_interest_name; ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                <?php } ?>
                                <th class="text-left <?php if ($product->wealth_highlight == true) {
                                    echo 'active';
                                } ?> " >Wealth</th>
                                <th class="text-left <?php if ($product->grow_highlight == true) {
                                    echo 'active';
                                } ?> " >Grow</th>

                                    <!--<th class="combine-criteria-padding <?php /*if ($product->other_highlight == true) {
                                        echo 'active';
                                    } */?> ">
                                        <div class="">
                                            <div class="width-50">
                                                <div class="ps-checkbox">
                                                    <input class="form-control" type="checkbox"
                                                           onchange="changeOCBC360Criteria(this);"
                                                           name="grow_interest"
                                                           data-product-id="<?php /*echo $product->product_id; */?>"
                                                           value="true"
                                                        <?php /*if ($product->grow_highlight) { */?>
                                                        checked="checked"
                                                        <?php /*} */?>
                                                           id="grow-interest-<?php /*echo $product->product_id; */?>">
                                                    <label
                                                        for="grow-interest-<?php /*echo $product->product_id; */?>">Grow</label>
                                                </div>
                                            </div>
                                        </div>
                                    </th>-->
                                <th class="combine-criteria-padding <?php if ($product->boost_highlight == true) {
                                    echo 'active';
                                } ?> ">
                                    <div class="">
                                        <div class="width-50">
                                            <div class="ps-checkbox">
                                                <input class="form-control" type="checkbox"
                                                       onchange="changeOCBC360Criteria(this);"
                                                       name="boost_interest"
                                                       data-product-id="<?php echo $product->product_id; ?>"
                                                       value="true"
                                                    <?php if ($product->boost_highlight) {
                                                        echo "checked = checked";
                                                    } ?>
                                                       id="boost-interest-<?php echo $product->product_id; ?>">
                                                <label
                                                    for="boost-interest-<?php echo $product->product_id; ?>" class="<?php if($product->boost_highlight==true  ) { echo'active'; } ?>">Boost</label>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <th class="text-left" >Total Interest Earned
                                    for <?php echo Helper::inThousand($product->placement); ?> </th>
                            </thead>
                            <tbody>
                            <?php $prevMaxRange = 0;  $totalRange = 0;
                            foreach ($productRanges as $key=>$range) {
                                $totalRange = 0 + ($range->max_range - $prevMaxRange);
                                if ($key != (count($productRanges) - 1)) {
                                }
                                ?>
                                <tr>
                                    <td class=" <?php if($product->highlight_index>=$key ) echo 'highlight'; ?> ">
                                        <?php
                                        if ($key == 0) {
                                            echo "First ";
                                            echo "$" . Helper::inThousand($range->max_range);
                                        } elseif ($key == (count($productRanges) - 1)) {
                                            echo "Next ";
                                            echo "$" . Helper::inThousand(($prevMaxRange));
                                        } else {
                                            echo "Next ";
                                            echo "$" . Helper::inThousand($range->max_range - $prevMaxRange);
                                        } ?>
                                    </td>
                                    <td class="text-center <?php if($product->highlight_index>=$key &&($range->salary_highlight==true) ) { echo 'highlight' ; } ?>">
                                        <?php if($range->bonus_interest_salary<=0) { ?>
                                        - <?php } else {  echo $range->bonus_interest_salary.'%'; } ?>
                                    </td>
                                    <td class="text-center <?php if($product->highlight_index>=$key &&($range->spend_highlight==true) ) {echo 'highlight';} ?> ">
                                        <?php if($range->bonus_interest_spend<=0) { ?>
                                        - <?php } else {  echo $range->bonus_interest_spend.'%'; } ?>
                                    </td>
                                    <?php if($firstRange->status_other == 1) { ?>
                                    <td class="text-center <?php if($product->highlight_index>=$key &&($range->other_highlight==true) ) { echo'highlight'; } ?> ">
                                        <?php if($range->bonus_interest_other<=0) { ?>
                                        - <?php } else { echo $range->bonus_interest_other.'%'; }?>
                                    </td>
                                    <?php } ?>

                                    <td class="text-center <?php if($product->highlight_index>=$key &&($range->wealth_highlight==true) ) { echo 'highlight' ;} ?> ">
                                        <?php if($range->bonus_interest_wealth<=0) { ?>
                                        - <?php } else { echo $range->bonus_interest_wealth.'%'; } ?>
                                    </td>
                                    <?php if($key==0) { ?>
                                    <td class="text-center <?php if($product->highlight_index>=$key &&($product->grow_highlight==true) ) { echo 'highlight'; } ?> "
                                        rowspan=" <?php echo count($productRanges) ; ?>">
                                        <?php if($range->bonus_interest_grow<=0) { ?>
                                        - <?php } else {  echo $range->bonus_interest_grow.'%' ; } ?>

                                    </td>
                                    <td class="text-center <?php if($product->highlight_index>=$key &&($product->boost_highlight==true) ) { echo 'highlight';} ?> "
                                        rowspan="<?php echo count($productRanges) ; ?>">
                                        <?php if($range->bonus_interest_boost<=0) { ?>
                                        - <?php } else {  echo $range->bonus_interest_boost.'%'; } ?>
                                    </td>
                                    <?php } ?>
                                    <?php
                                    if ($key != (count($productRanges) - 1)) {
                                        $prevMaxRange = $range->max_range;
                                    }?>
                                    <?php if($key==0) { ?>
                                    <td class="text-center  <?php if($product->highlight==true) { echo 'highlight'; } ?> "
                                        rowspan="<?php echo count($productRanges) ; ?> ">
                                        $<?php echo Helper::inRoundTwoDecimal($product->interest_earned);?>
                                        <br> base on effective interest rate
                                    </td>
                                    <?php } ?>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    </form>

                <?php
                $range = $productRanges[0];
                if ($status == true) { ?>
                    <div class="ps-product__panel aio-product">
                        <h4>Total Bonus Interest Earned for SGD
                            <?php echo "$" . \Helper::inThousand($product->placement); ?></h4>

                        <p class="center">
            <span
                class="nill"><?php echo "$" . \Helper::inThousand($product->interest_earned); ?>  </span><br/> Base on effective interest rate
                        </p>
                    </div>
                <?php } else { ?>
                    <div class="ps-product__panel aio-product">
                        <h4>Total Bonus Interest Earned for SGD
                            <?php echo "$" . \Helper::inThousand($range->placement); ?></h4>
                        <span class="nill"> <?php echo NILL; ?></span><br/>

                        <p><?php echo NOT_ELIGIBLE; ?></p>
                    </div>
                    <?php
                }
            }
        }

}