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
<div class="ps-page--deposit">

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
<div class="container" id="logo-detail">
<div class="ps-block--deposit-filter ">
<div class="ps-block__content">
<form id="search-form" class="ps-form--filter"
action="{{ URL::route('aioa-deposit-mode.search') }}#logo-detail"
method="post">

<h4>Fill in your need</h4>

<div class="ps-form__values">
<div class="form-group--label">
<div class="form-group__content">
<label>Salary</label>
<input class="form-control" type="text" placeholder="" name="salary" id="salary"
value="{{ isset($searchFilter['salary']) ? $searchFilter['salary'] : '' }}">
</div>
@if(isset($toolTips->salary))
<a class="ps-tooltip" href="javascript:void(0)"
data-tooltip="{{$toolTips->salary}}"><i
class="fa fa-exclamation-circle"></i></a>
@endif
</div>
<div class="form-group--label">
<div class="form-group__content">
<label>Payment</label>
<input class="form-control" type="text" placeholder="" name="giro" id="giro"
value="{{ isset($searchFilter['giro']) ? $searchFilter['giro'] : '' }}">
</div>
@if(isset($toolTips->payment))
<a class="ps-tooltip" href="javascript:void(0)"
data-tooltip="{{$toolTips->payment}}"><i
class="fa fa-exclamation-circle"></i></a>
@endif
</div>
<div class="form-group--label">
<div class="form-group__content">
<label>Spending</label>
<input class="form-control" type="text" placeholder="" name="spend" id='spend'
value="{{ isset($searchFilter['spend']) ? $searchFilter['spend'] : '' }}">
</div>
@if(isset($toolTips->spend))
<a class="ps-tooltip" href="javascript:void(0)" data-tooltip="{{$toolTips->spend}}"><i
class="fa fa-exclamation-circle"></i></a>
@endif
</div>
<div class="form-group--label">
<div class="form-group__content">
<label>Privilege</label>
<input class="form-control" type="text" placeholder="" name="privilege"
id='privilege'
value="{{ isset($searchFilter['privilege']) ? $searchFilter['privilege'] : '' }}">
</div>
@if(isset($toolTips->privilege))
<a class="ps-tooltip" href="javascript:void(0)"
data-tooltip="{{$toolTips->privilege}}"><i
class="fa fa-exclamation-circle"></i></a>
@endif
</div>
<div class="form-group--label">
<div class="form-group__content">
<label>Loan</label>
<input class="form-control" type="text" placeholder="" name="loan" id="loan"
value="{{ isset($searchFilter['loan']) ? $searchFilter['loan'] : '' }}">
</div>
@if(isset($toolTips->loan))
<a class="ps-tooltip" href="javascript:void(0)"
data-tooltip="{{$toolTips->loan}}"><i
class="fa fa-exclamation-circle"></i></a>
@endif
</div>
</div>
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
<div class="ps-form__option">
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
<option value="">Sort by</option>
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
<a class="btn refresh form-control " style="width: 73px;"
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
<div class="product-row-01 clearfix slider-class">
@php $i = 1;$featured = []; @endphp
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight" data-mh="product"><img
src="{{ asset($product->brand_logo) }}" alt="">
@if(isset($searchFilter['filter']))
<h4 class="slider-heading">
@if($searchFilter['filter']==INTEREST)
up to <strong> {{ $product->maximum_interest_rate }}%</strong>
@endif
@if($searchFilter['filter']==PLACEMENT)
Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
@endif
@if($searchFilter['filter']==TENURE)
@if($product->promotion_end == null)
<strong>{{ONGOING}}</strong>
@else
<strong> {{ $product->promotion_period }}</strong> {{\Helper::days_or_month_or_year(2,  $product->promotion_period)}}
@endif

@endif
@if($searchFilter['filter']==CRITERIA)
up to <strong> {{ $product->promotion_period }} Criteria</strong>
@endif
</h4>
@endif
<div class="ps-block__info">
<p class=" @if($searchFilter['filter']==INTEREST) highlight highlight-bg @endif">
<strong>
rate: </strong>{{ $product->maximum_interest_rate }}%</p>

<p class="@if($searchFilter['filter']==PLACEMENT) highlight highlight-bg @endif">
<strong>Min:</strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

