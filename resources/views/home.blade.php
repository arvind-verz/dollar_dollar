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
            <div class="ps-slider--home owl-slider" data-owl-animated="fadeOut" data-owl-auto="true"
                 data-owl-dots="true" data-owl-duration="1000" data-owl-gap="0" data-owl-hoverpause="true"
                 data-owl-item="1" data-owl-item-lg="1" data-owl-item-md="1" data-owl-item-sm="1" data-owl-item-xs="1"
                 data-owl-loop="true" data-owl-mousedrag="on" data-owl-nav="false" data-owl-smartspeed="10"
                 data-owl-speed="5000">
                @foreach($banners as $banner)



                    @if($banner->display==1 && strtotime(date('Y-m-d', strtotime('now')))<=strtotime(date('Y-m-d', strtotime($banner->banner_expiry))) && strtotime(date('Y-m-d', strtotime('now')))>=strtotime(date('Y-m-d', strtotime($banner->banner_start_date))))
                        <a href="{{ !empty($banner->banner_link) ? $banner->banner_link : 'javascript:void(0)' }}"
                           target="_blank">
                            <div class="ps-banner bg--cover" data-background="{{asset($banner->banner_image )}}">
                                <img alt="" src="{{asset($banner->banner_image )}}">

                                <div class="ps-banner__content">
                                    {!! $banner->banner_content !!}
                                </div>
                                </img>
                            </div>
                        </a>
                    @else
                        <a href="{{ !empty($banner->fixed_banner_link) ? $banner->fixed_banner_link : 'javascript:void(0)' }}"
                           target="_blank">
                            <div class="ps-banner bg--cover" data-background="{{asset($banner->fixed_banner )}}">
                                <img alt="" src="{{asset($banner->fixed_banner )}}">
                                </img>
                            </div>
                        </a>
                    @endif



                @endforeach
            </div>
        </div>
    @elseif($banners->count()== 1)



        @foreach($banners as $banner)
            <a href="{{ !empty($banner->fixed_banner_link) ? $banner->fixed_banner_link : 'javascript:void(0)' }}"
               target="_blank">
                <div class="ps-banner bg--cover" data-background="{{asset($banner->fixed_banner )}}">
                    <img alt="" src="{{asset($banner->fixed_banner )}}">
                    </img>
                </div>
            </a>
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
                            <p>
                                {{ $banner->description }}
                            </p>
                        </div>
                    </a>
                    <?php $i++; ?>
                @endforeach



            @endif
        </div>
    </div>
    <div class="ps-home-search">
        <div class="ps-section__content" data-mh="home-search">
