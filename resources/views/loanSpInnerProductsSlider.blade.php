@if($sliderProducts->count())
    @php $i = 1;$featured = []; @endphp
    @foreach($sliderProducts as $product)
        @if($product->featured==1)
            <?php $featured[] = $i; ?>
            @php $i++; @endphp
        @endif
    @endforeach
    <?php $i = 1;$featured_item = 5 - count($featured);
    $featured_count = count($featured);
    $featured_width = 0;
    /*if ($featured_count == 1) {
    $featured_width = 2;
    } elseif ($featured_count == 2) {
    $featured_width = 3;
    } elseif ($featured_count == 3) {
    $featured_width = 4;
    }*/
    ?>
    <div class="product-mobile">Show Product<span></span></div>
    <div class="product-col-0{{ $featured_width }} sp-only dump-padding-left">
        <div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded"
             data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
             data-owl-gap="10" data-owl-item="{{ $featured_item }}"
             data-owl-item-lg="{{ $featured_item }}"
             data-owl-item-md="3" data-owl-item-sm="2"
             data-owl-item-xs="1" data-owl-loop="true" data-owl-mousedrag="on"
             data-owl-nav="true" data-owl-nav-left="<i class='fa fa-angle-left'></i>"
             data-owl-nav-right="<i class='fa fa-angle-right'></i>"
             data-owl-speed="5000">
            @php $j = 1;$featured = []; @endphp
            @foreach ($sliderProducts as $product)
                @if($product->featured==1)
                    <div class="ps-block--short-product second highlight" data-mh="product">
                        <div class="slider-img"><img src="{{ asset($product->brand_logo) }}" alt=""></div>
                        @if(isset($searchFilter['filter']))
                            <h4>
                                <strong>
                                    @if($searchFilter['filter']==INTEREST)
                                        Avg. rate: <span class="highlight-slider"> {{ $product->avg_interest }}
                                            %</span>
                                    @endif
                                    @if($searchFilter['filter']==TENURE)
                                        Lock in: <span class="highlight-slider">{{$product->lock_in}}</span> YRS
                                    @endif
                                    @if($searchFilter['filter']==INSTALLMENT)
                                        Min: <span
                                                class="highlight-slider"> SGD ${{ Helper::inThousand($product->minimum_loan_amount) }}</span>
                                    @endif
                                </strong>
                            </h4>
                        @endif
                        <div class="ps-block__info">
                            <p class=" @if($searchFilter['filter']==INTEREST) highlight highlight-bg @endif">
                    <span class="slider-font">
                    Rate: </span>{{ $product->avg_interest }}%</p>

                            <p class="@if($searchFilter['filter']==TENURE) highlight highlight-bg @endif">
                                <span class="slider-font">Lock in:</span> {{ $product->lock_in }} YRS
                            </p>

                            <p class="@if($searchFilter['filter']==INSTALLMENT) highlight highlight-bg @endif">
                                <span class="slider-font"> Min: </span> SGD
                                ${{ Helper::inThousand($product->minimum_loan_amount) }}
                            </p>
                        </div>
                        <a class="ps-btn" href="#p-{{$j}}">More info</a>
                    </div>
                @endif
                @if ( $product->featured==0)
                    <div class="ps-block--short-product second" data-mh="product">
                        <div class="slider-img"><img src="{{ asset($product->brand_logo) }}" alt=""></div>
                        @if(isset($searchFilter['filter']))
                            <h4>
                                <strong>
                                    @if($searchFilter['filter']==INTEREST)
                                        Avg. rate: <span class="highlight-slider"> {{ $product->avg_interest }}
                                            %</span>
                                    @endif
                                    @if($searchFilter['filter']==TENURE)
                                        Lock in: <span class="highlight-slider">{{$product->lock_in}}</span> YRS
                                    @endif
                                    @if($searchFilter['filter']==INSTALLMENT)
                                        Min: <span
                                                class="highlight-slider"> SGD ${{ Helper::inThousand($product->minimum_loan_amount) }}</span>
                                    @endif
                                </strong>
                            </h4>
                        @endif
                        <div class="ps-block__info">
                            <p class=" @if($searchFilter['filter']==INTEREST) highlight highlight-bg @endif">
                    <span class="slider-font">
                    Rate: </span>{{ $product->avg_interest }}%</p>

                            <p class="@if($searchFilter['filter']==TENURE) highlight highlight-bg @endif">
                                <span class="slider-font">Lock in:</span> {{ $product->lock_in }} YRS
                            </p>

                            <p class="@if($searchFilter['filter']==INSTALLMENT) highlight highlight-bg @endif">
                                <span class="slider-font"> Min: </span> SGD
                                ${{ Helper::inThousand($product->minimum_loan_amount) }}
                            </p>
                        </div>
                        <a class="ps-btn" href="#p-{{$j}}">More info</a>
                    </div>
                @endif
                @php $j++; @endphp
            @endforeach
        </div>
    </div>
@endif