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
        <div class="container">
            <div class="ps-block--image">
                <div class="ps-block__content">
                    <h3 class="ps-heading"><span> <i class="fa fa-area-chart"></i> All in One </span> Deposit</h3>

                    <p>Fixed Deposit offers higher interest rates than saving account whereby customer deposit a sum of
                        money for a fixed period of time, E.g. 6, 9, 12 months for a promised interest upon
                        maturity.</p>
                </div>
                <img src="img/block/fixed.png" alt="">
            </div>
            <div class="ps-block--deposit-filter mb-60">
                <div class="ps-block__content">
                    <form class="ps-form--filter" action="{{ route('aioa-deposit-mode.search') }}" method="post">

                        <h4>Fill in your need</h4>

                        <div class="ps-form__values">
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Salary</label>
                                    <input class="form-control" type="text" placeholder="" name="salary"
                                           value="{{ isset($search_filter['salary']) ? $search_filter['salary'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Payment</label>
                                    <input class="form-control" type="text" placeholder="" name="giro"
                                           value="{{ isset($search_filter['giro']) ? $search_filter['giro'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Spending</label>
                                    <input class="form-control" type="text" placeholder="" name="spend"
                                           value="{{ isset($search_filter['spend']) ? $search_filter['spend'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Wealth</label>
                                    <input class="form-control" type="text" placeholder="" name="wealth"
                                           value="{{ isset($search_filter['wealth']) ? $search_filter['wealth'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                            <div class="form-group--label">
                                <div class="form-group__content">
                                    <label>Loan</label>
                                    <input class="form-control" type="text" placeholder="" name="loan"
                                           value="{{ isset($search_filter['loan']) ? $search_filter['loan'] : '' }}">
                                </div>
                                <a class="ps-tooltip" href="#" data-tooltip="Enter tooltip here"><i
                                            class="fa fa-exclamation-circle"></i></a>
                            </div>
                        </div>
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
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 ">
                                        <div class="form-group form-group--nest">
                                            <div class="form-group__content"><span class="prefix_holder">@if(isset($search_filter['filter']) && $search_filter['filter']=='Placement')
                                                        $@elseif(!isset($search_filter['filter']))$@endif</span>
                                                <input class="form-control" type="text" placeholder=""
                                                       name="search_value"
                                                       value="{{ isset($search_filter['search_value']) ? $search_filter['search_value'] : '' }}"/>
                                            </div>
                                            <button type="submit">Go</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
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

                    </form>
                </div>
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
            <div class="ps-block--legend-table">
                <div class="ps-block__header">
                    <h3>Legend table</h3>
                </div>
                <div class="ps-block__content">
                    <p><img src="img/icons/cf.png" alt="">= Criteria Fulfilled</p>

                    <p><img src="img/icons/bonus.png" alt="">= eligible for bonus interest</p>
                </div>
            </div>

            @php
            $adspopup = json_decode($page->ads_placement);
            //dd($ads);
            $j=1;

            @endphp

            @if(count($promotion_products))

            @foreach($promotion_products as $promotion_product)
            <?php
            $ads = json_decode($promotion_product->ads_placement);
            $product_range = $promotion_product->product_range;

            ?>
                    <!-- INDIVIDUAL CRITERIA BASE -->
            @if($promotion_product->formula_id==ALL_IN_ONE_ACCOUNT_F1)
            @if($page->slug=='all-in-one-deposit-mode')
                    <!-- <div class="ps-poster"><a href="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? $ads[3]->ad_horizontal_image_popup_top : '' }}"><img src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}" alt=""></a></div> -->
            @endif
            <div class="ps-product ps-product--2">
                <div class="ps-product__header"><img src="{{ asset($promotion_product->brand_logo) }}" alt="">

                    {{--<div class="ps-product__action"><a class="ps-btn ps-btn--red" href="#">Apply
                            Now</a></div>--}}
                </div>
                <div class="ps-product__content">
                    <h4 class="ps-product__heading"><strong class="highlight">{{$promotion_product->product_name}}
                            :</strong> Fulfil each criteria and earn up
                        to {{ $promotion_product->maximum_interest_rate }}%</h4>

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
                            @foreach($product_range as $range)
                                @php
                                //dd($range);
                                @endphp
                                <tr>
                                    <td>Bonus Interest PA</td>
                                    <td class="text-center @if($promotion_product->salary_highlight==true ) highlight @endif"> @if($range->bonus_interest_salary<=0)
                                            - @else {{ $range->bonus_interest_salary }} % @endif

                                    </td>
                                    <td class="text-center @if($promotion_product->payment_highlight==true ) highlight @endif"> @if($range->bonus_interest_giro_payment<=0)
                                            - @else {{ $range->bonus_interest_giro_payment }} % @endif

                                    </td>
                                    <td class="text-center @if($promotion_product->spend_highlight==true ) highlight @endif">
                                        @if($range->bonus_interest_spend<=0)
                                            - @else {{ $range->bonus_interest_spend }} % @endif

                                    </td>
                                    <td class="text-center @if($promotion_product->wealth_highlight==true ) highlight @endif">
                                        Up to @if($range->bonus_interest_wealth<=0)
                                            - @else  {{ $range->bonus_interest_wealth }}% @endif
                                    </td>
                                    <td class="text-center @if($promotion_product->bonus_highlight==true ) highlight @endif">@if($range->bonus_interest<=0)
                                            - @else  {{ $range->bonus_interest }}% @endif
                                        on
                                        first {{ $range->first_cap_amount }} if account more
                                        than {{ $range->bonus_amount }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Total Bonus Interest Earned for ${{$range->placement}}</td>
                                    <td class="text-center @if($promotion_product->highlight==true ) highlight @endif"
                                        colspan="4">
                                        @if($range->placement > $range->first_cap_amount)
                                            First
                                            ${{ $range->first_cap_amount }} -
                                            ${{ ($range->first_cap_amount*($promotion_product->total_interest/100)) }} (
                                            {{ $promotion_product->total_interest }}%), next
                                            ${{ ($range->placement-$range->first_cap_amount) }} -
                                            ${{ (($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount)) }}
                                            ({{ $range->bonus_interest_remaining_amount }}%) Total =
                                            ${{ $promotion_product->interest_earned }}
                                        @else
                                            Total =
                                            ${{ $promotion_product->interest_earned }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="ps-product__detail">
                        {!! $promotion_product->product_footer !!}
                    </div>
                    <div class="ps-poster">
                        <a href="#"><img src="img/poster/medium/" alt=""></a>
                    </div>
                    <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                    class="fa fa-angle-down"></i></a></div>
                </div>
            </div>
            @endif

                    <!-- TIER BASE -->
            @if($promotion_product->formula_id==ALL_IN_ONE_ACCOUNT_F2)
                <div class="ps-product ps-product--2">
                    <div class="ps-product__header"><img src="{{ asset($promotion_product->brand_logo) }}" alt="">

                        {{--<div class="ps-product__action"><a class="ps-btn ps-btn--red" href="#">Apply
                                Now</a></div>--}}
                    </div>
                    <div class="ps-product__content">
                        <h4 class="ps-product__heading"><strong
                                    class="highlight">{{$promotion_product->product_name}} :</strong>
                            Meet either of Criteria and earn up to @if($promotion_product->maximum_interest_rate<=0)
                                - @else  {{ $promotion_product->maximum_interest_rate }}% @endif
                        </h4>

                        <div class="ps-product__poster"><img src="img/poster/product-2.jpg" alt=""></div>
                        <div class="ps-table-wrap">
                            <table class="ps-table ps-table--product ps-table--product-2">
                                <thead>
                                <tr>
                                    <th>Balance</th>
                                    <th>Criteria a (spend)</th>
                                    <th>Criteria b (Spend + Salary/Giro)</th>
                                    <th>Interest Earned for each Tier</th>
                                    <th>Total Interest Earned for {{ $promotion_product->placement }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($product_range as $key=>$range)
                                    <tr>
                                        <td class=" @if($promotion_product->highlight_index>=$key &&($promotion_product->criteria_b_highlight==true || $promotion_product->criteria_a_highlight==true) ) highlight @endif ">
                                            <?php
                                            if ($key == 0) {
                                                echo "First ";
                                                echo "$" . $range->max_range;
                                            } elseif ($range->above_range == true) {
                                                echo "Above ";
                                                echo "$" . ($range->min_range - 1);
                                            } else {
                                                echo "Next ";
                                                echo "$" . $range->max_range;
                                            }?>
                                        </td>
                                        <td class="text-center @if($promotion_product->highlight_index>=$key &&($promotion_product->criteria_a_highlight==true) ) highlight @endif">
                                            @if($range->bonus_interest_criteria_a<=0)
                                                - @else  {{ $range->bonus_interest_criteria_a }}% @endif
                                        </td>
                                        <td class="text-center @if($promotion_product->highlight_index>=$key &&($promotion_product->criteria_b_highlight==true) ) highlight @endif  ">
                                            @if($range->bonus_interest_criteria_b<=0)
                                                - @else  {{ $range->bonus_interest_criteria_b }}% @endif
                                        </td>
                                        <td>
                                            <?php
                                            if ($key == 0) {
                                                echo "First ";
                                                echo "$" . $range->max_range;
                                            } elseif ($range->above_range == true) {
                                                echo "REMAINING BALANCE ";
                                               // echo "$" . ($range->min_range - 1);
                                            } else {
                                                echo "Next ";
                                                echo "$" . $range->max_range;
                                            }?>
                                            -${{ $range->interest_earn }}
                                            ({{ $range->criteria }}%)
                                        </td>
                                        @if($key==0)
                                            <td class="text-center  @if($promotion_product->highlight==true) highlight @endif"
                                                rowspan="4">
                                                ${{ $promotion_product->interest_earned }}
                                                <br> Effective Interest
                                                Rate {{ $promotion_product->total_interest }}%
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="ps-product__detail">
                            {!! $promotion_product->product_footer !!}
                        </div>
                        <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                        class="fa fa-angle-down"></i></a></div>
                    </div>
                </div>
                @endif
                        <!-- COMBINE TIER BASE -->
                @if($promotion_product->formula_id==ALL_IN_ONE_ACCOUNT_F3)
                    <div class="ps-product ps-product--2">
                        <div class="ps-product__header"><img src="{{ asset($promotion_product->brand_logo) }}" alt="">

                            {{--<div class="ps-product__action"><a class="ps-btn ps-btn--red" href="#">Apply
                                    Now</a></div>--}}
                        </div>
                        <div class="ps-product__content">

                            <h4 class="ps-product__heading"><strong
                                        class="highlight">{{$promotion_product->product_name}} :</strong>
                                Fulfil up to 3 criteria and earn up
                                to @if($promotion_product->maximum_interest_rate<=0)
                                    - @else  {{ $promotion_product->maximum_interest_rate }}% @endif</h4>

                            <div class="ps-table-wrap">
                                <table class="ps-table ps-table--product ps-table--product-3">
                                    <thead>
                                    <tr>
                                        <th>CRITERIA</th>
                                        <th>SALARY</th>
                                        <th>Giro</th>
                                        <th>SPEND</th>
                                        {{--<th>
                                            <div class="ps-checkbox">
                                                <input class="form-control" type="checkbox" id="life-1"
                                                       name="life"/>
                                                <label for="life-1">Life Insurance</label>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="ps-checkbox">
                                                <input class="form-control" type="checkbox" id="life-2"
                                                       name="life"/>
                                                <label for="life-2">Housing Loan</label>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="ps-checkbox">
                                                <input class="form-control" type="checkbox" id="life-3"
                                                       name="life"/>
                                                <label for="life-3">Education Loan</label>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="ps-checkbox">
                                                <input class="form-control" type="checkbox" id="life-4"
                                                       name="life"/>
                                                <label for="life-4">Hire Purchase loan</label>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="ps-checkbox">
                                                <input class="form-control" type="checkbox" id="life-5"
                                                       name="life"/>
                                                <label for="life-5">Renovation loan</label>
                                            </div>
                                        </th>--}}
                                        <th>Life Insurance</th>
                                        <th>Housing Loan</th>
                                        <th>Education Loan</th>
                                        <th>Hire Purchase loan</th>
                                        <th>Renovation loan</th>
                                        <th>Unit trust</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($product_range as $range)
                                        <tr>
                                            <td>Bonus Interest PA</td>
                                            <td class="text-center @if($promotion_product->criteria_1==true ) highlight @endif"
                                                colspan="3">1 Criteria Met
                                                – @if($range->bonus_interest_criteria1<=0)
                                                    - @else  {{ $range->bonus_interest_criteria1 }}% @endif
                                            </td>
                                            <td class=" text-center @if($promotion_product->criteria_2==true ) highlight @endif"
                                                colspan="3">2 Criteria
                                                – @if($range->bonus_interest_criteria2<=0)
                                                    - @else  {{ $range->bonus_interest_criteria2 }}% @endif
                                            </td>
                                            <td class="text-center @if($promotion_product->criteria_3==true ) highlight @endif"
                                                colspan="3">3
                                                Criteria @if($range->bonus_interest_criteria3<=0)
                                                    - @else  {{ $range->bonus_interest_criteria3 }}% @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Total Bonus Interest Earned for
                                                ${{ $range->placement }}</td>
                                            <td class=" text-center @if($promotion_product->highlight==true ) highlight @endif"
                                                colspan="8">

                                                @if($range->placement > $range->first_cap_amount)
                                                    First
                                                    ${{ $range->first_cap_amount }} -
                                                    ${{ ($range->first_cap_amount*($promotion_product->total_interest/100)) }}
                                                    (
                                                    {{ $promotion_product->total_interest }}%), next
                                                    ${{ ($range->placement-$range->first_cap_amount) }} -
                                                    ${{ (($range->bonus_interest_remaining_amount/100)*($range->placement-$range->first_cap_amount)) }}
                                                    ({{ $range->bonus_interest_remaining_amount }}%) Total =
                                                    ${{ $promotion_product->interest_earned }}
                                                @else
                                                    Total =
                                                    ${{ $promotion_product->interest_earned }}
                                                @endif
                                            </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="ps-product__detail">
                                {!! $promotion_product->product_footer !!}
                            </div>
                            <div class="ps-poster">
                                <a href="#"><img src="img/poster/medium/" alt=""></a>
                            </div>
                            <div class="ps-product__footer"><a class="ps-product__more" href="#">More Detail<i
                                            class="fa fa-angle-down"></i></a></div>
                        </div>
                    </div>
                    @endif
                            <!-- DBS CRITERIA -->
                    @if($promotion_product->formula_id==ALL_IN_ONE_ACCOUNT_F4)

                        <div class="ps-product ps-product--2 no-border">
                            <div class="ps-product__header"><img src="{{ asset($promotion_product->brand_logo) }}"
                                                                 alt="">

                                {{--<div class="ps-product__action"><a class="ps-btn ps-btn--red" href="#">Apply
                                        Now</a></div>--}}
                            </div>
                            <div class="ps-product__content">
                                <h4 class="ps-product__heading"><strong
                                            class="highlight">{{$promotion_product->product_name}}: </strong> Meet
                                    either Criteria and earn up to {{$promotion_product->maximum_interest_rate}}%
                                </h4>

                                <div class="ps-table-wrap">
                                    <table class="ps-table ps-table--product">
                                        <thead>
                                        <tr>
                                            <th>Monthly Transaction</th>
                                            <th>Criteria a (Salary + 1 category)</th>
                                            <th>Criteria b (Salary + 2 OR more Cateogry)</th>
                                            <th>Total Interest Earned for ${{ $promotion_product->placement }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($product_range as $range)

                                        @endforeach
                                        @foreach($product_range as $key=>$range)
                                            <tr>
                                                <td class="@if($range->criteria_a_highlight==true || $range->criteria_b_highlight==true ) highlight @endif"
                                                    style="width: 30%">@if($key==0)
                                                        <${{ $range->max_range+1 }}
                                                    @elseif((count($product_range)-1)==$key)
                                                         >${{ $range->min_range }}
                                                    @else
                                                         ${{ $range->min_range }} TO
                                                        <${{ $range->max_range+1 }} @endif</td>
                                                <td class="text-center @if($range->criteria_a_highlight==true ) highlight @endif">
                                                    @if($range->bonus_interest_criteria_a<=0)
                                                        - @else  {{ $range->bonus_interest_criteria_a }}% @endif

                                                </td>
                                                <td class="text-center @if($range->criteria_b_highlight==true ) highlight @endif">
                                                    @if($range->bonus_interest_criteria_b<=0)
                                                        - @else  {{ $range->bonus_interest_criteria_b }}% @endif

                                                </td>
                                                @if($key==0)
                                                    <td class=" text-center @if($promotion_product->highlight==true ) highlight @endif"
                                                        rowspan="6">
                                                        Total=
                                                        ${{ $promotion_product->interest_earned.' ( '.$promotion_product->total_interest.'%) ' }}</td>
                                                @endif
                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="ps-product__detail">
                                    {!! $promotion_product->product_footer !!}
                                </div>
                                <div class="ps-product__footer"><a class="ps-product__more" href="#">More
                                        Detail<i class="fa fa-angle-down"></i></a></div>
                            </div>
                        </div>
                    @endif
                    @php $j++; @endphp
                    @endforeach
                @endif
        </div>
    </div>
    <script type="text/javascript">
        $(".search_type").on("click", function () {
            var prefix_holder = '';
            $(".search_type").removeClass("active");
            $("input[type='radio']").prop("checked", false);
            $(this).addClass("active").find("input[type='radio']").prop("checked", true);
            var value = $(this).find("input[type='radio']").val();
            if (value == 'Placement') {
                prefix_holder = '$';
            }
            $("span.prefix_holder").text(prefix_holder);
        });
    </script>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