<span>
Need something?
</span>
            <h4>
                Search Products
            </h4>
        </div>
        <form action="{{ route('product-search') }}" class="ps-form--search" data-mh="home-search" method="POST">
            <div class="form-group">
                <select class="form-control" name="account_type" required="required">
                    <option value="" disabled="disabled" selected="selected">
                        Select account Type
                    </option>
                    <option value="1">
                        Fixed Deposit
                    </option>
                    <option value="2">
                        Saving Deposit
                    </option>
                    <option value="3">
                        Privilege Deposit
                    </option>
                    <option value="4">
                        Foreign Currency
                    </option>
                    <option value="5">
                        All In One Account
                    </option>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control prefix_dollar" name="search_value" placeholder="Enter Placement" required=""
                       type="text" value="100000">
                <!-- <span class="suffix_k">K</span> -->
                </input>
            </div>
            <div class="form-group submit">
                <button class="ps-btn" type="submit">
                    Search Now
                    <i class="fa fa-search">
                    </i>
                </button>
            </div>
        </form>
    </div>
    {{--Brand section start--}}







    @if($brands->count())
        <div class="ps-home--partners">
            <div class="container">
                <div class="nav-outside owl-slider" data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                     data-owl-gap="0" data-owl-item="8" data-owl-item-lg="8" data-owl-item-md="6" data-owl-item-sm="4"
                     data-owl-item-xs="3" data-owl-loop="true" data-owl-mousedrag="on" data-owl-nav="true"
                     data-owl-speed="5000">
                    @foreach($brands as $brand)
                        <a class="active"
                           href="{{!empty($brand->brand_link) ? $brand->brand_link : 'javascript:void(0)'}}"
                           target="_blank">
                            <img alt="" src="{{ asset($brand->brand_logo) }}" style="padding:19px;"/>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif



    {{--Brand section end--}}
    <input name="deposit_type" type="hidden" value="Fixed Deposit">
    <div class="ps-home-fixed-deposit ps-tabs-root">
        <div class="ps-section__header">
            <div class="container">
                <ul class="ps-tab-list">
                    <li class="current">
                        <a href="#tab-1">
                            Fixed Deposit
                        </a>
                    </li>
                    <li>
                        <a href="#tab-2">
                            Saving Deposit
                        </a>
                    </li>
                    <li>
                        <a href="#tab-3">
                            Privilege Deposit
                        </a>
                    </li>
                    <li>
                        <a href="#tab-5">
                            Foreign Currency
                        </a>
                    </li>
                    <li>
                        <a href="#tab-4">
                            All In One Account
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ps-section__content bg--cover" data-background="img/bg/home-bg.jpg">
            <div class="container">
                <div class="ps-tabs">
                    <div class="ps-tab active" id="tab-1">
                        <div class="ps-block--desposit">
                            <div class="ps-block__header">
                                <h3>
                                    <strong>
                                        Fixed Deposit
                                    </strong>
                                </h3>

                                <div class="ps-block__actions">
                                    <ul class="catListing clearfix">
                                        <li class="selected" id="catList1">
                                            <a class="aboutpage" id="showContent-1" target="showContent-container-1">
                                                Interest
                                            </a>
                                        </li>
                                        <li class="" id="catList2">
                                            <a class="aboutpage" id="showContent-2" target="showContent-container-2">
                                                Placement
                                            </a>
                                        </li>
                                        <li class="" id="catList3">
                                            <a class="aboutpage" id="showContent-3" target="showContent-container-3">
                                                tenure
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-1">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php
                                    $products = \Helper::getHomeProducts(FIX_DEPOSIT, 'maximum_interest_rate');
                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)
                                        @if($product->featured==1)
                                            <?php $featured[] = $i; ?>
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}
    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}
                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if($product->featured==1)



                                                @endif



                                                @if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php







                                    $products = \Helper::getHomeProducts(FIX_DEPOSIT, 'maximum_interest_rate');



                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)
                                            <?php $featured[] = $i; ?>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if($product->featured==1)
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                                @if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-2"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FIX_DEPOSIT, 'minimum_placement_amount');



                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FIX_DEPOSIT, 'minimum_placement_amount');



                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp







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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                 <span class="highlight-slider">
                                                                SGD ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                     </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif

                                                @if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                 <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-3"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php
                                    $products = \Helper::getHomeProducts(FIX_DEPOSIT, 'promotion_period');
                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)
                                        @if($product->featured==1)
                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class="highlight highlight-bg">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FIX_DEPOSIT, 'promotion_period');
                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)
                                        @if($product->featured==1)
                                            @php $featured[] = $i; @endphp
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class="highlight highlight-bg">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url('fixed-deposit-mode'); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                <h3>
                                    <strong>
                                        Saving Deposit
                                    </strong>
                                </h3>

                                <div class="ps-block__actions">
                                    <ul class="catListing clearfix">
                                        <li class="selected" id="catList4">
                                            <a class="aboutpage" id="showContent-4" target="showContent-container-4">
                                                Interest
                                            </a>
                                        </li>
                                        <li class="" id="catList5">
                                            <a class="aboutpage" id="showContent-5" target="showContent-container-5">
                                                Placement
                                            </a>
                                        </li>
                                        <li class="" id="catList6">
                                            <a class="aboutpage" id="showContent-6" target="showContent-container-6">
                                                tenure
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-4">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(SAVING_DEPOSIT, 'maximum_interest_rate');











                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i;  @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }} %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
                                                                <span class="highlight-slider">
                                                                    {{ $product->maximum_interest_rate  }} %
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(SAVING_DEPOSIT, 'maximum_interest_rate');











                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
                                                                <span class="highlight-slider">
                                                                    {{ $product->maximum_interest_rate  }} %
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
                                                                <span class="highlight-slider">
                                                                    {{ $product->maximum_interest_rate  }} %
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-5"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(SAVING_DEPOSIT, 'minimum_placement_amount');











                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(SAVING_DEPOSIT, 'minimum_placement_amount');











                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-6"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(SAVING_DEPOSIT, 'promotion_period');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(SAVING_DEPOSIT, 'promotion_period');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)


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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==SAVING_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(SAVING_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                <h3>
                                    <strong>
                                        Privilege Deposit
                                    </strong>
                                </h3>

                                <div class="ps-block__actions">
                                    <ul class="catListing clearfix">
                                        <li class="selected" id="catList7">
                                            <a class="aboutpage" id="showContent-7" target="showContent-container-7">
                                                Interest
                                            </a>
                                        </li>
                                        <li class="" id="catList8">
                                            <a class="aboutpage" id="showContent-8" target="showContent-container-8">
                                                Placement
                                            </a>
                                        </li>
                                        <li class="" id="catList9">
                                            <a class="aboutpage" id="showContent-9" target="showContent-container-9">
                                                tenure
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-7">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT, 'maximum_interest_rate');






                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)

                                        @if($product->featured==1)

                                            @php $featured[] = $i;  @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT, 'maximum_interest_rate');






                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)

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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-8"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT, 'minimum_placement_amount');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT, 'minimum_placement_amount');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-9"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT, 'promotion_period');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php
                                    $products = \Helper::getHomeProducts(PRIVILEGE_DEPOSIT, 'promotion_period');
                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)
                                        @if($product->featured==1)
                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <strong>
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                    </span>
                                                                </strong>
                                                                @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                            @else
                                                                <strong>
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                </strong>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==PRIVILEGE_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(PRIVILEGE_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                <h3>
                                    <strong>
                                        All in One Deposit
                                    </strong>
                                </h3>

                                <div class="ps-block__actions">
                                    <ul class="catListing clearfix">
                                        <li class="selected" id="catList10">
                                            <a class="aboutpage" id="showContent-10" target="showContent-container-10">
                                                Interest
                                            </a>
                                        </li>
                                        <li class="" id="catList11">
                                            <a class="aboutpage" id="showContent-11" target="showContent-container-11">
                                                Placement
                                            </a>
                                        </li>
                                        <li class="" id="catList12">
                                            <a class="aboutpage" id="showContent-12" target="showContent-container-12">
                                                Criteria
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-10">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT, 'maximum_interest_rate');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p>
                                                                <?php echo $product->
                                                                promotion_period; ?>



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT, 'maximum_interest_rate');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i;  @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p>
                                                                {{ $product->promotion_period }}



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p>
                                                                {{ $product->promotion_period }}



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p>
                                                                <?php echo $product->
                                                                promotion_period; ?>



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-11"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT, 'minimum_placement_amount');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p>
                                                                <?php echo $product->
                                                                promotion_period; ?>



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT, 'minimum_placement_amount');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p>
                                                                {{ $product->promotion_period }}



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p>
                                                                {{ $product->promotion_period }}



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                SGD
                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                                </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p>
                                                                <?php echo $product->
                                                                promotion_period; ?>



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-12"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT, 'promotion_period');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->promotion_period }} Criteria
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <?php echo $product->
                                                                promotion_period; ?>



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(ALL_IN_ONE_ACCOUNT, 'promotion_period');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->promotion_period }} Criteria
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                {{ $product->promotion_period }}



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->promotion_period }} Criteria
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                {{ $product->promotion_period }}



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==ALL_IN_ONE_ACCOUNT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->promotion_period }} Criteria
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                SGD


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <?php echo $product->
                                                                promotion_period; ?>



                                                                {{CRITERIA}}
                                                            </p>
                                                        </div>
                                                        <a class="ps-btn" href="<?php echo url(AIO_DEPOSIT_MODE); ?>">
                                                            More info
                                                        </a>
                                                        </img>
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
                                <h3>
                                    <strong>
                                        Foreign Currency Deposit
                                    </strong>
                                </h3>

                                <div class="ps-block__actions">
                                    <ul class="catListing clearfix">
                                        <li class="selected" id="catList13">
                                            <a class="aboutpage" id="showContent-13" target="showContent-container-13">
                                                Interest
                                            </a>
                                        </li>
                                        <li class="" id="catList14">
                                            <a class="aboutpage" id="showContent-14" target="showContent-container-14">
                                                Placement
                                            </a>
                                        </li>
                                        <li class="" id="catList15">
                                            <a class="aboutpage" id="showContent-15" target="showContent-container-15">
                                                tenure
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-13">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT, 'maximum_interest_rate');











                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)

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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT, 'maximum_interest_rate');











                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i;  @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Up to
