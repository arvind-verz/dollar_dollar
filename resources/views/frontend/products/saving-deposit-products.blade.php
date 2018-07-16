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
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
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
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
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
            <div class="ps-slider--feature-product nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true"
                 data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="5"
                 data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="5"
                 data-owl-duration="1000" data-owl-mousedrag="on"
                 data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;"
                 data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                @php $i = 1; @endphp
                @foreach($products as $product)
                    <div class="ps-block--short-product second @if($product->featured==1) highlight @endif"
                         data-mh="product"><img
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
                @endforeach
            </div>
        @endif
        <div class="ps-block--legend-table">
            <div class="ps-block__header">
                <h3>Legend table</h3>
            </div>
            <div class="ps-block__content">
                <p><img src="img/icons/bonus.png" alt="">= eligible for bonus interest</p>
            </div>
        </div>

        @if($products->count())
            <?php $j = 1;?>
            @foreach($products as $product)
                <?php
                $ads = $product->ads;
                //dd($ads);
                ?>
                @if(isset($ads[3]))
                    <div class="ps-poster"><a
                                href="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? $ads[3]->ad_horizontal_image_popup_top : '' }}"><img
                                    src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
                                    alt=""></a></div>
                @endif
                <div class="ps-product  @if($product->featured==1) featured-1 @endif" id="{{ $j }}">
                    <div class="ps-product__header"><img src="{{ asset($product->brand_logo) }}" alt="">

                        <div class="ps-product__promo">
                            <p>
                                <span class="highlight"> Promo: </span> {{ date('M d, Y', strtotime($product->promotion_start)) . ' to ' . date('M d, Y', strtotime($product->promotion_end)) }}
                            </p>

                            <p class="text-uppercase">
                                {{-$product->remaining_days}} days left

                            </p>
                        </div>
                    </div>
                    <div class="ps-product__content">
                        @if(count($product->ads))
                            @if(!empty($ads[0]->ad_image_horizontal))

                                <div class="ps-product__poster"><a
                                            href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"><img
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
                                                        <td class="@if($productRange->placement_highlight==true ) highlight @endif">{{ '$' . $productRange->min_range . ' - $' . $productRange->max_range }}</td>
                                                        <td class="@if( $productRange->bonus_interest_highlight==true  ) highlight @endif">{{ $productRange->bonus_interest . '%' }}</td>
                                                        <td class="@if($productRange->board_interest_highlight==true ) highlight @endif">{{ $productRange->board_rate . '%' }}</td>
                                                        <td class="@if($productRange->total_interest_highlight==true ) highlight @endif">{{ ($productRange->bonus_interest+$productRange->board_rate). '%' }}</td>
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
                                            <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}"><img
                                                        src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                        alt=""></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php } ?>
                                    @endif
                                    <div class="ps-product__panel">
                                        <h4>Possible interest(s) earned for SGD ${{ $product->placement }}</h4>

                                        <h2>${{ $product->total_interest_earn }} <br>
                                                <span>
                                                    Total interest rate {{ $product->total_interest }}%
                                                </span>
                                        </h2>
                                    </div>
                                    <div class="clearfix"></div>
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
                                                            <td class="@if($productRange->placement_highlight==true ) highlight @endif">{{ '$' . $productRange->min_range . ' - $' . $productRange->max_range }}</td>
                                                            <td class="@if( $productRange->tenure_highlight==true  ) highlight @endif">{{ $productRange->tenor. ' Months' }}</td>
                                                            <td class="@if( $productRange->bonus_interest_highlight==true  ) highlight @endif">{{ $productRange->bonus_interest . '%' }}</td>
                                                            <td class="@if($productRange->board_interest_highlight==true ) highlight @endif">{{ $productRange->board_rate . '%' }}</td>
                                                            <td class="@if($productRange->total_interest_highlight==true ) highlight @endif">{{ ($productRange->bonus_interest+$productRange->board_rate). '%' }}</td>
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
                                                <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}"><img
                                                            src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                            alt=""></a>
                                            </div>
                                            <div class="clearfix"></div>
                                            <?php } ?>
                                        @endif
                                        <div class="ps-product__panel">
                                            <h4>Possible interest(s) earned for SGD ${{ $product->placement }}</h4>

                                            <h2>${{ $product->total_interest_earn }} <br>
                                                <span>
                                                    Total interest rate {{ $product->total_interest }}%
                                                </span>
                                            </h2>
                                        </div>
                                        <div class="clearfix"></div>
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
                                                                            <td rowspan="6" style="border: none; font-size: 30px; background-color: #faf9f9">{{ $productRange->sibor_rate. '%' }}</td>
                                                                        @endif
                                                                        @if($i==4)
                                                                            <td>TO</td>
                                                                        @elseif(!((4 < $i) && ($i < 11)))
                                                                            <td>{{ 'COUNTER ' . $i . ' - ' . ($i*0.1). '%' }}</td>
                                                                        @endif
                                                                        @if($i==4)
                                                                            <td>TO</td>
                                                                        @elseif(!((4 <= $i) && ($i <= 10)))
                                                                            <td>{{ (($i*0.1)+($productRange->sibor_rate)) . '%' }}</td>
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
                                                    <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}"><img
                                                                src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                alt=""></a>
                                                </div>
                                                <div class="clearfix"></div>
                                                <?php } ?>
                                            @endif
                                            <div class="ps-product__panel">
                                                <h4>Possible interest(s) earned for SGD ${{ $product->placement }}</h4>

                                                <h2>${{ $product->total_interest_earn }} <br>
                                                <span>
                                                    Total interest rate {{ $product->total_interest }}%
                                                </span>
                                                </h2>
                                            </div>
                                            <div class="clearfix"></div>
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
                                                                        - @endif{{ '$' . $productRange->max_range }}</td>
                                                                    <td>{{ $productRange->board_rate }}%

                                                                    </td>
                                                                    <td>{{ $productRange->bonus_interest }}%

                                                                    </td>
                                                                    <td>{{ $productRange->total_interest }}%

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
                                                        <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}"><img
                                                                    src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                                                    alt=""></a>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <?php } ?>
                                                @endif
                                                <div class="ps-product__panel">
                                                    <h4>Possible interest(s) earned for SGD
                                                        ${{ $product->placement }}</h4>

                                                    <h2>${{ $product->total_interest_earn }} <br>
                                                        {{-- <span>
                                                            Total interest rate {{ $product->total_interest }}%
                                                        </span>--}}
                                                    </h2>
                                                </div>
                                                <div class="clearfix"></div>
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
                                                                                <td class="">{{ '$' .$baseInterest }}</td>
                                                                            @endforeach

                                                                        @elseif($key==2)
                                                                            @foreach($product->additional_interests as $additionalInterest)
                                                                                <td>{{ '$' . $additionalInterest }}</td>
                                                                            @endforeach
                                                                        @elseif($key==3)
                                                                            <td colspan="{{count($product->months)}}"></td>
                                                                            <td>{{ '$' . $product->total_interest_earn }}
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
