@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
<?php
$slug = HOME_SLUG;
//get banners
$banners = \Helper::getBanners($slug);
$datetime = Helper::todayDate();
?>
{{--Banner section start--}}

@if($banners->count()>1)
<div class="ps-home-banner">
<div class="ps-slider--home owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1"
data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000"
data-owl-mousedrag="on" data-owl-animated="false" data-owl-hoverpause="true">
@foreach($banners as $banner)
@if($banner->display==1 && strtotime(date('Y-m-d', strtotime('now')))<=strtotime(date('Y-m-d', strtotime($banner->banner_expiry))) && strtotime(date('Y-m-d', strtotime('now')))>=strtotime(date('Y-m-d', strtotime($banner->banner_start_date))))
<a href="{{ $banner->banner_link }}" target="_blank">
<div class="ps-banner bg--cover" data-background="{{asset($banner->banner_image )}}"><img
src="{{asset($banner->banner_image )}}" alt="">

<div class="ps-banner__content">
{!! $banner->banner_content !!}
</div>
</div>
</a>
@else
<a href="{{ $banner->fixed_banner_link }}" target="_blank">
<div class="ps-banner bg--cover" data-background="{{asset($banner->fixed_banner )}}"><img
src="{{asset($banner->fixed_banner )}}" alt="">
</div>
</a>
@endif
@endforeach
</div>
</div>
@elseif($banners->count()== 1)
@foreach($banners as $banner)
<div class="ps-hero bg--cover" data-background="{{asset($banner->fixed_banner )}}"><img
src="{{asset($banner->fixed_banner )}}" alt=""></div>
@endforeach
@endif

{{--Banner section end--}}

<div class="ps-home--links">
<div class="container">
<?php $i = 1; ?>
@if($banners->count()>1)
@foreach($banners as $banner)
<a href="javascript:clickSliderhome({{$i}})">
<div class="ps-block--home-link" data-mh="home-link">
{{ $banner->title }}
<p>{{ $banner->description }}</p>
</div>
</a>
<?php $i++; ?>
@endforeach
@endif
</div>
</div>

<div class="ps-home-search">
<div class="ps-section__content" data-mh="home-search"><span>Need something?</span>
<h4>Search Products</h4>
</div>
<form class="ps-form--search" action="{{ route('product-search') }}" method="POST" data-mh="home-search">
<div class="form-group">
<select class="form-control" name="account_type" required="required">
<option value="">Select account Type</option>
<option value="1">Fixed Deposit</option>
<option value="2">Saving Deposit</option>
<option value="3">Privilege Deposit</option>
<option value="4">Foreign Currency</option>
<option value="5">All In One Account</option>
</select>
</div>
<div class="form-group">
<input class="form-control prefix_dollar" type="text" name="search_value" placeholder="Enter Placement"
value="100000" required>
<!-- <span class="suffix_k">K</span> -->
</div>
<div class="form-group submit">
<button type="submit" class="ps-btn">Search Now<i class="fa fa-search"></i></button>
</div>
</form>
</div>

{{--Brand section start--}}

@if($brands->count())

<div class="ps-home--partners">
<div class="container">

<div class="nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="8" data-owl-item-xs="3"
data-owl-item-sm="4" data-owl-item-md="6" data-owl-item-lg="8" data-owl-duration="1000"
data-owl-mousedrag="on">
@foreach($brands as $brand)
<a href="{{!empty($brand->brand_link) ? $brand->brand_link : 'javascript:void(0)'}}" target="_blank"
class="active"><img
src="{{ asset($brand->brand_logo) }}" style="padding:19px;" alt=""></a>
@endforeach

</div>
</div>
</div>
@endif
{{--Brand section end--}}

<input type="hidden" name="deposit_type" value="Fixed Deposit">
<div class="ps-home-fixed-deposit ps-tabs-root">
<div class="ps-section__header">
<div class="container">
<ul class="ps-tab-list">
<li class="current"><a href="#tab-1">Fixed Deposit</a></li>
<li><a href="#tab-2">Saving Deposit</a></li>
<li><a href="#tab-3">Privilege Deposit</a></li>
<li><a href="#tab-5">Foreign Currency</a></li>
<li><a href="#tab-4">All In One Account</a></li>

</ul>
</div>
</div>
<div class="ps-section__content bg--cover" data-background="img/bg/home-bg.jpg">
<div class="container">
<div class="ps-tabs">
<div class="ps-tab active" id="tab-1">
<div class="ps-block--desposit">
<div class="ps-block__header">
<h3><strong>Fixed Deposit</strong></h3>

