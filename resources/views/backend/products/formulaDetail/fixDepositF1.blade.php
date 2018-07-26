<div class="display-none" id="fixDepositF1">
    @if(isset($product) && (in_array($product->formula_id,[FIX_DEPOSIT_F1, FOREIGN_CURRENCY_DEPOSIT_F1])))
        @if(count($product->product_range))
            @foreach($product->product_range as $key => $value)

                <div id="placement_range_{{$key}}">
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
                                       name="min_placement[{{$key}}]"
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
                                       name="max_placement[{{$key}}]"
                                       value="{{ $value->max_range  }}">

                            </div>

                        </div>
                        <div class="col-sm-2" id="add-placement-range-button">
                            @if($key==0)
                                <button type="button"
                                        class="btn btn-info pull-left mr-15 add-placement-range-button 1"
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
                    <div class="form-group " id="">
                        {{Form::label('legend', 'Legend Type',['class'=>'col-sm-2 control-label'])}}
                        <div class="col-sm-8">
                            <select class="form-control" name="legend[{{$key}}]" id="legend">
                                <option value="">None</option>
                                @if($legends->count())
                                    @foreach($legends as $legend)
                                        <option value="{{$legend->id}}"
                                                @if($value->legend == $legend->id) selected="selected" @endif>{{$legend->title}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-2">
                        </div>
                    </div>
                    <?php $bonusInterest = $value->bonus_interest;
                    $tenures = json_decode($product->tenure); ?>
                    @if(count($product->tenure))


                        @foreach($tenures as $k => $v)

                            <div class="form-group {{$k}}" id="formula_detail_{{$key.$k}}">
                                <label for="title" class="col-sm-2 control-label"></label>

                                <div class="col-sm-6 ">
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Tenur</label>
                                            <input type="text" class="form-control tenure-{{$k}} only_numeric" id=""
                                                   name="tenure[{{$key}}][{{$k}}]"
                                                   value="{{$v}}"
                                                   placeholder="" onchange="changeTenureValue(this)"
                                                   @if($key!=0) readonly="readonly"@endif>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Bonus Interest</label>
                                            <input type="text" class="form-control only_numeric" id=""
                                                   name="bonus_interest[{{$key}}][{{$k}}]"
                                                   value="{{$bonusInterest[$k]}}"
                                                   placeholder="">

                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-1 col-sm-offset-1 " id="add-formula-detail-button">
                                    @if($key==0)
                                        @if($k==0)
                                            <button type="button"
                                                    class="btn btn-info pull-left mr-15"
                                                    id="add-formula-detail-{{$key}}{{count($tenures)}}"
                                                    data-formula-detail-id="{{count($tenures)}}"
                                                    data-range-id="{{count($product->product_range)}}"
                                                    onClick="addMoreFormulaDetail(this);"><i
                                                        class="fa fa-plus"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger -pull-right"
                                                    data-formula-detail-id="{{$k}}" data-range-id="{{$key}}"
                                                    id="remove-formula-detail-{{$key}}{{$k}}"
                                                    onClick="removeFormulaDetail(this);">
                                                <i class="fa fa-minus"> </i>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-sm-2">&emsp;</div>
                            </div>
                        @endforeach
                    @endif

                    <div id="new-formula-detail-{{$key}}"></div>

                </div>
            @endforeach
        @endif
    @else

        <div id="placement_range_0">
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
                               name="min_placement[0]"
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
                               name="max_placement[0]"
                               value="{{ old('max_placement') ? old('max_placement') :''  }}">

                    </div>

                </div>
                <div class="col-sm-2" id="add-placement-range-button">
                    <button type="button"
                            class="btn btn-info pull-left mr-15 add-placement-range-button"
                            data-range-id="0" onClick="addMorePlacementRange(this);"><i
                                class="fa fa-plus"></i>
                    </button>
                </div>

            </div>
            <div class="form-group " >
                <label for="title" class="col-sm-2 control-label">Legend Type</label>
                <div class="col-sm-8">
                    <select class="form-control" name="legend[0]">
                        <option value="">None</option>
                        @if($legends->count())
                            @foreach($legends as $legend)
                                <option value="{{$legend->id}}"
                                        @if(old('legend')==$legend->id) selected="selected" @endif>{{$legend->title}}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
            <div class="form-group 0" id="formula_detail_00">
                <label for="title" class="col-sm-2 control-label"></label>

                <div class="col-sm-6 ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="">Tenure</label>
                            <input type="text" class="form-control tenure-0 only_numeric" id=""
                                   data-formula-detail-id="0"
                                   name="tenure[0][]"
                                   placeholder="" onchange="changeTenureValue(this)">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Bonus Interest</label>
                            <input type="text" class="form-control only_numeric" id=""
                                   name="bonus_interest[0][]"
                                   placeholder="">

                        </div>

                    </div>
                </div>
                <div class="col-sm-1 col-sm-offset-1 " id="add-formula-detail-button">
                    <button type="button"
                            class="btn btn-info pull-left mr-15"
                            id="add-formula-detail-00"
                            data-formula-detail-id="0" data-range-id="0"
                            onClick="addMoreFormulaDetail(this);"><i
                                class="fa fa-plus"></i>
                    </button>

                </div>
                <div class="col-sm-2">&emsp;</div>
            </div>
            <div id="new-formula-detail-0"></div>
        </div>
    @endif
    <div id="new-placement-range"></div>

</div>

