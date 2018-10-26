@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
    <?php
            //dd($page);
    $search_filter = isset($search_filter) ? $search_filter : "";
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

    <div class="ps-page--deposit ps-loan">
        <div class="container">
            <div class="ps-block--image">
                <div class="ps-block__content">
                    <h3 class="ps-heading"><span> <i class="fa fa-area-chart"></i> Home </span> Loan</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br/><br/>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <a href="">LEARN MORE<i class="fa fa-angle-right"></i></a></p>
                </div>
                <div class="ps-block__content right" ><img src="{{asset('/uploads/uploads/images/loan.jpg')}}" alt=""></div>
            </div>

            <div class="ps-block--deposit-filter mb-60">
                <div class="ps-block__content">
                    <form class="ps-form--filter" action="do_action" method="post">
                        <h4>Fill in your need</h4>
                        <div class="ps-form__values">
                            <div class="form-group--label form-group--label1">
                                <div class="form-group__content">
                                    <label>Rate Type<a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i class="fa fa-exclamation-circle"></i></a></label>
                                    <select class="form-control">
                                        <option>ALL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label2">
                                <div class="form-group__content">
                                    <label>Tenor<a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i class="fa fa-exclamation-circle"></i></a></label>
                                    <select class="form-control">
                                        <option>30</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label3">
                                <div class="form-group__content">
                                    <label>Property Type<a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i class="fa fa-exclamation-circle"></i></a></label>
                                    <select class="form-control">
                                        <option>HDB/Private</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label3">
                                <div class="form-group__content">
                                    <label>Completion</label>
                                    <select class="form-control">
                                        <option>Completed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <a class="btn refresh form-control " href="http://verz1.com/dollar_dollar/public/all-in-one-deposit-mode/#logo-detail"> <i class="fa fa-refresh"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="ps-form__option">
                                    <button class="ps-btn filter" disabled>Interest</button>
                                    <button class="ps-btn filter" disabled>Loan amount</button>
                                    <button class="ps-btn filter" disabled>Tenor</button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="row ps-col-tiny">
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 ">
                                        <div class="form-group form-group--nest">
                                            <div class="form-group__content"><span>$</span>
                                                <input class="form-control" type="text" placeholder="">
                                            </div>
                                            <button>Go</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 ps-loan-select">
                                        <select class="form-control">
                                            <option value="1">Descending</option>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="product-row-01 clearfix slider-class">
                <div class="product-col-01">
                    <div class="ps-slider--feature-product saving">
                        <div class="ps-block--short-product second highlight" data-mh="product">
                            <img src="http://verz1.com/dollar_dollar/public/uploads/brands/logos/DBS_1535354543.png" alt="">
                            <h4>
                                <strong>Up to <span class="highlight-slider"> 3.5%</span></strong>
                            </h4>
                            <div class="ps-block__info">
                                <p class="  highlight highlight-bg "><strong>rate: </strong>3.5%</p>
                                <p class=""><strong>Min:</strong> SGD $50K</p>
                                <p class="">5 Criteria</p>
                            </div>
                            <a class="ps-btn" href="#1">More data</a>
                        </div>
                    </div>
                </div>
                <div class="product-col-01">
                    <div class="ps-slider--feature-product saving">
                        <div class="ps-block--short-product second highlight" data-mh="product">
                            <img src="http://verz1.com/dollar_dollar/public/uploads/brands/logos/ocbc_1533044523.png" alt="">
                            <h4>
                                <strong>Up to <span class="highlight-slider"> 3%</span></strong>
                            </h4>
                            <div class="ps-block__info">
                                <p class="  highlight highlight-bg "><strong>rate: </strong>3%</p>
                                <p class=""><strong>Min:</strong>SGD $100K
                                </p>
                                <p class="">1 Criteria</p>
                            </div>
                            <a class="ps-btn" href="#2">More data</a>
                        </div>
                    </div>
                </div>
                <div class="product-col-03">
                    <div class="ps-slider--feature-product saving nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="3" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="3" data-owl-item-lg="3" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;" data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                        <div class="ps-block--short-product second" data-mh="product" style="">
                            <img src="http://verz1.com/dollar_dollar/public/uploads/brands/logos/uob_1532959156.png" alt="">
                            <h4>
                                <strong>Up to <span class="highlight-slider"> 2.44 %</span></strong>
                            </h4>
                            <div class="ps-block__info">
                                <p class="  highlight highlight-bg ">
                                    <strong>rate: </strong>2.44%
                                </p>
                                <p class=" ">
                                    <strong>Min:</strong> SGD $75K
                                </p>
                                <p class="">2 Criteria</p>
                            </div>
                            <a class="ps-btn" href="#5">More data</a>
                        </div>
                        <div class="ps-block--short-product second" data-mh="product" style="">
                            <img src="http://verz1.com/dollar_dollar/public/uploads/brands/logos/maybank_1533044551.png" alt="">
                            <h4>
                                <strong>Up to <span class="highlight-slider"> 2.44 %</span></strong>
                            </h4>
                            <div class="ps-block__info">
                                <p class="  highlight highlight-bg ">
                                    <strong>rate: </strong>2.44%
                                </p>
                                <p class=" ">
                                    <strong>Min:</strong> SGD $75K
                                </p>
                                <p class="">2 Criteria</p>
                            </div>
                            <a class="ps-btn" href="#5">More data</a>
                        </div>
                        <div class="ps-block--short-product second" data-mh="product" style="">
                            <img src="http://verz1.com/dollar_dollar/public/uploads/brands/logos/ocbc_1533044523.png" alt="">
                            <h4>
                                <strong>Up to <span class="highlight-slider"> 2.44 %</span></strong>
                            </h4>
                            <div class="ps-block__info">
                                <p class="  highlight highlight-bg ">
                                    <strong>rate: </strong>2.44%
                                </p>
                                <p class=" ">
                                    <strong>Min:</strong> SGD $75K
                                </p>
                                <p class="">2 Criteria</p>
                            </div>
                            <a class="ps-btn" href="#5">More data</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ps-product featured-1">
                <div class="ps-product__header">
                    <img src="http://verz1.com/dollar_dollar/public/uploads/brands/logos/uob_1532959156.png" alt="">
                    <div class="ps-product__promo left">
                        <label class="ps-btn--checkbox">
                            <input type="checkbox" id="checkbox-1" class="checkbox"><span></span>Shortlist this Loan
                        </label>
                    </div>
                </div>
                <div class="ps-loan__text1">BOC Fixed Deposit Rate (FHR) Housing Loan</div>
                <div class="ps-loan-content ps-loan-content1">
                    <table class="ps-table ps-table--product">
                        <thead>
                        <tr>
                            <th>YEARS</th>
                            <th>INTEREST RATE (PA)</th>
                            <th>Monthly Installment</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="highlight">YEAR 1</td>
                            <td>1.5% (1mth Sibor + 1.5%)</td>
                            <td class="highlight">$700 / mth</td>
                        </tr>
                        <tr>
                            <td class="highlight">YEAR 2</td>
                            <td>1.5% (1mth Sibor + 1.5%)</td>
                            <td class="highlight">$700 / mth</td>
                        </tr>
                        <tr>
                            <td class="highlight">YEAR 3</td>
                            <td>1.5% (1mth Sibor + 1.5%)</td>
                            <td class="highlight">$700 / mth</td>
                        </tr>
                        <tr>
                            <td class="highlight">THEREAFTER</td>
                            <td>2.3% (1mth Sibor + 2.3%)</td>
                            <td class="highlight">$500 / mth</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="ps-loan-right">
                        <h4>For 600k loan with 30 years Loan Tenure</h4>
                        <p>Rate Type : <strong>Floating (Sibor)</strong></p>
                        <p>Interest Rate : <strong>2.3% (3 Years)</strong></p>
                        <p>Lock In : <strong>2 Years</strong></p>
                        <p>Monthly Installments : <strong>$500 (3 Years Avg.)</strong></p>
                        <p>Property Type : <strong>Private/HDB (Completed)</strong></p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="ps-product__detail">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                            <h4 class="ps-product__heading">Keypoints</h4>
                            <ul class="ps-list--arrow-circle">
                                <li>Receive interest upfront</li>
                                <li>Deposit into main account</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                            <div class="ps-product__actions"><a class="ps-btn ps-btn--outline" href="#">Main Page</a><a class="ps-btn ps-btn--outline" href="#">T&amp;C</a></div>
                        </div>
                    </div>
                </div>
                <div class="ps-product__footer">
                    <a class="ps-product__more" href="#">More Details <i class="fa fa-angle-down"></i></a>
                    <!-- <a class="ps-product__info sp-only" href="#">More data<i class="fa fa-angle-down"></i></a> -->
                </div>
            </div>
            <div class="ps-product featured-1">
                <div class="ps-product__header">
                    <img src="http://verz1.com/dollar_dollar/public/uploads/brands/logos/ocbc_1533044523.png" alt="">
                    <div class="ps-product__promo left">
                        <label class="ps-btn--checkbox">
                            <input type="checkbox" id="checkbox-2" class="checkbox"><span></span>Shortlist this Loan
                        </label>
                    </div>
                </div>
                <div class="ps-loan__text1">BOC Fixed Deposit Rate (FHR) Housing Loan</div>
                <div class="ps-loan-content ps-loan-content1">
                    <table class="ps-table ps-table--product">
                        <thead>
                        <tr>
                            <th>YEARS</th>
                            <th>INTEREST RATE (PA)</th>
                            <th>Monthly Installment</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="highlight">YEAR 1</td>
                            <td>1.5% (1mth Sibor + 1.5%)</td>
                            <td class="highlight">$700 / mth</td>
                        </tr>
                        <tr>
                            <td class="highlight">YEAR 2</td>
                            <td>1.5% (1mth Sibor + 1.5%)</td>
                            <td class="highlight">$700 / mth</td>
                        </tr>
                        <tr>
                            <td class="highlight">YEAR 3</td>
                            <td>1.5% (1mth Sibor + 1.5%)</td>
                            <td class="highlight">$700 / mth</td>
                        </tr>
                        <tr>
                            <td class="highlight">THEREAFTER</td>
                            <td>2.3% (1mth Sibor + 2.3%)</td>
                            <td class="highlight">$500 / mth</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="ps-loan-right">
                        <h4>For 600k loan with 30 years Loan Tenure</h4>
                        <p>Rate Type : <strong>Floating (Sibor)</strong></p>
                        <p>Interest Rate : <strong>2.3% (3 Years)</strong></p>
                        <p>Lock In : <strong>2 Years</strong></p>
                        <p>Monthly Installments : <strong>$500 (3 Years Avg.)</strong></p>
                        <p>Property Type : <strong>Private/HDB (Completed)</strong></p>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="ps-product__detail">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                            <h4 class="ps-product__heading">Keypoints</h4>
                            <ul class="ps-list--arrow-circle">
                                <li>Receive interest upfront</li>
                                <li>Deposit into main account</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                            <div class="ps-product__actions"><a class="ps-btn ps-btn--outline" href="#">Main Page</a><a class="ps-btn ps-btn--outline" href="#">T&amp;C</a></div>
                        </div>
                    </div>
                </div>
                <div class="ps-product__footer">
                    <a class="ps-product__more" href="#">More Details <i class="fa fa-angle-down"></i></a>
                    <!-- <a class="ps-product__info sp-only" href="#">More data<i class="fa fa-angle-down"></i></a> -->
                </div>
            </div>
        </div>
        {{--Page content end--}}
        {{--contact us or what we offer section start--}}
        @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
            {!! $systemSetting->{$page->contact_or_offer} !!}
        @endif
        {{--contact us or what we offer section end--}}
        <div class="ps-loan-popup">
            <p>Speak with a mortgage specialist to know more about the loan you have shortlisted!</p>
            <a href="{{url('loan-enquiry')}}">ENQUIRE NOW</a>
        </div>


@endsection