<span class="highlight-slider">
{{ $product->maximum_interest_rate  }}


    %
</span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-14"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT, 'minimum_placement_amount');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                {{$product->currency_code}}
                                                                    ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT, 'minimum_placement_amount');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                {{$product->currency_code}}
                                                                    ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                {{$product->currency_code}}
                                                                    ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                Min:
                                                                <span class="highlight-slider">
                                                                {{$product->currency_code}}
                                                                    ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </span>
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p class="highlight highlight-bg">
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p>
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p>
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-15"
                                 style="display:none;">
                                <div class="product-row-01 clearfix pc-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT, 'promotion_period');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)



                                                @if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
                                                    </div>
                                                @endif



                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php



                                    $products = \Helper::getHomeProducts(FOREIGN_CURRENCY_DEPOSIT, 'promotion_period');







                                    $i = 1;$featured = []; ?>
                                    @foreach($products as $product)



                                        @if($product->featured==1)



                                            @php $featured[] = $i; @endphp
                                            <div class="product-col-01 home-featured">
                                                <div class="ps-slider--feature-product saving">
                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
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
                                             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                                             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
                                             data-owl-item-lg="{{ $featured_item }}"
                                             data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"
                                             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
                                             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
                                             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
                                             data-owl-speed="5000">
                                            @foreach ($products as $product)

                                                @if($product->featured==1)

                                                    <div class="ps-block--short-product second highlight"
                                                         data-mh="product">
                                                        <img alt="" src="{{ asset($product->brand_logo) }}">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
                                                    </div>

                                                @endif

                                                @if ($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT && $product->featured==0)
                                                    <div class="ps-block--short-product">
                                                        <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                                                        <h4 class="slider-heading">
                                                            <strong>
                                                                @if($product->max_tenure > 0)
                                                                    <span class="highlight-slider">
                                                                    {{ $product->max_tenure }}
                                                                         </span>
                                                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{\Helper::days_or_month_or_year(1,  $product->max_tenure)}} @else {{\Helper::days_or_month_or_year(2,  $product->max_tenure)}} @endif
                                                                @else
                                                                    <span class="highlight-slider">
                                                                    {{$product->promotion_period}}
                                                                    </span>
                                                                @endif
                                                            </strong>
                                                        </h4>

                                                        <div class="ps-block__info">
                                                            <p>
                                                                <strong>
                                                                    rate:
                                                                </strong>
                                                                {{ $product->maximum_interest_rate }}


                                                                %
                                                            </p>

                                                            <p>
                                                                <strong>
                                                                    Min:
                                                                </strong>
                                                                {{$product->currency_code}}


                                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                            </p>
                                                            @if($product->max_tenure > 0)
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}} @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1])) {{DAYS}} @else {{MONTHS}} @endif
                                                                </p>
                                                            @else
                                                                <p class=" highlight highlight-bg ">
                                                                    {{$product->promotion_period}}
                                                                </p>
                                                            @endif
                                                        </div>
                                                        <a class="ps-btn"
                                                           href="<?php echo url(FOREIGN_CURRENCY_DEPOSIT_MODE); ?>">
                                                            More


                                                            info
                                                        </a>
                                                        </img>
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
                <div class="ps-section__footer view_all_types">
                    <a href="fixed-deposit-mode">
                        View all bank rates
                    </a>
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
                            <a href="{{ url('blog-list') }}">
                                <h3 class="ps-heading">
                                    <strong>
                                        Lastest Blog
                                    </strong>
                                </h3>
                            </a>

                            <div class="ps-slider-navigation" data-slider="ps-slider--home-blog">
                                <a class="ps-prev" href="javascript:void(0);">
                                    <i class="fa fa-caret-left">
                                    </i>
                                </a>
                                <a class="ps-next" href="javascript:void(0);">
                                    <i class="fa fa-caret-right">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <div class="owl-slider owl-blog" data-owl-auto="true" data-owl-dots="false"
                             data-owl-duration="1000" data-owl-gap="0" data-owl-item="1" data-owl-item-lg="1"
                             data-owl-item-md="1" data-owl-item-sm="1" data-owl-item-xs="1" data-owl-loop="true"
                             data-owl-mousedrag="off" data-owl-nav="false" data-owl-speed="5000">
                            @foreach($blogs as $blog)
                                <div class="ps-post--home">
                                    <div class="ps-post__thumbnail">
                                        <a class="ps-post__overlay" href="{{ url($blog->slug) }}">
                                        </a>
                                        <img alt="" height="250px" src="{{ asset($blog->blog_image) }}">

                                        <div class="ps-post__posted">
