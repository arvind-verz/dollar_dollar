<div class="display-none" id="loanF1">
    @if(isset($product) && (in_array($product->formula_id,[LOAN_F1])))
        @if(count($product->product_range))
            <?php $ProductRanges = $product->product_range ?>
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
                               name="min_placement_f1"
                               value="{{$ProductRanges[0]->min_range}}">

                    </div>
                </div>
                <div class="col-sm-4 ">
                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Max Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right only_numeric"
                               name="max_placement_f1"
                               value="{{$ProductRanges[0]->max_range}}">
                    </div>
                </div>
                <div class="col-sm-2" id="add-home-loan-range-f1-button">
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Rate type</label>

                <div class="col-sm-8">
                    <select class="form-control" name="rate_type_f1" id="currency">
                        <option value="">None</option>
                        <option value="{{FIX_RATE}}" @if($ProductRanges[0]->rate_type==FIX_RATE) selected="selected" @endif>{{FIX_RATE}}</option>
                        <option value="{{FLOATING_RATE}}" @if($ProductRanges[0]->rate_type==FLOATING_RATE) selected="selected" @endif>{{FLOATING_RATE}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
            <div class="form-group">
                <label for="property_type" class="col-sm-2 control-label">Property type</label>

                <div class="col-sm-8">
                    <select class="form-control" name="property_type_f1" id="property-type">
                        <option value="">None</option>
                        <option value="{{HDB_PROPERTY}}"  @if($ProductRanges[0]->property_type==HDB_PROPERTY) selected="selected" @endif>{{HDB_PROPERTY}}</option>
                        <option value="{{PRIVATE_PROPERTY}}" @if($ProductRanges[0]->property_type==PRIVATE_PROPERTY) selected="selected" @endif>{{PRIVATE_PROPERTY}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
            <div class="form-group">
                <label for="completion_status" class="col-sm-2 control-label">Completion Status</label>

                <div class="col-sm-8">
                    <select class="form-control" name="completion_status_f1" id="completion-status">
                        <option value="">None</option>
                        <option value="{{COMPLETE}}" @if($ProductRanges[0]->completion_status==COMPLETE) selected="selected" @endif>{{COMPLETE}}</option>
                        <option value="{{BUC}}" @if($ProductRanges[0]->completion_status==BUC) selected="selected" @endif>{{BUC}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
                <div class="form-group ">
                    <label for="title" class="col-sm-2 control-label"></label>

                    <div class="col-sm-8 ">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="">Board rate type</label>
                                <select class="form-control" name="floating_rate_type_f1" id="">
                                    <option value="">None</option>
                                    <option value="{{FIX_RATE_TYPE}}" @if($ProductRanges[0]->floating_rate_type==COMPLETE) selected="selected" @endif>{{FIX_RATE_TYPE}}</option>
                                    <option value="{{SIBOR_RATE_TYPE}}" @if($ProductRanges[0]->floating_rate_type==COMPLETE) selected="selected" @endif>{{SIBOR_RATE_TYPE}}</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Interest</label>
                                <input type="text" class="form-control only_numeric" id="board_rate_0"
                                       name="board_rate_f1" value="{{$ProductRanges[0]->board_rate}}"
                                       placeholder="">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2">&emsp;</div>
                </div>
            @foreach($product->product_range as $key => $value)

                    <div id="home_loan_range_f1_{{$key}}">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label"></label>

                            <div class="col-sm-8 ">

                                <div class="col-md-6 ">
                                    <label for="">Tenure</label>
                                    <input type="text" class="form-control tenure-0 only_numeric" id=""
                                           data-formula-detail-id="0"
                                           name="tenure_f1[{{$key}}]" value="{{$value->tenure}}"
                                           placeholder="">
                                </div>
                                <div class="col-md-6 ">
                                    <label for="">Bonus Interest</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_f1[{{$key}}]" value="{{$value->bonus_interest}}"
                                           placeholder="">
                                </div>

                            </div>
                            <div class="col-sm-2" id="add-home-loan-placement-range-f1-button">
                                @if($key==0)
                                    <button type="button"
                                            class="btn btn-info pull-left mr-15 mt-25 add-home-loan-range-f1-button"
                                            data-range-id="{{count($product->product_range)}}" onClick="addMorePlacementRange(this);"><i
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
                    </div>
            @endforeach
        @endif
    @else


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
                           name="min_placement_f1"
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
                           name="max_placement_f1"
                           value="{{ old('max_placement') ? old('max_placement') :''  }}">
                </div>
            </div>
            <div class="col-sm-2" id="add-home-loan-range-f1-button">
            </div>
        </div>
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label">Rate type</label>

            <div class="col-sm-8">
                <select class="form-control" name="rate_type_f1" id="currency">
                    <option value="">None</option>
                    <option value="{{FIX_RATE}}">{{FIX_RATE}}</option>
                    <option value="{{FLOATING_RATE}}">{{FLOATING_RATE}}</option>
                </select>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
        <div class="form-group">
            <label for="property_type" class="col-sm-2 control-label">Property type</label>

            <div class="col-sm-8">
                <select class="form-control" name="property_type_f1" id="property-type">
                    <option value="">None</option>
                    <option value="{{HDB_PROPERTY}}">{{HDB_PROPERTY}}</option>
                    <option value="{{PRIVATE_PROPERTY}}">{{PRIVATE_PROPERTY}}</option>
                </select>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
        <div class="form-group">
            <label for="completion_status" class="col-sm-2 control-label">Completion Status</label>

            <div class="col-sm-8">
                <select class="form-control" name="completion_status_f1" id="completion-status">
                    <option value="">None</option>
                    <option value="{{COMPLETE}}">{{COMPLETE}}</option>
                    <option value="{{BUC}}">{{BUC}}</option>
                </select>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
        <div class="form-group ">
            <label for="title" class="col-sm-2 control-label"></label>

            <div class="col-sm-8 ">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="">Board rate type</label>
                        <select class="form-control" name="floating_rate_type_f1" id="">
                            <option value="">None</option>
                            <option value="{{FIX_RATE_TYPE}}">{{FIX_RATE_TYPE}}</option>
                            <option value="{{SIBOR_RATE_TYPE}}">{{SIBOR_RATE_TYPE}}</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Interest</label>
                        <input type="text" class="form-control only_numeric" id="board_rate_0"
                               name="board_rate_f1"
                               placeholder="">
                    </div>
                </div>
            </div>
            <div class="col-sm-2">&emsp;</div>
        </div>
        <div id="home_loan_range_f1_0">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">

                    <div class="col-md-6 ">
                        <label for="">Tenure</label>
                        <input type="text" class="form-control tenure-0 only_numeric" id=""
                               data-formula-detail-id="0"
                               name="tenure_f1[0]"
                               placeholder="">
                    </div>
                    <div class="col-md-6 ">
                        <label for="">Bonus Interest</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="bonus_interest_f1[0]"
                               placeholder="">
                    </div>

                </div>
                <div class="col-sm-2" id="add-home-loan-placement-range-f1-button">
                    <button type="button"
                            class="btn btn-info pull-left mr-15 mt-25 add-home-loan-range-f1-button"
                            data-range-id="0" onClick="addMorePlacementRange(this);"><i
                                class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif
        <div id="home-loan-range-f1"></div>
</div>

