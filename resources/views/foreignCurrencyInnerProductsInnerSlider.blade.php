@if($sliderProducts->count())
    <div class="product-row-01  pc-only clearfix slider-class">
        @php $i = 1;$featured = []; $sliderProducts = $sliderProducts->take(41); @endphp
        @foreach($sliderProducts as $product)
            @if($product->featured==1 &&  $product->slider_status==1 && $searchFilter['currency']!='All' )

                @php $featured[] = $i;  @endphp
                <div class="product-col-01">
                    <div class="ps-slider--feature-product saving">
                        <div class="ps-block--short-product second highlight" data-mh="product">
                            <div class="slider-img"><img src="{{ asset($product->brand_logo) }}" alt=""></div>
                            @if(isset($searchFilter['filter']))
                                <h4>
                                    <strong>
                                        @if($searchFilter['filter']==INTEREST)
                                            Up to <span class="highlight-slider"> {{ $product->maximum_interest_rate }}
                                                %</span>
                                        @endif
                                        @if($searchFilter['filter']==PLACEMENT)
                                            Min:   <span class="highlight-slider">
                            SGD ${{ Helper::inThousand($product->minimum_placement_amount) }} </span>
                                        @endif
                                        @if($searchFilter['filter']==TENURE)
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
                                        @if($searchFilter['filter']==CRITERIA)
                                            up to  <span class="highlight-slider"> {{ $product->promotion_period }}
                                                Criteria </span>
                                        @endif
                                    </strong>
                                </h4>
                            @endif
                            <div class="ps-block__info">
                                <p class=" @if($searchFilter['filter']==INTEREST) highlight highlight-bg @endif">
                                <span class="slider-font">
                                Rate: </span>{{ $product->maximum_interest_rate }}%</p>

                                <p class="@if($searchFilter['filter']==PLACEMENT) highlight highlight-bg @endif">
                                    <span class="slider-font">Max:</span> @if($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT){{$product->currency_code}} @else
                                        SGD @endif
                                    ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                </p>

                                @if($product->promotion_type_id==ALL_IN_ONE_ACCOUNT)
                                    <p class="@if($searchFilter['filter']==CRITERIA) highlight highlight-bg @endif">
                                        {{ $product->promotion_period }} {{CRITERIA}}
                                    </p>
                                @else
                                    <p class="@if($searchFilter['filter']==TENURE) highlight highlight-bg @endif">
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
                            <a class="ps-btn" href="#p-{{ $i }}">More info</a>
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
                    @if(($searchFilter['filter']!='All'|| $product->featured==0) &&  $product->slider_status==1)
                        <div class="ps-block--short-product second" data-mh="product">
                            <div class="slider-img"><img src="{{ asset($product->brand_logo) }}" alt=""></div>
                            @if(isset($searchFilter['filter']))
                                <h4>
                                    <strong>
                                        @if($searchFilter['filter']==INTEREST)
                                            Up to <span class="highlight-slider"> {{ $product->maximum_interest_rate }}
                                                %</span>
                                        @endif
                                        @if($searchFilter['filter']==PLACEMENT)
                                            Min:   <span class="highlight-slider">
                            SGD ${{ Helper::inThousand($product->minimum_placement_amount) }} </span>
                                        @endif
                                        @if($searchFilter['filter']==TENURE)
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
                                        @if($searchFilter['filter']==CRITERIA)
                                            up to  <span class="highlight-slider"> {{ $product->promotion_period }}
                                                Criteria </span>
                                        @endif
                                    </strong>
                                </h4>
                            @endif

                            <div class="ps-block__info">
                                <p class=" @if($searchFilter['filter']==INTEREST) highlight highlight-bg @endif">
                                <span class="slider-font">
                                Rate: </span>{{ $product->maximum_interest_rate }}%</p>

                                <p class="@if($searchFilter['filter']==PLACEMENT) highlight highlight-bg @endif">
                                    <span class="slider-font">Max:</span> @if($product->promotion_type_id ==FOREIGN_CURRENCY_DEPOSIT){{$product->currency_code}} @else
                                        SGD @endif
                                    ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                </p>

                                @if($product->promotion_type_id==ALL_IN_ONE_ACCOUNT)
                                    <p class="@if($searchFilter['filter']==CRITERIA) highlight highlight-bg @endif">
                                        {{ $product->promotion_period }} {{CRITERIA}}
                                    </p>
                                @else
                                    <p class="@if($searchFilter['filter']==TENURE) highlight highlight-bg @endif">
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
                            <a class="ps-btn" href="#p-{{ (count($featured)+$i) }}">More info</a>
                        </div>
                        @php $i++; @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endif