<p class="@if($searchFilter['filter']==CRITERIA) highlight highlight-bg @endif">{{ $product->promotion_period }} {{CRITERIA}}</p>
</div>
<a class="ps-btn" href="#{{ $i }}">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
@php $i = 1;$featured_item = 5-count($featured);
$featured_count = count($featured);
$featured_width = 12;
if($featured_count==1) {
$featured_width = 2;
}
elseif($featured_count==2) {
$featured_width = 3;
}
elseif($featured_count==3) {
$featured_width = 4;
}
@endphp
<div class="product-col-0{{ $featured_width }}">
<div class="ps-slider--feature-product saving nav-outside owl-slider" data-owl-auto="true"
data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true"
data-owl-dots="false" data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="1" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000" data-owl-mousedrag="on"
data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;"
data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
@php $i = 1; @endphp
@foreach($products as $product)
@if($product->featured==0)
<div class="ps-block--short-product second" data-mh="product"><img
src="{{ asset($product->brand_logo) }}" alt="">
@if(isset($searchFilter['filter']))
<h4 class="slider-heading">
@if($searchFilter['filter']==INTEREST)
up to <strong> {{ $product->maximum_interest_rate }}%</strong>
@endif
@if($searchFilter['filter']==PLACEMENT)
Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
@endif
@if($searchFilter['filter']==TENURE)
@if($product->promotion_end == null)
<strong>{{ONGOING}}</strong>
@else
<strong> {{ $product->promotion_period }}</strong> {{\Helper::days_or_month_or_year(2,  $product->promotion_period)}}
@endif

@endif
@if($searchFilter['filter']==CRITERIA)
up to <strong> {{ $product->promotion_period }} Criteria</strong>
@endif
</h4>
@endif

<div class="ps-block__info">
<p class=" @if($searchFilter['filter']==INTEREST) highlight highlight-bg @endif">
<strong>
rate: </strong>{{ $product->maximum_interest_rate }}%</p>

<p class=" @if($searchFilter['filter']==PLACEMENT) highlight highlight-bg @endif">
<strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

<p class="@if($searchFilter['filter']==CRITERIA) highlight highlight-bg @endif">{{ $product->promotion_period }} {{CRITERIA}}</p>
</div>
<a class="ps-btn" href="#{{ (count($featured)+$i) }}">More info</a>
</div>
@php $i++; @endphp
@endif
@endforeach
</div>
</div>
</div>
@endif
@if(count($legendtable))
<div class="ps-block--legend-table">
<div class="ps-block__header">
<h3>Legend table</h3>
</div>
<div class="ps-block__content">
@foreach($legendtable as $legend)
@if($legend->page_type=='Fixed Deposit')
<p><img src="{{ asset($legend->icon) }}" alt="">{{ $legend->title }}</p>
@endif
@if($legend->page_type==ALL_IN_ONE_ACCOUNT)
<p><img src="{{ asset($legend->icon) }}" alt=""> = {{ $legend->title }}</p>
@endif
@endforeach
</div>
</div>
@endif

<?php
$adspopup = json_decode($page->ads_placement);
//dd($ads);
$j = 1;
?>

@if(count($products))

@foreach($products as $product)
<?php
$productRanges = $product->product_range;
$ads = $product->ads_placement;
/*echo 'Interest: ' . $product->maximum_interest_rate . '<br/>';
echo 'Placement: ' . $product->minimum_placement_amount . '<br/>';
echo 'Tenure: ' . $product->max_tenure . '<br/>'; */
//dd($products);
?>
@if($page->slug==AIO_DEPOSIT_MODE && isset($ads[3]->ad_horizontal_image_popup_top))

<div class="ps-poster-popup">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div>
<a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
alt=""></a>
</div>
@endif
<!-- INDIVIDUAL CRITERIA BASE -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F1)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img src="{{ asset($product->brand_logo) }}"
alt="">
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
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only" href="#">More info<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
@endif

<!-- TIER BASE -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F2)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img
src="{{ asset($product->brand_logo) }}" alt="">
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
<th class="text-left">Criteria a <br/><span
class="subtitle">(spend)</span></th>
<th class="text-left">Criteria b <br/><span class="subtitle">(Spend + Salary/Giro)</span>
</th>
<th class="text-left">Interest Earned for each Tier</th>
<th class="text-left">Total Interest Earned
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
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only" href="#">More info<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
@endif
<!-- COMBINE TIER BASE -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F3)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img
src="{{ asset($product->brand_logo) }}"
alt="">

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

