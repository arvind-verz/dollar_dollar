@foreach($products as $product)

    @if($product->featured==1)

        <?php $featured[] = $i; ?>

        <div class="product-col-01 home-featured">

            <div class="ps-slider--feature-product saving">

                <div class="ps-block--short-product second highlight"

                     data-mh="product">

                    <div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>

                    <h4 class="slider-heading">

                        <strong>

                            @if($product->by_order_value==INTEREST)

                                Up to <span class="highlight-slider"> {{ $product->maximum_interest_rate }}

                                    %</span>

                            @endif

                            @if($product->by_order_value==PLACEMENT)

                                Min:   <span class="highlight-slider">

                                                                @if($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT){{$product->currency_code}} @else

                                        SGD @endif ${{ Helper::inThousand($product->minimum_placement_amount) }} </span>

                            @endif

                            @if($product->by_order_value==TENURE)

                                @if($product->promotion_period==ONGOING)

                                            <span class="highlight-slider"> {{ $product->promotion_period }} </span>

                                @else

                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1]))

                                        <span class="highlight-slider"> {{ $product->remaining_days }} </span> {{\Helper::daysOrMonthForSlider(1,  $product->remaining_days)}}

                                    @elseif($product->tenure_value > 0)

                                        <span class="highlight-slider"> {{ $product->promotion_period }} </span>{{\Helper::daysOrMonthForSlider(2,  $product->tenure_value)}}

                                    @elseif(is_numeric($product->promotion_period))

                                        <span class="highlight-slider"> {{ $product->promotion_period }} </span> {{\Helper::daysOrMonthForSlider(2,  $product->promotion_period)}}

                                    @else

                                        <span class="highlight-slider"> {{ $product->promotion_period }} </span>

                                    @endif

                                @endif

                            @endif

                            @if($product->by_order_value==CRITERIA)

                                Up to  <span class="highlight-slider"> {{ $product->promotion_period }}

                                    Criteria </span>

                            @endif

                        </strong>

                    </h4>



                    <div class="ps-block__info">

                        <p class=" @if($product->by_order_value==INTEREST) highlight highlight-bg @endif">

                            <span class="slider-font">

                                Rate: </span>{{ $product->maximum_interest_rate }}%</p>



                        <p class=" @if($product->by_order_value==PLACEMENT) highlight highlight-bg @endif">

                            <span class="slider-font">Min:</span> @if($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT){{$product->currency_code}} @else

                                SGD @endif

                            ${{ Helper::inThousand($product->minimum_placement_amount) }}

                        </p>

                        @if($product->product_url==AIO_DEPOSIT_MODE)

                            <p class="@if($product->by_order_value==CRITERIA) highlight highlight-bg @endif">

                                {{ $product->promotion_period }} {{CRITERIA}}

                            </p>

                        @else

                            <p class="@if($product->by_order_value==TENURE) highlight highlight-bg @endif">

                                @if($product->promotion_period==ONGOING)

                                         {{ $product->promotion_period }}

                                @else

                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1]))

                                        {{ $product->remaining_days }}  <span

                                                class="slider-font">{{\Helper::daysOrMonthForSlider(1,  $product->remaining_days)}}</span>

                                    @else

                                        {{$product->promotion_period}} @if($product->tenure_value > 0) <span

                                                class="slider-font">{{\Helper::daysOrMonthForSlider(2,  $product->tenure_value)}}</span> @endif

                                    @endif

                                @endif

                            </p>

                        @endif

                    </div>

                    <a class="ps-btn"

                       href="<?php echo url($product->product_url); ?>">

                        More info

                    </a>



                </div>

            </div>

        </div>

        @php $i++; @endphp

    @endif

@endforeach

<?php $i = 1;$featured_item = 5 - count($featured);

$featured_count = count($featured);

$featured_width = 0;

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

         data-owl-item-md="3" data-owl-item-sm="2"

         data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"

         data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"

         data-owl-nav-right="<i class='fa fa-angle-right'></i>"

         data-owl-speed="5000">

        @foreach ($products as $product)

            @if($product->featured==1)

            @endif

            @if ( $product->featured==0)

                <div class="ps-block--short-product second">

                    <div class="slider-img"><img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}"></div>

                    <h4 class="slider-heading">

                        <strong>

                            @if($product->by_order_value==INTEREST)

                                Up to <span class="highlight-slider"> {{ $product->maximum_interest_rate }}

                                    %</span>

                            @endif

                            @if($product->by_order_value==PLACEMENT)

                                Min:   <span class="highlight-slider">

                                                                @if($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT){{$product->currency_code}} @else

                                        SGD @endif

                                    ${{ Helper::inThousand($product->minimum_placement_amount) }} </span>

                            @endif

                            @if($product->by_order_value==TENURE)

                                @if($product->promotion_period==ONGOING)

                                    <span class="highlight-slider"> {{ $product->promotion_period }} </span>

                                @else

                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1]))

                                        <span class="highlight-slider"> {{ $product->remaining_days }} </span> {{\Helper::daysOrMonthForSlider(1,  $product->remaining_days)}}

                                    @elseif($product->tenure_value > 0)

                                        <span class="highlight-slider"> {{ $product->promotion_period }} </span>{{\Helper::daysOrMonthForSlider(2,  $product->tenure_value)}}

                                    @elseif(is_numeric($product->promotion_period))

                                        <span class="highlight-slider"> {{ $product->promotion_period }} </span> {{\Helper::daysOrMonthForSlider(2,  $product->promotion_period)}}

                                    @else

                                        <span class="highlight-slider"> {{ $product->promotion_period }} </span>

                                    @endif

                                @endif

                            @endif

                            @if($product->by_order_value==CRITERIA)

                                Up to  <span class="highlight-slider"> {{ $product->promotion_period }}

                                    Criteria </span>

                            @endif

                        </strong>

                    </h4>



                    <div class="ps-block__info">

                        <p class=" @if($product->by_order_value==INTEREST) highlight highlight-bg @endif">

                             <span class="slider-font">

                                Rate: </span>{{ $product->maximum_interest_rate }}%</p>



                        <p class=" @if($product->by_order_value==PLACEMENT) highlight highlight-bg @endif">

                            <span class="slider-font">Min:</span> @if($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT){{$product->currency_code}} @else

                                SGD @endif

                            ${{ Helper::inThousand($product->minimum_placement_amount) }}

                        </p>



                        @if($product->product_url==AIO_DEPOSIT_MODE)

                            <p class="@if($product->by_order_value==CRITERIA) highlight highlight-bg @endif">

                                {{ $product->promotion_period }} {{CRITERIA}}

                            </p>

                        @else

                            <p class="@if($product->by_order_value==TENURE) highlight highlight-bg @endif">

                                @if($product->promotion_period==ONGOING)

                                         {{ $product->promotion_period }}

                                @else

                                    @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1]))

                                        {{ $product->remaining_days }}  <span

                                                class="slider-font">{{\Helper::daysOrMonthForSlider(1,  $product->remaining_days)}}</span>

                                    @else

                                        {{$product->promotion_period}} @if($product->tenure_value > 0) <span

                                                class="slider-font">{{\Helper::daysOrMonthForSlider(2,  $product->tenure_value)}}</span> @endif

                                    @endif

                                @endif

                            </p>

                        @endif

                    </div>

                    <a class="ps-btn"

                       href="<?php echo url($product->product_url); ?>">

                        More info

                    </a>



                </div>

            @endif

        @endforeach

    </div>

</div>