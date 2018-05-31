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

                            <li><a href="#formula-detail" data-toggle="tab">Formula Detail</a></li>
                            <li class="active"><a href="#product-detail" data-toggle="tab">Product Detail</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{PRODUCT_MODULE_SINGLE.' '.ADD_ACTION}}</li>

                        </ul>


                        <div class="box-body">

                            <button type="button" class="btn bg-purple" data-toggle="modal"
                                    data-target="#model-product-name">
                                <i class="glyphicon glyphicon-plus"></i> {{ADD_ACTION.' '.PRODUCT_NAME_MODULE_SINGLE}}
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal"
                                    data-target="#model-price-range">
                                <i class="glyphicon glyphicon-plus"></i> {{ADD_ACTION.' '.PLACEMENT_RANGE_MODULE_SINGLE}}
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#model-formula-detail">
                                <i class="glyphicon glyphicon-plus"></i> {{ADD_ACTION.' '.FORMULA_DETAIL_MODULE_SINGLE}}
                            </button>
                            <hr/>
                        </div>
                        <div class="box-body">

                            {!! Form::open(['class' => 'form-horizontal','route' => 'promotion-products-add-db', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <!-- Custom Tabs (Pulled to the right) -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="product-detail">
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="name" id="name">
                                                <option value="">None</option>
                                                @if($product_names->count())
                                                    @foreach($product_names as $product_name)
                                                        <option value="{{$product_name->id}}"
                                                                @if(old('name')==$product_name->id) selected="selected" @endif>{{$product_name->product_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
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
                                        <label for="title" class="col-sm-2 control-label">Promotion Start Date</label>

                                        <div class="col-sm-10">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right"
                                                       name="promotion_start_date"
                                                       id="datepicker"
                                                       value="{{ old('promotion_start_date') ? date('Y-m-d', strtotime(old('promotion_start_date'))) :date('Y-m-d', time())  }}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Promotion End Date</label>

                                        <div class="col-sm-10">
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right"
                                                       name="promotion_end_date"
                                                       id="datepicker1"
                                                       value="{{ old('promotion_end_date') ? date('Y-m-d', strtotime(old('promotion_end_date'))) :date('Y-m-d', time())  }}">
                                            </div>
                                        </div>
                                    </div>
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


        @include('backend.dataModel.addProductName')
        @include('backend.dataModel.addPriceRange')
        @include('backend.dataModel.addFormulaDetail')

    </section>

    <!-- /.content -->
    <script type="text/javascript">

        $(document).ready(function () {
            var promotion_type = $("#product-type").val();
            var formula = $("#hidden-formula").val();
            var formula_product_id = $("#formula_product_id").val();
            var placement_range = $("#hidden-placement-range").val();
            var product_name_id = $("#name").val();

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
            if ((product_name_id.length != 0)) {
                //alert(formula);
                $.ajax({
                    method: "POST",
                    url: "{{url('/admin/get-formula-detail')}}",
                    data: {product_name_id: product_name_id},
                    cache: false,
                    success: function (data) {
                        $("#formula-detail").html(data);
                    }
                });

            }
            if ((formula_product_id.length != 0) && (formula_product_id.length != 0)) {
                //alert(formula);
                $.ajax({
                    method: "POST",
                    url: "{{url('/admin/get-placement-range')}}",
                    data: {formula_product_id: formula_product_id, placement_range: placement_range},
                    cache: false,
                    success: function (data) {
                        $("select[name='placement_range']").html(data);
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
        $("#formula_product_id").on("change", function () {
            var formula_product_id = $(this).val();
            var placement_range = $("#hidden-placement-range").val();
            //alert(formula_product_id + ' ' + placement_range );
            $.ajax({
                method: "POST",
                url: "{{url('/admin/get-placement-range')}}",
                data: {formula_product_id: formula_product_id, placement_range: placement_range},
                cache: false,
                success: function (data) {
                    $("select[name='placement_range']").html(data);
                }
            });

        });
        $("#name").on("change", function (e) {
            var product_name_id = $(this).val();
            var $_target = $(e.currentTarget);

            //alert(product_name_id );
            $.ajax({
                method: "POST",
                url: "{{url('/admin/get-formula-detail')}}",
                data: {product_name_id: product_name_id},
                cache: false,
                success: function (data) {
                    $("#formula-detail").html(data);
                    var panelBody = $("#formula-detail").attr("data-widget");
                    alert(panelBody);
                    if (panelBody) {
                        panelBody.collapse('toggle')
                    }
                }
            });

        });

    </script>
@endsection
