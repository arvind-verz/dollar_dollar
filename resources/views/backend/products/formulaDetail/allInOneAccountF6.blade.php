<div class="display-none" id="allInOneAccountF6">
    @if(isset($product) && (in_array($product->formula_id,[ALL_IN_ONE_ACCOUNT_F6])))
        @if(count($product->product_range))
            <?php $prevMax = 0;?>
            @foreach($product->product_range as $key => $value)
                @if($key==0)
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label">Formula Detail</label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount (Grow)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="minimum_grow_aioa6" value="{{ $value->minimum_grow}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Cap Amount (Grow)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="cap_grow_aioa6" value="{{ $value->cap_grow}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Bonus Interest (Grow)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_grow_aioa6"
                                           value="{{ $value->bonus_interest_grow}}"
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
                                    <label for="">Cap Amount (Boost)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="cap_boost_aioa6" value="{{ $value->cap_boost}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Bonus)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_boost_aioa6" value="{{ $value->bonus_interest_boost}}"
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
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount (Salary)</label>
                                    <input type="text" class="form-control only_numeric"
                                           name="minimum_salary_aioa6" value="{{ $value->minimum_salary  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount (Spend)</label>
                                    <input type="text" class="form-control only_numeric"
                                           name="minimum_spend_aioa6" value="{{ $value->minimum_spend  }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount (Wealth)</label>
                                    <input type="text" class="form-control only_numeric"
                                           name="minimum_wealth_aioa6" value="{{ $value->minimum_wealth  }}"
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
                                    <label for="">Other Criteria Name</label>
                                    <input type="text" class="form-control "
                                           name="other_interest_name_aioa6"
                                           value="{{ $value->other_interest_name  }}"
                                           placeholder="">
                                </div>
                               {{-- <div class="col-md-4 mb-3">
                                    <label for="">Minimum Requirement Amount (Other)</label>
                                    <input type="text" class="form-control only_numeric"
                                           name="minimum_other_aioa6" value="{{ $value->minimum_other  }}"
                                           placeholder="">

                                </div>--}}
                                <div class="col-md-6 mb-3">
                                    @if($value->status_other==1)
                                        <input type="hidden" id="aioa-6-1-status-input" name="status_other_aioa6"
                                               value="1"/>
                                        <label for="">Status</label>
                                        <button type="button" data-status="true" id="aioa-6-1-status"
                                                class="btn btn-block btn-success btn-social"
                                                onclick="changeAIO5Status(this)"><i class="fa fa-check"></i> Enable
                                        </button>

                                    @else
                                        <input type="hidden" id="aioa-6-1-status-input" name="status_other_aioa6"
                                               value="0"/>
                                        <label for="">Status</label>
                                        <button type="button" data-status="false" id="aioa-6-1-status"
                                                class="btn btn-block btn-danger btn-social"
                                                onclick="changeAIO5Status(this)"><i class="fa fa-times"></i> Disable
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                {{--<div class="col-md-6 mb-3">
                                    <label for="">First Cap Amount</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="first_cap_amount_aioa6" value="{{ $value->first_cap_amount  }}"
                                           placeholder="">

                                </div>--}}
                                <div class="col-md-612 mb-3">
                                    <label for="">Base Interest</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_remaining_amount_aioa6"
                                           value="{{ $value->bonus_interest_remaining_amount  }}"
                                           placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>

                @endif
                <div id="aioa_placement_range_f6_{{$key}}">

                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">

                            <div class="input-group date ">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger">@if($key==0)First @else Next @endif
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric"
                                       name="max_placement_aioa6[{{$key}}]"
                                       value="{{ ($value->max_range - $prevMax)  }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-aioa-placement-range-f6-button">
                            @if($key==0)
                                <button type="button"
                                        class="btn btn-info pull-left mr-15 add-aioa-placement-range-f6-button"
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
                    $prevMax = $value->max_range;
                    ?>

                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">

                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Salary)</label>
                                    <input type="text" class="form-control only_numeric"
                                           id="bonus_interest_salary_{{$key}}"
                                           name="bonus_interest_salary_aioa6[{{$key}}]"
                                           value="{{ $value->bonus_interest_salary }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Spend)</label>
                                    <input type="text" class="form-control only_numeric"
                                           id="bonus_interest_spend_{{$key}}"
                                           name="bonus_interest_spend_aioa6[{{$key}}]"
                                           value="{{ $value->bonus_interest_spend }}"
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
                                    <label for="">Bonus Interest (Other)</label>
                                    <input type="text" class="form-control only_numeric"
                                           id="bonus_interest_other_{{$key}}"
                                           name="bonus_interest_other_aioa6[{{$key}}]"
                                           value="{{ $value->bonus_interest_other }}"
                                           placeholder="">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest (Wealth)</label>
                                    <input type="text" class="form-control only_numeric"
                                           id="bonus_interest_wealth_{{$key}}"
                                           name="bonus_interest_wealth_aioa6[{{$key}}]"
                                           value="{{ $value->bonus_interest_wealth }}"
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
                        <label for="">Minimum Requirement Amount (Grow)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="minimum_grow_aioa6" value=""
                               placeholder="">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Cap Amount (Grow)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="cap_grow_aioa6" value=""
                               placeholder="">

                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Bonus Interest (Grow)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="bonus_interest_grow_aioa6"
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
                        <label for="">Cap Amount (Boost)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="cap_boost_aioa6" value=""
                               placeholder="">

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Bonus Interest (Bonus)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="bonus_interest_boost_aioa6" value=""
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
                    <div class="col-md-4 mb-3">
                        <label for="">Minimum Requirement Amount (Salary)</label>
                        <input type="text" class="form-control only_numeric"
                               name="minimum_salary_aioa6" value=""
                               placeholder="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Minimum Requirement Amount (Spend)</label>
                        <input type="text" class="form-control only_numeric"
                               name="minimum_spend_aioa6" value=""
                               placeholder="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="">Minimum Requirement Amount (Wealth)</label>
                        <input type="text" class="form-control only_numeric"
                               name="minimum_wealth_aioa6" value=""
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
                        <label for="">Other Criteria Name</label>
                        <input type="text" class="form-control "
                               name="other_interest_name_aioa6"
                               value=""
                               placeholder="">
                    </div>
                   {{-- <div class="col-md-4 mb-3">
                        <label for="">Minimum Requirement Amount (Other)</label>
                        <input type="text" class="form-control only_numeric"
                               name="minimum_other_aioa6" value=""
                               placeholder="">

                    </div>--}}
                    <div class="col-md-6 mb-3">
                        <input type="hidden" id="aioa-6-1-status-input" name="status_other_aioa6"
                               value="1"/>
                        <label for="">Status</label>
                        <button type="button" data-status="true" id="aioa-6-1-status"
                                class="btn btn-block btn-success btn-social"
                                onclick="changeAIO5Status(this)"><i class="fa fa-check"></i> Enable
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-sm-2">&emsp;</div>
        </div>
        <div class="form-group ">
            <label for="title" class="col-sm-2 control-label"></label>

            <div class="col-sm-8 ">
                <div class="form-row">
                    {{--<div class="col-md-6 mb-3">
                        <label for="">First Cap Amount</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="first_cap_amount_aioa6" value=""
                               placeholder="">

                    </div>--}}
                    <div class="col-md-12 mb-3">
                        <label for="">Base Interest </label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="bonus_interest_remaining_amount_aioa6"
                               value=""
                               placeholder="">
                    </div>
                </div>
            </div>
            <div class="col-sm-2">&emsp;</div>
        </div>

        <div id="aioa_placement_range_f6_0">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label"></label>
                <div class="col-sm-8 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_aioa6[0]"
                               value="{{ old('max_placement') ? old('max_placement') :''  }}">

                    </div>
                </div>
                <div class="col-sm-2" id="add-aioa-placement-range-f6-button">
                    <button type="button"
                            class="btn btn-info pull-left mr-15 add-aioa-placement-range-f6-button"
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
                            <label for="">Bonus Interest (Salary)</label>
                            <input type="text" class="form-control only_numeric"
                                   id="bonus_interest_salary_0"
                                   name="bonus_interest_salary_aioa6[0]"
                                   value=""
                                   placeholder="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Spend)</label>
                            <input type="text" class="form-control only_numeric"
                                   id="bonus_interest_spend_0"
                                   name="bonus_interest_spend_aioa6[0]"
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
                            <label for="">Bonus Interest (Other)</label>
                            <input type="text" class="form-control only_numeric"
                                   id="bonus_interest_other_0"
                                   name="bonus_interest_other_aioa6[0]"
                                   value=""
                                   placeholder="">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest (Wealth)</label>
                            <input type="text" class="form-control only_numeric"
                                   id="bonus_interest_wealth_0"
                                   name="bonus_interest_wealth_aioa6[0]"
                                   value=""
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>


        </div>
    @endif
    <div id="aioa-placement-range-f6"></div>

</div>

