<div class="display-none" id="fixDepositF1">
@if(count(old('min_placement')))
    <?php //dd(old('min_placement')[0]); ?>
    @foreach(old('min_placement') as $key => $value)

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
                        <input type="text" class="form-control pull-right "
                               name="min_placement[{{$key}}]"
                               value="{{ old('min_placement')[$key]  }}">

                    </div>
                </div>

                <div class="col-sm-4 ">

                    <div class="input-group date ">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-danger">Max
                                Placement
                            </button>
                        </div>
                        <input type="text" class="form-control pull-right"
                               name="max_placement[{{$key}}]"
                               value="{{ old('max_placement')[$key]  }}">

                    </div>

                </div>
                <div class="col-sm-2">
                    <button type="button"
                            class="btn btn-info pull-left mr-15 add-placement-range-button 1"
                            data-range-id="0"
                            onClick="addMorePlacementRange(this);"><i
                                class="fa fa-plus"></i>
                    </button>
                    <button type="button"
                            class="btn btn-danger -pull-right  remove-placement-range-button display-none"
                            data-range-id="0" onClick="removePlacementRange(this);">
                        <i
                                class="fa fa-minus"> </i>
                    </button>
                </div>

            </div>
            @if(count(old('tenure')[$key]))

                @foreach(old('tenure')[$key] as $k => $v)

                    <div class="form-group " id="formula_detail_{{$key}}">
                        <label for="title" class="col-sm-2 control-label"></label>

                        <div class="col-sm-6 ">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="">Tenur</label>
                                    <input type="text" class="form-control" id=""
                                           name="tenure[{{$key}}][{{$k}}]"
                                           value="{{old('tenure')[$key][$k]}}"
                                           placeholder="">

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Bonus Interest</label>
                                    <input type="text" class="form-control" id=""
                                           name="bonus_interest[{{$key}}][{{$k}}]"
                                           value=" {{old('bonus_interest')[$key][$k] }}"
                                           placeholder="">

                                </div>

                            </div>
                        </div>
                        <div class="col-sm-1 col-sm-offset-1 ">
                            <button type="button"
                                    class="btn btn-info pull-left mr-15"
                                    id="add-formula-detail-{{$key}}{{$k}}"
                                    data-formula-detail-id="{{$k}}"
                                    data-range-id="{{$key}}"
                                    onClick="addMoreFormulaDetail(this);"><i
                                        class="fa fa-plus"></i>
                            </button>
                            <button type="button"
                                    class="btn btn-danger -pull-right display-none"
                                    id="remove-formula-detail-{{$key}}{{$k}}"
                                    data-formula-detail-id="{{$k}}"
                                    data-range-id="{{$key}}"
                                    onClick="removeFormulaDetail(this);"><i
                                        class="fa fa-minus"> </i>
                            </button>
                        </div>
                        <div class="col-sm-2">&emsp;</div>
                    </div>
                @endforeach
            @endif

            <div id="new-formula-detail-{{$key}}"></div>

        </div>
    @endforeach

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
                    <input type="text" class="form-control pull-right "
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
                    <input type="text" class="form-control pull-right"
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
        <div class="form-group 0" id="formula_detail_00">
            <label for="title" class="col-sm-2 control-label"></label>

            <div class="col-sm-6 ">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="">Tenur</label>
                        <input type="text" class="form-control tenure-0" id="" data-formula-detail-id="0"
                               name="tenure[0][]"
                               placeholder="" onchange="changeTenureValue(this)">

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="">Bonus Interest</label>
                        <input type="text" class="form-control" id=""
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

