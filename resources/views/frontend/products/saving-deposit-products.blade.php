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

            <!-- Search form start -->
            <div class="ps-block--deposit-filter">
                <form class="ps-form--filter" id="search-form"
                      action="{{ URL::route('saving-deposit-mode.search') }}#logo-detail" method="post">
                    <div class="ps-block__header">
                        <div class="owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
                             data-owl-gap="10" data-owl-nav="false" data-owl-dots="false" data-owl-item="10"
                             data-owl-item-xs="3" data-owl-item-sm="5" data-owl-item-md="6" data-owl-item-lg="10"
                             data-owl-duration="1000" data-owl-mousedrag="on">
                            @if(count($brands))
                                @foreach($brands as $brand)
                                    <span class="brand ">
<input type="radio" name="brand_id"
       value="@if(!empty($searchFilter['brand_id']) && $brand->id==$searchFilter['brand_id']) {{ $searchFilter['brand_id'] }} @else {{ $brand->id }} @endif"
       style="opacity: 0;position: absolute;"
       @if(!empty($searchFilter['brand_id']) && $brand->id==$searchFilter['brand_id']) checked @endif>
<a href="{{ !empty($brand->brand_link) ? $brand->brand_link : 'javascript:void(0)' }}" target="_blank">
    <img src="{{ asset($brand->brand_logo) }}"
         style="padding-right:20px; min-width: 80px;"
         class="brand_img  @if(!empty($searchFilter['brand_id']) && $brand->id==$searchFilter['brand_id']) selected_img @endif">
