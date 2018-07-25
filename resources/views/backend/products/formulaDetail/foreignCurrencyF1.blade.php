<?php
$currencyId = 0;
?>
<div class="display-none" id="foreignCurrencyF1">
    <div class="row " style="padding: 10px;" id="f1-currency-range-<?php echo $currencyId;?>">
        <div class="col-md-11 ">
            <div class="box box-info">
                <div class="box-header with-border ">

                    <a href="#foreignCurrencyF1-{{$currencyId}}" class="" role="button" data-toggle="collapse"
                       aria-expanded="true"
                            ><h3 class="box-title">Currency Detail </h3></a>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool"
                                aria-controls="#foreignCurrencyF1-{{$currencyId}}"
                                onclick="showHide(this);"><i class="fa fa-minus"></i>
                        </button>
                    </div>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row collapse in" id="foreignCurrencyF1-{{$currencyId}}" aria-expanded="true" style="">

                        <div class="form-group ">
                            <label for="title" class="col-sm-2 control-label">Currency Type</label>

                            <div class="col-sm-8">
                                <select class="form-control" name="currency[{{$currencyId}}]">
                                    <option value="">None</option>
                                    @if($currencies->count())
                                        @foreach($currencies as $currency)
                                            <option value="{{$currency->id}}"
                                                    @if(old('currency')==$currency->id) selected="selected" @endif>{{$currency->currency.' ('.($currency->code.')')}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-2">
                            </div>
                        </div>
                        <!-- Fixed Deposit Formula for ForeignCurrency -->
                        <div id="fcdp-f1-range-0">
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
                                               name="min_placement[{{$currencyId}}][0]"
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
                                               name="max_placement[{{$currencyId}}][0]"
                                               value="{{ old('max_placement') ? old('max_placement') :''  }}">

                                    </div>

                                </div>
                                <div class="col-sm-2" id="add-placement-range-button">
                                    <button type="button"
                                            class="btn btn-info pull-left mr-15 add-placement-range-button" data-currency-id="{{$currencyId}}"
                                            data-range-id="0" onClick="addMorePlacementRange(this);"><i
                                                class="fa fa-plus"></i>
                                    </button>
                                </div>

                            </div>
                            <div class="form-group ">
                                <label for="title" class="col-sm-2 control-label">Legend Type</label>

                                <div class="col-sm-8">
                                    <select class="form-control" name="legend[{{$currencyId}}][0]">
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
                                                   name="tenure[{{$currencyId}}][0][]"
                                                   placeholder="" onchange="changeTenureValue(this)">

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Bonus Interest</label>
                                            <input type="text" class="form-control only_numeric" id=""
                                                   name="bonus_interest[{{$currencyId}}][0][]"
                                                   placeholder="">

                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-1 col-sm-offset-1 " id="add-formula-detail-button">
                                    <button type="button"
                                            class="btn btn-info pull-left mr-15"
                                            id="add-formula-detail-00" data-currency-id="{{$currencyId}}"
                                            data-formula-detail-id="0" data-range-id="0"
                                            onClick="addMoreFormulaDetail(this);"><i
                                                class="fa fa-plus"></i>
                                    </button>

                                </div>
                                <div class="col-sm-2">&emsp;</div>
                            </div>
                            <div id="new-formula-detail-0"></div>
                        </div>

                        <div id="new-fcdp-f1-range-{{$currencyId}}"></div>
                        <!-- /End Fixed Deposit Formula for Foreign Currency -->

                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-1 " id="add-foreign-currency-f1-detail-button">
            <button type="button"
                    class="btn btn-info pull-left mr-15"
                    data-currency-id="{{$currencyId}}"
                    onClick="addMoreCurrencyRange(this);"><i
                        class="fa fa-plus"></i>
            </button>

        </div>
    </div>
    <div id="new-foreign-currency-range-f1">

    </div>
</div>
<script>

    function showHide(obj) {

        var ariaControl = obj.getAttribute('aria-controls');
        $(obj).find('i').toggleClass('fa-minus fa-plus');
        var ariaExpanded = $(ariaControl).attr("aria-expanded");

        if (ariaExpanded == 'true') {
            $(ariaControl).collapse('hide');
        }
        else {
            $(ariaControl).collapse('show');
        }
    }


</script>
