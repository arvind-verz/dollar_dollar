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
            <div class="ps-block--deposit-filter mb-60">
                <div class="ps-block__content">
                    <form id="search-form" class="ps-form--filter"
                          action="{{ URL::route('aioa-deposit-mode.search') }}#logo-detail"
                          method="post">
                        <h4>Fill in your needs</h4>

                        <div class="ps-form__values">
                            <div class="form-group--label form-group--label1">
                                <div class="form-group__content">
                                    <label>Rate Type
                                        @if(isset($toolTips->rate_type))
                                            <a class="ps-tooltip" href="javascript:void(0)"
                                               data-tooltip="{{$toolTips->rate_type}}"><i
                                                        class="fa fa-exclamation-circle"></i></a>
                                        @endif
                                    </label>
                                    <select class="form-control" name="rate_type">
                                        <option value="1"
                                                @if(isset($searchFilter['rate_type']) && $searchFilter['rate_type']==BOTH_VALUE) selected @endif>{{BOTH_VALUE}}</option>
                                        <option value="2"
                                                @if(isset($searchFilter['rate_type']) && $searchFilter['rate_type']==FIX_RATE) selected @endif>{{FIX_RATE}}</option>
                                        <option value="3"
                                                @if(isset($searchFilter['rate_type']) && $searchFilter['rate_type']==FLOATING_RATE) selected @endif>{{FLOATING_RATE}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label2">
                                <div class="form-group__content">
                                    <label>Tenure<a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                                    class="fa fa-exclamation-circle"></i></a></label>
                                    <select class="form-control" name="tenure">
                                        @for($i=1;$i<=35;$i++)
                                            <option @if(isset($searchFilter['tenure']) && $searchFilter['tenure']==$i) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label3">
                                <div class="form-group__content">
                                    <label>Property Type<a class="ps-tooltip" href="#"
                                                           data-tooltip="Enter tooltip here"><i
                                                    class="fa fa-exclamation-circle"></i></a></label>
                                    <select class="form-control" name="property_type">
                                        <option @if(isset($searchFilter['property_type']) && $searchFilter['property_type']==HDB_PROPERTY) selected @endif>{{HDB_PROPERTY}}</option>
                                        <option @if(isset($searchFilter['property_type']) && $searchFilter['property_type']==PRIVATE_PROPERTY) selected @endif>{{PRIVATE_PROPERTY}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group--label form-group--label3">
                                <div class="form-group__content">
                                    <label>Completion</label>
                                    <select class="form-control" name="completion">
                                        <option @if(isset($searchFilter['completion']) && $searchFilter['completion']==COMPLETE) selected @endif>{{COMPLETE}}</option>
                                        <option @if(isset($searchFilter['completion']) && $searchFilter['completion']==BUC) selected @endif>{{BUC}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <a class="btn refresh form-control "
                                   href="{{url(LOAN_MODE)}}/#logo-detail"></i></a>
                            </div>
                            <div class="form-group">
                                <div class="form-group ">
                                    <a class="btn refresh form-control " style="width: 73px;"
                                       href="{{url(LOAN_MODE)}}/#logo-detail"> <i
                                                class="fa fa-refresh"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="ps-form__option">
                                    <button type="button"
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']==INTEREST) active @endif">
                                        <input type="radio" name="filter" value="{{INTEREST}}"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Interest') checked @endif>{{INTEREST}}
                                    </button>
                                    <button type="button"
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']==PLACEMENT) active @elseif(empty($searchFilter)) active @endif">
                                        <input type="radio" name="filter" value="{{PLACEMENT}}"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']==PLACEMENT) checked
                                               @elseif(empty($searchFilter)) checked @endif>Loan amount
                                    </button>
                                    <button type="button"
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']==TENURE) active @endif">
                                        <input type="radio" name="filter" value="{{TENURE}}"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']==TENURE) checked @endif>Lock in
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
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 ps-loan-select">
                                        <select class="form-control sort-by" name="sort_by">
                                            <option value="" disabled="disabled" selected="selected">Sort by
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
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(count($products))
                @include('productsInnerSlider')
            @endif
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
                            <div class="ps-product__actions"><a class="ps-btn ps-btn--outline" href="#">Main Page</a><a
                                        class="ps-btn ps-btn--outline" href="#">T&amp;C</a></div>
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
                            <div class="ps-product__actions"><a class="ps-btn ps-btn--outline" href="#">Main Page</a><a
                                        class="ps-btn ps-btn--outline" href="#">T&amp;C</a></div>
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
