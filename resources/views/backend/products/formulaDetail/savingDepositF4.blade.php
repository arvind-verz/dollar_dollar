<div class="display-none" id="savingDepositF4">
    @if(isset($product) && (in_array($product->formula_id,[SAVING_DEPOSIT_F4,  WEALTH_DEPOSIT_F4,  FOREIGN_CURRENCY_DEPOSIT_F5])))

        @if(count($product->product_range))
            <?php $prevMax = 0 ?>
        @foreach($product->product_range as $key => $value)

                <div id="saving_placement_range_f4_{{$key}}">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Formula
                            Detail</label>

                        <div class="col-sm-8 ">

                            <div class="input-group date ">
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-danger">
                                        @if($key==0)First @else Next @endif
                                    </button>
                                </div>
                                <input type="text" class="form-control pull-right only_numeric"
                                       name="max_placement_sdp4[{{$key}}]"
                                       value="{{ ($value->max_range - $prevMax)  }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-saving-placement-range-f4-button">
                            @if($key==0)
                                <button type="button"
                                        class="btn btn-info pull-left mr-15 add-saving-placement-range-f4-button"
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
                    $bonusInterest = $value->bonus_interest;
                    $boardRate = $value->board_rate;
                    ?>


                    <div class="form-group ">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-8 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest</label>
                                    <input type="text" class="form-control only_numeric" id="bonus_interest_{{$key}}"
                                           name="bonus_interest_sdp4[{{$key}}]" value="{{$bonusInterest}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Board Rate</label>
                                    <input type="text" class="form-control only_numeric" id="board_rate_{{$key}}"
                                           name="board_rate_sdp4[{{$key}}]" value="{{$boardRate}}"
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

        <div id="saving_placement_range_f4_0">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Formula Detail</label>


                <div class="col-sm-8 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_sdp4[0]"
                               value="{{ old('max_placement') ? old('max_placement') :''  }}">
                    </div>

                </div>
                <div class="col-sm-2" id="add-saving-placement-range-f4-button">
                    <button type="button"
                            class="btn btn-info pull-left mr-15 add-saving-placement-range-f4-button"
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
                            <label for="">Bonus Interest</label>
                            <input type="text" class="form-control only_numeric" id="bonus_interest_0"
                                   name="bonus_interest_sdp4[0]"
                                   placeholder="">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Board Rate</label>
                            <input type="text" class="form-control only_numeric" id="board_rate_0"
                                   name="board_rate_sdp4[0]"
                                   placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
        </div>
    @endif
    <div id="saving-placement-range-f4"></div>

</div>

