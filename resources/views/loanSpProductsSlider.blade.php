@foreach($products as $product)

    @if($product->featured==1)

        <?php $featured[] = $i; ?>

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

<div class="product-col-0{{ $featured_width }} dump-padding-left">

    <div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"

         data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"

         data-owl-gap="10" data-owl-item="{{ $featured_item }}"

         data-owl-item-lg="{{ $featured_item }}"

         data-owl-item-md="{{ $featured_item }}" data-owl-item-sm="2"

         data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"

         data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"

         data-owl-nav-right="<i class='fa fa-angle-right'></i>"

         data-owl-speed="5000">

        @foreach ($products as $product)

            @if($product->featured==1)

                <div class="ps-block--short-product second highlight"

                     data-mh="product">

                    <img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}">
                    <h4 class="slider-heading">

                        <strong>
                            @if($product->by_order_value==INTEREST)
                                Avg. rate: <span class="highlight-slider"> {{ $product->avg_interest }}
                                    %</span>
                            @elseif($product->by_order_value==TENURE)
                                Lock in: <span class="highlight-slider">{{$product->lock_in}}</span> YRS
                            @elseif($product->by_order_value==INSTALLMENT)
                                Min: <span
                                        class="highlight-slider"> SGD ${{ \Helper::inThousand($product->minimum_loan_amount) }}</span>
                            @endif
                        </strong>

                    </h4>


                    <div class="ps-block__info">
                        <p class=" @if($product->by_order_value==INTEREST)highlight highlight-bg @endif">
                                <span class="slider-font">
                                 Rate: </span>{{ $product->avg_interest }}%</p>
                        <p class="@if($product->by_order_value==TENURE) highlight highlight-bg @endif">
                            <span class="slider-font">Lock in:</span> {{ $product->lock_in }} YRS
                        </p>
                        <p class="@if($product->by_order_value==INSTALLMENT) highlight highlight-bg @endif">
                            <span class="slider-font"> Min: </span> SGD ${{ Helper::inThousand($product->minimum_loan_amount) }}
                        </p>
                    </div>
                    <a class="ps-btn"

                       href="<?php echo url($product->product_url); ?>">

                        More info

                    </a>

                </div>

            @endif

            @if ( $product->featured==0)

                <div class="ps-block--short-product second">

                    <img data-sizes="auto" class="lazyload" alt="" data-src="{{ asset($product->brand_logo) }}">

                    <h4 class="slider-heading">

                        <strong>
                            @if($product->by_order_value==INTEREST)
                                Avg. rate: <span class="highlight-slider"> {{ $product->avg_interest }}
                                    %</span>
                            @elseif($product->by_order_value==TENURE)
                                Lock in: <span class="highlight-slider">{{$product->lock_in}}</span> YRS
                            @elseif($product->by_order_value==INSTALLMENT)
                                Min: <span
                                        class="highlight-slider"> SGD ${{ \Helper::inThousand($product->minimum_loan_amount) }}</span>
                            @endif
                        </strong>

                    </h4>


                    <div class="ps-block__info">
                        <p class=" @if($product->by_order_value==INTEREST)highlight highlight-bg @endif">
                                <span class="slider-font">
                                 Rate: </span>{{ $product->avg_interest }}%</p>
                        <p class="@if($product->by_order_value==TENURE) highlight highlight-bg @endif">
                            <span class="slider-font">Lock in:</span> {{ $product->lock_in }} YRS
                        </p>
                        <p class="@if($product->by_order_value==INSTALLMENT) highlight highlight-bg @endif">
                            <span class="slider-font"> Min: </span> SGD ${{ Helper::inThousand($product->minimum_loan_amount) }}
                        </p>
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