<div class="ps-table-wrap" id='{{$product->product_id}}'>
<form id="form-{{$product->product_id}}"
class="ps-form--filter" method="post">
<table class="ps-table ps-table--product ps-table--product-3">
<thead>
<tr>
<th class="combine-criteria-padding">CRITERIA</th>
<th class="combine-criteria-padding">SALARY</th>
<th class="combine-criteria-padding">Giro</th>
<th class="combine-criteria-padding">SPEND</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
data-product-id="{{$product->product_id}}"
name="life_insurance"
onchange="changeCriteria(this);"
@if($product->life_insurance) checked=checked
@endif value="true"
id="life-insurance-{{$product->product_id}}"/>
<label for="life-insurance-{{$product->product_id}}">Life
Insurance</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
onchange="changeCriteria(this);"
@if($product->housing_loan) checked=checked
@endif
name="housing_loan"
data-product-id="{{$product->product_id}}"
value="true"
id="housing-loan-{{$product->product_id}}">
<label for="housing-loan-{{$product->product_id}}">Housing
Loan</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
name="education_loan"
onchange="changeCriteria(this);"
data-product-id="{{$product->product_id}}"
value="true"
id='education-loan-{{$product->product_id}}'
@if($product->education_loan) checked=checked @endif/>
<label for="education-loan-{{$product->product_id}}">Education
Loan</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
onchange="changeCriteria(this);"
name="hire_loan" value="true"
data-product-id="{{$product->product_id}}"
id="hire-loan-{{$product->product_id}}"
@if($product->hire_loan) checked=checked @endif/>
<label for="hire-loan-{{$product->product_id}}">Hire
Purchase loan</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
name="renovation_loan"
onchange="changeCriteria(this);"
data-product-id="{{$product->product_id}}"
value="true"
id="renovation-loan-{{$product->product_id}}"
@if($product->renovation_loan) checked=checked @endif/>
<label for="renovation-loan-{{$product->product_id}}">Renovation
loan</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control" type="checkbox"
onchange="changeCriteria(this);"
name="unit_trust" value="true"
data-product-id="{{$product->product_id}}"
id="unit-trust-{{$product->product_id}}"
@if($product->unit_trust) checked=checked @endif/>
<label for="unit-trust-{{$product->product_id}}">Unit
Trust</label>
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
- @if($range->bonus_interest_criteria1<=0)
- @else  {{ $range->bonus_interest_criteria1 }}
% @endif
</td>
<td class=" text-center @if($product->criteria_2==true ) highlight @endif"
colspan="3">2 Criteria
- @if($range->bonus_interest_criteria2<=0)
- @else  {{ $range->bonus_interest_criteria2 }}
% @endif
</td>
<td class="text-center @if($product->criteria_3==true ) highlight @endif"
colspan="3">3
Criteria @if($range->bonus_interest_criteria3<=0)
- @else  {{ $range->bonus_interest_criteria3 }}
% @endif
</td>
</tr>
<tr>
<td colspan="1" class="text-left">Total Bonus Interest
Earned for
${{ Helper::inThousand($range->placement) }}</td>
<td class=" text-center @if($product->highlight==true ) highlight @endif"
colspan="9">

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
<div class="clearfix"></div>

@if(!empty($product->ads_placement))
@php
$ads = json_decode($product->ads_placement);
if(!empty($ads[2]->ad_horizontal_image_popup)) {
@endphp
<div class="ps-poster-popup">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more" href="#">More
Detail<i
class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only" href="#">More
info<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
@endif
<!-- DBS CRITERIA -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F4)

<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img
src="{{ asset($product->brand_logo) }}"
alt="">

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
<th>Criteria A <br/><span class="subtitle">(Salary + 2 OR more Cateogry)</span>
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
${{ Helper::inThousand($range->min_range) }} TO
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
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more" href="#">More
Detail<i class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only" href="#">More
info<i class="fa fa-angle-down"></i></a></div>
</div>
</div>
@endif
@if(count($products)>=2)
@if(count($ads_manage) && $ads_manage[0]->page_type==AIO_DEPOSIT_MODE && $j==2)
<div class="ps-poster-popup">
<!-- <div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div> -->
@php
$current_time = strtotime(date('Y-m-d', strtotime('now'))); 
$ad_start_date = strtotime($ads_manage[0]->ad_start_date);
$ad_end_date = strtotime($ads_manage[0]->ad_end_date);
@endphp
@if($current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads_manage[0]->paid_ad_image))
    <a href="{{ isset($ads_manage[0]->paid_ad_link) ? $ads_manage[0]->paid_ad_link : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads_manage[0]->paid_ad_image) ? asset($ads_manage[0]->paid_ad_image) : '' }}"
