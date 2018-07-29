<div class="display-none" id="allInOneAccountF2">
    @if(isset($product) && (in_array($product->formula_id,[ALL_IN_ONE_ACCOUNT_F2])))
        @if(count($product->product_range))
            <?php $prevMax = 0 ?>
            @foreach($product->product_range as $key => $value)
                @if($key==0)
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label">Formula Detail</label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount (Spend)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_spend_aioa2" value="{{ $value->minimum_spend}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Number of Payment (Giro)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_giro_payment_aioa2"
                                           value="{{ $value->minimum_giro_payment}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount (Salary)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_salary_aioa2" value="{{ $value->minimum_salary}}"
                                           placeholder="">

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                @endif
                <div id="aioa_placement_range_f2_{{$key}}">

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">

                            <div class="input-group date ">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger">@if($key==0)First @else Next @endif
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric"
                                       name="max_placement_aioa2[{{$key}}]"
                                       value="{{ ($value->max_range - $prevMax)  }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-aioa-placement-range-f2-button">
                            @if($key==0)
                                <button type="button"
                                        class="btn btn-info pull-left mr-15 add-aioa-placement-range-f2-button"
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
                    $prevMax=$value->max_range;
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
                                           name="bonus_interest_criteria_a_aioa2[{{$key}}]"
                                           value="{{$bonusInterestCriteriaA}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (B)</label>
                                    <input type="text" class="form-control only_numeric" id="board_rate_{{$key}}"
                                           name="bonus_interest_criteria_b_aioa2[{{$key}}]"
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
                        <label for="">Minimum Requirement Amount (Spend)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_spend_aioa2" value=""
                               placeholder="">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Minimum Requirement Number of Payment (Giro)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_giro_payment_aioa2" value=""
                               placeholder="">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Minimum Requirement Amount (Salary)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_salary_aioa2" value=""
                               placeholder="">

                    </div>
                </div>
            </div>
            <div class="col-sm-2">&emsp;</div>
        </div>
        <div id="aioa_placement_range_f2_0">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_aioa2[0]"
                               value="{{ old('max_placement') ? old('max_placement') :''  }}">

                    </div>

                </div>
                <div class="col-sm-2" id="add-aioa-placement-range-f2-button">
                    <button type="button"
                            class="btn btn-info pull-left mr-15 add-aioa-placement-range-f2-button"
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
                                   name="bonus_interest_criteria_a_aioa2[0]"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (B)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_criteria_b_aioa2[0]"
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
        </div>
    @endif
    <div id="aioa-placement-range-f2"></div>

</div>