<span class="date">
{{ date("d", strtotime($blog->created_at)) }}
</span>
<span class="month">
{{ date("M", strtotime($blog->created_at)) }}
</span>
                                        </div>
                                        </img>
                                    </div>
                                    <div class="ps-post__content">
                                        <a class="ps-post__title" href="{{ url($blog->slug) }}">
                                            {{ $blog->name }}
                                        </a>

                                        <p>
                                            {!! $blog->short_description !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="ps-section__right">
                        <div class="ps-fanpage">
                            <div class="fb-page" data-adapt-container-width="true" data-height="280"
                                 data-hide-cover="false" data-href="https://www.facebook.com/dollardollar.sg/"
                                 data-show-facepile="true" data-small-header="false" data-tabs="timeline"
                                 data-width="500">
                                <blockquote cite="https://www.facebook.com/dollardollar.sg/"
                                            class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/dollardollar.sg/">
                                        DollarDollar
                                    </a>
                                </blockquote>
                            </div>
                        </div>
                        <div class="ps-block--home-signup">
                            <h3>
                                Create an account to manage your privilege easily.
                                <strong>
                                    It is free!
                                </strong>
                            </h3>
                            <a class="ps-btn ps-btn--yellow" href="{{ url('login/facebook') }}">
                                <i class="fab fa-facebook-f">
                                </i>
                                Signup with facebook
                            </a>
                            <a class="ps-btn ps-btn--outline" href="{{ url('login/google') }}">
                                Sign Up with


                                email
                            </a>
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