<div class="ps-block__actions">
<ul class="catListing clearfix">
<li id="catList1" class="selected"><a class="aboutpage"
target="showContent-container-1"
id="showContent-1">Interest</a></li>
<li id="catList2" class=""><a class="aboutpage" target="showContent-container-2"
id="showContent-2">Placement</a></li>
<li id="catList3" class=""><a class="aboutpage" target="showContent-container-3"
id="showContent-3">tenure</a></li>
</ul>
</div>
</div>
<div class="productGridContainer target-content" id="showContent-container-1">
<div class="product-row-01 clearfix">
<?php

$products = \Helper::getHomeProducts(FIX_DEPOSIT,'maximum_interest_rate');
$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
<?php $featured[] = $i; ?>
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading">
<strong>up to <span class="highlight">{{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url('fixed-deposit-mode'); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">
@foreach ($products as $product)
@if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url('fixed-deposit-mode'); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-2"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(FIX_DEPOSIT,'minimum_placement_amount');
$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"> Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url('fixed-deposit-mode'); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"> Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url('fixed-deposit-mode'); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-3"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(FIX_DEPOSIT,'promotion_period');


$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading">

@if($product->max_tenure > 0)
<strong> {{ $product->max_tenure }}</strong> @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
@else
<strong> {{$product->promotion_period}}</strong>
@endif

</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p class=" highlight highlight-bg ">
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p class="highlight highlight-bg">{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url('fixed-deposit-mode'); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"> @if($product->promotion_end == null)
<strong>{{ONGOING}}</strong>
@else
<strong> {{ $product->promotion_period }}</strong> {{\Helper::days_or_month_or_year(2,  $product->promotion_period)}}
@endif
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p class=" highlight highlight-bg ">
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p class=" highlight highlight-bg ">{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url('fixed-deposit-mode'); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>
<div class="ps-tab" id="tab-2">
<div class="ps-block--desposit">
<div class="ps-block__header">
<h3><strong>Saving Deposit</strong></h3>

<div class="ps-block__actions">
<ul class="catListing clearfix">
<li id="catList4" class="selected"><a class="aboutpage"
target="showContent-container-4"
id="showContent-4">Interest</a></li>
<li id="catList5" class=""><a class="aboutpage" target="showContent-container-5"
id="showContent-5">Placement</a></li>
<li id="catList6" class=""><a class="aboutpage" target="showContent-container-6"
id="showContent-6">tenure</a></li>
</ul>
</div>
</div>
<div class="productGridContainer target-content" id="showContent-container-4">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(SAVING_DEPOSIT,'maximum_interest_rate');


$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i;  @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">
@foreach ($products as $product)
@if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-5"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(SAVING_DEPOSIT,'minimum_placement_amount');


$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"> Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"> Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-6"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(SAVING_DEPOSIT,'promotion_period');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading">

@if($product->max_tenure > 0)
<strong> {{ $product->max_tenure }}</strong> @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
@else
<strong> {{$product->promotion_period}}</strong>
@endif

</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p class=" highlight highlight-bg ">
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p class=" highlight highlight-bg ">{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"> @if($product->promotion_end == null)
<strong>{{ONGOING}}</strong>
@else
<strong> {{ $product->promotion_period }}</strong> {{\Helper::days_or_month_or_year(2,  $product->promotion_period)}}
@endif
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p class=" highlight highlight-bg ">
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p class=" highlight highlight-bg ">{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>
<div class="ps-tab" id="tab-3">
<div class="ps-block--desposit">
<div class="ps-block__header">
<h3><strong>Privilege Deposit</strong></h3>

<div class="ps-block__actions">
<ul class="catListing clearfix">
<li id="catList7" class="selected"><a class="aboutpage"
target="showContent-container-7"
id="showContent-7">Interest</a></li>
<li id="catList8" class=""><a class="aboutpage" target="showContent-container-8"
id="showContent-8">Placement</a></li>
<li id="catList9" class=""><a class="aboutpage" target="showContent-container-9"
id="showContent-9">tenure</a></li>
</ul>
</div>
</div>
<div class="productGridContainer target-content" id="showContent-container-7">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT,'maximum_interest_rate');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i;  @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">
@foreach ($products as $product)
@if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-8"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT,'minimum_placement_amount');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"> Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"> Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-9"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT,'promotion_period');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading">

@if($product->max_tenure > 0)
<strong> {{ $product->max_tenure }}</strong> @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
@else
<strong> {{$product->promotion_period}}</strong>
@endif

</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p class=" highlight highlight-bg ">
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p class=" highlight highlight-bg ">{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"> @if($product->promotion_end == null)
<strong>{{ONGOING}}</strong>
@else
<strong> {{ $product->promotion_period }}</strong> {{\Helper::days_or_month_or_year(2,  $product->promotion_period)}}
@endif
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p class=" highlight highlight-bg ">
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p class=" highlight highlight-bg ">{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>

<div class="ps-tab" id="tab-4">
<div class="ps-block--desposit">
<div class="ps-block__header">
<h3><strong>All in One Deposit</strong></h3>

<div class="ps-block__actions">
<ul class="catListing clearfix">
<li id="catList10" class="selected"><a class="aboutpage"
target="showContent-container-10"
id="showContent-10">Interest</a></li>
<li id="catList11" class=""><a class="aboutpage"
target="showContent-container-11"
id="showContent-11">Placement</a></li>
<li id="catList12" class=""><a class="aboutpage"
target="showContent-container-12"
id="showContent-12">Criteria</a></li>
</ul>
</div>
</div>
<div class="productGridContainer target-content" id="showContent-container-10">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT,'maximum_interest_rate');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i;  @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

<p>{{ $product->promotion_period }}
{{CRITERIA}}</p>
</div>
<a class="ps-btn"
href="<?php echo url(AIO_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">
@foreach ($products as $product)
@if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

<p><?php echo $product->promotion_period; ?>
{{CRITERIA}}</p>
</div>
<a class="ps-btn"
href="<?php echo url(AIO_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-11"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT,'minimum_placement_amount');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"> Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

<p>{{ $product->promotion_period }}
{{CRITERIA}}</p>
</div>
<a class="ps-btn"
href="<?php echo url(AIO_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"> Min: <strong>
SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

<p><?php echo $product->promotion_period; ?>
{{CRITERIA}}</p>
</div>
<a class="ps-btn"
href="<?php echo url(AIO_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-12"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT,'promotion_period');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading">
<strong>up to <span class="highlight"> {{ $product->promotion_period }} Criteria</span></strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

<p class="highlight highlight-bg">{{ $product->promotion_period }}
{{CRITERIA}}</p>
</div>
<a class="ps-btn"
href="<?php echo url(AIO_DEPOSIT_MODE); ?>">More info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading">
<strong>up to <span class="highlight"> {{ $product->promotion_period }} Criteria</span></strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> SGD
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

<p class="highlight highlight-bg"><?php echo $product->promotion_period; ?>
{{CRITERIA}}</p>
</div>
<a class="ps-btn"
href="<?php echo url(AIO_DEPOSIT_MODE); ?>">More info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>

<div class="ps-tab" id="tab-5">
<div class="ps-block--desposit">
<div class="ps-block__header">
<h3><strong>Foreign Currency Deposit</strong></h3>

<div class="ps-block__actions">
<ul class="catListing clearfix">
<li id="catList13" class="selected"><a class="aboutpage"
target="showContent-container-13"
id="showContent-13">Interest</a></li>
<li id="catList14" class=""><a class="aboutpage"
target="showContent-container-14"
id="showContent-14">Placement</a></li>
<li id="catList15" class=""><a class="aboutpage"
target="showContent-container-15"
id="showContent-15">tenure</a></li>
</ul>
</div>
</div>
<div class="productGridContainer target-content" id="showContent-container-13">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT,'maximum_interest_rate');


$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i;  @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> {{$product->currency_code}}
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">More
info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">
@foreach ($products as $product)
@if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"><strong>up to <span class="highlight"> {{ $product->maximum_interest_rate  }}
%</span></strong>
</h4>

<div class="ps-block__info">
<p class="highlight highlight-bg"><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> {{$product->currency_code}}
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">More
info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-14"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT,'minimum_placement_amount');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading"> Min: <strong>
{{$product->currency_code}}
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> {{$product->currency_code}}
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">More
info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading"> Min: <strong>
{{$product->currency_code}}
${{ Helper::inThousand($product->minimum_placement_amount) }}
</strong>
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p class="highlight highlight-bg"><strong>Min:</strong> {{$product->currency_code}}
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p>
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p>{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">More
info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>

<div class="productGridContainer target-content" id="showContent-container-15"
style="display:none;">
<div class="product-row-01 clearfix">
<?php
$products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT,'promotion_period');

$i = 1;$featured = []; ?>
@foreach($products as $product)
@if($product->featured==1)
@php $featured[] = $i; @endphp
<div class="product-col-01">
<div class="ps-slider--feature-product saving">
<div class="ps-block--short-product second highlight"
data-mh="product"><img
src="{{ asset($product->brand_logo) }}"
alt="">
<h4 class="slider-heading">

@if($product->max_tenure > 0)
<strong> {{ $product->max_tenure }}</strong> @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
@else
<strong> {{$product->promotion_period}}</strong>
@endif

</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> {{$product->currency_code}}
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p class=" highlight highlight-bg ">
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p class=" highlight highlight-bg ">{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">More
info</a>
</div>
</div>
</div>
@php $i++; @endphp
@endif
@endforeach
<?php $i = 1;$featured_item = 5 - count($featured);
$featured_count = count($featured);
$featured_width = 12;
if ($featured_count == 1) {
$featured_width = 2;
} elseif ($featured_count == 2) {
$featured_width = 3;
} elseif ($featured_count == 3) {
$featured_width = 4;
}
?>
<div class="product-col-0{{ $featured_width }} dump-padding-left">
<div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="20" data-owl-nav="true" data-owl-dots="false"
data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
data-owl-item-sm="2" data-owl-item-md="{{ $featured_item }}"
data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000"
data-owl-mousedrag="on"
data-owl-nav-left="<i class='fa fa-angle-left'></i>"
data-owl-nav-right="<i class='fa fa-angle-right'></i>">

@foreach ($products as $product)
@if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
<div class="ps-block--short-product"><img
src="<?php echo asset($product->brand_logo); ?>"
alt="">
<h4 class="slider-heading">
@if($product->max_tenure > 0)
<strong> {{ $product->max_tenure }}</strong> @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
@else
<strong> {{$product->promotion_period}}</strong>
@endif
</h4>

<div class="ps-block__info">
<p><strong>
rate: </strong>{{ $product->maximum_interest_rate }}
%</p>

<p><strong>Min:</strong> {{$product->currency_code}}
${{ Helper::inThousand($product->minimum_placement_amount) }}
</p>

@if($product->max_tenure > 0)
<p class=" highlight highlight-bg ">
{{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif</p>
@else
<p class=" highlight highlight-bg ">{{$product->promotion_period}}</p>
@endif
</div>
<a class="ps-btn"
href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">More
info</a>
</div>
@endif
@endforeach
</div>
</div>
</div>
</div>
</div>
</div>

</div>
<div class="ps-section__footer view_all_types"><a href="fixed-deposit-mode">View all bank rates</a>
</div>

</div>
</div>
</div>

{{--Blog section start--}}

<div class="ps-home-blog">
<div class="container">
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
<div class="ps-section__left">
<div class="ps-section__header">
<a href="{{ url('blog-list') }}"><h3 class="ps-heading"><strong>Lastest Blog</strong></h3>
</a>

<div class="ps-slider-navigation" data-slider="ps-slider--home-blog"><a class="ps-prev"
href="javascript:void(0);"><i
class="fa fa-caret-left"></i></a><a class="ps-next"
href="javascript:void(0);"><i
class="fa fa-caret-right"></i></a></div>
</div>
<div class="owl-slider owl-blog" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="1"
data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1"
data-owl-duration="1000" data-owl-mousedrag="off">
@foreach($blogs as $blog)
<div class="ps-post--home">
<div class="ps-post__thumbnail">
<a class="ps-post__overlay" href="{{ url($blog->slug) }}"></a><img
src="{{ asset($blog->blog_image) }}" alt="" height="250px">

<div class="ps-post__posted"><span
class="date">{{ date("d", strtotime($blog->created_at)) }}</span><span
class="month">{{ date("M", strtotime($blog->created_at)) }}</span>
</div>
</div>
<div class="ps-post__content">
<a class="ps-post__title" href="{{ url($blog->slug) }}">{{ $blog->name }}</a>

<p>{!! $blog->short_description !!}</p>
</div>
</div>
@endforeach
</div>
</div>
</div>
<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
<div class="ps-section__right">
<div class="ps-fanpage">
<div class="fb-page" data-href="https://www.facebook.com/dollardollar.sg/"
data-tabs="timeline" data-width="500" data-height="280" data-small-header="false"
data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
<blockquote cite="https://www.facebook.com/dollardollar.sg/"
class="fb-xfbml-parse-ignore"><a
href="https://www.facebook.com/dollardollar.sg/">DollarDollar</a>
</blockquote>
</div>
</div>
<div class="ps-block--home-signup">
<h3>Create an account to manage your privilege easily. <strong> It is free!</strong></h3><a
class="ps-btn ps-btn--yellow" href="{{ url('login/facebook') }}"><i
class="fa fa-facebook"></i> Signup with facebook</a><a
class="ps-btn ps-btn--outline" href="{{ url('login/google') }}">Sign Up with
email</a>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$("document").ready(function () {
var owl = $('.owl-blog');
owl.owlCarousel({
loop: true,
margin: 10,
items: 1
});
$('.ps-next').click(function () {
owl.trigger('next.owl.carousel');
})
$('.ps-prev').click(function () {
owl.trigger('prev.owl.carousel', [300]);
})
});


$("a.aboutpage").on("click", function () {
$("a.aboutpage").parent().removeClass("selected");
$(this).parent().addClass("selected");
});
$(".ps-tab-list li").on("click", function () {
$(".ps-tab-list li").removeClass("current");
$(this).addClass("current");
var id = $(this).find("a").attr("href");

var title = $(this).find("a").html();
if (title == 'Fixed Deposit') {
$("div.view_all_types a").attr("href", "fixed-deposit-mode");
}
else if (title == 'Saving Deposit') {
$("div.view_all_types a").attr("href", "saving-deposit-mode");
}
else if (title == 'Privilege Deposit') {
$("div.view_all_types a").attr("href", "privilege-deposit-mode");
}
else if (title == 'All In One Account') {
$("div.view_all_types a").attr("href", "all-in-one-deposit-mode");
}
else if (title == 'Foreign Currency') {
$("div.view_all_types a").attr("href", "foreign-currency-deposit-mode");
}
$("div" + id).find("ul.catListing li:first a").click();
});

/*$.ajax({
method: 'POST',
url: '{{ route('deposit-type') }}',
data: {type: 'Interest', promotion_type:'<?php echo FOREIGN_CURRENCY_DEPOSIT_MODE ; ?>'},
cache: false,
success: function (data) {
//alert(data);
$("span.display_fixed").html(data);
}
});
$("a.deposit_value").on("click", function () {
$("a.deposit_value").removeClass("active");
$(this).addClass("active");
var title = $("input[name='deposit_type']").val();
var value = $(this).text();
if (title == 'Fixed Deposit') {
$.ajax({
method: 'POST',
url: '{{ route('deposit-type') }}',
data: {type: value, promotion_type:'<?php echo FIX_DEPOSIT ; ?>'},
cache: false,
success: function (data) {
//alert(data);
$("span.display_fixed").html(data);
}
});
}

else if (title == 'Saving Deposit') {
$.ajax({
method: 'POST',
url: '{{ route('deposit-type') }}',
data: {type: value, promotion_type:'<?php echo SAVING_DEPOSIT ; ?>'},
cache: false,
success: function (data) {
$("span.display_saving").html(data);
}
});
}
else if (title == 'Privilege Deposit') {
$.ajax({
method: 'POST',
url: '{{ route('deposit-type') }}',
data: {type: value, promotion_type:'<?php echo PRIVILEGE_DEPOSIT ; ?>'},
cache: false,
success: function (data) {
//alert(data);
$("span.display_fixed").html(data);
}
});
}
else if (title == 'All In One Account') {
$.ajax({
method: 'POST',
url: '{{ route('deposit-type') }}',
data: {type: value, promotion_type:'<?php echo ALL_IN_ONE_ACCOUNT ; ?>'},
cache: false,
success: function (data) {
//alert(data);
$("span.display_fixed").html(data);
}
});
}
else if (title == 'Foreign Currency') {
$.ajax({
method: 'POST',
url: '{{ route('deposit-type') }}',
data: {type: value, promotion_type:'<?php echo FOREIGN_CURRENCY_DEPOSIT ; ?>'},
cache: false,
success: function (data) {
//alert(data);
$("span.display_fixed").html(data);
}
});
}
else {
$.ajax({
method: 'POST',
url: '{{ route('deposit-type') }}',
data: 'type=Interest',
cache: false,
success: function (data) {
//alert(data);
$("span.display_fixed").html(data);
}
});
}
});*/
</script>
{{--Blog section end--}}

{{--contact us or what we offer section start--}}
@if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
{!! $systemSetting->{$page->contact_or_offer} !!}
@endif
{{--contact us or what we offer section end--}}


@endsection
