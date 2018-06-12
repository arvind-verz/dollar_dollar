@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
    <?php
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

    {{--Page content start--}}
    <div class="ps-page--deposit">
        <?php

        $pageName = explode(' ', trim($page->name));
        $details = [];
        $details['first_heading'] = $pageName[0];
        // $a =  array_shift($arr);
        unset($pageName[0]);
        $details['second_heading'] = implode(' ',$pageName);
        $string = $page->contents;
        $output = preg_replace_callback('~\{{(.*?)\}}~',
                function ($key) use ($details) {
                    $variable[$key[1]] = $details[$key[1]];
                    return $variable[$key[1]];
                },
                $string);
        ?>
        {!! $output !!}
        <div class="container">
            <div class="ps-block--deposit-filter">
                <div class="ps-block__header"><img src="{{ asset('img/block/list-brand.png') }}" alt=""></div>
                <div class="ps-block__content">
                    <form class="ps-form--filter" action="{{ route('fixed-deposit-mode.search') }}" method="post">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="ps-form__option">
                                    <button type="button" class="ps-btn filter search_type @if(isset($search_filter['filter']) && $search_filter['filter']=='Interest') active @endif"><input type="radio" name="filter" value="Interest" style="opacity: 0;position: absolute;" @if(isset($search_filter['filter']) && $search_filter['filter']=='Interest') checked @endif>Interest</button>
                                    <button type="button" class="ps-btn filter search_type @if(isset($search_filter['filter']) && $search_filter['filter']=='Placement') active @elseif(empty($search_filter)) active @endif"><input type="radio" name="filter" value="Placement" style="opacity: 0;position: absolute;" @if(isset($search_filter['filter']) && $search_filter['filter']=='Placement') checked @elseif(empty($search_filter)) checked @endif>Placement</button>
                                    <button type="button" class="ps-btn filter search_type @if(isset($search_filter['filter']) && $search_filter['filter']=='Tenor') active @endif"><input type="radio" name="filter" value="Tenor" style="opacity: 0;position: absolute;" @if(isset($search_filter['filter']) && $search_filter['filter']=='Tenor') checked @endif>Tenor</button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="row ps-col-tiny">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group form-group--nest">
                                            <div class="form-group__content"><span class="prefix_holder">@if(isset($search_filter['filter']) && $search_filter['filter']=='Placement')$@elseif(!isset($search_filter['filter']))$@endif</span>
                                                <input class="form-control" name="search_value" type="text" placeholder="" value="{{ isset($search_filter['search_value']) ? $search_filter['search_value'] : '' }}">
                                            </div>
                                            <button type="submit">Go</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <select class="form-control" name="sort_by">
                                            <option value="">Sort by</option>
                                            <option value="1" @if(isset($search_filter['sort_by']) && $search_filter['sort_by']==1) selected @endif>1</option>
                                            <option value="1" @if(isset($search_filter['sort_by']) && $search_filter['sort_by']==2) selected @endif>2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if(count($promotion_products))                
            <div class="ps-slider--feature-product nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true"
                 data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="4"
                 data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4"
                 data-owl-duration="1000" data-owl-mousedrag="on"
                 data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;"
                 data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                 @foreach($promotion_products as $promotion_product)
                <div class="ps-block--short-product second" data-mh="product"><img src="{{ asset($promotion_product->brand_logo) }}" alt="">
                    <h4>up to <strong> 1.3%</strong></h4>

                    <div class="ps-block__info">
                        <p><strong> rate: </strong>1.3%</p>

                        <p><strong>Min:</strong> SGD $20,000</p>

                        <p class="highlight">12 Months</p>
                    </div>
                    <a class="ps-btn" href="#">More info</a>
                </div>
                @endforeach
            </div>
            @endif
            <div class="ps-block--legend-table">
                <div class="ps-block__header">
                    <h3>Legend table</h3>
                </div>
                <div class="ps-block__content">
                    <p><img src="{{ asset('img/icons/ff.png') }}" alt="">= Fresh funds</p>

                    <p><img src="{{ asset('img/icons/ef.png') }}" alt="">= example funds</p>

                    <p><img src="{{ asset('img/icons/cx.png') }}" alt="">= example funds</p>
                </div>
            </div>
            @if(count($promotion_products))
                @foreach($promotion_products as $promotion_product)
                @php
                    $product_tenures = json_decode($promotion_product->product_tenure);
                    $product_range = json_decode($promotion_product->product_range);
                @endphp
                <div class="ps-product featured-1">
                    <div class="ps-product__header"><img src="{{ $promotion_product->brand_logo }}" alt="">

                        <div class="ps-product__promo">
                            <p><span class="highlight"> Promo: </span> {{ date('M d, Y', strtotime($promotion_product->promotion_start)) . ' to ' . date('M d, Y', strtotime($promotion_product->promotion_end)) }}</p>

                            <p class="text-uppercase">
                                @php
                                    $start_date = new DateTime(date("Y-m-d", strtotime("now")));
                                    $end_date = new DateTime(date("Y-m-d", strtotime($promotion_product->promotion_end)));
                                    $interval = date_diff($end_date, $start_date);
                                    echo $interval->format('%R%a days left');
                                @endphp
                             </p>
                        </div>
                    </div>
                    <div class="ps-product__content">
                        @if(count($promotion_product->ads_placement))
                        @php
                            $ads = json_decode($promotion_product->ads_placement);
                            if(!empty($ads[0]->ad_image_horizontal)) {
                        @endphp
                        <div class="ps-product__poster"><a href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"><img src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}" alt=""></a></div>
                        @php } @endphp
                        @endif
                        <div class="ps-product__table">
                            <div class="ps-table-wrap">
                                <table class="ps-table ps-table--product">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Account</th>
                                        @foreach($product_range as $tenure)
                                        @php
                                        $key = array();
                                        $days_type = \Helper::days_or_month_or_year($tenure->tenure_type, $tenure->tenure);
                                        @endphp
                                        <th>{{ $tenure->tenure . ' ' . $days_type }}</th>
                                        @endforeach

                                        @foreach($product_range as $range_key => $range)
                                        @if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor')
                                            @if($search_filter['search_value']==$range->tenure)
                                            @php
                                            $key[] = $range_key;
                                            @endphp
                                            @endif
                                        @endif
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product_range as $range)
                                        
                                    <tr class="
                                    @if(isset($search_filter['filter']) && ($search_filter['filter']=='Placement'))
                                        @if(isset($search_filter['search_value']) && ($search_filter['search_value']>=$range->min_range && $search_filter['search_value']<=$range->max_range)) highlight 
                                        @endif
                                    @endif">
                                        <td><img src="{{ asset('img/icons/ff.png') }}" alt=""></td>
                                        <td>{{ '$' . $range->min_range . 'k - $' . $range->max_range . 'k' }}</td>
                                        @foreach($range->bonus_interest as $bonus_key => $bonus_interest)
                                        <td class="@if(isset($search_filter['search_value']) && $search_filter['filter']=='Interest' && $search_filter['search_value']==$bonus_interest) highlight 
                                        @endif
                                        @if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor' && in_array($bonus_key, $key)) highlight 
                                        @endif
                                        ">{{ $bonus_interest . '%' }}</td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if(count($promotion_product->ads_placement))
                        @php
                            $ads = json_decode($promotion_product->ads_placement);
                            if(!empty($ads[1]->ad_image_vertical)) {
                        @endphp
                        <div class="ps-product__poster">
                            <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}"><img src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}" alt=""></a>
                        </div>
                        <div class="clearfix"></div>
                        @php } @endphp
                        @endif
                        <div class="ps-product__panel">                            
                            @foreach($product_range as $key => $range)                                
                                @php              
                                $tenure_count = count($range->bonus_interest);
                                if(isset($search_filter['search_value']) && ($search_filter['filter']=='Placement') && ($search_filter['search_value']>=$range->min_range && $search_filter['search_value']<=$range->max_range)) {
                                    $placement_value = $range->max_range;
                                    if(isset($search_filter['search_value']) && $search_filter['filter']=='Placement') {
                                        $placement_value = $search_filter['search_value'];
                                    }                        
                                    $P = $placement_value;
                                    @endphp
                                    <h4>Possible interest(s) earned for SGD ${{ $P }}k</h4>
                                    @php
                                    for($i=0;$i<$tenure_count;$i++) {
                                        $BI = $range->bonus_interest[$i];
                                        $TM = $product_range[$i]->tenure;
                                        $calc = eval('return '.$promotion_product->formula.';');
                                        $days_type = \Helper::days_or_month_or_year($product_range[$i]->tenure_type, $product_range[$i]->tenure);
                                    @endphp
                                        <p><strong>{{ $TM . ' ' . $days_type }}
                                        </strong> - ${{ $calc }}k ({{ $range->bonus_interest[$i] }}%)</p>
                                    @php
                                    }
                                }
                                elseif(!isset($search_filter['search_value'])) {
                                    $placement_value = $range->max_range;
                                    if(isset($search_filter['search_value']) && $search_filter['filter']=='Placement') {
                                        $placement_value = $search_filter['search_value'];
                                    }                        
                                    $P = $placement_value;
                                    @endphp
                                    @if($key==0)
                                    <h4>Possible interest(s) earned for SGD ${{ $P }}k</h4>
                                    @endif
                                    @php
                                    if($key==0) {                      
                                    for($i=0;$i<$tenure_count;$i++) {
                                        $BI = ($P/100*$range->bonus_interest[$i]);
                                        $TM = $product_range[$i]->tenure;
                                        $calc = eval('return '.$promotion_product->formula.';');
                                        $days_type = \Helper::days_or_month_or_year($product_range[$i]->tenure_type, $product_range[$i]->tenure);
                                    @endphp
                                        <p><strong>{{ $TM . ' ' . $days_type }}
                                        </strong> - ${{ $calc }}k ({{ $range->bonus_interest[$i] }}%)</p>
                                    @php
                                    }}
                                }
                                @endphp
                            @endforeach
                        </div>
                        <div class="clearfix"></div>
                        <div class="ps-product__detail">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                            <h4 class="ps-product__heading">Criteria</h4>
                                            <ul class="ps-list--arrow-circle">
                                                <li>Fresh funds #</li>
                                                <li>RHB Fixed Deposit account</li>
                                                <li>Placement done at Branch</li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                            <h4 class="ps-product__heading">Keypoints</h4>
                                            <ul class="ps-list--arrow-circle">
                                                <li>Receive interest upfront</li>
                                                <li>Deposit into main account</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                    <div class="ps-product__actions"><a class="ps-btn ps-btn--black" href="#">Main
                                            Page</a><a
                                                class="ps-btn ps-btn--outline" href="#">T&C</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                        class="fa fa-angle-down"></i></a></div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
    <script type="text/javascript">
        $(".search_type").on("click", function() {
            var prefix_holder = '';
            $(".search_type").removeClass("active");
            $("input[type='radio']").prop("checked", false);
            $(this).addClass("active").find("input[type='radio']").prop("checked", true);
            var value = $(this).find("input[type='radio']").val();
            if(value=='Placement') {
                prefix_holder = '$';
            }
            $("span.prefix_holder").text(prefix_holder);
        })
    </script>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
