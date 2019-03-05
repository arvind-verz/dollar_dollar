@foreach($nonFormulaProducts as $key=> $product)
    <?php $ads = \GuzzleHttp\json_decode($product->ads_placement);  ?>
    @if(isset($ads[3]->ad_horizontal_image_popup_top))
        <div class="ps-poster-popup">
            <a href="{{ isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : 'javascript:void(0)' }}"
               target="_blank"><img
                        src="{{ isset($ads[3]->ad_horizontal_image_popup_top) ? asset($ads[3]->ad_horizontal_image_popup_top) : '' }}"
                        alt="">
            <div class="close-popup">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div></a>
        </div>
    @endif
    <div class="ps-product @if($page->slug==AIO_DEPOSIT_MODE) ps-product--2 @endif  @if($product->featured==1) featured-1 @endif "
         id="a-{{ $key }}">
        @if($page->slug==AIO_DEPOSIT_MODE)
            <div class="ps-product__header"><img src="{{ asset($product->brand_logo) }}"
                                                 alt="">
                @if(!empty($product->apply_link_status))
                    <div class="ps-product__action"><a class="ps-btn ps-btn--red"
                                                       href="{{$product->apply_link}}">Apply
                            Now</a></div>@endif
            </div>
        @else
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
                            {{UNTIL}} {{ date('d/m/y', strtotime($product->promotion_end)) }}
                        @endif
                    </p>

                    <p class="text-uppercase">
                        <?php
                        $start_date = new DateTime(date("Y-m-d", strtotime("now")));
                        if ((!is_null($product->remaining_days)) && (in_array($product->promotion_formula_id, [SAVING_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F2, PRIVILEGE_DEPOSIT_F1]))) {
                            echo $product->remaining_days . ' ' . \Helper::days_or_month_or_year(1, $product->remaining_days) . ' left';
                        } elseif ($product->promotion_end > $todayStartDate) {

                            $end_date = new DateTime(date("Y-m-d",
                                    strtotime($product->promotion_end)));
                            $interval = date_diff($end_date, $start_date);
                            echo $interval->format('%a') . ' ' . \Helper::days_or_month_or_year(1, $interval->format('%a')) . ' left';

                        }
                        ?>
                    </p>
                </div>
            </div>
        @endif
        <div class="ps-product__content">
            <h4 class="ps-product__heading">{!! $product->bank_sub_title !!}</h4>
            @if(!empty($ads[0]->ad_image_horizontal))

                <div class="ps-product__poster"><a
                            href="{{ isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : 'javascript:void(0)' }}"
                            target="_blank"><img
                                src="{{ isset($ads[0]->ad_image_horizontal) ? asset($ads[0]->ad_image_horizontal) : '' }}"
                                alt=""></a></div>
            @endif
            @if(!empty($ads[2]->ad_horizontal_image_popup))
                <div class="ps-poster-popup">

                    <a href="{{ isset($ads[2]->ad_link_horizontal_popup) ? $ads[2]->ad_link_horizontal_popup : 'javascript:void(0)' }}"><img
                                src="{{ isset($ads[2]->ad_horizontal_image_popup) ? asset($ads[2]->ad_horizontal_image_popup) : '' }}"
                                alt=""
                                target="_blank">
                    <div class="close-popup">
                        <i class="fa fa-times"
                           aria-hidden="true"></i>
                    </div></a>

                </div>
            @endif
            <div class="ps-product__detail">
                {!! $product->product_footer !!}
            </div>
            <div class="ps-product__footer"><a
                        class="ps-product__more" href="#">More
                    Detail<i
                            class="fa fa-angle-down"></i></a><a
                        class="ps-product__info sp-only"
                        href="#">More data<i
                            class="fa fa-angle-down"></i></a>
            </div>
        </div>
    </div>
@endforeach