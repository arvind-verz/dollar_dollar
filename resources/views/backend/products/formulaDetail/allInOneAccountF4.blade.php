<div class="display-none" id="allInOneAccountF4">
    @if(isset($product) && (in_array($product->formula_id,[ALL_IN_ONE_ACCOUNT_F4])))
        @if(count($product->product_range))
            <?php //dd(old('min_placement')[0]); ?>
            @foreach($product->product_range as $key => $value)
                @if($key==0)
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label">Formula Detail</label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Salary)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_salary_aioa4" value="{{ $value->minimum_salary}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Spend)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_spend_aioa4"
                                           value="{{ $value->minimum_spend}}"
                                           placeholder="">

                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Amount (Home Loan)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_home_loan_aioa4" value="{{ $value->minimum_home_loan}}"
                                           placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                        <div class="form-group ">
                            <label for="title" class="col-sm-2 control-label"></label>

                            <div class="col-sm-8 ">
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">Minimum Amount (Insurance)</label>
                                        <input type="text" class="form-control only_numeric" id=""
                                               name="minimum_insurance_aioa4" value="{{ $value->minimum_insurance  }}"
                                               placeholder="">

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Minimum Amount (Investment)</label>
                                        <input type="text" class="form-control only_numeric" id=""
                                               name="minimum_investment_aioa4"
                                               value="{{ $value->minimum_investment}}"
                                               placeholder="">
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-2">&emsp;</div>
                        </div>
                        <div class="form-group ">
                            <label for="title" class="col-sm-2 control-label"></label>

                            <div class="col-sm-8 ">
                                <div class="form-row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">First Cap Amount</label>
                                        <input type="text" class="form-control only_numeric" id=""
                                               name="first_cap_amount_aioa3" value="@if(isset($value->first_cap_amount)){{$value->first_cap_amount}} @endif"
                                               placeholder="">

                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Board Rate</label>
                                        <input type="text" class="form-control only_numeric" id=""
                                               name="bonus_interest_remaining_amount_aioa3"
                                               value="@if(isset($value->bonus_interest_remaining_amount)){{ $value->bonus_interest_remaining_amount  }} @endif"
                                               placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">&emsp;</div>
                        </div>
                @endif
                <div id="aioa_placement_range_f4_{{$key}}">

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success">Min
                                        Placement
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric "
                                       name="min_placement_aioa4[{{$key}}]"
                                       value="{{ $value->min_range  }}">

                            </div>
                        </div>

                        <div class="col-sm-4 ">

                            <div class="input-group date ">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger">Max
                                        Placement
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric"
                                       name="max_placement_aioa4[{{$key}}]"
                                       value="{{ $value->max_range  }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-aioa-placement-range-f4-button">
                            @if($key==0)
                                <button type="button"
                                        class="btn btn-info pull-left mr-15 add-aioa-placement-range-f4-button"
                                        data-range-id="{{count($product->product_range)}}"
                                        onClick="addMorePlacementRange(this);"><i
                                            class="fa fa-plus"></i>
                                </button>
                            @else
                                <button type="button"
                                        class="btn btn-danger -pull-right  remove-placement-range-button "
                                        data-range-id="{{$key}}" onClick="removePlacementRange(this);"><i
                                            class="fa fa-minus"> </i>
                                </button>
                            @endif
                        </div>

                    </div>
                    <?php
                    $bonusInterestCriteriaA = $value->bonus_interest_criteria_a;
                    $bonusInterestCriteriaB = $value->bonus_interest_criteria_b;
                    ?>


                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (A)</label>
                                    <input type="text" class="form-control only_numeric" id="bonus_interest_{{$key}}"
                                           name="bonus_interest_criteria_a_aioa4[{{$key}}]"
                                           value="{{$bonusInterestCriteriaA}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (B)</label>
                                    <input type="text" class="form-control only_numeric" id="board_rate_{{$key}}"
                                           name="bonus_interest_criteria_b_aioa4[{{$key}}]"
                                           value="{{$bonusInterestCriteriaB}}"
                                           placeholder="">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                </div>
            @endforeach
        @endif
    @else
        <div class="form-group ">
            <label for="title" class="col-sm-2 control-label">Formula Detail</label>

            <div class="col-sm-8 ">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="">Minimum Amount (Salary)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_salary_aioa4" value=""
                               placeholder="">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Minimum Amount (Spend)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_spend_aioa4"
                               value=""
                               placeholder="">

                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="">Minimum Amount (Home Loan)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_home_loan_aioa4" value=""
                               placeholder="">
                    </div>
                </div>
            </div>
            <div class="col-sm-2">&emsp;</div>
        </div>
        <div class="form-group ">
            <label for="title" class="col-sm-2 control-label"></label>

            <div class="col-sm-8 ">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="">Minimum Amount (Insurance)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_insurance_aioa4" value=""
                               placeholder="">

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Minimum Amount (Investment)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_investment_aioa4"
                               value=""
                               placeholder="">
                    </div>

                </div>
            </div>
            <div class="col-sm-2">&emsp;</div>
        </div>
        <div class="form-group ">
            <label for="title" class="col-sm-2 control-label"></label>

            <div class="col-sm-8 ">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="">First Cap Amount</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="first_cap_amount_aioa3" value=""
                               placeholder="">

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Bonus Interest (Remaining)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="bonus_interest_remaining_amount_aioa3"
                               value=""
                               placeholder="">
                    </div>
                </div>
            </div>
            <div class="col-sm-2">&emsp;</div>
        </div>
        <div id="aioa_placement_range_f4_0">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-4">
                    <div class="input-group date">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success">Min
                                Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric "
                               name="min_placement_aioa4[0]"
                               value="">

                    </div>
                </div>

                <div class="col-sm-4 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Max Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_aioa4[0]"
                               value="">

                    </div>

                </div>
                <div class="col-sm-2" id="add-aioa-placement-range-f4-button">
                    <button type="button"
                            class="btn btn-info pull-left mr-15 add-aioa-placement-range-f4-button"
                            data-range-id="0" onClick="addMorePlacementRange(this);"><i
                                class="fa fa-plus"></i>
                    </button>
                </div>

            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (A)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_criteria_a_aioa4[0]"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (B)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_criteria_b_aioa4[0]"
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
        </div>
    @endif
    <div id="aioa-placement-range-f4"></div>

</div>

