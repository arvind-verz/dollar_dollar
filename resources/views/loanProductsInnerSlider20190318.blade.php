@if($sliderProducts->count())
    <div class="product-row-01 pc-only clearfix slider-class">
        @php $i = 1;$featured = []; @endphp
        @foreach($sliderProducts as $product)
            @if($product->featured==1)
                @php $featured[] = $i; @endphp
                <div class="product-col-01">
                    <div class="ps-slider--feature-product saving">
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
                            <a class="ps-btn" href="#p-{{ $product->product_id }}">More info</a>
                        </div>
                    </div>
                </div>
                @php $i++; @endphp
            @endif
        @endforeach
        @php $i = 1;
        $featured_item = 5-count($featured);
        $featured_item_md = 3-count($featured);
        if($featured_item>5){
        $featured_item = 0;
        $featured_item_md = 0 ;
        }elseif($featured_item>3){
        $featured_item_md = 0 ;
        }

        $featured_count = count($featured);
        $featured_width = 0;
        if($featured_count==1) {
        $featured_width = 2;
        }
        elseif($featured_count==2) {
        $featured_width = 3;
        }
        elseif($featured_count==3) {
        $featured_width = 4;
        }
        @endphp
        <div class="product-col-0{{ $featured_width }}">
            <div class="ps-slider--feature-product saving nav-outside owl-slider" data-owl-auto="true"
                 data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true"
                 data-owl-dots="false" data-owl-item="{{ $featured_item }}" data-owl-item-xs="1"
                 data-owl-item-sm="1" data-owl-item-md="{{$featured_item_md}}"
                 data-owl-item-lg="{{ $featured_item }}" data-owl-duration="1000" data-owl-mousedrag="on"
                 data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;"
                 data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                @php $i = 1; @endphp
                @foreach($sliderProducts as $product)
                    @if($product->featured==0)
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
                            <a class="ps-btn" href="#p-{{$product->product_id}}">More info</a>
                        </div>
                        @php $i++; @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif