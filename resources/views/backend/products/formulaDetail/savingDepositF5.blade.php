<div class="display-none" id="savingDepositF5">
    @if(isset($product) && (in_array($product->formula_id,[SAVING_DEPOSIT_F5,WEALTH_DEPOSIT_F5,FOREIGN_CURRENCY_DEPOSIT_F6])))
        @if(count($product->product_range))
            <?php //dd(old('min_placement')[0]); ?>
            @foreach($product->product_range as $key => $value)

                <div id="saving_placement_range_f5_{{$key}}">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Formula
                            Detail</label>

                        <div class="col-sm-4">
                            <div class="input-group date">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-success">Min
                                        Placement
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric "
                                       name="min_placement_sdp5"
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
                                       name="max_placement_sdp5"
                                       value="{{ $value->max_range  }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-saving-placement-range-f5-button">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Base Interest</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="base_interest_sdp5" value="{{ $value->base_interest  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_sdp5" value="{{ $value->bonus_interest  }}"
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
                                    <label for="">Placement Month</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="placement_month_sdp5" value="{{ $value->placement_month  }}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Display Month Interval</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="display_month_sdp5" value="{{ $value->display_month  }}"
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

        <div id="saving_placement_range_f5_0">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Formula Detail</label>

                <div class="col-sm-4">
                    <div class="input-group date">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success">Min
                                Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric "
                               name="min_placement_sdp5"
                               value="{{ old('min_placement') ? old('min_placement') :''  }}">

                    </div>
                </div>

                <div class="col-sm-4 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Max Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_sdp5"
                               value="{{ old('max_placement') ? old('max_placement') :''  }}">

                    </div>

                </div>
                <div class="col-sm-2" id="add-saving-placement-range-f5-button">

                </div>

            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">Base Interest</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="base_interest_sdp5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest_sdp5"
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
                            <label for="">Placement Month</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="placement_month_sdp5"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Display Month Interval</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="display_month_sdp5"
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
        </div>
    @endif
    <div id="saving-placement-range-f5"></div>

</div>

