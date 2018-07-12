
<div class="display-none" id="savingDepositF3">
    @if(isset($product) && (in_array($product->formula_id,[SAVING_DEPOSIT_F3,WEALTH_DEPOSIT_F3,FOREIGN_CURRENCY_DEPOSIT_F4])))
        @if(count($product->product_range))
            <?php //dd(old('min_placement')[0]); ?>
            @foreach($product->product_range as $key => $value)

                <div id="saving_placement_range_f3_{{$key}}">
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
                                       name="min_placement_sdp3"
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
                                       name="max_placement_sdp3"
                                       value="{{ $value->max_range  }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-saving-placement-range-f3-button">
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Average Bonus Interest</label>
                                    <input type="text" class="form-control only_numeric" id="air"
                                           name="air_sdp3" value="{{$value->air}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Sibor Rate</label>
                                    <input type="text" class="form-control only_numeric" id="sibor_rate"
                                           name="sibor_rate_sdp3"  value="{{$value->sibor_rate}}"
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

        <div id="saving_placement_range_f3_0">
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
                               name="min_placement_sdp3"
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
                               name="max_placement_sdp3"
                               value="{{ old('max_placement') ? old('max_placement') :''  }}">

                    </div>

                </div>
                <div class="col-sm-2" id="add-saving-placement-range-f3-button">

                </div>

            </div>
            <div class="form-group ">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">Average Bonus Interest</label>
                            <input type="text" class="form-control only_numeric" id="air"
                                   name="air_sdp3"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Sibor Rate</label>
                            <input type="text" class="form-control only_numeric" id="sibor_rate"
                                   name="sibor_rate_sdp3"
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
        </div>
    @endif
    <div id="saving-placement-range-f3"></div>

</div>

