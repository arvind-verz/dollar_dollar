@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( PRODUCT_MODULE )}}
            <small>{{$productType}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li class="active"><a
                        href="{{ route('promotion-products',['productTypeId'=>$productTypeId]) }}">{{$productType}}</a>
            </li>
            <li class="active">{{'Product '.ADD_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom" id="rootwizard">
                        <ul class="nav nav-tabs pull-right">
                            <a href="#basic-detail" id="tab-3" data-toggle="tab"  class="display-none" >Other Detail</a>
                            <a href="#formula-detail" id="tab-2" data-toggle="tab"  class="display-none">Formula Detail</a>
                            <a href="#product-detail" id="tab-1" class="display-none" data-toggle="tab">Product
                                Detail</a>

                            <li><a  data-href-target="#tab-3"   class="all-validation" data-index="1">Other Detail</a></li>
                            <li><a  data-href-target="#tab-2" data-index="0"  class="all-validation">Formula Detail</a>
                            </li>
                            <li class="active"><a data-href-target="#tab-1" data-index="2"  class="all-validation" >Product
                                    Detail</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{'Product '.ADD_ACTION}}</li>
                        </ul>
                        <div class="box-body">

                            {!! Form::open(['id'=>'addProduct','class' => 'form-horizontal','route' => 'promotion-products-add-db', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <!-- Custom Tabs (Pulled to the right) -->

                            <div class="tab-content">
                                <div class="tab-pane active" id="product-detail">
                                    <div class="form-group">
                                        {{Form::label('name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('name', old('name'), ['id'=>'name','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Bank</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="bank" id="bank">
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
                                        {{Form::label('bank_sub_title', 'Bank Sub Title',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('bank_sub_title', old('bank_sub_title'), ['id' => '', 'class' => ' tiny-mce  form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Product Type</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="product_type" id="product-type"
                                                    readonly="readonly">
                                                @if($promotion_types->count())
                                                    @foreach($promotion_types as $product_type)
                                                        <option value="{{$product_type->id}}"
                                                                @if(old('product_type') == $product_type->id) selected="selected" @endif>{{$product_type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group display-none" id="apply-link">
                                        <input type="hidden" id="apply-link-status" name="apply_link_status" value="1"/>
                                        {{Form::label('apply_link', 'Apply Button Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-8">
                                            {{Form::text('apply_link', old('Apply Link'), ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        <div class="col-sm-2 " id="apply-status">
                                            <button type="button" data-status="true" id=""
                                                    class="btn btn-block btn-success btn-social"
                                                    onclick="changeApplyStatus(this)"><i class="fa fa-check"></i> Enable
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Shortlist Button Status</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="shortlist_status"
                                                    style="width: 100%;">
                                                <option value="1" selected="selected">
                                                    Active
                                                </option>
                                                <option value="0" >
                                                    Deactivate
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Formula</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="formula" id="formula">
                                                <option value="">None</option>
                                                @if($formulas->count())
                                                    @foreach($formulas as $formula)
                                                        <option value="{{$formula->id}}"
                                                                @if(old('formula') == $formula->id) selected="selected" @endif>{{$formula->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <input type="hidden" id="hidden-formula" value="{{ old('formula') }}">
                                        </div>
                                    </div>
                                    <div class="form-group" >
                                        {{Form::label('minimum_loan_amount', 'Minimum loan amount',['class'=>'col-sm-2 control-label','id'=>'placement-amount-content'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('minimum_loan_amount', old('minimum_loan_amount'), ['id'=>'minimum-loan-amount','class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    {{--<div class="form-group">
                                        {{Form::label('maximum_interest_rate', 'Interest Rate',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('maximum_interest_rate', old('maximum_interest_rate'), ['id'=>'maximum-interest-rate','class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                        </div>
                                    </div>--}}
                                        <div class="form-group">
                                            {{Form::label('lock_in', 'Lock In',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                {{Form::text('lock_in', old('lock_in'), ['id'=>'lock-in','class' => 'form-control only_numeric', 'placeholder' => ''])}}
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
                                                       data-date="{{ old('promotion_start_date') ? date('Y-m-d', strtotime(old('promotion_start_date'))) : null  }}"
                                                       name="promotion_start_date" id="promotion_start_date"
                                                       onchange="dateChange(this);"
                                                       value="{{ old('promotion_start_date') ? date('Y-m-d', strtotime(old('promotion_start_date'))) : null  }}">

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
                                                       data-date="{{ old('promotion_end_date') ? date('Y-m-d', strtotime(old('promotion_end_date'))) :null  }}"
                                                       name="promotion_end_date" id="promotion_end_date"
                                                       onchange="dateChange(this);"
                                                       value="{{ old('promotion_end_date') ? date('Y-m-d', strtotime(old('promotion_end_date'))) :null  }}">

                                                <div class="input-group-addon ">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 " id="ongoing">
                                            <button type="button" data-status="true" id="ongoing-status"
                                                    class="btn btn-block btn-success btn-social"
                                                    onclick="changeOnGoingStatus(this)"><i class="fa fa-check"></i>
                                                Ongoing
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group " id="until-end-section">
                                        <label for="title" class="col-sm-2 control-label">Until End Date</label>

                                        <div class="col-sm-10 ">

                                            <div class="input-group date ">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-danger">End
                                                        Date
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker1"
                                                       data-date="{{ old('until_end_date') ? date('Y-m-d', strtotime(old('until_end_date'))) :null  }}"
                                                       name="until_end_date" id="until-end-date"
                                                       value="{{ old('until_end_date') ? date('Y-m-d', strtotime(old('until_end_date'))) :null  }}">

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
                                                <option value="1" selected="selected">
                                                    Active
                                                </option>
                                                <option value="0" >
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
                                    <div class="box-footer wizard">
                                        <a href="{{ route('promotion-products',['productTypeId'=>$productTypeId]) }}"
                                           class="btn btn-default back"><i class="fa fa-close">
                                            </i> Cancel</a>
                                        <a href="javascript:;" data-href-target="#tab-2"  data-index="0"  class="all-validation btn btn-warning pull-right next">Next <i
                                                    class="fa  fa-angle-double-right "></i></a>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="formula-detail">
                                    <div class="form-group " id="formula-details-error-section">
                                        <h3 class="col-sm-12 col-md-12 col-lg-12 text-danger"> Formula details
                                            unavailable</h3>
                                    </div>
                                    @include('backend.products.formulaDetail.LoanF1')
                                    <div class="box-footer wizard">
                                        <a href="javascript:;" data-href-target="#tab-1"  data-index="2"  class="all-validation btn btn-warning previous"><i
                                                    class="fa  fa-angle-double-left"></i> Previous</a>
                                        <a href="javascript:;" data-href-target="#tab-3"  data-index="1"  class="all-validation btn btn-warning pull-right next">Next <i
                                                    class="fa  fa-angle-double-right "></i></a>
                                    </div>
                                </div>
                                <div class="tab-pane" id="basic-detail">
                                    <div class="form-group">
                                        {{Form::label('product_footer', 'Other Detail',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('product_footer', old('product_footer'), ['id' => '', 'class' => ' tiny-mce  form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_image', 'Ad Horizontal Image',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::file('ad_horizontal_image', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image
                                            size should be @if($productTypeId==ALL_IN_ONE_ACCOUNT)1140*160 @else 1140*160 @endif for better display
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_link', 'Ad Horizontal Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_horizontal_link', old('ad_horizontal_link'), ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_image_vertical', 'Ad Vertical Image',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::file('ad_image_vertical', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image
                                            size should be 280*140 for better display
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_vertical_link', 'Ad Vertical Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_vertical_link', old('ad_vertical_link'), ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_image_popup', 'Ad Horizontal Image Popup Bottom',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::file('ad_horizontal_image_popup', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image
                                            size should be 1140*500 for better display
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_link_popup', 'Ad Horizontal Link Popup Bottom',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_horizontal_link_popup', old('ad_horizontal_link_popup'), ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_image_popup_top', 'Ad Horizontal Image Popup Top',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::file('ad_horizontal_image_popup_top', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image
                                            size should be 1140*500 for better display
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_link_popup_top', 'Ad Horizontal Link Popup Top',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_horizontal_link_popup_top', old('ad_horizontal_link_popup_top'), ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="box-footer wizard">
                                        <a href="javascript:;" data-href-target="#tab-2"  data-index="0"  class="all-validation btn btn-warning previous"><i
                                                    class="fa  fa-angle-double-left"></i> Previous</a>
                                        <button type="submit" class="btn btn-info pull-right finish"><i
                                                    class="fa  fa-check"></i>
                                            Add
                                        </button>
                                    </div>
                                </div>

                                <!-- /.box-body -->
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
        </div>
    </section>

    <!-- /.content -->
    <script type="text/javascript">

        $(document).ready(function () {
            var promotion_type = $("#product-type").val();
            var formula = $("#hidden-formula").val();
            //var product_id = $("#product-id").val();
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
            var LOAN = ['<?php echo LOAN_F1; ?>'];
            if (formula == 0) {
                $('#formula-details-error-section').removeClass('display-none');
            } else {
                $('#formula-details-error-section').addClass('display-none');
            }
            if (jQuery.inArray(formula, LOAN) !== -1) {

                $('#loanF1').removeClass('display-none');
            }

            $(document).on('change', '#rate-type', function() {
                var rate_type = $(this).val();
                $.ajax({
                    method: "POST",
                    url: "{{url('/admin/promotion-products/change-rate-type')}}",
                    data: {rate_type: rate_type},
                    cache: false,
                    success: function (data) {
                        $("#rate-type-content").html(data);
                    }
                });
            });
        });
        $("select[name='product_type']").on("change", function () {
            $('#loanF1').addClass('display-none');
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
        $("select[name='formula']").on("change", function () {
            var formula = $(this).val();
            $('#loanF1').addClass('display-none');
            var LOAN = ['<?php echo LOAN_F1; ?>'];
            if (formula == 0) {
                $('#formula-details-error-section').removeClass('display-none');
            } else {
                $('#formula-details-error-section').addClass('display-none');
            }
            if (jQuery.inArray(formula, LOAN) !== -1) {
                $('#loanF1').removeClass('display-none');
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
