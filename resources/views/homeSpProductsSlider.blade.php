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
                    <img alt="" src="{{ asset($product->brand_logo) }}">
                    <h4 class="slider-heading">
                        <strong>
                            Up to
                                                                  <span class="highlight-slider">
                                                                    {{ $product->maximum_interest_rate  }}
                                                                      %
                                                                  </span>
                        </strong>
                    </h4>

                    <div class="ps-block__info">
                        <p class="highlight highlight-bg">
                            <strong>
                                rate:
                            </strong>
                            {{ $product->maximum_interest_rate }}
                            %
                        </p>

                        <p>
                            <strong>
                                Min:
                            </strong>
                            SGD
                            ${{ Helper::inThousand($product->minimum_placement_amount) }}
                        </p>

                        <p>
                            @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1]))
                                {{ $product->remaining_days }}  {{\Helper::daysOrMonthForSlider(1,  $product->remaining_days)}}
                            @else
                                {{$product->promotion_period}} @if($product->tenure_value > 0) {{\Helper::daysOrMonthForSlider(2,  $product->tenure_value)}} @endif
                            @endif
                        </p>
                    </div>
                    <a class="ps-btn"
                       href="<?php echo url('fixed-deposit-mode'); ?>">
                        More info
                    </a>
                    </img>
                </div>
            @endif
            @if ($product->promotion_type_id ==FIX_DEPOSIT && $product->featured==0)
                <div class="ps-block--short-product">
                    <img alt="" src="<?php echo asset($product->brand_logo); ?>">
                    <h4 class="slider-heading">
                        <strong>
                            Up to
                                                                    <span class="highlight-slider">
                                                                      {{ $product->maximum_interest_rate  }}
                                                                        %
                                                                    </span>
                        </strong>
                    </h4>

                    <div class="ps-block__info">
                        <p class="highlight highlight-bg">
                            <strong>
                                rate:
                            </strong>
                            {{ $product->maximum_interest_rate }}
                            %
                        </p>

                        <p>
                            <strong>
                                Min:
                            </strong>
                            SGD
                            ${{ Helper::inThousand($product->minimum_placement_amount) }}
                        </p>

                        <p>
                            @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1]))
                                {{ $product->remaining_days }}  {{\Helper::daysOrMonthForSlider(1,  $product->remaining_days)}}
                            @else
                                {{$product->promotion_period}} @if($product->tenure_value > 0) {{\Helper::daysOrMonthForSlider(2,  $product->tenure_value)}} @endif
                            @endif
                        </p>
                    </div>
                    <a class="ps-btn"
                       href="<?php echo url('fixed-deposit-mode'); ?>">
                        More info
                    </a>
                    </img>
                </div>
            @endif
        @endforeach
    </div>
</div>