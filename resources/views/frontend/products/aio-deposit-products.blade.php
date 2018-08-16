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
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Payment</label>
                                    <input class="form-control" type="text" placeholder="" name="giro" id="giro"
                                           value="{{ isset($searchFilter['giro']) ? $searchFilter['giro'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Spending</label>
                                    <input class="form-control" type="text" placeholder="" name="spend" id='spend'
                                           value="{{ isset($searchFilter['spend']) ? $searchFilter['spend'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Wealth</label>
                                    <input class="form-control" type="text" placeholder="" name="wealth" id='wealth'
                                           value="{{ isset($searchFilter['wealth']) ? $searchFilter['wealth'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Loan</label>
                                    <input class="form-control" type="text" placeholder="" name="loan" id="loan"
                                           value="{{ isset($searchFilter['loan']) ? $searchFilter['loan'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="ps-form__option">
                                    <button type="button" style="width: calc((100% / 2) - 10px) !important;"
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Interest') active @endif">
                                        <input type="radio" name="filter" value="Interest"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Interest') checked @endif>Interest
                                    </button>
                                    <button type="button" style="width: calc((100% / 2) - 10px) !important;"
                                            class="ps-btn filter submit-search search_type @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Placement') active @elseif(empty($searchFilter)) active @endif">
                                        <input type="radio" name="filter" value="Placement"
                                               style="opacity: 0;position: absolute;"
                                               @if(isset($searchFilter['filter']) && $searchFilter['filter']=='Placement') checked
                                               @elseif(empty($searchFilter)) checked @endif>Placement
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                                <div class="row ps-col-tiny">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group form-group--nest">
                                            <div class="form-group__content">
                                                <input class="form-control only_numeric prefix_dollar" type="text" placeholder=""
                                                       name="search_value" id="search_value"
                                                       value="{{ isset($searchFilter['search_value']) ? $searchFilter['search_value'] : '' }}"/>
                                            </div>

                                            <button type="submit">Go</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12 ">
                                        <select class="form-control" name="sort_by">
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
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            @if($products->count())
                <div class="product-row-01 clearfix">
                    @php $i = 1;$featured = []; @endphp
                    @foreach($products as $product)
                        @if($product->featured==1)
                            @php $featured[] = $i; @endphp
                            <div class="product-col-01">
                                <div class="ps-slider--feature-product saving">
                                    <div class="ps-block--short-product second highlight" data-mh="product"><img
                                                src="{{ asset($product->brand_logo) }}" alt="">
                                        <h4>up to <strong> {{ $product->upto_interest_rate  }}%</strong>
                                        </h4>

                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>{{ $product->maximum_interest_rate }}%</p>

                                            <p><strong>Min:</strong> SGD
                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                            </p>

                                            <p class="highlight">{{ $product->promotion_period }} Months</p>
                                        </div>
                                        <a class="ps-btn" href="#{{ $i }}">More info</a>
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
                                        <h4>up to <strong> {{ $product->upto_interest_rate  }}%</strong>
                                        </h4>

                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>{{ $product->maximum_interest_rate }}%</p>

                                            <p><strong>Min:</strong> SGD
                                                ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                            </p>

                                            <p class="highlight">{{ $product->promotion_period }} Months</p>
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
                    //dd($products);
                    ?>
                    @if(count($products)>=4)
                        @if(count($ads_manage) && $ads_manage[0]->page_type==AIO_DEPOSIT_MODE && $j==4)
                            <div class="ps-poster-popup">
                                <!-- <div class="close-popup">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div> -->
                                <a href="{{ isset($ads_manage[0]->ad_link) ? $ads_manage[0]->ad_link : '#' }}"
                                   target="_blank"><img
                                            src="{{ isset($ads_manage[0]->ad_image) ? asset($ads_manage[0]->ad_image) : '' }}"
                                            alt=""></a>
                            </div>
                        @endif
                    @else
                        @if(count($ads_manage) && $ads_manage[0]->page_type==AIO_DEPOSIT_MODE && $j==1)
                            <div class="ps-poster-popup">
                                <!-- <div class="close-popup">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div> -->
                                <a href="{{ isset($ads_manage[0]->ad_link) ? $ads_manage[0]->ad_link : '#' }}"
                                   target="_blank"><img
                                            src="{{ isset($ads_manage[0]->ad_image) ? asset($ads_manage[0]->ad_image) : '' }}"
                                            alt=""></a>
                            </div>
                        @endif
                    @endif
                    @if($page->slug==AIO_DEPOSIT_MODE && isset($ads[3]->ad_horizontal_image_popup_top))

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
                                <!-- INDIVIDUAL CRITERIA BASE -->
                        @if($product->formula_id==ALL_IN_ONE_ACCOUNT_F1)
                            <div class="ps-product ps-product--2 @if($product->featured==1) featured-1 @endif"
                                 id="{{ $j }}">
                                <div class="ps-product__header"><img src="{{ asset($product->brand_logo) }}"
                                                                     alt="">

                                    <div class="ps-product__action"><a class="ps-btn ps-btn--red"
                                                                       href="{{$product->apply_link}}">Apply
                                            Now</a></div>
                                </div>
                                <div class="ps-product__content">
                                    <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                                    @if(!empty($product->ads_placement))
                                        @php
                                        $ads = json_decode($product->ads_placement);
                                        if(!empty($ads[0]->ad_image_horizontal)) {
                                        @endphp
                                        <div class="ps-product__poster"><a
                                                    href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"
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
                                                <th>WEALTH</th>
                                                <th>BONUS(OPTIONAL)</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($productRanges as $range)
                                                @php
                                                //dd($range);
                                                @endphp
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
                                                    <td class="text-center @if($product->wealth_highlight==true ) highlight @endif">
                                                        Up to @if($range->bonus_interest_wealth<=0)
                                                            - @else  {{ $range->bonus_interest_wealth }}% @endif
                                                    </td>
                                                    <td class="text-left @if($product->bonus_highlight==true ) highlight @endif">@if($range->bonus_interest<=0)
                                                            - @else  {{ $range->bonus_interest }}% @endif
                                                        on
                                                        first {{ Helper::inThousand($range->first_cap_amount) }} if
                                                        account more
                                                        than {{ Helper::inThousand($range->bonus_amount) }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="text-left">Total Bonus Interest Earned for
                                                        ${{Helper::inThousand($range->placement)}}</td>
                                                    <td class="text-center @if($product->highlight==true ) highlight @endif"
                                                        colspan="5">
                                                        @if($range->placement > $range->first_cap_amount)
                                                            First
                                                            ${{ Helper::inThousand($range->first_cap_amount) }} -
                                                            ${{ Helper::inThousand(($range->first_cap_amount*($product->total_interest/100))) }}
                                                            (
                                                            {{ $product->total_interest }}%), next
                                                            ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
                                                            -
                                                            ${{ Helper::inThousand((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
                                                            ({{ $range->bonus_interest_remaining_amount }}%) Total =
                                                            ${{ Helper::inThousand($product->interest_earned) }}
                                                        @else
                                                            Total =
                                                            ${{ Helper::inThousand($product->interest_earned) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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
                                               href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : '#'}}"><img
                                                        src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                        alt="" target="_blank"></a>

                                        </div>
                                        @php } @endphp
                                    @endif
                                    <div class="ps-product__detail">
                                        {!! $product->product_footer !!}
                                    </div>
                                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
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

                                        <div class="ps-product__action"><a class="ps-btn ps-btn--red"
                                                                           href="{{$product->apply_link}}">Apply
                                                Now</a></div>
                                    </div>
                                    <div class="ps-product__content">

                                        <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                                        @if(!empty($product->ads_placement))
                                            @php
                                            $ads = json_decode($product->ads_placement);
                                            if(!empty($ads[0]->ad_image_horizontal)) {
                                            @endphp
                                            <div class="ps-product__poster"><a
                                                        href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"
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
                                                    <th class="text-left">Criteria a <br/><span class="subtitle">(spend)</span></th>
                                                    <th class="text-left">Criteria b <br/><span class="subtitle">(Spend + Salary/Giro)</span></th>
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
                                                            -${{ Helper::inThousand($range->interest_earn) }}
                                                            ({{ $range->criteria }}%)
                                                        </td>
                                                        @if($key==0)
                                                            <td class="text-center  @if($product->highlight==true) highlight @endif"
                                                                rowspan="{{count($productRanges)}}">
                                                                ${{ Helper::inThousand($product->interest_earned) }}
                                                                <br> Effective Interest
                                                                Rate {{ $product->total_interest }}%
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
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
                                                   href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : '#'}}"><img
                                                            src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                            alt="" target="_blank"></a>

                                            </div>
                                            @php } @endphp
                                        @endif
                                        <div class="ps-product__detail">
                                            {!! $product->product_footer !!}
                                        </div>
                                        <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
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

                                            <div class="ps-product__action"><a class="ps-btn ps-btn--red"
                                                                               href="{{$product->apply_link}}">Apply
                                                    Now</a></div>
                                        </div>
                                        <div class="ps-product__content">
                                            <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                                            @if(!empty($product->ads_placement))
                                                @php
                                                $ads = json_decode($product->ads_placement);
                                                if(!empty($ads[0]->ad_image_horizontal)) {
                                                @endphp
                                                <div class="ps-product__poster"><a
                                                            href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"
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
                                                                <td colspan="1" class="text-left">Total Bonus Interest Earned for
                                                                    ${{ Helper::inThousand($range->placement) }}</td>
                                                                <td class=" text-center @if($product->highlight==true ) highlight @endif"
                                                                    colspan="9">

                                                                    @if($range->placement > $range->first_cap_amount)
                                                                        First
                                                                        ${{ Helper::inThousand($range->first_cap_amount) }}
                                                                        -
                                                                        ${{ Helper::inThousand(($range->first_cap_amount*($product->total_interest/100))) }}
                                                                        (
                                                                        {{ $product->total_interest }}%), next
                                                                        ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
                                                                        -
                                                                        ${{ Helper::inThousand((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
                                                                        ({{ $range->bonus_interest_remaining_amount }}%)
                                                                        Total =
                                                                        ${{ Helper::inThousand($product->interest_earned) }}
                                                                    @else
                                                                        Total =
                                                                        ${{ Helper::inThousand($product->interest_earned) }}
                                                                    @endif
                                                                </td>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="ps-product__detail">
                                                {!! $product->product_footer !!}
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
                                                       href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : '#'}}"><img
                                                                src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                                alt="" target="_blank"></a>

                                                </div>
                                                @php } @endphp
                                            @endif
                                            <div class="ps-product__footer"><a class="ps-product__more" href="#">More
                                                    Detail<i
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

                                                <div class="ps-product__action"><a class="ps-btn ps-btn--red"
                                                                                   href="{{$product->apply_link}}">Apply
                                                        Now</a></div>
                                            </div>
                                            <div class="ps-product__content">
                                                <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                                                @if(!empty($product->ads_placement))
                                                    @php
                                                    $ads = json_decode($product->ads_placement);
                                                    if(!empty($ads[0]->ad_image_horizontal)) {
                                                    @endphp
                                                    <div class="ps-product__poster"><a
                                                                href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"
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
                                                            <th>Criteria a (Salary + 1 category)</th>
                                                            <th>Criteria b (Salary + 2 OR more Cateogry)</th>
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
                                                                        <${{ Helper::inThousand($range->max_range+1) }}
                                                                    @elseif((count($productRanges)-1)==$key)
                                                                        >${{ Helper::inThousand($range->min_range) }}
                                                                    @else
                                                                        ${{ Helper::inThousand($range->min_range) }} TO
                                                                        <${{ Helper::inThousand($range->max_range+1) }} @endif</td>
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
                                                                        Total=
                                                                        ${{ Helper::inThousand($product->interest_earned).' ( '.$product->total_interest.'%) ' }}</td>
                                                                @endif
                                                            </tr>

                                                        @endforeach
                                                        </tbody>
                                                    </table>
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
                                                           href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : '#'}}"><img
                                                                    src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                                    alt="" target="_blank"></a>

                                                    </div>
                                                    @php } @endphp
                                                @endif
                                                <div class="ps-product__detail">
                                                    {!! $product->product_footer !!}
                                                </div>
                                                <div class="ps-product__footer"><a class="ps-product__more" href="#">More
                                                        Detail<i class="fa fa-angle-down"></i></a></div>
                                            </div>
                                        </div>
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
                                                <a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : '' }}"
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

                                                        <div class="ps-product__action"><a class="ps-btn ps-btn--red"
                                                                                           href="{{$product->apply_link}}">Apply
                                                                Now</a></div>
                                                    </div>
                                                    <div class="ps-product__content">
                                                        <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                                                        @if(!empty($product->ads_placement))
                                                            @php
                                                            $ads = json_decode($product->ads_placement);
                                                            if(!empty($ads[0]->ad_image_horizontal)) {
                                                            @endphp
                                                            <div class="ps-product__poster"><a
                                                                        href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"
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
                                                                    <th>WEALTH</th>
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
                                                                        <td class="text-center @if($product->wealth_highlight==true ) highlight @endif">
                                                                            Up to @if($range->bonus_interest_wealth<=0)
                                                                                - @else  {{ $range->bonus_interest_wealth }}
                                                                                % @endif
                                                                        </td>
                                                                        <td class="text-center @if($product->bonus_highlight==true ) highlight @endif">@if($range->bonus_interest<=0)
                                                                                - @else  {{ $range->bonus_interest }}
                                                                                % @endif
                                                                            on
                                                                            first {{ Helper::inThousand($range->first_cap_amount) }}
                                                                            if
                                                                            account more
                                                                            than {{ Helper::inThousand($range->bonus_amount) }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2">Total Bonus Interest Earned for
                                                                            ${{Helper::inThousand($range->placement)}}</td>
                                                                        <td class="text-center @if($product->highlight==true ) highlight @endif"
                                                                            colspan="4">
                                                                            @if($range->placement > $range->first_cap_amount)
                                                                                First
                                                                                ${{ Helper::inThousand($range->first_cap_amount) }}
                                                                                -
                                                                                ${{ Helper::inThousand(($range->first_cap_amount*($product->total_interest/100))) }}
                                                                                (
                                                                                {{ $product->total_interest }}%), next
                                                                                ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
                                                                                -
                                                                                ${{ Helper::inThousand((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
                                                                                ({{ $range->bonus_interest_remaining_amount }}
                                                                                %) Total =
                                                                                ${{ Helper::inThousand($product->interest_earned) }}
                                                                            @else
                                                                                Total =
                                                                                ${{ Helper::inThousand($product->interest_earned) }}
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
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
                                                                   href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : '#'}}"><img
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

                                                            <div class="ps-product__action"><a
                                                                        class="ps-btn ps-btn--red"
                                                                        href="{{$product->apply_link}}">Apply
                                                                    Now</a></div>
                                                        </div>
                                                        <div class="ps-product__content">

                                                            <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                                                            @if(!empty($product->ads_placement))
                                                                @php
                                                                $ads = json_decode($product->ads_placement);
                                                                if(!empty($ads[0]->ad_image_horizontal)) {
                                                                @endphp
                                                                <div class="ps-product__poster"><a
                                                                            href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"
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
                                                                                    ${{ Helper::inThousand($product->interest_earned) }}
                                                                                    <br> Effective Interest
                                                                                    Rate {{ $product->total_interest }}%
                                                                                </td>
                                                                            @endif
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
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
                                                                       href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : '#'}}"><img
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

                                                                <div class="ps-product__action"><a
                                                                            class="ps-btn ps-btn--red"
                                                                            href="{{$product->apply_link}}">Apply
                                                                        Now</a></div>
                                                            </div>
                                                            <div class="ps-product__content">
                                                                <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                                                                @if(!empty($product->ads_placement))
                                                                    @php
                                                                    $ads = json_decode($product->ads_placement);
                                                                    if(!empty($ads[0]->ad_image_horizontal)) {
                                                                    @endphp
                                                                    <div class="ps-product__poster"><a
                                                                                href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"
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
                                                                                <th>CRITERIA</th>
                                                                                <th>SALARY</th>
                                                                                <th>Giro</th>
                                                                                <th>SPEND</th>
                                                                                <th>
                                                                                    <div class="ps-checkbox">
                                                                                        <input class="form-control"
                                                                                               type="checkbox"
                                                                                               data-product-id="{{$product->product_id}}"
                                                                                               name="life_insurance"
                                                                                               data-status ="0"
                                                                                               onchange="changeCriteria(this);"
                                                                                               @if($product->life_insurance) checked=checked
                                                                                               @endif value="true"
                                                                                               id="life-insurance-{{$product->product_id}}"/>
                                                                                        <label for="life-insurance-{{$product->product_id}}">Life
                                                                                            Insurance</label>
                                                                                    </div>
                                                                                </th>
                                                                                <th>
                                                                                    <div class="ps-checkbox">
                                                                                        <input class="form-control"
                                                                                               type="checkbox"
                                                                                               onchange="changeCriteria(this);"
                                                                                               @if($product->housing_loan) checked=checked
                                                                                               @endif
                                                                                               name="housing_loan"
                                                                                               data-product-id="{{$product->product_id}}"
                                                                                               value="true" data-status ="0"
                                                                                               id="housing-loan-{{$product->product_id}}">
                                                                                        <label for="housing-loan-{{$product->product_id}}">Housing
                                                                                            Loan</label>
                                                                                    </div>
                                                                                </th>
                                                                                <th>
                                                                                    <div class="ps-checkbox">
                                                                                        <input class="form-control"
                                                                                               type="checkbox"
                                                                                               name="education_loan"
                                                                                               onchange="changeCriteria(this);"
                                                                                               data-product-id="{{$product->product_id}}"
                                                                                               value="true" data-status ="0"
                                                                                               id='education-loan-{{$product->product_id}}'
                                                                                               @if($product->education_loan) checked=checked @endif/>
                                                                                        <label for="education-loan-{{$product->product_id}}">Education
                                                                                            Loan</label>
                                                                                    </div>
                                                                                </th>
                                                                                <th>
                                                                                    <div class="ps-checkbox">
                                                                                        <input class="form-control"
                                                                                               type="checkbox"
                                                                                               onchange="changeCriteria(this);"
                                                                                               name="hire_loan"
                                                                                               value="true" data-status ="0"
                                                                                               data-product-id="{{$product->product_id}}"
                                                                                               id="hire-loan-{{$product->product_id}}"
                                                                                               @if($product->hire_loan) checked=checked @endif/>
                                                                                        <label for="hire-loan-{{$product->product_id}}">Hire
                                                                                            Purchase loan</label>
                                                                                    </div>
                                                                                </th>
                                                                                <th>
                                                                                    <div class="ps-checkbox">
                                                                                        <input class="form-control"
                                                                                               type="checkbox"
                                                                                               name="renovation_loan"
                                                                                               onchange="changeCriteria(this);"
                                                                                               data-product-id="{{$product->product_id}}"
                                                                                               value="true" data-status ="0"
                                                                                               id="renovation-loan-{{$product->product_id}}"
                                                                                               @if($product->renovation_loan) checked=checked @endif/>
                                                                                        <label for="renovation-loan-{{$product->product_id}}">Renovation
                                                                                            loan</label>
                                                                                    </div>
                                                                                </th>
                                                                                <th>
                                                                                    <div class="ps-checkbox">
                                                                                        <input class="form-control"
                                                                                               type="checkbox"
                                                                                               onchange="changeCriteria(this);"
                                                                                               name="unit_trust"
                                                                                               value="true" data-status ="0"
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
                                                                                    <td colspan="2">Total Bonus Interest
                                                                                        Earned for
                                                                                        ${{ Helper::inThousand($range->placement) }}</td>
                                                                                    <td class=" text-center @if($product->highlight==true ) highlight @endif"
                                                                                        colspan="8">

                                                                                        @if($range->placement > $range->first_cap_amount)
                                                                                            First
                                                                                            ${{ Helper::inThousand($range->first_cap_amount) }}
                                                                                            -
                                                                                            ${{ Helper::inThousand(($range->first_cap_amount*($product->total_interest/100))) }}
                                                                                            (
                                                                                            {{ $product->total_interest }}
                                                                                            %), next
                                                                                            ${{ Helper::inThousand(($range->placement-$range->first_cap_amount)) }}
                                                                                            -
                                                                                            ${{ Helper::inThousand((($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount))) }}
                                                                                            ({{ $range->bonus_interest_remaining_amount }}
                                                                                            %)
                                                                                            Total =
                                                                                            ${{ Helper::inThousand($product->interest_earned) }}
                                                                                        @else
                                                                                            Total =
                                                                                            ${{ Helper::inThousand($product->interest_earned) }}
                                                                                        @endif
                                                                                    </td>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </form>
                                                                </div>
                                                                <div class="ps-product__detail">
                                                                    {!! $product->product_footer !!}
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
                                                                           href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : '#'}}"><img
                                                                                    src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                                                                    alt="" target="_blank"></a>

                                                                    </div>
                                                                    @php } @endphp
                                                                @endif
                                                                <div class="ps-product__footer"><a
                                                                            class="ps-product__more" href="#">More
                                                                        Detail<i
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

                                                                    <div class="ps-product__action"><a
                                                                                class="ps-btn ps-btn--red"
                                                                                href="{{$product->apply_link}}">Apply
                                                                            Now</a></div>
                                                                </div>
                                                                <div class="ps-product__content">
                                                                    <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
                                                                    @if(!empty($product->ads_placement))
                                                                        @php
                                                                        $ads = json_decode($product->ads_placement);
                                                                        if(!empty($ads[0]->ad_image_horizontal)) {
                                                                        @endphp
                                                                        <div class="ps-product__poster"><a
                                                                                    href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' }}"
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
                                                                                            <${{ Helper::inThousand($range->max_range+1) }}
                                                                                        @elseif((count($productRanges)-1)==$key)
                                                                                            >${{ Helper::inThousand($range->min_range) }}
                                                                                        @else
                                                                                            ${{ Helper::inThousand($range->min_range) }}
                                                                                            TO
                                                                                            <${{ Helper::inThousand($range->max_range+1) }} @endif</td>
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
                                                                                            Total=
                                                                                            ${{ Helper::inThousand($product->interest_earned).' ( '.$product->total_interest.'%) ' }}</td>
                                                                                    @endif
                                                                                </tr>

                                                                            @endforeach
                                                                            </tbody>
                                                                        </table>
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
                                                                               href="{{isset($ads[2]->ad_link_horizontal_popup) ? asset($ads[2]->ad_link_horizontal_popup) : '#'}}"><img
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
                                                                            Detail<i class="fa fa-angle-down"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                    status:status
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
