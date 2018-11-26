<div class="display-none" id="loanF1">
    @if(isset($product) && (in_array($product->formula_id,[LOAN_F1])))
        @if(count($product->product_range))
            <?php $ProductRanges = $product->product_range ?>

            <div class="form-group" id="rate-type-content">
                <label for="title" class="col-sm-2 control-label">Rate type</label>

                <div class="col-sm-8">
                    <select class="form-control" name="rate_type_f1" id="rate-type">
                        <option value="{{FIXED_RATE}}" @if($ProductRanges[0]->rate_type==FIXED_RATE) selected="selected" @endif>{{FIXED_RATE}}</option>
                        <option value="{{FLOATING_RATE}}" @if($ProductRanges[0]->rate_type==FLOATING_RATE) selected="selected" @endif>{{FLOATING_RATE}}</option>
                    </select>
                </div>
                <input type="hidden" class="form-control" id="" name="rate_type_name_f1" value="" placeholder="">
                <div class="col-sm-2">
                </div>
            </div>
            <div class="form-group">
                <label for="property_type" class="col-sm-2 control-label">Property type</label>

                <div class="col-sm-8">
                    <select class="form-control" name="property_type_f1" id="property-type">
                        <option value="{{HDB_PROPERTY}}"  @if($ProductRanges[0]->property_type==HDB_PROPERTY) selected="selected" @endif>{{HDB_PROPERTY}}</option>
                        <option value="{{PRIVATE_PROPERTY}}" @if($ProductRanges[0]->property_type==PRIVATE_PROPERTY) selected="selected" @endif>{{PRIVATE_PROPERTY}}</option>
                        <option value="{{HDB_PRIVATE_PROPERTY}}" @if($ProductRanges[0]->property_type==HDB_PRIVATE_PROPERTY) selected="selected" @endif>{{HDB_PRIVATE_PROPERTY}}</option>
                        <option value="{{COMMERCIAL_PROPERTY}}" @if($ProductRanges[0]->property_type==COMMERCIAL_PROPERTY) selected="selected" @endif>{{COMMERCIAL_PROPERTY}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
            <div class="form-group">
                <label for="completion_status" class="col-sm-2 control-label">Completion Status</label>

                <div class="col-sm-8">
                    <select class="form-control" name="completion_status_f1" id="completion-status">
                        <option value="{{COMPLETE}}" @if($ProductRanges[0]->completion_status==COMPLETE) selected="selected" @endif>{{COMPLETE}}</option>
                        <option value="{{BUC}}" @if($ProductRanges[0]->completion_status==BUC) selected="selected" @endif>{{BUC}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                </div>
            </div>

            @foreach($product->product_range as $key => $value)

                    <div id="home_loan_range_f1_{{$key}}">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label"></label>

                            <div class="col-sm-8 ">

                                <div class="col-md-3 ">
                                    <label for="">Year</label>

                                    <select class="form-control tenure-0" name="tenure_f1[{{$key}}]">
                                        @for($i=1;$i<=6;$i++)
                                            <option name="{{$i}}"
                                                    @if(isset($value->tenure) && $value->tenure==$i) selected @endif>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="">Rate type</label>
                                    <select class="form-control" name="floating_rate_type_f1[{{$key}}]" id="">
                                        <option value="{{FIX_RATE_TYPE}}" @if($value->floating_rate_type==FIX_RATE_TYPE) selected="selected" @endif>{{FIX_RATE_TYPE}}</option>
                                        <option value="{{SIBOR_RATE_TYPE}}" @if($value->floating_rate_type==SIBOR_RATE_TYPE) selected="selected" @endif>{{SIBOR_RATE_TYPE}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2 ">
                                    <label for="">Bonus interest</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="bonus_interest_f1[{{$key}}]" value="{{$value->bonus_interest}}"
                                           placeholder="">
                                </div>
                                <div class="col-md-3">
                                    <label for="">Rate name (other)</label>
                                    <input type="text" class="form-control" id=""
                                           name="rate_name_other_f1[{{$key}}]" value="{{$value->rate_name_other}}"
                                           placeholder="">
                                </div>
                                <div class="col-md-2 ">
                                    <label for="">Rate interest (other)</label>
                                    <input type="text" class="form-control only_numeric" id=""
                                           name="rate_interest_other_f1[{{$key}}]" value="{{$value->rate_interest_other}}"
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
                <div id="home-loan-range-f1"></div>
                <div class="form-group">
                    <label for="title" class="col-sm-2 control-label"></label>
                    <div class="col-sm-8 ">

                        <div class="col-md-3 ">
                            <label for="">Year</label>
                            <input type="text" class="form-control" id=""
                                   name="there_after"  readonly value="There After"
                                   placeholder="">
                        </div>
                        <div class="col-md-2">
                            <label for="">Rate type</label>
                            <select class="form-control" name="there_after_rate_type" id="">
                                <option value="{{FIX_RATE_TYPE}}" @if($value->there_after_rate_type==FIX_RATE_TYPE) selected="selected" @endif >{{FIX_RATE_TYPE}}</option>
                                <option value="{{SIBOR_RATE_TYPE}}" @if($value->there_after_rate_type==SIBOR_RATE_TYPE) selected="selected" @endif >{{SIBOR_RATE_TYPE}}</option>
                            </select>
                        </div>
                        <div class="col-md-2 ">
                            <label for="">Bonus interest</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="there_after_bonus_interest" value="{{$value->there_after_bonus_interest}}"
                                   placeholder="">
                        </div>
                        <div class="col-md-3">
                            <label for="">Rate name (other)</label>
                            <input type="text" class="form-control" id=""
                                   name="there_after_rate_type_name_other" value="{{$value->there_after_rate_name_other}}"
                                   placeholder="">
                        </div>
                        <div class="col-md-2 ">
                            <label for="">Rate interest (other)</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="there_after_rate_interest_other" value="{{$value->there_after_rate_interest_other}}"
                                   placeholder="">
                        </div>
                    </div>
                    <div class="col-sm-2">
                    </div>
                </div>
        @endif
    @else
        <div class="form-group" id="rate-type-content">
            <label for="title" class="col-sm-2 control-label">Rate type</label>

            <div class="col-sm-8">
                <select class="form-control" name="rate_type_f1" id="rate-type">
                    <option value="{{FIXED_RATE}}">{{FIXED_RATE}}</option>
                    <option value="{{FLOATING_RATE}}">{{FLOATING_RATE}}</option>
                </select>
            </div>
            <input type="hidden" class="form-control" id="" name="rate_type_name_f1" value="" placeholder="">
            <div class="col-sm-2">
            </div>
        </div>
        <div class="form-group">
            <label for="property_type" class="col-sm-2 control-label">Property type</label>

            <div class="col-sm-8">
                <select class="form-control" name="property_type_f1" id="property-type">
                    <option value="{{HDB_PROPERTY}}">{{HDB_PROPERTY}}</option>
                    <option value="{{PRIVATE_PROPERTY}}">{{PRIVATE_PROPERTY}}</option>
                    <option value="{{HDB_PRIVATE_PROPERTY}}">{{HDB_PRIVATE_PROPERTY}}</option>
                    <option value="{{COMMERCIAL_PROPERTY}}">{{COMMERCIAL_PROPERTY}}</option>
                </select>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
        <div class="form-group">
            <label for="completion_status" class="col-sm-2 control-label">Completion Status</label>

            <div class="col-sm-8">
                <select class="form-control" name="completion_status_f1" id="completion-status">
                    <option value="{{COMPLETE}}">{{COMPLETE}}</option>
                    <option value="{{BUC}}">{{BUC}}</option>
                </select>
            </div>
            <div class="col-sm-2">
            </div>
        </div>

        <div id="home_loan_range_f1_0">
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-8 ">

                    <div class="col-md-3 ">
                        <label for="">Year</label>

                        <select class="form-control tenure-0" name="tenure_f1[0]">
                            @for($i=1;$i<=6;$i++)
                                <option name="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="">Rate type</label>
                        <select class="form-control" name="floating_rate_type_f1[0]" id="">
                            <option value="{{FIX_RATE_TYPE}}" >{{FIX_RATE_TYPE}}</option>
                            <option value="{{SIBOR_RATE_TYPE}}" >{{SIBOR_RATE_TYPE}}</option>
                        </select>
                    </div>
                    <div class="col-md-2 ">
                        <label for="">Bonus interest</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="bonus_interest_f1[0]" value=""
                               placeholder="">
                    </div>
                    <div class="col-md-3">
                        <label for="">Rate name (other)</label>
                        <input type="text" class="form-control" id=""
                               name="rate_name_other_f1[0]" value=""
                               placeholder="">
                    </div>
                    <div class="col-md-2 ">
                        <label for="">Rate interest (other)</label>
                        <input type="text" class="form-control only_numeric" id=""
                               name="rate_interest_other_f1[0]" value=""
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
        <div id="home-loan-range-f1"></div>
        <div class="form-group">
            <label for="title" class="col-sm-2 control-label"></label>
            <div class="col-sm-8 ">

                <div class="col-md-3 ">
                    <label for="">Year</label>
                    <input type="text" class="form-control" id=""
                           name="there_after"  readonly value="There After"
                           placeholder="">
                </div>
                <div class="col-md-2">
                    <label for="">Rate type</label>
                    <select class="form-control" name="there_after_rate_type" id="">
                        <option value="{{FIX_RATE_TYPE}}" >{{FIX_RATE_TYPE}}</option>
                        <option value="{{SIBOR_RATE_TYPE}}" >{{SIBOR_RATE_TYPE}}</option>
                    </select>
                </div>
                <div class="col-md-2 ">
                    <label for="">Bonus interest</label>
                    <input type="text" class="form-control only_numeric" id=""
                           name="there_after_bonus_interest" value=""
                           placeholder="">
                </div>
                <div class="col-md-3">
                    <label for="">Rate name (other)</label>
                    <input type="text" class="form-control" id=""
                           name="there_after_rate_name_other" value=""
                           placeholder="">
                </div>
                <div class="col-md-2 ">
                    <label for="">Rate interest (other)</label>
                    <input type="text" class="form-control only_numeric" id=""
                           name="there_after_rate_interest_other" value=""
                           placeholder="">
                </div>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
    @endif

</div>