alt=""></a>
@else
<a href="{{ isset($ads_manage[0]->ad_link) ? $ads_manage[0]->ad_link : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads_manage[0]->ad_image) ? asset($ads_manage[0]->ad_image) : '' }}"
alt=""></a>
@endif
</div>
@endif
@elseif(empty($remainingProducts->count()) && $j==$products->count())
@if(count($ads_manage) && $ads_manage[0]->page_type==AIO_DEPOSIT_MODE)
<div class="ps-poster-popup">
<!-- <div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div> -->
@php
$current_time = strtotime(date('Y-m-d', strtotime('now'))); 
$ad_start_date = strtotime($ads_manage[0]->ad_start_date);
$ad_end_date = strtotime($ads_manage[0]->ad_end_date);
@endphp
@if($current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads_manage[0]->paid_ad_image))
    <a href="{{ isset($ads_manage[0]->paid_ad_link) ? $ads_manage[0]->paid_ad_link : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads_manage[0]->paid_ad_image) ? asset($ads_manage[0]->paid_ad_image) : '' }}"
alt=""></a>
@else
<a href="{{ isset($ads_manage[0]->ad_link) ? $ads_manage[0]->ad_link : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads_manage[0]->ad_image) ? asset($ads_manage[0]->ad_image) : '' }}"
alt=""></a>
@endif
</div>
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
$ads = $product->ads_placement;

?>
@if($page->slug==AIO_DEPOSIT_MODE && isset($ads[3]->ad_horizontal_image_popup_top))

<div class="ps-poster-popup">
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div>
<a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
alt=""></a>
</div>
@endif
<!-- INDIVIDUAL CRITERIA BASE -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F1)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img
src="{{ asset($product->brand_logo) }}"
alt="">

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
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more"
href="#">More Detail<i
class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only"
href="#">More info<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
@endif

<!-- TIER BASE -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F2)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img
src="{{ asset($product->brand_logo) }}" alt="">

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
<div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a class="ps-product__more"
href="#">More Detail<i
class="fa fa-angle-down"></i></a><a class="ps-product__info sp-only"
href="#">More info<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
@endif
<!-- COMBINE TIER BASE -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F3)
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img
src="{{ asset($product->brand_logo) }}"
alt="">

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
<th class="combine-criteria-padding">
CRITERIA
</th>
<th class="combine-criteria-padding">
SALARY
</th>
<th class="combine-criteria-padding">
Giro
</th>
<th class="combine-criteria-padding">
SPEND
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control"
type="checkbox"
data-product-id="{{$product->product_id}}"
name="life_insurance"
data-status="0"
onchange="changeCriteria(this);"
@if($product->life_insurance) checked=checked
@endif value="true"
id="life-insurance-{{$product->product_id}}"/>
<label for="life-insurance-{{$product->product_id}}">Life
Insurance</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control"
type="checkbox"
onchange="changeCriteria(this);"
@if($product->housing_loan) checked=checked
@endif
name="housing_loan"
data-product-id="{{$product->product_id}}"
value="true"
data-status="0"
id="housing-loan-{{$product->product_id}}">
<label for="housing-loan-{{$product->product_id}}">Housing
Loan</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control"
type="checkbox"
name="education_loan"
onchange="changeCriteria(this);"
data-product-id="{{$product->product_id}}"
value="true"
data-status="0"
id='education-loan-{{$product->product_id}}'
@if($product->education_loan) checked=checked @endif/>
<label for="education-loan-{{$product->product_id}}">Education
Loan</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control"
type="checkbox"
onchange="changeCriteria(this);"
name="hire_loan"
value="true"
data-status="0"
data-product-id="{{$product->product_id}}"
id="hire-loan-{{$product->product_id}}"
@if($product->hire_loan) checked=checked @endif/>
<label for="hire-loan-{{$product->product_id}}">Hire
Purchase loan</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control"
type="checkbox"
name="renovation_loan"
onchange="changeCriteria(this);"
data-product-id="{{$product->product_id}}"
value="true"
data-status="0"
id="renovation-loan-{{$product->product_id}}"
@if($product->renovation_loan) checked=checked @endif/>
<label for="renovation-loan-{{$product->product_id}}">Renovation
loan</label>
</div>
</th>
<th class="combine-criteria-padding">
<div class="ps-checkbox">
<input class="form-control"
type="checkbox"
onchange="changeCriteria(this);"
name="unit_trust"
value="true"
data-status="0"
data-product-id="{{$product->product_id}}"
id="unit-trust-{{$product->product_id}}"
@if($product->unit_trust) checked=checked @endif/>
<label for="unit-trust-{{$product->product_id}}">Unit
Trust</label>
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
- @if($range->bonus_interest_criteria1<=0)
- @else  {{ $range->bonus_interest_criteria1 }}
% @endif
</td>
<td class=" text-center @if($product->criteria_2==true ) highlight @endif"
colspan="3">2 Criteria
- @if($range->bonus_interest_criteria2<=0)
- @else  {{ $range->bonus_interest_criteria2 }}
% @endif
</td>
<td class="text-center @if($product->criteria_3==true ) highlight @endif"
colspan="3">3
Criteria @if($range->bonus_interest_criteria3<=0)
- @else  {{ $range->bonus_interest_criteria3 }}
% @endif
</td>
</tr>
<tr>
<td colspan="1">Total Bonus Interest
Earned for
${{ Helper::inThousand($range->placement) }}</td>
<td class=" text-center @if($product->highlight==true ) highlight @endif"
colspan="9">

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
<div class="close-popup">
<i class="fa fa-times"
aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a
class="ps-product__more" href="#">More
Detail<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only" href="#">More
info<i
class="fa fa-angle-down"></i></a></div>
</div>
</div>
@endif
<!-- DBS CRITERIA -->
@if($product->formula_id==ALL_IN_ONE_ACCOUNT_F4)

