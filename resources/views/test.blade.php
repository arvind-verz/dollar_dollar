@if($promotion_product->promotion_formula_id==3)
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
                @foreach($product_range as $key => $range)
                    @php $max_range_arr[] = $range->max_range; @endphp
                    <tr class="
                                    @if(isset($search_filter['filter']) && ($search_filter['filter']=='Placement'))
                    @if(isset($search_filter['search_value']) && ($search_filter['search_value']>=$range->min_range && $search_filter['search_value']<=$range->max_range)) highlight
                                        @endif
                    @endif">
                        <td>{{ '$' . $range->min_range . ' - $' . $range->max_range }}</td>
                        @if($key==0)
                            <td rowspan="{{ count($product_range) }}"
                                class="@if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor' && $search_filter['search_value']==$range->tenor)) highlight
                                        @endif">{{ $range->tenor. ' ' . $days_type }}</td>@endif
                        <td class="@if(isset($search_filter['search_value']) && $search_filter['filter']=='Interest' && $search_filter['search_value']==$range->bonus_interest) highlight
                                        @endif">{{ $range->bonus_interest . '%' }}</td>
                        <td class="@if(isset($search_filter['search_value']) && $search_filter['filter']=='Interest' && $search_filter['search_value']==$range->board_rate) highlight
                                        @endif">{{ $range->board_rate . '%' }}</td>
                        <td class="@if(isset($search_filter['search_value']) && $search_filter['filter']=='Interest' && $search_filter['search_value']==($range->bonus_interest+$range->board_rate)) highlight
                                        @endif">{{ ($range->bonus_interest+$range->board_rate). '%' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @if(count($promotion_product->ads_placement))
        @php
        $ads = json_decode($promotion_product->ads_placement);
        if(!empty($ads[1]->ad_image_vertical)) {
        @endphp
        <div class="ps-product__poster">
            <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}"><img
                        src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                        alt=""></a>
        </div>
        <div class="clearfix"></div>
        @php }  @endphp
    @endif
    <div class="ps-product__panel">
        @foreach($product_range as $key => $range)
            @php
            if(isset($search_filter['search_value']) &&
            ($search_filter['filter']=='Placement') &&
            ($search_filter['search_value']>=$range->min_range &&
            $search_filter['search_value']<=$range->max_range)) {
            $placement_value = $range->max_range;
            if(isset($search_filter['search_value']) &&
            $search_filter['filter']=='Placement') {
            $placement_value = $search_filter['search_value'];
            }
            $P = $placement_value;
            $PI = $range->board_rate/100;
            @endphp
            @if($key==0)
                <h4>Possible interest(s) earned for SGD ${{ $P }}</h4>
            @endif
            @php
            $BI = $range->bonus_interest/100;
            $TM = $range->tenor;
            $calc = eval('return '.$promotion_product->formula.';');
            @endphp
            @if($key==0)
                <h2>${{ round($calc, 2) }} <br>
                                                        <span>Total interest rate {{ ($range->bonus_interest + $range->board_rate) }}
                                                            %</span></h2>
            @endif
            @php
            }
            elseif(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor') {
            $placement_value = max($max_range_arr);
            $P = $placement_value;
            $PI = $range->board_rate/100;
            @endphp
            @if($key==0)
                <h4>Possible interest(s) earned for SGD ${{ $P }}</h4>
            @endif
            @php
            $BI = $range->bonus_interest/100;
            $TM = $range->tenor;
            $calc = eval('return '.$promotion_product->formula.';');
            @endphp
            @if($key==0)
                <h2>${{ round($calc, 2) }} <br>
                                                        <span>Total interest rate {{ ($range->bonus_interest + $range->board_rate) }}
                                                            %</span></h2>
            @endif
            @php
            }
            elseif(!isset($search_filter['search_value'])) {
            $placement_value = $range->max_range;
            if(isset($search_filter['search_value']) &&
            $search_filter['filter']=='Placement') {
            $placement_value = $search_filter['search_value'];
            }
            $P = $placement_value;
            $PI = $range->board_rate/100;
            @endphp
            @if($key==0)
                <h4>Possible interest(s) earned for SGD ${{ $P }}</h4>
            @endif
            @php
            if($key==0) {
            $BI = $range->bonus_interest/100;
            $TM = $range->tenor;
            $calc = eval('return '.$promotion_product->formula.';');
            @endphp
            @if($key==0)
                <h2>${{ round($calc, 2) }} <br>
                                                        <span>Total interest rate {{ ($range->bonus_interest + $range->board_rate) }}
                                                            %</span></h2>
            @endif
            @php
            }
            }
            @endphp

        @endforeach


    </div>
    <div class="clearfix"></div>
    @endif


            <!-- FORMULA 3 -->
    @if($promotion_product->promotion_formula_id==4)
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
                    @foreach($product_range as $key => $range)
                        @php $i = 1;   $counters = $range->counter;@endphp
                        @foreach($counters as $counter)
                            <tr>
                                @if($i==1)
                                    <td rowspan="{{ count((array)$counters) }}">{{ $range->sibor_rate/100 . '%' }}</td>
                                @endif
                                <td>{{ 'COUNTER ' . $i . ' - ' . $counter . '%' }}</td>
                                <td>{{ ($counter+($range->sibor_rate/100)) . '%' }}</td>

                            </tr>
                            @php $i++; @endphp
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if(count($promotion_product->ads_placement))
            @php
            $ads = json_decode($promotion_product->ads_placement);
            if(!empty($ads[1]->ad_image_vertical)) {
            @endphp
            <div class="ps-product__poster">
                <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}"><img
                            src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                            alt=""></a>
            </div>
            <div class="clearfix"></div>
            @php } @endphp
        @endif
        <div class="ps-product__panel">
            @foreach($product_range as $key => $range)

                @php
                $P = $range->max_range;
                if(isset($search_filter['search_value']) &&
                $search_filter['filter']=='Placement') {
                $P = $search_filter['search_value'];
                }
                $AIR = $range->air/100;
                $SBR = $range->sibor_rate/100;
                $calc = eval('return '.$promotion_product->formula.';');
                @endphp
                <h4>Possible interest(s) earned for SGD ${{ $P }}</h4>

                <h2>{{ '$' . $calc }}<br>
                                                    <span>Total interest rate {{ (($range->sibor_rate/100)+end($counters)) }}
                                                        %</span></h2>
            @endforeach
        </div>
        <div class="clearfix"></div>
        @endif
                <!-- FORMULA 4 -->
        @if($promotion_product->promotion_formula_id==5)
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
                        @foreach($product_range as $key => $range)
                            <tr>
                                <td>@if($key==0) 1st - @else NEXT
                                    - @endif{{ '$' . $range->max_range }}</td>
                                <td>@php echo $range->board_rate . '%
                                    <small>p.a.</small>
                                    '; @endphp</td>
                                <td>@php echo $range->bonus_interest . '%
                                    <small>p.a.</small>
                                    '; @endphp</td>
                                <td>@php echo
                                    ($range->bonus_interest+$range->board_rate) . '%
                                    <small>p.a.</small>
                                    '; @endphp</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if(count($promotion_product->ads_placement))
                @php
                $ads = json_decode($promotion_product->ads_placement);
                if(!empty($ads[1]->ad_image_vertical)) {
                @endphp
                <div class="ps-product__poster">
                    <a href="{{ isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' }}"><img
                                src="{{ isset($ads[1]->ad_image_vertical) ? asset($ads[1]->ad_image_vertical) : '' }}"
                                alt=""></a>
                </div>
                <div class="clearfix"></div>
                @php } @endphp
            @endif
            <div class="ps-product__panel">
                @php $placement_value = 15000;$calc = []; @endphp
                @foreach($product_range as $key => $range)
                    @php
                    if(isset($search_filter['search_value']) &&
                    ($search_filter['filter']=='Placement')) {
                    if(isset($search_filter['search_value']) &&
                    $search_filter['filter']=='Placement' && $key==0) {
                    $placement_value = $search_filter['search_value'];
                    }
                    if($key==0) {
                    $P = $placement_value;
                    @endphp
                    <h4>Possible interest(s) earned for SGD ${{ $P }}</h4>
                    @php
                    }
                    $TIE = $range->bonus_interest+$range->board_rate;
                    if($placement_value>0) {
                    if($placement_value>=$product_range[$key]->account_balance) {
                    $P = $product_range[$key]->account_balance;
                    $calc[] = eval('return '.$promotion_product->formula.';');
                    $P = $placement_value-$product_range[$key]->account_balance;
                    $placement_value = $P;
                    }
                    else {
                    $calc[] = eval('return '.$promotion_product->formula.';');
                    $placement_value = 0;
                    }
                    }
                    if($key==(count($product_range)-1)) {
                    @endphp
                    <h2>{{ '$' . array_sum($calc)  }}
                        <br> {{--<span>Total interest rate 1%</span>--}}</h2>
                    @php
                    }
                    }
                    elseif(!isset($search_filter['search_value'])) {
                    $TIE = $range->bonus_interest+$range->board_rate;
                    if($key==0) {
                    @endphp
                    <h4>Possible interest(s) earned for SGD
                        ${{ $placement_value }}</h4>
                    @php
                    }
                    if($placement_value>0) {
                    if($placement_value>=$product_range[$key]->max_range) {
                    $P = $product_range[$key]->account_balance;
                    $calc[] = eval('return '.$promotion_product->formula.';');
                    $P = $placement_value-$product_range[$key]->max_range;
                    $placement_value = $P;
                    }
                    else {
                    $calc[] = eval('return '.$promotion_product->formula.';');
                    $placement_value = 0;
                    }
                    }
                    if($key==(count($product_range)-1)) {
                    @endphp
                    <h2>{{ '$' . array_sum($calc)  }}
                        <br> {{--<span>Total interest rate 1%</span>--}}</h2>
                    @php
                    }
                    }
                    @endphp
                @endforeach
            </div>
            <div class="clearfix"></div>
            @endif

                    <!-- FORMULA 5 -->
            @if($promotion_product->promotion_formula_id==6 )
                @php
                $row_data = ['CUMMULATED MONTHLY SAVINGS AMOUNT', 'BASE INTEREST',
                'ADDITIONAL 2% P.A. INTEREST', 'TOTAL AMOUNT'];
                @endphp
                <?php $months = [1];
                $x = (int)$product_range[0]->placement_month;
                $y = (int)$product_range[0]->display_month;
                $j = 1;
                $z = 1;
                do {
                    $z = $y * $j;

                    if (($x > $z)) {
                        $months[] = $z;
                    } else {
                        $z = $x;
                        $months[] = $z;
                    }
                    $j++;
                } while ($z != $x); ?>
                <div class="ps-product__table fullwidth">
                    <div class="ps-table-wrap">
                        <table class="ps-table ps-table--product">
                            <thead>
                            <tr>
                                <th></th>
                                @foreach($months as $month)
                                    <th>{{ 'MONTH ' . $month }}</th>
                                @endforeach
                                <th>{{ 'END OF YEARS' }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $total_sum = array(); @endphp
                            @foreach($row_data as $key => $data)
                                <tr>
                                    <td>{{ $data }}</td>
                                    @if($key==0)
                                        @foreach($product_range as $key => $range)
                                            @foreach($months as $month)
                                                <td class="@if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor' && $month==$search_filter['search_value']) highlight  @endif">{{ '$' . ($range->min_range*$month) }}</td>
                                            @endforeach
                                            <td>{{ '$' . ($range->min_range*end($months)) }}</td>
                                        @endforeach
                                        @php $total_sum[] =
                                        ($range->min_range*end($months)); @endphp
                                    @elseif($key==1)
                                        @foreach($product_range as $key => $range)
                                            @php
                                            $IEB_formula = '($BI *
                                            (($PM + $CM)) * 31/365)';
                                            $calc = [];
                                            $BI = $range->bonus_interest/100;
                                            $CM = 0;
                                            @endphp
                                            @for($i=1;$i<=($range->placement_month);$i++)
                                                @php
                                                $PM = $range->min_range;
                                                $calc[] = round(eval('return
                                                '.$IEB_formula.';'),
                                                2);

                                                @endphp
                                                @if(in_array($i, $months))
                                                    <td class="@if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor' && $i==$search_filter['search_value']) highlight  @endif">{{ '$' . round(eval('return '.$IEB_formula.';'), 2) }}</td>
                                                @endif
                                                @php $CM = $CM+$PM; @endphp
                                            @endfor
                                            <td>{{ '$' . array_sum($calc) }}</td>
                                        @endforeach
                                        @php $total_sum[] =
                                        array_sum($calc); @endphp
                                    @elseif($key==2)
                                        @foreach($product_range as $key => $range)
                                            @php
                                            $IEA_formula = '($AI *
                                            (($PM + $CM) + $PMIE) * 31/365)';
                                            $calc = [];
                                            $BI = $range->bonus_interest/100;
                                            $CM = 0;
                                            $AI = 2/100;
                                            $PMIE = 0;
                                            @endphp
                                            @for($i=1;$i<=($range->placement_month);$i++)
                                                @php
                                                $PM = $range->min_range;
                                                $calc[] = round(eval('return
                                                '.$IEA_formula.';'),
                                                2);
                                                @endphp
                                                @if(in_array($i, $months ))
                                                    <td class="@if(isset($search_filter['search_value']) && $search_filter['filter']=='Tenor' && $i==$search_filter['search_value']) highlight  @endif
                                                            ">{{ '$' . round(eval('return '.$IEA_formula.';'), 2) }}</td>
                                                @endif
                                                @php $CM = $CM+$PM;$PMIE =
                                                round(eval('return
                                                '.$IEA_formula.';'),
                                                2); @endphp
                                            @endfor
                                            <td>{{ '$' . array_sum($calc) }}</td>
                                        @endforeach
                                        @php $total_sum[] =
                                        array_sum($calc); @endphp
                                    @elseif($key==3)
                                        <td colspan="{{count($months)}}"></td>
                                        <td>{{ '$' . array_sum($total_sum) }}</td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif

