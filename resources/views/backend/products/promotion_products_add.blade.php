@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( PRODUCT_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li class="active"><a href="{{ route('promotion-products') }}">{{PRODUCT_MODULE}}</a></li>
            <li class="active">{{PRODUCT_MODULE_SINGLE.' '.ADD_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">

                            <li><a href="#basic-detail" data-toggle="tab">Other Detail</a></li>
                            <li><a href="#formula-detail" data-toggle="tab">Formula Detail</a></li>
                            <li class="active"><a href="#product-detail" data-toggle="tab">Product Detail</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{PRODUCT_MODULE_SINGLE.' '.ADD_ACTION}}</li>

                        </ul>
                        <div class="box-body">

                            {!! Form::open(['class' => 'form-horizontal','route' => 'promotion-products-add-db', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <!-- Custom Tabs (Pulled to the right) -->

                            <div class="tab-content">
                                <div class="tab-pane active" id="product-detail">
                                    <div class="form-group">
                                        {{Form::label('name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('name', old('name'), ['id'=>'','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Bank</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="bank">
                                                <option value="">None</option>
                                                @if($banks->count())
                                                    @foreach($banks as $bank)
                                                        <option value="{{$bank->id}}"
                                                                @if(old('bank')==$bank->id) selected="selected" @endif>{{$bank->title}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Product Type</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="product_type" id="product-type">
                                                <option value="">None</option>
                                                @if($promotion_types->count())
                                                    @foreach($promotion_types as $product_type)
                                                        <option value="{{$product_type->id}}"
                                                                @if(old('product_type') == $product_type->id) selected="selected" @endif>{{$product_type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Formula</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="formula">
                                                <option value="">None</option>
                                            </select>
                                            <input type="hidden" id="hidden-formula" value="{{ old('formula') }}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Date Range</label>

                                        <div class="col-sm-4">
                                            <div class="input-group date">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-success">Start
                                                        Date
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker1"
                                                       name="promotion_start_date"
                                                       value="{{ old('promotion_start_date') ? date('Y-m-d', strtotime(old('promotion_start_date'))) :date('Y-m-d', time())  }}">

                                                <div class="input-group-addon ">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4 ">

                                            <div class="input-group date ">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-danger">End
                                                        Date
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker1"
                                                       name="promotion_end_date"
                                                       value="{{ old('promotion_end_date') ? date('Y-m-d', strtotime(old('promotion_end_date'))) :date('Y-m-d', time())  }}">

                                                <div class="input-group-addon ">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="status"
                                                    style="width: 100%;">
                                                <option value="1" @if(old('status') == 1) selected="selected" @endif>
                                                    Active
                                                </option>
                                                <option value="0" @if(old('status') == 0) selected="selected" @endif>
                                                    Deactivate
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Featured</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="featured"
                                                    style="width: 100%;">
                                                <option value="0" @if(old('featured') == 0) selected="selected" @endif >
                                                    No
                                                </option>
                                                <option value="1" @if(old('featured') == 1) selected="selected" @endif>
                                                    Yes
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="formula-detail">
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
                                                @if(count(old('tenure_type')[$key]))

                                                    @foreach(old('tenure_type')[$key] as $k => $v)

                                                        <div class="form-group " id="formula_detail_{{$key}}">
                                                            <label for="title" class="col-sm-2 control-label"></label>

                                                            <div class="col-sm-6 ">
                                                                <div class="form-row">
                                                                    <div class="col-md-4 mb-3">
                                                                        <label for="">Tenure Type</label>
                                                                        <select class="form-control "
                                                                                data-placeholder=""
                                                                                name="tenure_type[{{$key}}][{{$k}}]"
                                                                                style="width: 100%;">
                                                                            <option value="None" selected="selected">
                                                                                None
                                                                            </option>
                                                                            <option value="1"
                                                                                    @if(old('tenure_type')[$key][$k] == 1)selected="selected" @endif>
                                                                                Day
                                                                            </option>
                                                                            <option value="2"
                                                                                    @if(old('tenure_type')[$key][$k] == 2)selected="selected" @endif>
                                                                                Month
                                                                            </option>
                                                                            <option value="3"
                                                                                    @if(old('tenure_type')[$key][$k] == 3)selected="selected" @endif>
                                                                                Year
                                                                            </option>

                                                                        </select>
                                                                        <?php // dd(old('tenure')[$key][{{$k}}]));?>
                                                                    </div>
                                                                    <div class="col-md-4 mb-3">
                                                                        <label for="">Tenur</label>
                                                                        <input type="text" class="form-control" id=""
                                                                               name="tenure[{{$key}}][{{$k}}]"
                                                                               value="{{old('tenure')[$key][$k]}}"
                                                                               placeholder="">

                                                                    </div>
                                                                    <div class="col-md-4 mb-3">
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
                                                                        data-formula-detail-id="{{$k}}" data-range-id="{{$key}}"
                                                                        onClick="addMoreFormulaDetail(this);"><i
                                                                            class="fa fa-plus"></i>
                                                                </button>
                                                                <button type="button"
                                                                        class="btn btn-danger -pull-right display-none"
                                                                        id="remove-formula-detail-{{$key}}{{$k}}"
                                                                        data-formula-detail-id="{{$k}}" data-range-id="{{$key}}"
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
                                                <div class="col-sm-2">
                                                    <button type="button"
                                                            class="btn btn-info pull-left mr-15 add-placement-range-button 1"
                                                            data-range-id="0" onClick="addMorePlacementRange(this);"><i
                                                                class="fa fa-plus"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-danger -pull-right  remove-placement-range-button display-none"
                                                            data-range-id="0" onClick="removePlacementRange(this);"><i
                                                                class="fa fa-minus"> </i>
                                                    </button>
                                                </div>

                                            </div>
                                            <div class="form-group " id="formula_detail_0">
                                                <label for="title" class="col-sm-2 control-label"></label>

                                                <div class="col-sm-6 ">
                                                    <div class="form-row">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Tenure Type</label>
                                                            <select class="form-control "
                                                                    data-placeholder="" name="tenure_type[0][]"
                                                                    style="width: 100%;">
                                                                <option value="None" selected="selected">None</option>
                                                                <option value="1">Day</option>
                                                                <option value="2">Month</option>
                                                                <option value="3">Year</option>

                                                            </select>

                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Tenur</label>
                                                            <input type="text" class="form-control" id=""
                                                                   name="tenure[0][]"
                                                                   placeholder="">

                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="">Bonus Interest</label>
                                                            <input type="text" class="form-control" id=""
                                                                   name="bonus_interest[0][]"
                                                                   placeholder="">

                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-sm-1 col-sm-offset-1 ">
                                                    <button type="button"
                                                            class="btn btn-info pull-left mr-15"
                                                            id="add-formula-detail-00"
                                                            data-formula-detail-id="0" data-range-id="0"
                                                            onClick="addMoreFormulaDetail(this);"><i
                                                                class="fa fa-plus"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-danger -pull-right display-none"
                                                            id="remove-formula-detail-00"
                                                            data-formula-detail-id="0" data-range-id="0"
                                                            onClick="removeFormulaDetail(this);"><i
                                                                class="fa fa-minus"> </i>
                                                    </button>
                                                </div>
                                                <div class="col-sm-2">&emsp;</div>
                                            </div>
                                            <div id="new-formula-detail-0"></div>
                                        </div>
                                    @endif
                                    <div id="new-placement-range"></div>

                                </div>

                                <div class="tab-pane" id="basic-detail">
                                    <div class="form-group">
                                        {{Form::label('criteria', 'Criteria',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('criteria', old('criteria'), ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{Form::label('key_points', 'Key Points',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('key_points', old('key_points'), ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_poster', 'Advertisement Image',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::file('ad_poster', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Advertisement Type</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="ad_type"
                                                    style="width: 100%;">
                                                <option value="">None</option>
                                                <option value="1" @if(old('ad_type') == 1) selected="selected" @endif>
                                                    Horizontal
                                                </option>
                                                <option value="2" @if(old('ad_type') == 2) selected="selected" @endif>
                                                    Vertical
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_link', 'Advertisement Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_link', old('ad_link'), ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{Form::label('main_page_link', 'Main Page Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('main_page_link', old('main_page_link'), ['id'=>'link_main_page','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('tc_link', 'T&C Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('tc_link', old('tc_link'), ['id'=>'link_tc','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('promotion-products') }}"
                                   class="btn btn-default"><i class="fa fa-close">
                                    </i> Cancel</a>

                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-check"></i>
                                    Add
                                </button>
                            </div>
                            <!-- /.tab-content -->
                            {!! Form::close() !!}

                        </div>
                    </div>
                    <!-- nav-tabs-custom -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!-- /.box -->

    </section>

    <!-- /.content -->
    <script type="text/javascript">

        $(document).ready(function () {
            var promotion_type = $("#product-type").val();
            var formula = $("#hidden-formula").val();


            //alert(product_name_id);
            if ((promotion_type.length != 0) && (formula.length != 0)) {
                //alert(formula);
                $.ajax({
                    method: "POST",
                    url: "{{url('/admin/promotion-products/get-formula')}}",
                    data: {promotion_type: promotion_type, formula: formula},
                    cache: false,
                    success: function (data) {
                        $("select[name='formula']").html(data);
                    }
                });

            }


        });
        $("select[name='product_type']").on("change", function () {
            var promotion_type = $(this).val();
            var formula = $("#formula").val();
            //alert(formula);
            $.ajax({
                method: "POST",
                url: "{{url('/admin/promotion-products/get-formula')}}",
                data: {promotion_type: promotion_type, formula: formula},
                cache: false,
                success: function (data) {
                    $("select[name='formula']").html(data);
                }
            });

        });
    </script>
@endsection