</a>
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
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']==TENURE) active @endif">
                                        <input type="radio" name="filter" value="{{TENURE}}"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']==TENURE) checked @endif>tenure
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="row ps-col-tiny">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
                                        <div class="form-group form-group--nest">
                                            <div class="form-group__content">@if(isset($searchFilter['filter']) && $searchFilter['filter']=='Placement')
                                                @elseif(!isset($searchFilter['filter']))$@endif
                                                <input class="form-control prefix_dollar only_numeric"
                                                       name="search_value" type="text"
                                                       placeholder=""
                                                       value="{{ isset($searchFilter['search_value']) ? $searchFilter['search_value'] : '' }}">

                                            </div>
                                            <button type="submit">Go</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                        <div class="form-group  ">
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
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
<div class="form-group  ">
<a class="btn refresh form-control "
href="{{url(SAVING_DEPOSIT_MODE)}}/#logo-detail"> <i
class="fa fa-refresh"></i></a>
</div>
</div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Search form end -->
            @if(count($products))
                @include('productsInnerSlider')
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
                            @if($legend->page_type==SAVING_DEPOSIT)
                                <p><img src="{{ asset($legend->icon) }}" alt=""> = {{ $legend->title }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            @if($products->count())
                <?php $j = 1;?>
                @foreach($products as $product)
                    <?php
                    $ads = $product->ads;
                    //dd($product);
                    ?>
                    {{-- {{$product->total_interest}} {{$product->total_interest_earn}} {{$product->max_tenure}}--}}

                    @if($page->slug=='saving-deposit-mode' && isset($ads[3]->ad_horizontal_image_popup_top))
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
                    <div class="ps-product  @if($product->featured==1) featured-1 @endif "
                         id="p-{{ $j }}">
                        <div class="ps-product__header"><img src="{{ asset($product->brand_logo) }}" alt="">

                            <?php
                            $todayStartDate = \Helper::startOfDayBefore();
                            $todayEndDate = \Helper::endOfDayAfter();
                            ?>
                            <div class="ps-product__promo">
                                <p>
                                    <span class="highlight"> Promo: </span>
                                    @if($product->promotion_end == null)
                                        {{ONGOING}}
                                    @elseif($product->promotion_end < $todayStartDate)
                                        {{EXPIRED}}
                                    @elseif($product->promotion_end > $todayStartDate)
                                        {{UNTIL}} {{ date('d M Y', strtotime($product->promotion_end)) }}
                                    @endif
                                </p>
                                
                            </div>
                        </div>
                        <div class="ps-product__content">
                            <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                            @if(count($product->ads))
                                @if(!empty($ads[0]->ad_image_horizontal))

                                    <div class="ps-product__poster"><a
                                                href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
                                                target="_blank"><img
                                                    src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
                                                    alt=""></a></div>
                                    @endif
                                    @endif
                                            <!-- FORMULA 1 -->
                                    @if($product->promotion_formula_id==SAVING_DEPOSIT_F1)
                                        <div class="ps-product__table">
                                            <div class="ps-table-wrap">
                                                <table class="ps-table ps-table--product">
                                                    <thead>
                                                    <tr>
                                                        <th>DEPOSIT BALANCE TIER</th>
                                                        <th class="center">BONUS RATE</th>
                                                        <th class="center">BOARD RATE</th>
                                                        <th class="center">TOTAL INTEREST</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($product->product_ranges as $productRange)

                                                        <tr class="@if($productRange->placement_highlight==true &&  $productRange->placement_value==true ) highlight @endif">
                                                            <td class="@if($productRange->placement_highlight==true ) highlight @endif">{{ '$' . Helper::inThousand($productRange->min_range) . ' - $' . Helper::inThousand($productRange->max_range) }}</td>
                                                            <td class="center @if( $productRange->bonus_interest_highlight==true  ) highlight @endif">@if($productRange->bonus_interest<=0)
                                                                    - @else {{ $productRange->bonus_interest . '%' }} @endif</td>
                                                            <td class=" center @if($productRange->board_interest_highlight==true ) highlight @endif">@if($productRange->board_rate<=0)
                                                                    - @else {{ $productRange->board_rate . '%' }} @endif </td>
                                                            <td class="center @if($productRange->total_interest_highlight==true ) highlight @endif">
                                                                @if(($productRange->bonus_interest+$productRange->board_rate)<=0)
                                                                    - @else {{ ($productRange->bonus_interest+$productRange->board_rate) . '%' }} @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @if(count($product->ads))
                                            <?php
                                            if(!empty($ads[1]->ad_image_vertical)) {
                                            ?>
                                            <div class="ps-product__poster">
                                                <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                                   target="_blank"><img
                                                            src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                            alt=""></a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php } ?>
                                        @endif
                                        <div class="ps-product__panel">
                                            <h4>Possible interest(s) earned for SGD
                                                ${{ Helper::inThousand($product->placement) }}</h4>

                                            <h2> @if(($product->total_interest_earn)<=0)
                                                    - @else
                                                    ${{ Helper::inRoundTwoDecimal($product->total_interest_earn) }} @endif
                                                <br>
                                                <span>
                                                Total interest rate @if(($product->total_interest)<=0)
                                                        - @else {{ $product->total_interest }}%
                                                        @if($product->promotion_period!=ONGOING) P.A. for {{$product->duration}} {{\Helper::days_or_month_or_year(1, $product->duration)}} @else for 1 year @endif @endif
                                                </span>
                                            </h2>
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
                                                    <!-- FORMULA 2 -->
                                        @elseif($product->promotion_formula_id==SAVING_DEPOSIT_F2)
                                            <div class="ps-product__table">
                                                <div class="ps-table-wrap">
                                                    <table class="ps-table ps-table--product">
                                                        <thead>
                                                        <tr>
                                                            <th>DEPOSIT BALANCE TIER</th>
                                                            <th class="center combine-criteria-padding">Tenure</th>
                                                            <th class="center combine-criteria-padding">BONUS RATE
                                                            </th>
                                                            <th class="center combine-criteria-padding">BOARD RATE
                                                            </th>
                                                            <th class="center combine-criteria-padding">TOTAL
                                                                INTEREST
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($product->product_ranges as $key => $productRange)

                                                            <tr class="@if($productRange->placement_highlight==true &&  $productRange->placement_value==true ) highlight @endif">
                                                                <td class="@if($productRange->placement_highlight==true ) highlight @endif">{{ '$' . Helper::inThousand($productRange->min_range) . ' - $' . Helper::inThousand($productRange->max_range) }}</td>
                                                                @if($key==0)
                                                                    <td rowspan="{{count($product->product_ranges)}}"
                                                                        class="center color-border-none @if( $product->tenure_highlight = true) highlight @endif">{{ $productRange->tenure}} {{\Helper::days_or_month_or_year(2, $product->tenure)}}</td>
                                                                @endif
                                                                <td class=" center @if( $productRange->bonus_interest_highlight==true  ) highlight @endif">@if(($productRange->bonus_interest)<=0)
                                                                        - @else {{ $productRange->bonus_interest . '%' }} @endif</td>
                                                                <td class=" center @if($productRange->board_interest_highlight==true ) highlight @endif">@if(($productRange->board_rate)<=0)
                                                                        - @else {{ $productRange->board_rate . '%' }} @endif</td>
                                                                <td class="center @if($productRange->total_interest_highlight==true ) highlight @endif">@if(($productRange->bonus_interest+$productRange->board_rate)<=0)
                                                                        - @else {{ ($productRange->bonus_interest+$productRange->board_rate). '%' }} @endif</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @if(count($product->ads))
                                                <?php
                                                if(!empty($ads[1]->ad_image_vertical)) {
                                                ?>
                                                <div class="ps-product__poster">
                                                    <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                                       target="_blank"><img
                                                                src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                alt=""></a>
                                                </div>
                                                <div class="clearfix"></div>
                                                <?php } ?>
                                            @endif
                                            <div class="ps-product__panel">
                                                <h4>Possible interest(s) earned for SGD
                                                    ${{ Helper::inThousand($product->placement) }}</h4>

                                                <h2>@if(($product->total_interest_earn)<=0)
                                                        - @else
                                                        ${{ Helper::inRoundTwoDecimal($product->total_interest_earn) }} @endif
                                                    <br>
                                                        <span>
                                                        Total interest rate @if(($product->total_interest)<=0)
                                                                - @else {{ $product->total_interest }}% P.A.
                                                                for {{$product->duration}} {{\Helper::days_or_month_or_year(2, $product->duration)}} @endif
                                                        </span>
                                                </h2>
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
                                                        <!-- FORMULA 3 -->
                                            @elseif($product->promotion_formula_id==SAVING_DEPOSIT_F3)
                                                <div class="ps-product__table">
                                                    <div class="ps-table-wrap">
                                                        <table class="ps-table ps-table--product text-center">
                                                            <thead>
                                                            <tr>
                                                                <th class="center">BASE RATE# (P.A.)</th>
                                                                <th class="center">BONUS RATE^ (P.A.)</th>
                                                                <th class="center">TOTAL INTEREST* (P.A.)</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($product->product_ranges as $productRange)
                                                                <?php //$i = 1;   $counters = 12;?>
                                                                @for($i=1;$i<=12;$i++)
                                                                    @if(!((4 <= $i) && ($i < 11)))
                                                                        <tr class="@if($productRange->high_light==true ) highlight @endif">
                                                                            @endif
                                                                            @if($i==1)
                                                                                <td rowspan="6" class="center"
                                                                                    style="border: none; font-size: 30px; background-color: #faf9f9"> @if(($productRange->sibor_rate)<=0)
                                                                                        - @else {{ $productRange->sibor_rate. '%' }} @endif</td>
                                                                            @endif
                                                                            @if($i==4)
                                                                                <td class="center">TO</td>
                                                                            @elseif(!((4 < $i) && ($i < 11)))
                                                                                <td class="center">{{ 'COUNTER ' . $i . ' - ' . ($i*0.1). '%' }}</td>
                                                                            @endif
                                                                            @if($i==4)
                                                                                <td class="center">TO</td>
                                                                            @elseif(!((4 <= $i) && ($i <= 10)))
                                                                                <td class="center"> @if((($i*0.1)+($productRange->sibor_rate)) <=0)
                                                                                        - @else {{ (($i*0.1)+($productRange->sibor_rate)) . '%' }} @endif </td>
                                                                            @endif
                                                                            @if(!((4 <= $i) && ($i < 11)))
                                                                        </tr>
                                                                    @endif

                                                                @endfor
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                @if(count($product->ads))
                                                    <?php
                                                    if(!empty($ads[1]->ad_image_vertical)) {
                                                    ?>
                                                    <div class="ps-product__poster">
                                                        <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                                           target="_blank"><img
                                                                    src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <?php } ?>
                                                @endif
                                                <div class="ps-product__panel">
                                                    <h4>Possible interest(s) earned for SGD
                                                        ${{ Helper::inThousand($product->placement) }}</h4>

                                                    <h2>@if($product->total_interest_earn <=0)
                                                            - @else
                                                            ${{ Helper::inRoundTwoDecimal($product->total_interest_earn) }} @endif
                                                        <br>
                                                                <span>
                                                                Average interest rate @if($product->total_interest <=0)
                                                                        - @else {{ $product->total_interest }}%
                                                                        <sup>*</sup> throughout 1
                                                                        Year @endif
                                                                </span>


                                                    </h2>
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
                                                            <!-- FORMULA 4 -->
                                                @elseif($product->promotion_formula_id==SAVING_DEPOSIT_F4)
                                                    <div class="ps-product__table">
                                                        <div class="ps-table-wrap">
                                                            <table class="ps-table ps-table--product text-center">
                                                                <thead>
                                                                <tr>
                                                                    <th>Account Balance
                                                                    </th>
                                                                    <th class="center">Base Interest</th>
                                                                    <th class="center">Bonus Interest</th>
                                                                    <th class="center">Total Interest</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $prevMaxRange = 0;  $totalRange = 0; ?>
                                                                @foreach($product->product_ranges as $key => $productRange)
                                                                    <tr class="@if($product->highlight>=$key) highlight @endif">
                                                                        <td>@if($key==0) FIRST
                                                                            - {{ '$' . Helper::inThousand($productRange->max_range - $prevMaxRange) }}
                                                                            @elseif($key == (count($product->product_ranges) - 1))
                                                                                ABOVE {{ '$' . Helper::inThousand($prevMaxRange) }}
                                                                            @else NEXT
                                                                                - {{ '$' . Helper::inThousand($productRange->max_range - $prevMaxRange) }} @endif</td>
                                                                        <td class="center">@if($productRange->board_rate <=0 )
                                                                                - @else {{ $productRange->board_rate }}
                                                                                % @endif
                                                                        </td>
                                                                        <td class="center">@if($productRange->bonus_interest <=0 )
                                                                                - @else {{ $productRange->bonus_interest }}
                                                                                % @endif

                                                                        </td>
                                                                        <td class="center">@if($productRange->total_interest <=0 )
                                                                                - @else {{ $productRange->total_interest }}
                                                                                % @endif

                                                                        </td>
                                                                    </tr>
                                                                    <?php if ($key != (count($product->product_ranges) - 1)) {
                                                                    $prevMaxRange = $productRange->max_range;
                                                                    } ?>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @if(count($product->ads))
                                                        <?php
                                                        if(!empty($ads[1]->ad_image_vertical)) {
                                                        ?>
                                                        <div class="ps-product__poster">
                                                            <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                                               target="_blank"><img
                                                                        src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                        alt=""></a>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <?php } ?>
                                                    @endif
                                                    <div class="ps-product__panel">
                                                        <h4>Possible interest(s) earned for SGD
                                                            ${{ Helper::inThousand($product->placement) }}
                                                        </h4>

                                                        <h2>@if($product->total_interest_earn <=0 )
                                                                - @else
                                                                ${{ Helper::inRoundTwoDecimal($product->total_interest_earn) }} @endif
                                                            <br>
                                                                        <span>
                                                                        {{BASE_EFFECTIVE_RATE}}
                                                                        </span>

                                                        </h2>
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

                                                                <!-- FORMULA 5 -->
                                                    @elseif($product->promotion_formula_id==SAVING_DEPOSIT_F5 )

                                                        <div class="ps-product__table fullwidth">
                                                            <div class="ps-table-wrap"
                                                                 style="overflow-x:  scroll;">
                                                                <table class="ps-table ps-table--product">
                                                                    <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        @foreach($product->months as $month)
                                                                            <th class="center">{{ 'MONTH ' . $month }}</th>
                                                                        @endforeach
                                                                        <th class="center">{{ 'END OF 2 YEARS' }}</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach($product->row_headings as $key => $heading)
                                                                        <tr class="@if($product->highlight==true ) highlight @endif">
                                                                            <td style=" @if($key==3) background-color: #D3D3D3; @endif ">{{ $heading }}</td>
                                                                            @if($key==0)
                                                                                @foreach($product->monthly_saving_amount as $amount)
                                                                                    <td class="center">{{ '$' . Helper::inRoundTwoDecimal($amount) }}</td>
                                                                                @endforeach

                                                                            @elseif($key==1)
                                                                                @foreach($product->base_interests as $baseInterest )
                                                                                    <td class="center">@if($baseInterest <=0 )
                                                                                            - @else {{ '$' .Helper::inRoundTwoDecimal($baseInterest) }} @endif   </td>
                                                                                @endforeach
                                                                            @elseif($key==2)
                                                                                @foreach($product->additional_interests as $additionalInterest)
                                                                                    <td class="center">@if($additionalInterest <=0 )
                                                                                            - @else {{ '$' .Helper::inRoundTwoDecimal($additionalInterest) }} @endif  </td>
                                                                                @endforeach
                                                                            @elseif($key==3)
                                                                                <td style=" background-color: #D3D3D3; "
                                                                                    colspan="{{count($product->months)}}"></td>
                                                                                <td class="center"
                                                                                    style=" background-color: #D3D3D3; ">@if($product->total_interest_earn <=0 )
                                                                                        - @else {{ '$' . Helper::inRoundTwoDecimal($product->total_interest_earn) }} @endif
                                                                                    {{-- <br/>
                                                                                    <span>
                                                                                    Total interest rate {{ $product->total_interest }}% P.A.
                                                                                    </span>--}}
                                                                                    {{--<span>Based the Effective interest Rate</span>--}}

                                                                                </td>
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="ps-product__panel aio-product">
                                                            <h4>Possible interest(s) earned for SGD
                                                                ${{ Helper::inThousand($product->placement) }}</h4>

                                                            <h2> @if(($product->total_interest_earn)<=0)
                                                                    - @else
                                                                    ${{ Helper::inRoundTwoDecimal($product->total_interest_earn) }} @endif
                                                                <br>
                                                                                <span>
                                                                                Total interest rate @if(($product->total_interest)<=0)
                                                                                        - @else {{ $product->total_interest }}
                                                                                        % P.A.
                                                                                        for {{$product->duration}} {{\Helper::days_or_month_or_year(1, $product->duration)}} @endif
                                                                                </span>
                                                            </h2>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        @if(!empty($product->ads_placement))
                                                            @php
                                                            $ads = json_decode($product->ads_placement);
                                                            if(!empty($ads[2]->ad_horizontal_image_popup))
                                                            {
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
                                                    @elseif(empty($product->formula_id))
                                                        @if(!empty($product->ads_placement))
                                                            @php
                                                            $ads =
                                                            json_decode($product->ads_placement);
                                                            if(!empty($ads[2]->ad_horizontal_image_popup))
                                                            {
                                                            @endphp
                                                            <div class="ps-poster-popup">
                                                                <div class="close-popup">
                                                                    <i class="fa fa-times"
                                                                       aria-hidden="true"></i>
                                                                </div>

                                                                <a href="{{ isset($ads[2]->ad_link_horizontal_popup) ? $ads[2]->ad_link_horizontal_popup : 'javascript:void(0)' }}"><img
                                                                            src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                                            alt=""
                                                                            target="_blank"></a>

                                                            </div>
                                                            @php } @endphp
                                                        @endif
                                                    @endif


                                                    <div class="ps-product__detail">
                                                        {!! $product->product_footer !!}
                                                    </div>
                                                    <div class="ps-product__footer"><a
                                                                class="ps-product__more" href="#">More Details<i
                                                                    class="fa fa-angle-down"></i></a><a
                                                                class="ps-product__info sp-only"
                                                                href="#">More data<i
                                                                    class="fa fa-angle-down"></i></a>
                                                    </div>
                        </div>
                    </div>
                    @if(count($products)>=2)
                        @if(count($ads_manage) && $ads_manage[0]->page_type==SAVING_DEPOSIT_MODE && $j==2)
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
                        @if(count($ads_manage) && $ads_manage[0]->page_type==SAVING_DEPOSIT_MODE)
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
                <?php $j = 1;?>
                @foreach($remainingProducts as $product)
                    <?php
                    $ads = $product->ads;
                    ?>

                    @if($page->slug=='saving-deposit-mode' && isset($ads[3]->ad_horizontal_image_popup_top))
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
                    <div class="ps-product  @if($product->featured==1) featured-1 @endif "
                         id="r-{{ $j }}">
                        <div class="ps-product__header"><img src="{{ asset($product->brand_logo) }}" alt="">

                            <?php
                            $todayStartDate = \Helper::startOfDayBefore();
                            $todayEndDate = \Helper::endOfDayAfter();
                            ?>
                            <div class="ps-product__promo">
                                <p>
                                    <span class="highlight"> Promo: </span>
                                    @if($product->promotion_end == null)
                                        {{ONGOING}}
                                    @elseif($product->promotion_end < $todayStartDate)
                                        {{EXPIRED}}
                                    @elseif($product->promotion_end > $todayStartDate)
                                        {{UNTIL}} {{ date('d M Y', strtotime($product->promotion_end)) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="ps-product__content">
                            <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                            @if(count($product->ads))
                                @if(!empty($ads[0]->ad_image_horizontal))

                                    <div class="ps-product__poster"><a
                                                href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
                                                target="_blank"><img
                                                    src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
                                                    alt=""></a></div>
                                    @endif
                                    @endif
                                            <!-- FORMULA 1 -->
                                    @if($product->promotion_formula_id==SAVING_DEPOSIT_F1)
                                        <div class="ps-product__table">
                                            <div class="ps-table-wrap">
                                                <table class="ps-table ps-table--product">
                                                    <thead>
                                                    <tr>
                                                        <th>DEPOSIT BALANCE TIER</th>
                                                        <th class="center">BONUS RATE</th>
                                                        <th class="center">BOARD RATE</th>
                                                        <th class="center">TOTAL INTEREST</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($product->product_ranges as $productRange)

                                                        <tr class="@if($productRange->placement_highlight==true &&  $productRange->placement_value==true ) highlight @endif">
                                                            <td class="@if($productRange->placement_highlight==true ) highlight @endif">{{ '$' . Helper::inThousand($productRange->min_range) . ' - $' . Helper::inThousand($productRange->max_range) }}</td>
                                                            <td class="center @if( $productRange->bonus_interest_highlight==true  ) highlight @endif">@if($productRange->bonus_interest<=0)
                                                                    - @else {{ $productRange->bonus_interest . '%' }} @endif</td>
                                                            <td class="center @if($productRange->board_interest_highlight==true ) highlight @endif">@if($productRange->board_rate<=0)
                                                                    - @else {{ $productRange->board_rate . '%' }} @endif </td>
                                                            <td class="center @if($productRange->total_interest_highlight==true ) highlight @endif">
                                                                @if(($productRange->bonus_interest+$productRange->board_rate)<=0)
                                                                    - @else {{ ($productRange->bonus_interest+$productRange->board_rate) . '%' }} @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @if(count($product->ads))
                                            <?php
                                            if(!empty($ads[1]->ad_image_vertical)) {
                                            ?>
                                            <div class="ps-product__poster">
                                                <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                                   target="_blank"><img
                                                            src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                            alt=""></a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php } ?>
                                        @endif
                                        <div class="ps-product__panel">
                                            <h4>Possible interest(s) earned for SGD
                                                ${{ Helper::inThousand($product->placement) }}</h4>

                                            <p>
                                                <span class="nill"> {{ NILL }}</span><br/>
                                                {{NOT_ELIGIBLE}}
                                            </p>
                                        </div>
                                        <div class="clearfix"></div>
                                        @if(!empty($product->ads_placement))
                                            <?php
                                            $ads = json_decode($product->ads_placement);
                                            ?>
                                            @if(!empty($ads[2]->ad_horizontal_image_popup))
                                                <div class="ps-poster-popup">
                                                    <div class="close-popup">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </div>

                                                    <a target="_blank"
                                                       href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : 'javascript:void(0)'}}"><img
                                                                src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                                alt="" target="_blank"></a>

                                                </div>

                                                @endif
                                                @endif

                                                        <!-- FORMULA 2 -->
                                            @elseif($product->promotion_formula_id==SAVING_DEPOSIT_F2)
                                                <div class="ps-product__table">
                                                    <div class="ps-table-wrap">
                                                        <table class="ps-table ps-table--product">
                                                            <thead>
                                                            <tr>
                                                                <th>DEPOSIT BALANCE TIER</th>
                                                                <th class="center combine-criteria-padding">TENURE
                                                                </th>
                                                                <th class="center combine-criteria-padding">BONUS
                                                                    RATE
                                                                </th>
                                                                <th class="center combine-criteria-padding">BOARD
                                                                    RATE
                                                                </th>
                                                                <th class="center combine-criteria-padding">TOTAL
                                                                    INTEREST
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($product->product_ranges as $key => $productRange)
                                                                <tr class="@if($productRange->placement_highlight==true &&  $productRange->placement_value==true ) highlight @endif">
                                                                    <td class="@if($productRange->placement_highlight==true ) highlight @endif">{{ '$' . Helper::inThousand($productRange->min_range) . ' - $' . Helper::inThousand($productRange->max_range) }}</td>
                                                                    @if($key==0)
                                                                        <td rowspan="{{count($product->product_ranges)}}"
                                                                            class="center color-border-none">{{ $productRange->tenure}} {{\Helper::days_or_month_or_year(2, $product->tenure)}}</td>
                                                                    @endif
                                                                    <td class="center @if( $productRange->bonus_interest_highlight==true  ) highlight @endif">@if(($productRange->bonus_interest)<=0)
                                                                            - @else {{ $productRange->bonus_interest . '%' }} @endif</td>
                                                                    <td class="center @if($productRange->board_interest_highlight==true ) highlight @endif">@if(($productRange->board_rate)<=0)
                                                                            - @else {{ $productRange->board_rate . '%' }} @endif</td>
                                                                    <td class="center @if($productRange->total_interest_highlight==true ) highlight @endif">@if(($productRange->bonus_interest+$productRange->board_rate)<=0)
                                                                            - @else {{ ($productRange->bonus_interest+$productRange->board_rate). '%' }} @endif</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                @if(count($product->ads))
                                                    <?php
                                                    if(!empty($ads[1]->ad_image_vertical)) {
                                                    ?>
                                                    <div class="ps-product__poster">
                                                        <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                                           target="_blank"><img
                                                                    src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <?php } ?>
                                                @endif
                                                <div class="ps-product__panel">
                                                    <h4>Possible interest(s) earned for SGD
                                                        ${{ Helper::inThousand($product->placement) }}</h4>

                                                    <p>
                                                        <span class="nill"> {{ NILL }}</span><br/>
                                                        {{NOT_ELIGIBLE}}
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

                                                            <!-- FORMULA 3 -->
                                                @elseif($product->promotion_formula_id==SAVING_DEPOSIT_F3)
                                                    <div class="ps-product__table">
                                                        <div class="ps-table-wrap">
                                                            <table class="ps-table ps-table--product text-center">
                                                                <thead>
                                                                <tr>
                                                                    <th class="center">BASE RATE# (P.A.)</th>
                                                                    <th class="center">BONUS RATE^ (P.A.)</th>
                                                                    <th class="center">TOTAL INTEREST* (P.A.)
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($product->product_ranges as $productRange)
                                                                    <?php //$i = 1;   $counters = 12;?>
                                                                    @for($i=1;$i<=12;$i++)
                                                                        @if(!((4 <= $i) && ($i < 11)))
                                                                            <tr class="@if($productRange->high_light==true ) highlight @endif">
                                                                                @endif
                                                                                @if($i==1)
                                                                                    <td class="center"
                                                                                        rowspan="6"
                                                                                        style="border: none; font-size: 30px; background-color: #faf9f9"> @if(($productRange->sibor_rate)<=0)
                                                                                            - @else {{ $productRange->sibor_rate. '%' }} @endif</td>
                                                                                @endif
                                                                                @if($i==4)
                                                                                    <td class="center">TO</td>
                                                                                @elseif(!((4 < $i) && ($i < 11)))
                                                                                    <td class="center">{{ 'COUNTER ' . $i . ' - ' . ($i*0.1). '%' }}</td>
                                                                                @endif
                                                                                @if($i==4)
                                                                                    <td class="center">TO</td>
                                                                                @elseif(!((4 <= $i) && ($i <= 10)))
                                                                                    <td class="center"> @if((($i*0.1)+($productRange->sibor_rate)) <=0)
                                                                                            - @else {{ (($i*0.1)+($productRange->sibor_rate)) . '%' }} @endif </td>
                                                                                @endif
                                                                                @if(!((4 <= $i) && ($i < 11)))
                                                                            </tr>
                                                                        @endif

                                                                    @endfor
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    @if(count($product->ads))
                                                        <?php
                                                        if(!empty($ads[1]->ad_image_vertical)) {
                                                        ?>
                                                        <div class="ps-product__poster">
                                                            <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                                               target="_blank"><img
                                                                        src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                        alt=""></a>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <?php } ?>
                                                    @endif
                                                    <div class="ps-product__panel">
                                                        <h4>Possible interest(s) earned for SGD
                                                            ${{ Helper::inThousand($product->placement) }}</h4>

                                                        <p>
                                                            <span class="nill"> {{ NILL }}</span><br/>
                                                            {{NOT_ELIGIBLE}}
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
                                                                <!-- FORMULA 4 -->
                                                    @elseif($product->promotion_formula_id==SAVING_DEPOSIT_F4)
                                                        <div class="ps-product__table">
                                                            <div class="ps-table-wrap">
                                                                <table class="ps-table ps-table--product text-center">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Account Balance
                                                                        </th>
                                                                        <th class="center">Base Interest
                                                                        </th>
                                                                        <th class="center">Bonus Interest
                                                                        </th>
                                                                        <th class="center">Total Interest
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php $prevMaxRange = 0;  $totalRange = 0; ?>
                                                                    @foreach($product->product_ranges as $key => $productRange)
                                                                        <tr class="@if($product->highlight>=$key) highlight @endif">
                                                                            <td>@if($key==0) FIRST
                                                                                - {{ '$' . Helper::inThousand($productRange->max_range - $prevMaxRange) }}
                                                                                @elseif($key == (count($product->product_ranges) - 1))
                                                                                    ABOVE {{ '$' . Helper::inThousand($prevMaxRange) }}
                                                                                @else NEXT
                                                                                    - {{ '$' . Helper::inThousand($productRange->max_range - $prevMaxRange) }} @endif</td>
                                                                            <td class="center">@if($productRange->board_rate <=0 )
                                                                                    - @else {{ $productRange->board_rate }}
                                                                                    % @endif
                                                                            </td>
                                                                            <td class="center">@if($productRange->bonus_interest <=0 )
                                                                                    - @else {{ $productRange->bonus_interest }}
                                                                                    % @endif

                                                                            </td>
                                                                            <td class="center">@if($productRange->total_interest <=0 )
                                                                                    - @else {{ $productRange->total_interest }}
                                                                                    % @endif

                                                                            </td>
                                                                        </tr>
                                                                        <?php if ($key != (count($product->product_ranges) - 1)) {
                                                                        $prevMaxRange = $productRange->max_range;
                                                                        } ?>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        @if(count($product->ads))
                                                            <?php
                                                            if(!empty($ads[1]->ad_image_vertical)) {
                                                            ?>
                                                            <div class="ps-product__poster">
                                                                <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : 'javascript:void(0)' }}"
                                                                   target="_blank"><img
                                                                            src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                            alt=""></a>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <?php } ?>
                                                        @endif
                                                        <div class="ps-product__panel">
                                                            <h4>Possible interest(s) earned for SGD
                                                                ${{ Helper::inThousand($product->placement) }}
                                                            </h4>

                                                            <p>
                                                                <span class="nill"> {{ NILL }}</span><br/>
                                                                {{NOT_ELIGIBLE}}
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

                                                                    <!-- FORMULA 5 -->
                                                        @elseif($product->promotion_formula_id==SAVING_DEPOSIT_F5 )

                                                            <div class="ps-product__table fullwidth">
                                                                <div class="ps-table-wrap">
                                                                    <table class="ps-table ps-table--product">
                                                                        <thead>
                                                                        <tr>
                                                                            <th></th>
                                                                            @foreach($product->months as $month)
                                                                                <th>{{ 'MONTH ' . $month }}</th>
                                                                            @endforeach
                                                                            <th>{{ 'END OF 2 YEARS' }}</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        @foreach($product->row_headings as $key => $heading)
                                                                            <tr class="@if($product->highlight==true ) highlight @endif">
                                                                                <td style=" @if($key==3) background-color: #D3D3D3; @endif ">{{ $heading }}</td>
                                                                                @if($key==0)
                                                                                    @foreach($product->monthly_saving_amount as $amount)
                                                                                        <td class="">{{ '$' . $amount }}</td>
                                                                                    @endforeach

                                                                                @elseif($key==1)
                                                                                    @foreach($product->base_interests as $baseInterest )
                                                                                        <td class="">@if($baseInterest <=0 )
                                                                                                - @else {{ '$' .$baseInterest }} @endif   </td>
                                                                                    @endforeach
                                                                                @elseif($key==2)
                                                                                    @foreach($product->additional_interests as $additionalInterest)
                                                                                        <td>@if($additionalInterest <=0 )
                                                                                                - @else {{ '$' .$additionalInterest }} @endif  </td>
                                                                                    @endforeach
                                                                                @elseif($key==3)
                                                                                    <td style=" background-color: #D3D3D3; "
                                                                                        colspan="{{count($product->months)}}"></td>
                                                                                    <td style=" background-color: #D3D3D3; ">@if($product->total_interest_earn <=0 )
                                                                                            - @else {{ '$' . $product->total_interest_earn }} @endif
                                                                                        {{-- <br/>
                                                                                        <span>
                                                                                        Total interest rate {{ $product->total_interest }}% P.A.
                                                                                        </span>--}}
                                                                                        {{--<span>Based the effective interest rate</span>--}}

                                                                                    </td>
                                                                                @endif
                                                                            </tr>
                                                                        @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="ps-product__panel aio-product">
                                                                <h4>Possible interest(s) earned
                                                                    for SGD
                                                                    ${{ Helper::inThousand($product->placement) }}</h4>

                                                                <p>
                                                                    <span class="nill"> {{ NILL }}</span><br/>
                                                                    {{NOT_ELIGIBLE}}
                                                                </p>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            @if(!empty($product->ads_placement))
                                                                @php
                                                                $ads =
                                                                json_decode($product->ads_placement);
                                                                if(!empty($ads[2]->ad_horizontal_image_popup))
                                                                {
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
                                                        @elseif(empty($product->formula_id))
                                                            @if(!empty($product->ads_placement))
                                                                @php
                                                                $ads =
                                                                json_decode($product->ads_placement);
                                                                if(!empty($ads[2]->ad_horizontal_image_popup))
                                                                {
                                                                @endphp
                                                                <div class="ps-poster-popup">
                                                                    <div class="close-popup">
                                                                        <i class="fa fa-times"
                                                                           aria-hidden="true"></i>
                                                                    </div>

                                                                    <a href="{{ isset($ads[2]->ad_link_horizontal_popup) ? $ads[2]->ad_link_horizontal_popup : 'javascript:void(0)' }}"><img
                                                                                src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                                                alt=""
                                                                                target="_blank"></a>

                                                                </div>
                                                                @php } @endphp
                                                            @endif
                                                        @endif
                                                        <div class="ps-product__detail">
                                                            {!! $product->product_footer !!}
                                                        </div>
                                                        <div class="ps-product__footer"><a
                                                                    class="ps-product__more" href="#">More Details<i
                                                                        class="fa fa-angle-down"></i></a><a
                                                                    class="ps-product__info sp-only"
                                                                    href="#">More data<i
                                                                        class="fa fa-angle-down"></i></a>
                                                        </div>
                        </div>
                    </div>
                    @if($products->count()<2 && $remainingProducts->count()>=2)
                        @if(count($ads_manage) && $ads_manage[0]->page_type==SAVING_DEPOSIT_MODE && $j==2)
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
                        @if(count($ads_manage) && $ads_manage[0]->page_type==SAVING_DEPOSIT_MODE)
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
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
