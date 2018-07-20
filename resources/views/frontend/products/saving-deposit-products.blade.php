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
        <div class="container">
            <div class="ps-block--deposit-filter">
                <form class="ps-form--filter" action="{{ route('saving-deposit-mode.search') }}" method="post">
                    <div class="ps-block__header">
                        @if(count($brands))
                            @foreach($brands as $brand)
                                <span class="brand">
                            <input type="radio" name="brand_id" value="{{ $brand->id }}"
                                   style="opacity: 0;position: absolute;">
                            <img src="{{ asset($brand->brand_logo) }}" width="100px"
                                 class="brand_img @if(!empty($searchFilter['brand_id']) && $brand->id==$searchFilter['brand_id']) selected_img @endif">
                        </span>
                            @endforeach
                        @endif
                    </div>
                    <div class="ps-block__content">

                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="ps-form__option">
                                    <button type="button"
                                            class="ps-btn filter search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Interest') active @endif">
                                        <input type="radio" name="filter" value="Interest"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Interest') checked @endif>Interest
                                    </button>
                                    <button type="button"
                                            class="ps-btn filter search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Placement') active @elseif(empty($searchFilter)) active @endif">
                                        <input type="radio" name="filter" value="Placement"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Placement') checked
                                               @elseif(empty($searchFilter)) checked @endif>Placement
                                    </button>
                                    <button type="button"
                                            class="ps-btn filter search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Tenor') active @endif">
                                        <input type="radio" name="filter" value="Tenor"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Tenor') checked @endif>Tenor
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="row ps-col-tiny">
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 ">
                                        <div class="form-group form-group--nest">
                                            <div class="form-group__content"><span class="prefix_holder">@if(isset($searchFilter['filter']) && $searchFilter['filter']=='Placement')
                                                        $@elseif(!isset($searchFilter['filter']))$@endif</span>
                                                <input class="form-control" name="search_value" type="text"
                                                       placeholder=""
                                                       value="{{ isset($searchFilter['search_value']) ? $searchFilter['search_value'] : '' }}">
                                            </div>
                                            <button type="submit">Go</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                                        <select class="form-control" name="sort_by">
                                            <option value="">Sort by</option>
                                            <option value="1"
                                                    @if(isset($searchFilter['sort_by']) && $searchFilter['sort_by']==1) selected @endif>
                                                Minimum
                                            </option>
                                            <option value="2"
                                                    @if(isset($searchFilter['sort_by']) && $searchFilter['sort_by']==2) selected @endif>
                                                Maximum
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                </form>
            </div>
        </div>
        @if($products->count())
            <div class="product-row-01">
                @php $i = 1;$featured = []; @endphp
                @foreach($products as $product)
                    @if($product->featured==1)
                    @php $featured[] = $i; @endphp
                    <div class="product-col-01">
                        <div class="ps-slider--feature-product saving">
                          <div class="ps-block--short-product second highlight" data-mh="product"><img
                                src="{{ asset($product->brand_logo) }}" alt="">
                                <h4>up to <strong> {{ $product->maximum_interest_rate }}%</strong></h4>

                                <div class="ps-block__info">
                                    <p><strong> rate: </strong>1.3%</p>

                                    <p><strong>Min:</strong> SGD ${{ $product->minimum_placement_amount }}</p>

                                    <p class="highlight">{{ $product->promotion_period }} Months</p>
                                </div>
                                <a class="ps-btn" href="#{{ $i }}">More info</a>
                            </div>
                        </div>
                    </div>
                    @php $i++; @endphp
                    @endif
                @endforeach
                @php $i = 1;$featured_item = 5-count($featured); @endphp
                <div class="product-col-0{{ count($featured)+1 }}">
                    <div class="ps-slider--feature-product saving nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="{{ $featured_item }}" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="{{ $featured_item }}" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;" data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                        @php $i = 1; @endphp
                        @foreach($products as $product)
                            @if($product->featured==0)
                            <div class="ps-block--short-product second" data-mh="product"><img
                                        src="{{ asset($product->brand_logo) }}" alt="">
                                <h4>up to <strong> {{ $product->maximum_interest_rate }}%</strong></h4>

                                <div class="ps-block__info">
                                    <p><strong> rate: </strong>1.3%</p>

                                    <p><strong>Min:</strong> SGD ${{ $product->minimum_placement_amount }}</p>

                                    <p class="highlight">{{ $product->promotion_period }} Months</p>
                                </div>
                                <a class="ps-btn" href="#{{ $i }}">More info</a>
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
                //dd($ads);
                ?>
                @if($page->slug=='saving-deposit-mode' && isset($ads[3]->ad_horizontal_image_popup_top))
                    <div class="ps-poster-popup">
                        <div class="close-popup">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </div>
                        <a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : '' }}"
                           target="_blank"><img
                                    src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
                                    alt=""></a>
                    </div>
                @endif
                <div class="ps-product  @if($product->featured==1) featured-1 @endif @if($page->slug=='saving-deposit-mode' && isset($ads[3]->ad_horizontal_image_popup_top)) product-popup @endif" id="{{ $j }}">
                    <div class="ps-product__header"><img src="{{ asset($product->brand_logo) }}" alt="">

                        <?php
                        $todayStartDate = \Helper::startOfDayBefore();
                        $todayEndDate = \Helper::endOfDayAfter();
                        ?>
                        <div class="ps-product__promo">
                            <p>
                                <span class="highlight"> Promo: </span>
                                @if($product->promotion_end == null)
                                    ONGOING
                                @elseif($product->promotion_end < $todayStartDate)
                                    ENDED
                                @elseif($product->promotion_end > $todayStartDate)
                                    {{ date('M d, Y', strtotime($product->promotion_start)) . ' to ' . date('M d, Y', strtotime($product->promotion_end)) }}
                                @endif
                            </p>
                            <p class="text-uppercase">
                                <?php
                                if ($product->promotion_end > $todayStartDate) {
                                    $start_date = new DateTime(date("Y-m-d", strtotime("now")));
                                    $end_date = new DateTime(date("Y-m-d",
                                            strtotime($product->promotion_end)));
                                    $interval = date_diff($end_date, $start_date);
                                    echo $interval->format('%a days left');
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="ps-product__content">
                        @if(count($product->ads))
                            @if(!empty($ads[0]->ad_image_horizontal))

                                <div class="ps-product__poster"><a
                                            href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}" target="_blank"><img
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
                                                    <th>BONUS RATE</th>
                                                    <th>BOARD RATE</th>
                                                    <th>TOTAL INTEREST</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($product->product_ranges as $productRange)

                                                    <tr class="@if($productRange->placement_highlight==true &&  $productRange->placement_value==true ) highlight @endif">
                                                        <td class="@if($productRange->placement_highlight==true ) highlight @endif">{{ '$' . Helper::inThousand($productRange->min_range) . ' - $' . Helper::inThousand($productRange->max_range) }}</td>
                                                        <td class="@if( $productRange->bonus_interest_highlight==true  ) highlight @endif">@if($productRange->bonus_interest<=0)
                                                                - @else {{ $productRange->bonus_interest . '%' }} @endif</td>
                                                        <td class="@if($productRange->board_interest_highlight==true ) highlight @endif">@if($productRange->board_rate<=0)
                                                                - @else {{ $productRange->board_rate . '%' }} @endif </td>
                                                        <td class="@if($productRange->total_interest_highlight==true ) highlight @endif">
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
                                            <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}" target="_blank"><img
                                                        src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                        alt=""></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php } ?>
                                    @endif
                                    <div class="ps-product__panel">
                                        <h4>Possible interest(s) earned for SGD ${{ Helper::inThousand($product->placement) }}</h4>

                                        <h2> @if(($product->total_interest_earn)<=0)
                                                - @else ${{ Helper::inThousand($product->total_interest_earn) }} @endif<br>
                                                <span>
                                                    Total interest rate @if(($product->total_interest)<=0)
                                                        - @else {{ $product->total_interest }}% @endif
                                                </span>
                                        </h2>
                                    </div>
                                    <div class="clearfix"></div>
                                    @if(count($product->ads_placement))
                                        @php
                                        $ads = json_decode($product->ads_placement);
                                        if(!empty($ads[2]->ad_horizontal_image_popup)) {
                                        @endphp
                                        <div class="ps-poster-popup">
                                            <div class="close-popup">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>

                                            <a href="#"><img
                                                        src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                        alt="" target="_blank"></a>

                                        </div>
                                        @php } @endphp
                                    @endif
                                    @endif
                                            <!-- FORMULA 2 -->
                                    @if($product->promotion_formula_id==SAVING_DEPOSIT_F2)
                                        <div class="ps-product__table">
                                            <div class="ps-table-wrap">
                                                <table class="ps-table ps-table--product">
                                                    <thead>
                                                    <tr>
                                                        <th>DEPOSIT BALANCE TIER</th>
                                                        <th>TENOR</th>
                                                        <th>BONUS RATE</th>
                                                        <th>BOARD RATE</th>
                                                        <th>TOTAL INTEREST</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($product->product_ranges as $productRange)
                                                        <tr class="@if($productRange->placement_highlight==true &&  $productRange->placement_value==true ) highlight @endif">
                                                            <td class="@if($productRange->placement_highlight==true ) highlight @endif">{{ '$' . Helper::inThousand($productRange->min_range) . ' - $' . Helper::inThousand($productRange->max_range) }}</td>
                                                            <td class="@if( $productRange->tenure_highlight==true  ) highlight @endif">{{ $productRange->tenor. ' Months' }}</td>
                                                            <td class="@if( $productRange->bonus_interest_highlight==true  ) highlight @endif">@if(($product->bonus_interest)<=0)
                                                                    - @else {{ $productRange->bonus_interest . '%' }} @endif</td>
                                                            <td class="@if($productRange->board_interest_highlight==true ) highlight @endif">@if(($product->board_rate)<=0)
                                                                    - @else {{ $productRange->board_rate . '%' }} @endif</td>
                                                            <td class="@if($productRange->total_interest_highlight==true ) highlight @endif">@if(($productRange->bonus_interest+$productRange->board_rate)<=0)
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
                                                <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}" target="_blank"><img
                                                            src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                            alt=""></a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php } ?>
                                        @endif
                                        <div class="ps-product__panel">
                                            <h4>Possible interest(s) earned for SGD ${{ Helper::inThousand($product->placement) }}</h4>

                                            <h2>@if(($product->total_interest_earn)<=0)
                                                    - @else ${{ Helper::inThousand($product->total_interest_earn) }} @endif <br>
                                                <span>
                                                    Total interest rate @if(($product->total_interest)<=0)
                                                        - @else ${{ $product->total_interest }}% @endif
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="clearfix"></div>
                                        @if(count($product->ads_placement))
                                        @php
                                        $ads = json_decode($product->ads_placement);
                                        if(!empty($ads[2]->ad_horizontal_image_popup)) {
                                        @endphp
                                        <div class="ps-poster-popup">
                                            <div class="close-popup">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>

                                            <a href="#"><img
                                                        src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                        alt="" target="_blank"></a>

                                        </div>
                                        @php } @endphp
                                    @endif
                                        @endif
                                                <!-- FORMULA 3 -->
                                        @if($product->promotion_formula_id==SAVING_DEPOSIT_F3)
                                            <div class="ps-product__table">
                                                <div class="ps-table-wrap">
                                                    <table class="ps-table ps-table--product text-center">
                                                        <thead>
                                                        <tr>
                                                            <th>BASE RATE# (P.A.)</th>
                                                            <th>BONUS RATE^ (P.A.)</th>
                                                            <th>TOTAL INTEREST* (P.A.)</th>
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
                                                                            <td rowspan="6" style="border: none; font-size: 30px; background-color: #faf9f9"> @if(($productRange->sibor_rate)<=0)
                                                                                    - @else {{ $productRange->sibor_rate. '%' }} @endif</td>
                                                                        @endif
                                                                        @if($i==4)
                                                                            <td>TO</td>
                                                                        @elseif(!((4 < $i) && ($i < 11)))
                                                                            <td>{{ 'COUNTER ' . $i . ' - ' . ($i*0.1). '%' }}</td>
                                                                        @endif
                                                                        @if($i==4)
                                                                            <td>TO</td>
                                                                        @elseif(!((4 <= $i) && ($i <= 10)))
                                                                            <td> @if((($i*0.1)+($productRange->sibor_rate)) <=0)
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
                                                    <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}" target="_blank"><img
                                                                src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                alt=""></a>
                                                </div>
                                                <div class="clearfix"></div>
                                                <?php } ?>
                                            @endif
                                            <div class="ps-product__panel">
                                                <h4>Possible interest(s) earned for SGD ${{ Helper::inThousand($product->placement) }}</h4>

                                                <h2>@if($product->total_interest_earn <=0)
                                                        - @else ${{ Helper::inThousand($product->total_interest_earn) }} @endif   <br>
                                                <span>
                                                    Total interest rate  @if($product->total_interest <=0)
                                                        - @else {{ $product->total_interest }}% @endif
                                                </span>
                                                </h2>
                                            </div>
                                            <div class="clearfix"></div>
                                            @if(count($product->ads_placement))
                                        @php
                                        $ads = json_decode($product->ads_placement);
                                        if(!empty($ads[2]->ad_horizontal_image_popup)) {
                                        @endphp
                                        <div class="ps-poster-popup">
                                            <div class="close-popup">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>

                                            <a href="#"><img
                                                        src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                        alt="" target="_blank"></a>

                                        </div>
                                        @php } @endphp
                                    @endif
                                            @endif
                                                    <!-- FORMULA 4 -->
                                            @if($product->promotion_formula_id==SAVING_DEPOSIT_F4)
                                                <div class="ps-product__table">
                                                    <div class="ps-table-wrap">
                                                        <table class="ps-table ps-table--product text-center">
                                                            <thead>
                                                            <tr>
                                                                <th>Account Balance in Stash account</th>
                                                                <th>Base Interest/Prevailing Rate (PA)</th>
                                                                <th>Bonus Interest (PA)</th>
                                                                <th>Total Interest (PA)</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($product->product_ranges as $key => $productRange)
                                                                <tr class="@if($product->highlight>=$key) highlight @endif">
                                                                    <td>@if($key==0) 1st - @else NEXT
                                                                        - @endif{{ '$' . Helper::inThousand($productRange->max_range) }}</td>
                                                                    <td>@if($productRange->board_rate <=0 )
                                                                            - @else {{ $productRange->board_rate }}% @endif
                                                                    </td>
                                                                    <td>@if($productRange->bonus_interest <=0 )
                                                                            - @else {{ $productRange->bonus_interest }}% @endif

                                                                    </td>
                                                                    <td>@if($productRange->total_interest <=0 )
                                                                            - @else {{ $productRange->total_interest }}% @endif

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
                                                        <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}" target="_blank"><img
                                                                    src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <?php } ?>
                                                @endif
                                                <div class="ps-product__panel">
                                                    <h4>Possible interest(s) earned for SGD
                                                        ${{ Helper::inThousand($product->placement) }}</h4>

                                                    <h2>@if($product->total_interest_earn <=0 )
                                                            - @else ${{ Helper::inThousand($product->total_interest_earn) }} @endif   <br>
                                                        {{-- <span>
                                                            Total interest rate {{ $product->total_interest }}%
                                                        </span>--}}
                                                    </h2>
                                                </div>
                                                <div class="clearfix"></div>
                                                @if(count($product->ads_placement))
                                        @php
                                        $ads = json_decode($product->ads_placement);
                                        if(!empty($ads[2]->ad_horizontal_image_popup)) {
                                        @endphp
                                        <div class="ps-poster-popup">
                                            <div class="close-popup">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>

                                            <a href="#"><img
                                                        src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                        alt="" target="_blank"></a>

                                        </div>
                                        @php } @endphp
                                    @endif
                                                @endif

                                                        <!-- FORMULA 5 -->
                                                @if($product->promotion_formula_id==SAVING_DEPOSIT_F5 )

                                                    <div class="ps-product__table fullwidth">
                                                        <div class="ps-table-wrap">
                                                            <table class="ps-table ps-table--product">
                                                                <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    @foreach($product->months as $month)
                                                                        <th>{{ 'MONTH ' . $month }}</th>
                                                                    @endforeach
                                                                    <th>{{ 'END OF YEARS' }}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($product->row_headings as $key => $heading)
                                                                    <tr class="@if($product->highlight==true ) highlight @endif">
                                                                        <td>{{ $heading }}</td>
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
                                                                            <td colspan="{{count($product->months)}}"></td>
                                                                            <td>@if($product->total_interest_earn <=0 )
                                                                                    - @else {{ '$' . $product->total_interest_earn }} @endif
                                                                                {{-- <br/>
                                                                                 <span>
                                                                                     Total interest rate {{ $product->total_interest }}%
                                                                                 </span>--}}
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    @if(count($product->ads_placement))
                                        @php
                                        $ads = json_decode($product->ads_placement);
                                        if(!empty($ads[2]->ad_horizontal_image_popup)) {
                                        @endphp
                                        <div class="ps-poster-popup">
                                            <div class="close-popup">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </div>

                                            <a href="#"><img
                                                        src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                        alt="" target="_blank"></a>

                                        </div>
                                        @php } @endphp
                                    @endif
                                                @endif
                                                    

                                                <div class="ps-product__detail">
                                                    {!! $product->product_footer !!}
                                                </div>
                                                <div class="ps-product__footer"><a class="ps-product__more" href="#">More
                                                        Detail<i
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
