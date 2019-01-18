@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
<?php
$searchFilter = isset($searchFilter) ? $searchFilter : "";
$slug = CONTACT_SLUG;
//get banners
$banners = Helper::getBanners($slug);
?>
{{--Banner section start--}}
@if($banners->count()>1)
<div class="ps-home-banner">
    <div class="ps-slider--home owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
        data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1"
        data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000"
        data-owl-mousedrag="on">
        @foreach($banners as $banner)
        <div class="ps-banner bg--cover" data-background="{{asset($banner->banner_image )}}"><img
            src="{{asset($banner->banner_image )}}" alt="">
            <div class="ps-banner__content">
                {!!$banner->banner_content!!}
            </div>
        </div>
        @endforeach
    </div>
</div>
@elseif($banners->count()== 1)
@foreach($banners as $banner)
<div class="ps-hero bg--cover" data-background="{{asset($banner->banner_image )}}"><img
src="{{asset($banner->banner_image )}}" alt=""></div>
@endforeach
@endif
{{--Banner section end--}}
<div class="ps-breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i> Home</a></li>
            @include('frontend.includes.breadcrumb')
        </ol>
    </div>
</div>
{{--Page content start--}}
<div class="ps-page--deposit all-in">
    <?php
    $pageName = explode(' ', trim($page->name));
    $details = [];
    $details['first_heading'] = $pageName[0];
    // $a =  array_shift($arr);
    unset($pageName[0]);
    $details['second_heading'] = implode(' ', $pageName);
    $string = $page->contents;
    $output = preg_replace_callback('~\{{(.*?)\}}~',
    function ($key) use ($details) {
    $variable[$key[1]] = $details[$key[1]];
    return $variable[$key[1]];
    },
    $string);
    ?>
    {!! $output !!}
    <div class="container all-in" id="logo-detail">
        <div class="ps-block--deposit-filter ">
            <div class="ps-block__content">
                <form id="search-form" class="ps-form--filter"
                    action="{{ URL::route('aioa-deposit-mode.search') }}#logo-detail"
                    method="post">
                    <h4>Fill in your needs</h4>
                    <div class="ps-form__values">
                        <div class="form-group--label">
                            <div class="form-group__content">
                                <label>Salary
                                    @if(isset($toolTips->salary))
                                    <a class="ps-tooltip" href="javascript:void(0)"
                                        data-tooltip="{{$toolTips->salary}}"><i
                                    class="fa fa-exclamation-circle"></i></a>
                                    @endif
                                </label>
                                <input class="form-control" type="text" placeholder="" name="salary" id="salary"
                                value="{{ isset($searchFilter['salary']) ? $searchFilter['salary'] : '' }}">
                            </div>
                        </div>
                        <div class="form-group--label">
                            <div class="form-group__content">
                                <label>Payment
                                    @if(isset($toolTips->payment))
                                    <a class="ps-tooltip" href="javascript:void(0)"
                                        data-tooltip="{{$toolTips->payment}}"><i
                                    class="fa fa-exclamation-circle"></i></a>
                                    @endif
                                </label>
                                <input class="form-control" type="text" placeholder="" name="giro" id="giro"
                                value="{{ isset($searchFilter['giro']) ? $searchFilter['giro'] : '' }}">
                            </div>
                        </div>
                        <div class="form-group--label">
                            <div class="form-group__content">
                                <label>Spending
                                    @if(isset($toolTips->spend))
                                    <a class="ps-tooltip" href="javascript:void(0)"
                                        data-tooltip="{{$toolTips->spend}}"><i
                                    class="fa fa-exclamation-circle"></i></a>
                                    @endif
                                </label>
                                <input class="form-control" type="text" placeholder="" name="spend" id='spend'
                                value="{{ isset($searchFilter['spend']) ? $searchFilter['spend'] : '' }}">
                            </div>
                        </div>
                        <div class="form-group--label">
                            <div class="form-group__content">
                                <label>Privilege
                                    @if(isset($toolTips->privilege))
                                    <a class="ps-tooltip" href="javascript:void(0)"
                                        data-tooltip="{{$toolTips->privilege}}"><i
                                    class="fa fa-exclamation-circle"></i></a>
                                    @endif
                                </label>
                                <input class="form-control" type="text" placeholder="" name="privilege"
                                id='privilege'
                                value="{{ isset($searchFilter['privilege']) ? $searchFilter['privilege'] : '' }}">
                            </div>
                        </div>
                        <div class="form-group--label">
                            <div class="form-group__content">
                                <label>Loan
                                    @if(isset($toolTips->loan))
                                    <a class="ps-tooltip" href="javascript:void(0)"
                                        data-tooltip="{{$toolTips->loan}}"><i
                                    class="fa fa-exclamation-circle"></i></a>
                                @endif</label>
                                <input class="form-control" type="text" placeholder="" name="loan" id="loan"
                                value="{{ isset($searchFilter['loan']) ? $searchFilter['loan'] : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                            <div class="ps-form__option flex-box">
                                <label>Sort by:</label>
                                <button type="button"
                                class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Interest') active @endif">
                                <input type="radio" name="filter" value="Interest"
                                style="opacity: 0;position: absolute;"
                                @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Interest') checked @endif>Interest
                                </button>
                                <button type="button"
                                class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Placement') active @elseif(empty($searchFilter)) active @endif">
                                <input type="radio" name="filter" value="Placement"
                                style="opacity: 0;position: absolute;"
                                @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Placement') checked
                                @elseif(empty($searchFilter)) checked @endif>Placement
                                </button>
                                <button type="button"
                                class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']==CRITERIA) active @endif">
                                <input type="radio" name="filter" value="{{CRITERIA}}"
                                style="opacity: 0;position: absolute;"
                                @if(isset($searchFilter['filter']) && $searchFilter['filter']==CRITERIA) checked @endif>{{CRITERIA}}
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                            <div class="row ps-col-tiny">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="form-group form-group--nest">
                                        <div class="form-group__content">
                                            <input class="form-control only_numeric prefix_dollar" type="text"
                                            placeholder=""
                                            name="search_value" id="search_value"
                                            value="{{ isset($searchFilter['search_value']) ? $searchFilter['search_value'] : '' }}"/>
                                        </div>
                                        <button type="submit">Go</button>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                    <div class="form-group ">
                                        <select class="form-control sort-by" name="sort_by">
                                            <option value="" disabled="disabled" selected="selected">Arrange by
                                            </option>
                                            <option value="1"
                                                @if(isset($searchFilter['sort_by']) && $searchFilter['sort_by']==1) selected @endif>
                                                Ascending
                                            </option>
                                            <option value="2"
                                                @if(isset($searchFilter['sort_by']) && $searchFilter['sort_by']==2) selected @endif>
                                                Descending
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                                    <div class="form-group ">
                                        <a class="btn refresh form-control " style="width: 78px;"
                                            href="{{url(AIO_DEPOSIT_MODE)}}/#logo-detail"> <i
                                        class="fa fa-refresh"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Search form end -->
        @if(count($products))
        @include('productsSpInnerSlider')
        @include('productsInnerSlider')
        @endif
        @include('frontend.includes.legend')
        
        <?php
        $adspopup = json_decode($page->ads_placement);
        //dd($ads);
        $j = 1;
        ?>
        @if(count($products))
        @foreach($products as $product)
        <?php
        $productRanges = $product->product_range;
        $ads = json_decode($product->ads_placement);
        ?>
        @if($page->slug==AIO_DEPOSIT_MODE && isset($ads[3]->ad_horizontal_image_popup_top))
        <div class="ps-poster-popup">
            <a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)' }}"
                target="_blank"><img
                src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
                alt="">
                
                <div class="close-popup">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </a>
        </div>
        @endif
        <!-- INDIVIDUAL CRITERIA BASE -->
        @if($product->formula_id==ALL_IN_ONE_ACCOUNT_F1)
        <div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
            id="p-{{ $j }}">
            <div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
            @if(!empty($product->apply_link_status))
            <div class="ps-product__action"><a class="ps-btn ps-btn--red"
                href="{{$product->apply_link}}">Apply
            Now</a></div>@endif
        </div>
        <div class="ps-product__content">
            <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
            @if(!empty($product->ads_placement))
            @php
            $ads = json_decode($product->ads_placement);
            if(!empty($ads[0]->ad_image_horizontal)) {
            @endphp
            <div class="ps-product__poster"><a
                href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
                target="_blank"><img
                src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
            alt=""></a></div>
            @php } @endphp
            @endif
            <div class="ps-table-wrap">
                <table class="ps-table ps-table--product ps-table--product-3">
                    <thead>
                        <tr>
                            <th>CRITERIA</th>
                            <th>SALARY</th>
                            <th>PAYMENT</th>
                            <th>SPEND</th>
                            <th>PRIVILEGE</th>
                            <th>BONUS <br/><span class="subtitle">(OPTIONAL)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productRanges as $range)
                        <tr>
                            <td class="text-left">Bonus Interest PA</td>
                            <td class="text-center @if($product->salary_highlight==true ) highlight @endif"> @if($range->bonus_interest_salary<=0)
                                - @else {{ $range->bonus_interest_salary }} % @endif
                            </td>
                            <td class="text-center @if($product->payment_highlight==true ) highlight @endif"> @if($range->bonus_interest_giro_payment<=0)
                                - @else {{ $range->bonus_interest_giro_payment }} % @endif
                            </td>
                            <td class="text-center @if($product->spend_highlight==true ) highlight @endif">
                                @if($range->bonus_interest_spend<=0)
                                - @else {{ $range->bonus_interest_spend }} % @endif
                            </td>
                            <td class="text-center @if($product->privilege_highlight==true ) highlight @endif">
                                Up to @if($range->bonus_interest_privilege<=0)
                                - @else  {{ $range->bonus_interest_privilege }}% @endif
                            </td>
                            <td class="text-left @if($product->bonus_highlight==true ) highlight @endif">@if($range->bonus_interest<=0)
                                - @else  {{ $range->bonus_interest }}% @endif
                                on
                                first ${{ Helper::inThousand($range->first_cap_amount) }} if
                                account more
                            than ${{ Helper::inThousand($range->bonus_amount) }}</td>
                        </tr>
                        <tr>
                            <td colspan="1" class="text-left">Total Bonus Interest Earned for
                            ${{Helper::inThousand($range->placement)}}</td>
                            <td class="text-center @if($product->highlight==true ) highlight @endif"
                                colspan="5">
                                @if($range->placement > $range->first_cap_amount)
                                First
                                ${{ Helper::inThousand($range->first_cap_amount) }} -
                                ${{ Helper::inRoundTwoDecimal(($range->first_cap_amount*($product->total_interest/100))) }}
                                (
                                {{ $product->total_interest }}%), remaining
                                ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
                                -
                                ${{ Helper::inRoundTwoDecimal((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
                                ({{ $range->bonus_interest_remaining_amount }}%) <br/> Total
                                =
                                ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
                                @else
                                Total =
                                ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
                                ({{$product->total_interest}}%)
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <?php
            $range = $productRanges[0];
            ?>
            <div class="ps-product__panel aio-product">
                <h4>Total Bonus Interest Earned for SGD
                ${{Helper::inThousand($range->placement)}}</h4>
                <p class="center">
                    <span class="nill"> ${{ Helper::inThousand($product->interest_earned) }} </span><br/>
                    @if($range->placement > $range->first_cap_amount)
                    First
                    ${{ Helper::inThousand($range->first_cap_amount) }} -
                    ${{ Helper::inRoundTwoDecimal(($range->first_cap_amount*($product->total_interest/100))) }}
                    (
                    {{ $product->total_interest }}%), Remaining
                    ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
                    -
                    ${{ Helper::inRoundTwoDecimal((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
                    ({{ $range->bonus_interest_remaining_amount }}%) <br/> Total
                    =
                    ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
                    @else
                    Total =
                    ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
                    ({{$product->total_interest}}%)
                    @endif
                </p>
            </div>
            <div class="clearfix"></div>
            @if(!empty($product->ads_placement))
            @php
            $ads = json_decode($product->ads_placement);
            if(!empty($ads[2]->ad_horizontal_image_popup)) {
            @endphp
            <div class="ps-poster-popup">
                <a target="_blank"
                    href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
                    src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                    alt="" target="_blank">
                    <div class="close-popup">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div></a>
                </div>
                @php } @endphp
                @endif
                <div class="ps-product__detail">
                    {!! $product->product_footer !!}
                </div>
                <div class="ps-product__footer"><a class="ps-product__more" href="#">More Details<i
                class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only"
                href="#">More data<i
            class="fa fa-angle-down"></i></a></div>
        </div>
    </div>
    <!-- TIER BASE -->
    @elseif($product->formula_id==ALL_IN_ONE_ACCOUNT_F2)
    <div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
        id="p-{{ $j }}">
        <div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
        @if(!empty($product->apply_link_status))
        <div class="ps-product__action"><a class="ps-btn ps-btn--red"
            href="{{$product->apply_link}}">Apply
        Now</a></div>@endif
    </div>
    <div class="ps-product__content">
        <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
        @if(!empty($product->ads_placement))
        @php
        $ads = json_decode($product->ads_placement);
        if(!empty($ads[0]->ad_image_horizontal)) {
        @endphp
        <div class="ps-product__poster"><a
            href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
            target="_blank"><img
            src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
        alt=""></a></div>
        @php } @endphp
        @endif
        <div class="ps-table-wrap">
            <table class="ps-table ps-table--product ps-table--product-2">
                <thead>
                    <tr>
                        <th class="text-left">Balance</th>
                        <th class="text-left" style="@if($product->criteria_a_highlight==true) color:#66ec76; @endif">Criteria a <br/><span
                        class="subtitle">(spend)</span></th>
                        <th class="text-left" style="@if($product->criteria_b_highlight==true) color:#66ec76; @endif">Criteria b <br/><span class="subtitle">(Spend + Salary/Giro)</span>
                    </th>
                    <th class="text-left" style="">Interest Earned for each Tier</th>
                    <th class="text-left" >Total Interest Earned
                    for {{ Helper::inThousand($product->placement) }}</th>
                </tr>
            </thead>
            <tbody>
                <?php $prevMaxRange = 0;  $totalRange = 0; ?>
                @foreach($productRanges as $key=>$range)
                <?php
                $totalRange = 0 + ($range->max_range - $prevMaxRange);
                if ($key != (count($productRanges) - 1)) {
                }
                ?>
                <tr>
                    <td class=" @if($product->highlight_index>=$key &&($product->criteria_b_highlight==true || $product->criteria_a_highlight==true) ) highlight @endif ">
                        <?php
                        if ($key == 0) {
                        echo "First ";
                        echo "$" . Helper::inThousand($range->max_range);
                        } elseif ($key == (count($productRanges) - 1)) {
                        echo "Above ";
                        echo "$" . Helper::inThousand(($prevMaxRange));
                        } else {
                        echo "Next ";
                        echo "$" . Helper::inThousand($range->max_range - $prevMaxRange);
                        } ?>
                    </td>
                    <td class="text-center @if($product->highlight_index>=$key &&($product->criteria_a_highlight==true) ) highlight @endif">
                        @if($range->bonus_interest_criteria_a<=0)
                        - @else  {{ $range->bonus_interest_criteria_a }}% @endif
                    </td>
                    <td class="text-center @if($product->highlight_index>=$key &&($product->criteria_b_highlight==true) ) highlight @endif  ">
                        @if($range->bonus_interest_criteria_b<=0)
                        - @else  {{ $range->bonus_interest_criteria_b }}% @endif
                    </td>
                    <td>
                        <?php
                        if ($key == 0) {
                        echo "First ";
                        echo "$" . Helper::inThousand($range->max_range);
                        } elseif ($key == (count($productRanges) - 1)) {
                        echo "Above ";
                        echo "$" . Helper::inThousand(($prevMaxRange));
                        } else {
                        echo "Next ";
                        echo "$" . Helper::inThousand($range->max_range - $prevMaxRange);
                        } if ($key != (count($productRanges) - 1)) {
                        $prevMaxRange = $range->max_range;
                        }?>
                        -${{ Helper::inRoundTwoDecimal($range->interest_earn) }}
                        ({{ $range->criteria }}%)
                    </td>
                    @if($key==0)
                    <td class="text-center  @if($product->highlight==true) highlight @endif"
                        rowspan="{{count($productRanges)}}">
                        ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
                        <br> base on effective interest rate
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="ps-product__panel aio-product">
        <h4>Total Interest Earned for SGD
        ${{Helper::inThousand($product->placement)}}</h4>
        <p class="center">
            <span class="nill"> ${{ Helper::inRoundTwoDecimal($product->interest_earned) }} </span><br/>
            Base on effective interest rate
        </p>
    </div>
    <div class="clearfix"></div>
    @if(!empty($product->ads_placement))
    @php
    $ads = json_decode($product->ads_placement);
    if(!empty($ads[2]->ad_horizontal_image_popup)) {
    @endphp
    <div class="ps-poster-popup">
        <a target="_blank"
            href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
            src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
            alt="" target="_blank">
            <div class="close-popup">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div></a>
        </div>
        @php } @endphp
        @endif
        <div class="ps-product__detail">
            {!! $product->product_footer !!}
        </div>
        <div class="ps-product__footer"><a class="ps-product__more" href="#">More Details<i
        class="fa fa-angle-down"></i></a><a
        class="ps-product__info sp-only" href="#">More data<i
    class="fa fa-angle-down"></i></a></div>
</div>
</div>
<!-- COMBINE TIER BASE -->
@elseif($product->formula_id==ALL_IN_ONE_ACCOUNT_F3)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="p-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a class="ps-btn ps-btn--red"
    href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
    href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
    target="_blank"><img
    src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<h4 class="ps-product__heading"><strong
class="highlight">{{$product->product_name}}
:</strong>
Fulfil up to 3 criteria and earn up
to @if($product->maximum_interest_rate<=0)
- @else  {{ $product->maximum_interest_rate }}% @endif
</h4>
<div id='{{$product->product_id}}'>
    <div class="ps-table-wrap">
        <form id="form-{{$product->product_id}}"
            class="ps-form--filter" method="post">
            <table class="ps-table ps-table--product ps-table--product-3">
                <thead>
                    <tr>
                        <th class="combine-criteria-padding" style="width:19%">CRITERIA</th>
                        <th class="combine-criteria-padding" style="width:9%">SALARY</th>
                        <th class="combine-criteria-padding" style="width:9%">PAYMENT</th>
                        <th class="combine-criteria-padding" style="width:9%">SPEND</th>
                        <th class="combine-criteria-padding" style="width:21%">
                            Loan
                            <div class="row">
                                <div class="width-50">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                        onchange="changeCriteria(this);"
                                        @if($product->housing_loan) checked=checked
                                        @endif
                                        name="housing_loan"
                                        data-product-id="{{$product->product_id}}"
                                        value="true"
                                        id="housing-loan-{{$product->product_id}}">
                                        <label for="housing-loan-{{$product->product_id}}">Housing</label>
                                    </div>
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                        name="education_loan"
                                        onchange="changeCriteria(this);"
                                        data-product-id="{{$product->product_id}}"
                                        value="true"
                                        id='education-loan-{{$product->product_id}}'
                                        @if($product->education_loan) checked=checked @endif/>
                                        <label for="education-loan-{{$product->product_id}}">Education</label>
                                    </div>
                                </div>
                                <div class="width-50">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                        onchange="changeCriteria(this);"
                                        name="hire_loan" value="true"
                                        data-product-id="{{$product->product_id}}"
                                        id="hire-loan-{{$product->product_id}}"
                                        @if($product->hire_loan) checked=checked @endif/>
                                        <label for="hire-loan-{{$product->product_id}}">Hire
                                        </label>
                                    </div>
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                        name="renovation_loan"
                                        onchange="changeCriteria(this);"
                                        data-product-id="{{$product->product_id}}"
                                        value="true"
                                        id="renovation-loan-{{$product->product_id}}"
                                        @if($product->renovation_loan) checked=checked @endif/>
                                        <label for="renovation-loan-{{$product->product_id}}">Renovation
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </th>
                        <th class="combine-criteria-padding" style="width:21%">
                            Wealth
                            <div class="row">
                                <div class="width-50">
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                        data-product-id="{{$product->product_id}}"
                                        name="life_insurance"
                                        onchange="changeCriteria(this);"
                                        @if($product->life_insurance) checked=checked
                                        @endif value="true"
                                        id="life-insurance-{{$product->product_id}}"/>
                                        <label for="life-insurance-{{$product->product_id}}">Insurance</label>
                                    </div>
                                    <div class="ps-checkbox">
                                        <input class="form-control" type="checkbox"
                                        onchange="changeCriteria(this);"
                                        name="unit_trust" value="true"
                                        data-product-id="{{$product->product_id}}"
                                        id="unit-trust-{{$product->product_id}}"
                                        @if($product->unit_trust) checked=checked @endif/>
                                        <label for="unit-trust-{{$product->product_id}}">Unit
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productRanges as $range)
                    <tr>
                        <td colspan="1" class="text-left">Bonus Interest PA</td>
                        <td class="text-center @if($product->criteria_1==true ) highlight @endif"
                            colspan="3">1 Criteria Met
                            @if($range->bonus_interest_criteria1<=0)
                            - @else - {{ $range->bonus_interest_criteria1 }}
                            % @endif
                        </td>
                        <td class=" text-center @if($product->criteria_2==true ) highlight @endif"
                            colspan="1">2 Criteria
                            @if($range->bonus_interest_criteria2<=0)
                            - @else - {{ $range->bonus_interest_criteria2 }}
                            % @endif
                        </td>
                        <td class="text-center @if($product->criteria_3==true ) highlight @endif"
                            colspan="1">3
                            Criteria @if($range->bonus_interest_criteria3<=0)
                            - @else - {{ $range->bonus_interest_criteria3 }}
                            % @endif
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1" class="text-left">Total Bonus Interest
                            Earned for
                        ${{ Helper::inThousand($range->placement) }}</td>
                        <td class=" text-center @if($product->highlight==true ) highlight @endif"
                            colspan="5">
                            @if($range->placement > $range->first_cap_amount)
                            First
                            ${{ Helper::inThousand($range->first_cap_amount) }}
                            -
                            ${{ Helper::inRoundTwoDecimal(($range->first_cap_amount*($product->total_interest/100))) }}
                            (
                            {{ $product->total_interest }}%), next
                            ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
                            -
                            ${{ Helper::inRoundTwoDecimal((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
                            ({{ $range->bonus_interest_remaining_amount }}%)
                            <br/>
                            Total =
                            ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
                            @else
                            Total =
                            ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
                            ({{$product->total_interest}}%)
                            @endif
                        </td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>
</div>
<?php
$range = $productRanges[0];
?>
<div class="ps-product__panel aio-product">
    <h4>Total Bonus Interest Earned for SGD
    ${{Helper::inThousand($range->placement)}}</h4>
    <p class="center">
        <span class="nill"> ${{ Helper::inThousand($product->interest_earned) }} </span><br/>
        @if($range->placement > $range->first_cap_amount)
        First
        ${{ Helper::inThousand($range->first_cap_amount) }} -
        ${{ Helper::inRoundTwoDecimal(($range->first_cap_amount*($product->total_interest/100))) }}
        (
        {{ $product->total_interest }}%), Remaining
        ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
        -
        ${{ Helper::inRoundTwoDecimal((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
        ({{ $range->bonus_interest_remaining_amount }}%) <br/> Total
        =
        ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
        @else
        Total =
        ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
        ({{$product->total_interest}}%)
        @endif
    </p>
</div>
</div>
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
    href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
    src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
    alt="" target="_blank">
    <div class="close-popup">
        <i class="fa fa-times" aria-hidden="true"></i>
    </div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
    {!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more" href="#">More Details<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only" href="#">More
data<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
<!-- DBS CRITERIA -->
@elseif($product->formula_id==ALL_IN_ONE_ACCOUNT_F4)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="p-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<div class="ps-table-wrap">
<table class="ps-table ps-table--product">
<thead>
    <tr>
        <th>Monthly Transaction</th>
        <th>Criteria A <br/><span class="subtitle">(Salary + 1 category)</span>
    </th>
    <th>Criteria A <br/><span
    class="subtitle">(Salary + 2 OR more Cateogry)</span>
</th>
<th>Total Interest Earned for SGD
${{ Helper::inThousand($product->placement) }}</th>
</tr>
</thead>
<tbody>
@foreach($productRanges as $range)
@endforeach
@foreach($productRanges as $key=>$range)
<tr>
<td class="@if($range->criteria_a_highlight==true || $range->criteria_b_highlight==true ) highlight @endif"
    style="width: 30%">@if($key==0)
    Less than
    ${{ Helper::inThousand($range->max_range+1) }}
    @elseif((count($productRanges)-1)==$key)
    ${{ Helper::inThousand($range->min_range) }} Or
    Above
    @else
    ${{ Helper::inThousand($range->min_range) }} TO <
${{ Helper::inThousand($range->max_range+1) }} @endif</td>
<td class="text-center @if($range->criteria_a_highlight==true ) highlight @endif">
    @if($range->bonus_interest_criteria_a<=0)
    - @else  {{ $range->bonus_interest_criteria_a }}
    % @endif
</td>
<td class="text-center @if($range->criteria_b_highlight==true ) highlight @endif">
    @if($range->bonus_interest_criteria_b<=0)
    - @else  {{ $range->bonus_interest_criteria_b }}
    % @endif
</td>
@if($key==0)
<td class=" text-center @if($product->highlight==true ) highlight @endif"
    rowspan="6">
    @if($product->placement > $range->first_cap_amount)
    First
    ${{ Helper::inThousand($range->first_cap_amount) }}
    -
    ${{ Helper::inRoundTwoDecimal(($range->first_cap_amount*($product->total_interest/100))) }}
    (
    {{ $product->total_interest }}%), next
    ${{ Helper::inThousand(($product->placement-$range->first_cap_amount)) }}
    -
    ${{ Helper::inRoundTwoDecimal((($range->board_rate/100)*($product->placement-$range->first_cap_amount))) }}
    ({{ $range->board_rate }}%)
    <br/>
    Total =
    ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
    @else
    Total =
    ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
    ({{$product->total_interest}}%)
    @endif
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="ps-product__panel aio-product">
<h4>Total Interest Earned for SGD
${{ Helper::inThousand($product->placement) }}</h4>
<p class="center">
<span class="nill">  ${{ Helper::inRoundTwoDecimal($product->interest_earned).' ( '.$product->total_interest.'%) ' }}</span>
</p>
</div>
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more" href="#">More
Details<i class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only" href="#">More
data<i class="fa fa-angle-down"></i></a></div>
</div>
</div>
<!-- General INDIVIDUAL CRITERIA BASE -->
@elseif($product->formula_id==ALL_IN_ONE_ACCOUNT_F5)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="p-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<?php $firstRange = $productRanges[0]; ?>
<div id='{{$product->product_id}}'>
<div class="ps-table-wrap">
<form id="form-{{$product->product_id}}"
class="ps-form--filter" method="post">
<table class="ps-table ps-table--product ps-table--product-3">
<thead>
<tr>
    <th>CRITERIA</th>
    @if(!empty($firstRange->minimum_spend_1)|| !empty($firstRange->minimum_spend_2))
    <th>SPEND</th>@endif
    @if(!empty($firstRange->minimum_salary))
    <th>SALARY</th>@endif
    @if(!empty($firstRange->minimum_giro_payment))
    <th>PAYMENT</th>@endif
    @if(!empty($firstRange->minimum_privilege_pa))
    <th>PRIVILEGE</th>@endif
    @if(!empty($firstRange->minimum_loan_pa))
    <th>LOAN</th>@endif
    @if(!empty($firstRange->other_minimum_amount1)&& ($firstRange->status_other1 == 1))
    <th class="combine-criteria-padding  @if($product->other_highlight1==true) active @endif">
        <div class="">
            <div class="width-50">
                <div class="ps-checkbox">
                    <input class="form-control"
                    type="checkbox"
                    onchange="changeIndividualCriteria(this);"
                    name="other_interest1"
                    data-product-id="{{$product->product_id}}"
                    value="true"
                    @if($product->other_highlight1==true) checked='checked'
                    @endif
                    id="other-interest1-{{$product->product_id}}">
                    <label for="other-interest1-{{$product->product_id}}">{{$firstRange->other_interest1_name}}</label>
                </div>
            </div>
        </div>
    </th>
    @endif
    @if(!empty($firstRange->other_minimum_amount2)&& ($firstRange->status_other2 == 1))
    <th class="combine-criteria-padding @if($product->other_highlight2==true) active @endif">
        <div class="">
            <div class="width-50">
                <div class="ps-checkbox">
                    <input class="form-control"
                    type="checkbox"
                    onchange="changeIndividualCriteria(this);"
                    name="other_interest2"
                    value="true"
                    @if($product->other_highlight2==true) checked='checked'
                    @endif
                    data-product-id="{{$product->product_id}}"
                    id="other-interest2-{{$product->product_id}}">
                    <label for="other-interest2-{{$product->product_id}}">{{$firstRange->other_interest2_name}}
                    </label>
                </div>
            </div>
        </div>
    </th>
    @endif
</tr>
</thead>
<tbody>
@foreach($productRanges as $range)
<tr>
    <td class="text-left">Bonus Interest PA</td>
    @if(!empty($firstRange->minimum_spend_1)|| !empty($firstRange->minimum_spend_2))
    <td class=" pt-0 pb-0 pl-0 pr-0 text-center @if($product->spend_2_highlight==true || $product->spend_1_highlight==true ) highlight @endif">
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td class=" text-center @if($product->spend_1_highlight==true ) highlight @endif">
                    @if($range->bonus_interest_spend_1<=0)
                    - @else {{ $range->bonus_interest_spend_1 }}
                % @endif</td>
                <td class=" text-center @if($product->spend_2_highlight==true ) highlight @endif">
                    @if($range->bonus_interest_spend_2<=0)
                    - @else {{ $range->bonus_interest_spend_2 }}
                % @endif</td>
            </tr>
        </table>
    </td>
    @endif
    @if(!empty($firstRange->minimum_salary))
    <td class=" text-center
        @if($product->salary_highlight==true ) highlight @endif
        "> @if($range->bonus_interest_salary<=0)
        - @else {{ $range->bonus_interest_salary }}
        % @endif
    </td>
    @endif
    @if(!empty($firstRange->minimum_giro_payment))
    <td class="text-center @if($product->payment_highlight==true ) highlight @endif"> @if($range->bonus_interest_giro_payment<=0)
        - @else {{ $range->bonus_interest_giro_payment }}
        % @endif
    </td>
    @endif
    @if(!empty($firstRange->minimum_privilege_pa))
    <td class="text-center @if($product->privilege_highlight==true ) highlight @endif">
        Up
        to @if($range->bonus_interest_privilege<=0)
        - @else  {{ $range->bonus_interest_privilege }}
        % @endif
    </td>@endif
    @if(!empty($firstRange->minimum_loan_pa))
    <td class="text-center @if($product->loan_highlight==true ) highlight @endif">@if($range->bonus_interest_loan<=0)
        - @else  {{ $range->bonus_interest_loan }}
        % @endif
    </td>@endif
    @if(!empty($firstRange->other_minimum_amount1)&& ($firstRange->status_other1 == 1))
    <td class="text-center @if($product->other_highlight1==true ) highlight @endif">@if($range->other_interest1<=0)
        - @else  {{ $range->other_interest1 }}
        % @endif
    </td>@endif
    @if(!empty($firstRange->other_minimum_amount2)&& ($firstRange->status_other2 == 1))
    <td class="text-center @if($product->other_highlight2==true ) highlight @endif">@if($range->other_interest2<=0)
        - @else  {{ $range->other_interest2 }}
        % @endif
    </td>@endif
</tr>
<tr>
    <td colspan="1" class="text-left">Total Bonus
        Interest Earned for
    ${{Helper::inThousand($range->placement)}}</td>
    <td class="text-center @if($product->highlight==true ) highlight @endif"
        colspan="{{$range->colspan}}">
        @if($range->placement > $range->first_cap_amount)
        First
        ${{ Helper::inThousand($range->first_cap_amount) }}
        -
        ${{ Helper::inRoundTwoDecimal(($range->first_cap_amount*($product->total_interest/100))) }}
        (
        {{ $product->total_interest }}%), remaining
        ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
        -
        ${{ Helper::inRoundTwoDecimal((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
        ({{ $range->bonus_interest_remaining_amount }}
        %) <br/> Total
        =
        ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
        @else
        Total =
        ${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
        ({{$product->total_interest}}%)
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>
</form>
</div>
<?php
$range = $productRanges[0];
?>
<div class="ps-product__panel aio-product">
<h4>Total Bonus Interest Earned for SGD
${{Helper::inThousand($range->placement)}}</h4>
<p class="center">
<span class="nill"> ${{ Helper::inThousand($product->interest_earned) }} </span><br/>
@if($range->placement > $range->first_cap_amount)
First
${{ Helper::inThousand($range->first_cap_amount) }} -
${{ Helper::inRoundTwoDecimal(($range->first_cap_amount*($product->total_interest/100))) }}
(
{{ $product->total_interest }}%), Remaining
${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
-
${{ Helper::inRoundTwoDecimal((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
({{ $range->bonus_interest_remaining_amount }}%) <br/> Total
=
${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
@else
Total =
${{ Helper::inRoundTwoDecimal($product->interest_earned) }}
({{$product->total_interest}}%)
@endif
</p>
</div>
</div>
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more" href="#">More Details<i
class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only"
href="#">More data<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
@elseif(empty($product->formula_id))
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="r-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a
class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times"
aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a
class="ps-product__more"
href="#">More Details<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only"
href="#">More data<i
class="fa fa-angle-down"></i></a>
</div>
</div>
</div>
@endif
@if(count($products)>=2)
@if(!empty($ads_manage) && $ads_manage->page_type==AIO_DEPOSIT_MODE && $j==2)
@include('frontend.includes.product-ads')
@endif
@elseif(empty($remainingProducts->count()) && $j==$products->count())
@if(!empty($ads_manage) && $ads_manage->page_type==AIO_DEPOSIT_MODE)
@include('frontend.includes.product-ads')
@endif
@endif
@php $j++; @endphp
@endforeach
@else
<div class="ps-block--legend-table">
<div class="ps-block__header">
</div>
<div class="ps-block__content text-center">
<p>{{CRITERIA_ERROR}}</p>
</div>
</div>
@endif
@if($remainingProducts->count())
@foreach($remainingProducts as $product)
<?php
$productRanges = $product->product_range;
$ads = json_decode($product->ads_placement);
?>
@if($page->slug==AIO_DEPOSIT_MODE && isset($ads[3]->ad_horizontal_image_popup_top))
<div class="ps-poster-popup">
<a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
alt="">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div></a>
</div>
@endif
<!-- INDIVIDUAL CRITERIA BASE -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F1)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="r-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a
class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<div class="ps-table-wrap">
<table class="ps-table ps-table--product ps-table--product-3">
<thead>
<tr>
<th>CRITERIA</th>
<th>SALARY</th>
<th>PAYMENT</th>
<th>SPEND</th>
<th>PRIVILEGE</th>
<th>BONUS(OPTIONAL)</th>
</tr>
</thead>
<tbody>
@foreach($productRanges as $range)
@php
//dd($range);
@endphp
<tr>
<td>Bonus Interest PA</td>
<td class="text-center @if($product->salary_highlight==true ) highlight @endif"> @if($range->bonus_interest_salary<=0)
- @else {{ $range->bonus_interest_salary }}
% @endif
</td>
<td class="text-center @if($product->payment_highlight==true ) highlight @endif"> @if($range->bonus_interest_giro_payment<=0)
- @else {{ $range->bonus_interest_giro_payment }}
% @endif
</td>
<td class="text-center @if($product->spend_highlight==true ) highlight @endif">
@if($range->bonus_interest_spend<=0)
- @else {{ $range->bonus_interest_spend }}
% @endif
</td>
<td class="text-center @if($product->privilege_highlight==true ) highlight @endif">
Up
to @if($range->bonus_interest_privilege<=0)
- @else  {{ $range->bonus_interest_privilege }}
% @endif
</td>
<td class="text-center @if($product->bonus_highlight==true ) highlight @endif">@if($range->bonus_interest<=0)
- @else  {{ $range->bonus_interest }}
% @endif
on
first
${{ Helper::inThousand($range->first_cap_amount) }}
if
account more
than
${{ Helper::inThousand($range->bonus_amount) }}</td>
</tr>
<tr>
<td colspan="2">Total Bonus Interest Earned for
${{Helper::inThousand($range->placement)}}</td>
<td class="text-center @if($product->highlight==true ) highlight @endif"
colspan="4">
<span class="nill"> {{ NILL }}</span><br/>
<p>{{NOT_ELIGIBLE}}</p>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
<?php
$range = $productRanges[0];
?>
<div class="ps-product__panel aio-product">
<h4>Total Bonus Interest Earned for SGD
${{Helper::inThousand($range->placement)}}</h4>
<span class="nill"> {{ NILL }}</span><br/>
<p class="center">{{NOT_ELIGIBLE}}</p>
</div>
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more"
href="#">More Details<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only"
href="#">More data<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
<!-- TIER BASE -->
@elseif($product->formula_id==ALL_IN_ONE_ACCOUNT_F2)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="r-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a
class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<div class="ps-table-wrap">
<table class="ps-table ps-table--product ps-table--product-2">
<thead>
<tr>
<th>Balance</th>
<th>Criteria a (spend)</th>
<th>Criteria b (Spend + Salary/Giro)</th>
<th>Interest Earned for each Tier</th>
<th>Total Interest Earned
for {{ Helper::inThousand($product->placement) }}</th>
</tr>
</thead>
<tbody>
<?php $prevMaxRange = 0;  $totalRange = 0; ?>
@foreach($productRanges as $key=>$range)
<?php
$totalRange = 0 + ($range->max_range - $prevMaxRange);
if ($key != (count($productRanges) - 1)) {
}
?>
<tr>
<td class=" @if($product->highlight_index>=$key &&($product->criteria_b_highlight==true || $product->criteria_a_highlight==true) ) highlight @endif ">
<?php
if ($key == 0) {
echo "First ";
echo "$" . Helper::inThousand($range->max_range);
} elseif ($key == (count($productRanges) - 1)) {
echo "Above ";
echo "$" . Helper::inThousand(($prevMaxRange));
} else {
echo "Next ";
echo "$" . Helper::inThousand($range->max_range - $prevMaxRange);
} ?>
</td>
<td class="text-center @if($product->highlight_index>=$key &&($product->criteria_a_highlight==true) ) highlight @endif">
@if($range->bonus_interest_criteria_a<=0)
- @else  {{ $range->bonus_interest_criteria_a }}
% @endif
</td>
<td class="text-center @if($product->highlight_index>=$key &&($product->criteria_b_highlight==true) ) highlight @endif  ">
@if($range->bonus_interest_criteria_b<=0)
- @else  {{ $range->bonus_interest_criteria_b }}
% @endif
</td>
<td>
<?php
if ($key == 0) {
echo "First ";
echo "$" . Helper::inThousand($range->max_range);
} elseif ($key == (count($productRanges) - 1)) {
echo "Above ";
echo "$" . Helper::inThousand(($prevMaxRange));
} else {
echo "Next ";
echo "$" . Helper::inThousand($range->max_range - $prevMaxRange);
} if ($key != (count($productRanges) - 1)) {
$prevMaxRange = $range->max_range;
}?>
-${{ Helper::inThousand($range->interest_earn) }}
({{ $range->criteria }}%)
</td>
@if($key==0)
<td class="text-center  @if($product->highlight==true) highlight @endif"
rowspan="{{count($productRanges)}}">
<span class="nill"> {{ NILL }}</span><br/>
<p>{{NOT_ELIGIBLE}}</p>
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
<div class="ps-product__panel aio-product">
<h4>Total Interest Earned for SGD
${{Helper::inThousand($product->placement)}}</h4>
<span class="nill"> {{ NILL }}</span><br/>
<p class="center">{{NOT_ELIGIBLE}}</p>
</div>
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more"
href="#">More Details<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only"
href="#">More data<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
<!-- COMBINE TIER BASE -->
@elseif($product->formula_id==ALL_IN_ONE_ACCOUNT_F3)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="r-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a
class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<h4 class="ps-product__heading"><strong
class="highlight">{{$product->product_name}}
:</strong>
Fulfil up to 3 criteria and earn up
to @if($product->maximum_interest_rate<=0)
- @else  {{ $product->maximum_interest_rate }}
% @endif
</h4>
<div class="ps-table-wrap"
id='{{$product->product_id}}'>
<form id="form-{{$product->product_id}}"
class="ps-form--filter" method="post">
<table class="ps-table ps-table--product ps-table--product-3">
<thead>
<tr>
<th class="combine-criteria-padding" style="width:19%">
CRITERIA
</th>
<th class="combine-criteria-padding" style="width:9%">
SALARY
</th>
<th class="combine-criteria-padding" style="width:9%">
PAYMENT
</th>
<th class="combine-criteria-padding" style="width:9%">
SPEND
</th>
<th class="combine-criteria-padding" style="width:21%">
Loan
<div class="row">
<div class="width-50">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
onchange="" disabled="disabled"
@if($product->housing_loan)
@endif
name="housing_loan"
data-product-id="{{$product->product_id}}"
value="true"
id="housing-loan-{{$product->product_id}}">
<label for="housing-loan-{{$product->product_id}}">Housing</label>
</div>
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
name="education_loan"
onchange="" disabled="disabled"
data-product-id="{{$product->product_id}}"
value="true"
id='education-loan-{{$product->product_id}}'
@if($product->education_loan)  @endif/>
<label for="education-loan-{{$product->product_id}}">Education</label>
</div>
</div>
<div class="width-50">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
onchange="" disabled="disabled"
name="hire_loan" value="true"
data-product-id="{{$product->product_id}}"
id="hire-loan-{{$product->product_id}}"
@if($product->hire_loan)  @endif/>
<label for="hire-loan-{{$product->product_id}}">Hire
</label>
</div>
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
name="renovation_loan"
onchange="" disabled="disabled"
data-product-id="{{$product->product_id}}"
value="true"
id="renovation-loan-{{$product->product_id}}"
@if($product->renovation_loan)  @endif/>
<label for="renovation-loan-{{$product->product_id}}">Renovation
</label>
</div>
</div>
</div>
</th>
<th class="combine-criteria-padding" style="width:21%">
Wealth
<div class="row">
<div class="width-50">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
data-product-id="{{$product->product_id}}"
name="life_insurance"
onchange="" disabled="disabled"
@if($product->life_insurance)
@endif value="true"
id="life-insurance-{{$product->product_id}}"/>
<label for="life-insurance-{{$product->product_id}}">Insurance</label>
</div>
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
onchange="" disabled="disabled"
name="unit_trust" value="true"
data-product-id="{{$product->product_id}}"
id="unit-trust-{{$product->product_id}}"
@if($product->unit_trust)  @endif/>
<label for="unit-trust-{{$product->product_id}}">Unit
</label>
</div>
</div>
</div>
</th>
</tr>
</thead>
<tbody>
@foreach($productRanges as $range)
<tr>
<td>Bonus Interest PA</td>
<td class="text-center @if($product->criteria_1==true ) highlight @endif"
colspan="3">1 Criteria Met
@if($range->bonus_interest_criteria1<=0)
- @else - {{ $range->bonus_interest_criteria1 }}
% @endif
</td>
<td class=" text-center @if($product->criteria_2==true ) highlight @endif"
colspan="1">2 Criteria
@if($range->bonus_interest_criteria2<=0)
- @else - {{ $range->bonus_interest_criteria2 }}
% @endif
</td>
<td class="text-center @if($product->criteria_3==true ) highlight @endif"
colspan="1">3
Criteria  @if($range->bonus_interest_criteria3<=0)
- @else - {{ $range->bonus_interest_criteria3 }}
% @endif
</td>
</tr>
<tr>
<td colspan="1">Total Bonus Interest
Earned for
${{ Helper::inThousand($range->placement) }}</td>
<td class=" text-center @if($product->highlight==true ) highlight @endif"
colspan="5">
<span class="nill"> {{ NILL }}</span><br/>
<p>{{NOT_ELIGIBLE}}</p>
</td>
</td>
</tr>
@endforeach
</tbody>
</table>
</form>
</div>
<div class="ps-product__panel aio-product">
<h4>Total Interest Earned for SGD
${{ Helper::inThousand($product->placement) }}</h4>
<span class="nill"> {{ NILL }}</span><br/>
<p class="center">{{NOT_ELIGIBLE}}</p>
</div>
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times"
aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a
class="ps-product__more" href="#">More
Details<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only" href="#">More
data<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
<!-- DBS CRITERIA -->
@elseif($product->formula_id==ALL_IN_ONE_ACCOUNT_F4)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="r-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a
class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<div class="ps-table-wrap">
<table class="ps-table ps-table--product">
<thead>
<tr>
<th>Monthly Transaction</th>
<th>Criteria a (Salary + 1 category)
</th>
<th>Criteria b (Salary + 2 OR more
Category)
</th>
<th>Total Interest Earned for
${{ Helper::inThousand($product->placement) }}</th>
</tr>
</thead>
<tbody>
@foreach($productRanges as $range)
@endforeach
@foreach($productRanges as $key=>$range)
<tr>
<td class="@if($range->criteria_a_highlight==true || $range->criteria_b_highlight==true ) highlight @endif"
style="width: 30%">@if($key==0)
Less than
${{ Helper::inThousand($range->max_range+1) }}
@elseif((count($productRanges)-1)==$key)
${{ Helper::inThousand($range->min_range) }}
Or Above
@else
${{ Helper::inThousand($range->min_range) }}
TO <
${{ Helper::inThousand($range->max_range+1) }} @endif</td>
<td class="text-center @if($range->criteria_a_highlight==true ) highlight @endif">
@if($range->bonus_interest_criteria_a<=0)
- @else  {{ $range->bonus_interest_criteria_a }}
% @endif
</td>
<td class="text-center @if($range->criteria_b_highlight==true ) highlight @endif">
@if($range->bonus_interest_criteria_b<=0)
- @else  {{ $range->bonus_interest_criteria_b }}
% @endif
</td>
@if($key==0)
<td class=" text-center @if($product->highlight==true ) highlight @endif"
rowspan="6">
<span class="nill"> {{ NILL }}</span><br/>
<p>{{NOT_ELIGIBLE}}</p>
</td>
@endif
</tr>
@endforeach
</tbody>
</table>
</div>
<?php
$range = $productRanges[0];
?>
<div class="ps-product__panel aio-product">
<h4>Total Interest Earned for SGD
${{ Helper::inThousand($product->placement) }}</h4>
<span class="nill"> {{ NILL }}</span><br/>
<p class="center">{{NOT_ELIGIBLE}}</p>
</div>
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times"
aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a
class="ps-product__more" href="#">More
Details<i class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only"
href="#">More
data<i class="fa fa-angle-down"></i></a>
</div>
</div>
</div>
<!-- general INDIVIDUAL CRITERIA BASE -->
@elseif($product->formula_id==ALL_IN_ONE_ACCOUNT_F5)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="r-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a
class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<?php $firstRange = $productRanges[0]; ?>
<div id='{{$product->product_id}}'>
<div class="ps-table-wrap">
<form id="form-{{$product->product_id}}"
class="ps-form--filter" method="post">
<table class="ps-table ps-table--product ps-table--product-3">
<thead>
<tr>
<th>CRITERIA</th>
@if(!empty($firstRange->minimum_spend_1)|| !empty($firstRange->minimum_spend_2))
<th>SPEND</th>@endif
@if(!empty($firstRange->minimum_salary))
<th>SALARY</th>@endif
@if(!empty($firstRange->minimum_giro_payment))
<th>PAYMENT</th>@endif
@if(!empty($firstRange->minimum_privilege_pa))
<th>PRIVILEGE</th>@endif
@if(!empty($firstRange->minimum_loan_pa))
<th>LOAN</th>@endif
@if(!empty($firstRange->other_minimum_amount1)&& ($firstRange->status_other1 == 1))
<th class="combine-criteria-padding  @if($product->other_highlight1==true) active @endif">
<div class="">
<div class="width-50">
<div class="ps-checkbox">
<input class="form-control"
type="checkbox"
onchange="changeIndividualCriteria(this);"
name="other_interest1"
data-product-id="{{$product->product_id}}"
value="true"
@if($product->other_highlight1==true) checked='checked'
@endif
id="other-interest1-{{$product->product_id}}">
<label for="other-interest1-{{$product->product_id}}">{{$firstRange->other_interest1_name}}</label>
</div>
</div>
</div>
</th>
@endif
@if(!empty($firstRange->other_minimum_amount2)&& ($firstRange->status_other2 == 1))
<th class="combine-criteria-padding @if($product->other_highlight2==true) active @endif">
<div class="">
<div class="width-50">
<div class="ps-checkbox">
<input class="form-control"
type="checkbox"
onchange="changeIndividualCriteria(this);"
name="other_interest2"
value="true"
@if($product->other_highlight2==true) checked='checked'
@endif
data-product-id="{{$product->product_id}}"
id="other-interest2-{{$product->product_id}}">
<label for="other-interest2-{{$product->product_id}}">{{$firstRange->other_interest2_name}}
</label>
</div>
</div>
</div>
</th>
@endif
</tr>
</thead>
<tbody>
@foreach($productRanges as $range)
<tr>
<td class="text-left">Bonus Interest PA</td>
@if(!empty($firstRange->minimum_spend_1)|| !empty($firstRange->minimum_spend_2))
<td class=" pt-0 pb-0 pl-0 pr-0 text-center @if($product->spend_2_highlight==true || $product->spend_1_highlight==true ) highlight @endif">
<table cellspacing="0" cellpadding="0">
<tr>
<td class=" text-center  td-unique text-center @if($product->spend_1_highlight==true ) highlight @endif">
@if($range->bonus_interest_spend_1<=0)
- @else {{ $range->bonus_interest_spend_1 }}
% @endif</td>
<td class=" text-center  td-unique text-center @if($product->spend_2_highlight==true ) highlight @endif">
@if($range->bonus_interest_spend_2<=0)
- @else {{ $range->bonus_interest_spend_2 }}
% @endif</td>
</tr>
</table>
</td>
@endif
@if(!empty($firstRange->minimum_salary))
<td class=" text-center  text-center @if($product->salary_highlight==true ) highlight @endif"> @if($range->bonus_interest_salary<=0)
- @else {{ $range->bonus_interest_salary }}
% @endif
</td>@endif
@if(!empty($firstRange->minimum_giro_payment))
<td class=" text-center  text-center @if($product->payment_highlight==true ) highlight @endif"> @if($range->bonus_interest_giro_payment<=0)
- @else {{ $range->bonus_interest_giro_payment }}
% @endif
</td>@endif
@if(!empty($firstRange->minimum_privilege_pa))
<td class=" text-center  text-center @if($product->privilege_highlight==true ) highlight @endif">
Up
to @if($range->bonus_interest_privilege<=0)
- @else  {{ $range->bonus_interest_privilege }}
% @endif
</td>@endif
@if(!empty($firstRange->minimum_loan_pa))
<td class="text-left @if($product->loan_highlight==true ) highlight @endif">@if($range->bonus_interest_loan<=0)
- @else  {{ $range->bonus_interest_loan }}
% @endif
</td>@endif
@if(!empty($firstRange->other_minimum_amount1)&& ($firstRange->status_other1 == 1))
<td class= text-center  "text-left @if($product->other_highlight1==true ) highlight @endif">@if($range->other_interest1<=0)
- @else  {{ $range->other_interest1 }}
% @endif
</td>@endif
@if(!empty($firstRange->other_minimum_amount2)&& ($firstRange->status_other2 == 1))
<td class=" text-center  text-left @if($product->other_highlight2==true ) highlight @endif">@if($range->other_interest2<=0)
- @else  {{ $range->other_interest2 }}
% @endif
</td>@endif
</tr>
<tr>
<td colspan="1">Total Bonus Interest Earned for
${{Helper::inThousand($range->placement)}}</td>
<td class="text-center @if($product->highlight==true ) highlight @endif"
colspan="{{$range->colspan}}">
<span class="nill"> {{ NILL }}</span><br/>
<p>{{NOT_ELIGIBLE}}</p>
</td>
</tr>
@endforeach
</tbody>
</table>
</form>
</div>
<?php
$range = $productRanges[0];
?>
<div class="ps-product__panel aio-product">
<h4>Total Bonus Interest Earned for SGD
${{Helper::inThousand($range->placement)}}</h4>
<span class="nill"> {{ NILL }}</span><br/>
<p class="center">{{NOT_ELIGIBLE}}</p>
</div>
</div>
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more"
href="#">More Details<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only"
href="#">More data<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
@elseif(empty($product->formula_id))
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="r-{{ $j }}">
<div class="ps-product__header"><div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>
@if(!empty($product->apply_link_status))
<div class="ps-product__action"><a
class="ps-btn ps-btn--red"
href="{{$product->apply_link}}">Apply
Now</a></div>@endif
</div>
<div class="ps-product__content">
<h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[0]->ad_image_horizontal)) {
@endphp
<div class="ps-product__poster"><a
href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
alt=""></a></div>
@php } @endphp
@endif
<div class="clearfix"></div>
@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank">
<div class="close-popup">
<i class="fa fa-times"
aria-hidden="true"></i>
</div></a>
</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a
class="ps-product__more"
href="#">More Details<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only"
href="#">More data<i
class="fa fa-angle-down"></i></a>
</div>
</div>
</div>
@endif
@if($products->count()<2 && $remainingProducts->count()>=2)
@if(!empty($ads_manage) && $ads_manage->page_type==AIO_DEPOSIT_MODE && $j==2)
@include('frontend.includes.product-ads')
@endif
@elseif(empty($products->count()) && $j==$remainingProducts->count())
@if(!empty($ads_manage) && $ads_manage->page_type==AIO_DEPOSIT_MODE)
@include('frontend.includes.product-ads')
@endif
@endif
@php $j++; @endphp
@endforeach
@endif
</div>
</div>
<script type="text/javascript">
function changeCriteria(id) {
var product_id = $(id).data('product-id');
var status = $(id).data('status');
var data = $('#search-form').serialize();
var checkBoxForm = $('#form-' + product_id).serialize();
if (checkBoxForm.length == 0) {
alert(" At least one criteria always required!");
$(id).prop("checked", true);
return false;
}
$.ajax({
method: "POST",
url: "{{url('/combine-criteria-filter')}}",
data: {
search_detail: data,
product_id: product_id,
check_box_detail: checkBoxForm,
status: status
},
cache: false,
async: false,
success: function (data) {
$('#' + product_id).html(data);
}
});
}
function changeIndividualCriteria(id) {
var product_id = $(id).data('product-id');
var status = $(id).data('status');
var data = $('#search-form').serialize();
var checkBoxForm = $('#form-' + product_id).serialize();
$.ajax({
method: "POST",
url: "{{url('/general-individual-criteria-filter')}}",
data: {
search_detail: data,
product_id: product_id,
check_box_detail: checkBoxForm,
status: status
},
cache: false,
async: false,
success: function (data) {
$('#' + product_id).html(data);
}
});
}
</script>
{{--Page content end--}}
{{--contact us or what we offer section start--}}
@if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
{!! $systemSetting->{$page->contact_or_offer} !!}
@endif
{{--contact us or what we offer section end--}}
@endsection