<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img
src="{{ asset($product->brand_logo) }}"
alt="">

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
Cateogry)
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
TO
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
<div class="close-popup">
<i class="fa fa-times"
aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a
class="ps-product__more" href="#">More
Detail<i class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only" href="#">More
info<i class="fa fa-angle-down"></i></a>
</div>
</div>
</div>
@endif
@if(empty($product->formula_id))
<div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
id="{{ $j }}">
<div class="ps-product__header"><img
src="{{ asset($product->brand_logo) }}"
alt="">

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
<div class="close-popup">
<i class="fa fa-times"
aria-hidden="true"></i>
</div>

<a target="_blank"
href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
alt="" target="_blank"></a>

</div>
@php } @endphp
@endif
<div class="ps-product__detail">
{!! $product->product_footer !!}
</div>
<div class="ps-product__footer"><a
class="ps-product__more"
href="#">More Detail<i
class="fa fa-angle-down"></i></a><a
class="ps-product__info sp-only"
href="#">More info<i
class="fa fa-angle-down"></i></a>
</div>
</div>
</div>
@endif
@if($products->count()<2 && $remainingProducts->count()>=2)
@if(count($ads_manage) && $ads_manage[0]->page_type==AIO_DEPOSIT_MODE && $j==2)
<div class="ps-poster-popup">
<!-- <div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div> -->
@php

$current_time = strtotime(date('Y-m-d', strtotime('now'))); 
$ad_start_date = strtotime($ads_manage[0]->ad_start_date);
$ad_end_date = strtotime($ads_manage[0]->ad_end_date);
@endphp
@if($current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads_manage[0]->paid_ad_image))
    <a href="{{ isset($ads_manage[0]->paid_ad_link) ? $ads_manage[0]->paid_ad_link : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads_manage[0]->paid_ad_image) ? asset($ads_manage[0]->paid_ad_image) : '' }}"
alt=""></a>
@else
<a href="{{ isset($ads_manage[0]->ad_link) ? $ads_manage[0]->ad_link : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads_manage[0]->ad_image) ? asset($ads_manage[0]->ad_image) : '' }}"
alt=""></a>
@endif

</div>
@endif
@elseif(empty($products->count()) && $j==$remainingProducts->count())
@if(count($ads_manage) && $ads_manage[0]->page_type==AIO_DEPOSIT_MODE)
<div class="ps-poster-popup">
<!-- <div class="close-popup">
<i class="fa fa-times" aria-hidden="true"></i>
</div> -->
@php

$current_time = strtotime(date('Y-m-d', strtotime('now'))); 
$ad_start_date = strtotime($ads_manage[0]->ad_start_date);
$ad_end_date = strtotime($ads_manage[0]->ad_end_date);
@endphp
@if($current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads_manage[0]->paid_ad_image))
    <a href="{{ isset($ads_manage[0]->paid_ad_link) ? $ads_manage[0]->paid_ad_link : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads_manage[0]->paid_ad_image) ? asset($ads_manage[0]->paid_ad_image) : '' }}"
alt=""></a>
@else
<a href="{{ isset($ads_manage[0]->ad_link) ? $ads_manage[0]->ad_link : 'javascript:void(0)' }}"
target="_blank"><img
src="{{ isset($ads_manage[0]->ad_image) ? asset($ads_manage[0]->ad_image) : '' }}"
alt=""></a>
@endif
</div>
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
//console.log(data);
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
console.log(data);
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
