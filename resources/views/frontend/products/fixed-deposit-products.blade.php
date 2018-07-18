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
        <div class="container">
            <div class="ps-block--deposit-filter">
                <form class="ps-form--filter" action="{{ route('fixed-deposit-mode.search') }}" method="post">
                    <div class="ps-block__header">
                        <div class="owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
                             data-owl-gap="10" data-owl-nav="false" data-owl-dots="false" data-owl-item="15"
                             data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1"
                             data-owl-duration="1000" data-owl-mousedrag="on">
                            @if(count($brands))
                                @foreach($brands as $brand)
                                    <span class="brand">
                                        <input type="radio" name="brand_id"
                                               value="@if(!empty($search_filter['brand_id']) && $brand->id==$search_filter['brand_id']) {{ $search_filter['brand_id'] }} @else {{ $brand->id }} @endif"
                                               style="opacity: 0;position: absolute;"
                                               @if(!empty($search_filter['brand_id']) && $brand->id==$search_filter['brand_id']) checked @endif>
                                        <img src="{{ asset($brand->brand_logo) }}" width="100px"
                                             class="brand_img @if(!empty($search_filter['brand_id']) && $brand->id==$search_filter['brand_id']) selected_img @endif">
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="ps-block__content">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="ps-form__option">
                                    <button type="button"
                                            class="ps-btn filter search_type @if(isset($search_filter['filter']) && $search_filter['filter']=='Interest') active @endif">
                                        <input type="radio" name="filter" value="Interest"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($search_filter['filter']) && $search_filter['filter']=='Interest') checked @endif>Interest
                                    </button>
                                    <button type="button"
                                            class="ps-btn filter search_type @if(isset($search_filter['filter']) && $search_filter['filter']=='Placement') active @elseif(empty($search_filter)) active @endif">
                                        <input type="radio" name="filter" value="Placement"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($search_filter['filter']) && $search_filter['filter']=='Placement') checked
                                               @elseif(empty($search_filter)) checked @endif>Placement
                                    </button>
                                    <button type="button"
                                            class="ps-btn filter search_type @if(isset($search_filter['filter']) && $search_filter['filter']=='Tenor') active @endif">
                                        <input type="radio" name="filter" value="Tenor"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($search_filter['filter']) && $search_filter['filter']=='Tenor') checked @endif>Tenor
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="row ps-col-tiny">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                        <div class="form-group form-group--nest">
                                            <div class="form-group__content"><span class="prefix_holder">@if(isset($search_filter['filter']) && $search_filter['filter']=='Placement')
                                                        $@elseif(!isset($search_filter['filter']))$@endif</span>
                                                <input class="form-control" name="search_value" type="text"
                                                       placeholder=""
                                                       value="{{ isset($search_filter['search_value']) ? $search_filter['search_value'] : '' }}">
                                            </div>
                                            <button type="submit">Go</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                        <select class="form-control" name="sort_by">
                                            <option value="">Sort by</option>
                                            <option value="1"
                                                    @if(isset($search_filter['sort_by']) && $search_filter['sort_by']==1) selected @endif>
                                                Minimum
                                            </option>
                                            <option value="2"
                                                    @if(isset($search_filter['sort_by']) && $search_filter['sort_by']==2) selected @endif>
                                                Maximum
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @if(count($promotion_products))
                <div class="ps-slider--feature-product nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true"
                     data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="5"
                     data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="5"
                     data-owl-duration="1000" data-owl-mousedrag="on"
                     data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;"
                     data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                    @php $i = 1; @endphp
                    @foreach($promotion_products as $promotion_product)
                        <div class="ps-block--short-product second @if($promotion_product->featured==1) highlight @endif"
                             data-mh="product"><img
                                    src="{{ asset($promotion_product->brand_logo) }}" alt="">
                            <h4>up to <strong> {{ $promotion_product->maximum_interest_rate }}%</strong></h4>

                            <div class="ps-block__info">
                                <p><strong> rate: </strong>1.3%</p>

                                <p><strong>Min:</strong> SGD ${{ $promotion_product->minimum_placement_amount }}</p>

                                <p class="highlight">{{ $promotion_product->promotion_period }} Months</p>
                            </div>
                            <a class="ps-btn" href="#{{ $i }}">More info</a>
                        </div>
                        @php $i++; @endphp
                    @endforeach
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
                        @endforeach
                    </div>
                </div>
            @endif
            @php
            //dd($ads);
            @endphp
            @if(count($promotion_products))

            @php $j = 1; @endphp
            @foreach($promotion_products as $promotion_product)
            @php
            $promotion_product_id = $promotion_product->promotion_product_id;
            $product_tenures = json_decode($promotion_product->product_tenure);
            $product_range = json_decode($promotion_product->product_range);
            $tenures = json_decode($promotion_product->tenure);
            $key = $interest_key = $sort_array = array();
            $ads = json_decode($promotion_product->ads_placement);
            @endphp
            @if($page->slug=='fixed-deposit-mode' && isset($ads[3]->ad_horizontal_image_popup_top))
            <div class="ps-poster-popup">
                <div class="close-popup">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
                <a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : '' }}" target="_blank"><img src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}" alt=""></a>
            </div>
            @endif
                    <div class="ps-product @if($promotion_product->featured==1) featured-1 @endif @if($page->slug=='fixed-deposit-mode' && isset($ads[3]->ad_horizontal_image_popup_top)) product-popup @endif" id="{{ $j }}">

                        <div class="ps-product__header"><img src="{{ asset($promotion_product->brand_logo) }}" alt="">
                            <?php
                            $todayStartDate = \Helper::startOfDayBefore();
                            $todayEndDate = \Helper::endOfDayAfter();
                            ?>
                            <div class="ps-product__promo">
                                <p>
                                    <span class="highlight"> Promo: </span>
                                    @if($promotion_product->promotion_end == null)
                                        ONGOING
                                    @elseif($promotion_product->promotion_end < $todayStartDate)
                                        ENDED
                                    @elseif($promotion_product->promotion_end > $todayStartDate)
                               {{ date('M d, Y', strtotime($promotion_product->promotion_start)) . ' to ' . date('M d, Y', strtotime($promotion_product->promotion_end)) }}
                                     @endif
                                </p>
                                    <p class="text-uppercase">
                                        <?php
                                        if ($promotion_product->promotion_end > $todayStartDate) {
                                            $start_date = new DateTime(date("Y-m-d", strtotime("now")));
                                            $end_date = new DateTime(date("Y-m-d",
                                                    strtotime($promotion_product->promotion_end)));
                                            $interval = date_diff($end_date, $start_date);
                                            echo $interval->format('%a days left');
                                        }
                                        ?>
                                </p>
                            </div>
                        </div>
                        <div class="ps-product__content">
                            @if(count($promotion_product->ads_placement))
                                @php
                                $ads = json_decode($promotion_product->ads_placement);
                                if(!empty($ads[0]->ad_image_horizontal)) {
                                @endphp
                                <div class="ps-product__poster"><a
                                            href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"><img
                                                src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
                                                alt=""></a></div>
                                @php } @endphp
                            @endif
                            <div class="ps-product__table">
                                <div class="ps-table-wrap">
                                    <table class="ps-table ps-table--product">
                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Account</th>
                                            @foreach($tenures as $tenor_key => $tenure)
                                                @php

                                                $days_type = \Helper::days_or_month_or_year(2, $tenure);
                                                @endphp
                                                <th>{{ $tenure . ' ' . $days_type }}</th>

                                                @if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor')
                                                    @if($search_filter['search_value']==$tenure)
                                                        @php

                                                        $key[] = $tenor_key;
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
                                                <td class="
                                                @if(isset($search_filter['search_value']) && $search_filter['filter']=='Interest' && in_array(sprintf('%.1f', $search_filter['search_value']), $range->bonus_interest)) highlight
                                                @endif
                                                @foreach($range->bonus_interest as $bonus_key => $bonus_interest)
                                                @if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor' && in_array($bonus_key, $key)) highlight
                                                    @endif
                                                @endforeach
                                                        ">{{ '$' . Helper::inThousand($range->min_range) . ' - $' . Helper::inThousand($range->max_range) }}</td>
                                                @foreach($range->bonus_interest as $bonus_key => $bonus_interest)
                                                    <td class="
                                                    @if(isset($search_filter['search_value']) && $search_filter['filter']=='Interest' && sprintf('%.1f', $search_filter['search_value'])==$bonus_interest) highlight
                                                    @endif
                                                    @if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor' && in_array($bonus_key, $key)) highlight
                                                    @endif">@if($bonus_interest<=0)
                                                            - @else {{ $bonus_interest . '%' }} @endif </td>
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
                                    <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}" target="_blank"><img
                                                src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                alt=""></a>
                                </div>
                                <div class="clearfix"></div>
                                @php } @endphp
                            @endif
                            <div class="ps-product__panel">
                                @if(count($result_data))
                                    @foreach($result_data as $key => $result)
                                        @if($promotion_product_id==$key)
                                            @foreach($result['tenor'] as $key2 => $value)
                                                @php $type = Helper::days_or_month_or_year(2, $value); @endphp
                                                @if($key2==0)
                                                    <h4>Possible interest(s) earned for SGD
                                                        ${{ Helper::inThousand($result[$key2]['amount']) }}</h4>
                                                @endif
                                                <p><strong>{{ $value . ' ' . $type }}</strong>-
                                                    ${{ Helper::inThousand($result[$key2]['calc']) }}
                                                    ({{ $result[$key2]['interest'] . '%' }})</p>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="clearfix"></div>
                            @if(count($promotion_product->ads_placement))
                                @php
                                $ads = json_decode($promotion_product->ads_placement);
                                if(!empty($ads[2]->ad_horizontal_image_popup)) {
                                @endphp
                                <div class="ps-poster-popup">
                                    <div class="close-popup">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </div>

                                    <a href="#"><img src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}" alt=""  target="_blank"></a>

                                </div>
                                @php } @endphp
                            @endif
                            <div class="ps-product__detail">
                                {!! $promotion_product->product_footer !!}
                            </div>
                            <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                            class="fa fa-angle-down"></i></a></div>
                        </div>
                    </div>
                    @php $j++; @endphp
                @endforeach
            @endif
        </div>
    </div>
    <script type="text/javascript">
        $(".search_type").on("click", function () {
            var prefix_holder = '';
            $(".search_type").removeClass("active");
            $("input[name='filter']").prop("checked", false);
            $(this).addClass("active").find("input[name='filter']").prop("checked", true);
            var value = $(this).find("input[name='filter']").val();
            if (value == 'Placement') {
                prefix_holder = '$';
            }
            $("span.prefix_holder").text(prefix_holder);
        });

        $("img.brand_img").on("click", function () {
            if ($(this).prev().prop("checked")) {
                $("input[name='brand_id']").prop("checked", false);
                $("span.brand img").css("border", "none");
            }
            else {
                $("input[name='brand_id']").prop("checked", false);
                $("span.brand img").css("border", "none");
                $(this).prev().prop("checked", true);
                $(this).css("border", "1px solid #000");
            }
        });
    </script>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
