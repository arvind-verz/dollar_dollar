@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( PRODUCT_MODULE )}}
            <small>{{$productType}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
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
                <div class=" ">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom" id="rootwizard">
                        <ul class="nav nav-tabs pull-right">

                            <li><a href="#basic-detail" data-toggle="tab" class="pointer-disable">Other Detail</a></li>
                            <li><a href="#formula-detail" data-toggle="tab" class="pointer-disable">Formula Detail</a></li>
                            <li class="active"><a href="#product-detail" data-toggle="tab" class="pointer-disable">Product Detail</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{'Product '.ADD_ACTION}}</li>

                        </ul>
                        <div class="row " style="padding: 10px;">
                            <div class="col-md-12" >
                                {!! Form::open(['id'=>'addProduct','class' => 'form-horizontal','route' => 'promotion-products-add-db', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                        <!-- Custom Tabs (Pulled to the right) -->

                                <div class="tab-content">
                                    <div class="tab-pane active " id="product-detail">
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
                                        <div class="form-group">
                                            {{Form::label('minimum_placement_amount', 'Minimum Placement Amount',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                {{Form::text('minimum_placement_amount', old('minimum_placement_amount'), ['id'=>'minimum-placement-amount','class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('maximum_interest_rate', 'Maximum Interest Rate',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                {{Form::text('maximum_interest_rate', old('maximum_interest_rate'), ['id'=>'maximum-interest-rate','class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('promotion_period', 'Placement Period',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                {{Form::text('promotion_period', old('promotion_period'), ['id'=>'promotion-period','class' => 'form-control only_numeric', 'placeholder' => ''])}}
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
                                                    <input type="text" class="form-control pull-right datepicker1" data-date="{{ old('promotion_start_date') ? date('Y-m-d', strtotime(old('promotion_start_date'))) :date('Y-m-d', time())  }}"
                                                           name="promotion_start_date" id="promotion_start_date" onchange="dateChange(this);"
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
                                                    <input type="text" class="form-control pull-right datepicker1" data-date="{{ old('promotion_end_date') ? date('Y-m-d', strtotime(old('promotion_end_date'))) :date('Y-m-d', time())  }}"
                                                           name="promotion_end_date" id="promotion_end_date" onchange="dateChange(this);"
                                                           value="{{ old('promotion_end_date') ? date('Y-m-d', strtotime(old('promotion_end_date'))) :date('Y-m-d', time())  }}">

                                                    <div class="input-group-addon ">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 " id="ongoing">
                                                <button type="button" data-status="false" id="ongoing" class="btn btn-block btn-danger btn-social" onclick="changeOnGoingStatus(this)"><i class="fa fa-times"></i> Ongoing</button>
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
                                                    <option value="0"
                                                            @if(old('status') == 0) selected="selected" @endif>
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
                                                    <option value="0"
                                                            @if(old('featured') == 0) selected="selected" @endif >
                                                        No
                                                    </option>
                                                    <option value="1"
                                                            @if(old('featured') == 1) selected="selected" @endif>
                                                        Yes
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="formula-detail">
                                        @include('backend.products.formulaDetail.foreignCurrencyF1')

                                    </div>
                                    <div class="tab-pane" id="basic-detail">
                                        <div class="form-group">
                                            {{Form::label('product_footer', 'Other Detail',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                {{Form::textarea('product_footer', old('product_footer'), ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            {{Form::label('ad_horizontal_image', 'Ad Horizontal Image',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                {{Form::file('ad_horizontal_image', ['class' => 'form-control', 'placeholder' => ''])}}
                                            </div>
                                            <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong>
                                                Image size should be 1136*140 for better display
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
                                            <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong>
                                                Image size should be 278*140 for better display
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
                                            <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong>
                                                Image size should be 1140*500 for better display
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
                                            <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong>
                                                Image size should be 1140*500 for better display
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('ad_horizontal_link_popup_top', 'Ad Horizontal Link Popup Top',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                {{Form::text('ad_horizontal_link_popup_top', old('ad_horizontal_link_popup_top'), ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                            </div>
                                        </div>

                                    </div>

                                    <!-- /.box-body -->
                                    <div class=" wizard mb-20">
                                        <a href="{{ route('promotion-products',['productTypeId'=>$productTypeId]) }}"
                                           class="btn btn-default back"><i class="fa fa-close">
                                            </i> Cancel</a>
                                        <a href="javascript:;" class="btn btn-warning previous"><i
                                                    class="fa  fa-angle-double-left"></i> Previous</a>
                                        <a href="javascript:;" class=" btn btn-warning pull-right next">Next <i
                                                    class="fa  fa-angle-double-right "></i></a>
                                        <button type="submit" class="btn btn-info pull-right finish"><i
                                                    class="fa  fa-check"></i>
                                            Add
                                        </button>
                                        </ul>
                                    </div>
                                    <!-- /.tab-content -->
                                    {!! Form::close() !!}

                                </div>
                            </div>
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


            var FDP1 = ['<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
            var SDP3 = ['<?php echo SAVING_DEPOSIT_F3; ?>', '<?php echo PRIVILEGE_DEPOSIT_F3; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F4; ?>'];
            var SDP5 = ['<?php echo SAVING_DEPOSIT_F5; ?>', '<?php echo PRIVILEGE_DEPOSIT_F5; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F6; ?>'];
            var SDP1 = [
                '<?php echo SAVING_DEPOSIT_F1; ?>', '<?php echo SAVING_DEPOSIT_F2; ?>',
                '<?php echo PRIVILEGE_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>',
                '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
            ];
            var SDP6 = [
                '<?php echo SAVING_DEPOSIT_F4; ?>', '<?php echo PRIVILEGE_DEPOSIT_F4; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F5; ?>'
            ];
            var SDP4 = [
                '<?php echo SAVING_DEPOSIT_F2; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
            ];
            if (jQuery.inArray(formula, FDP1) !== -1) {
                $('#foreignCurrencyF1').removeClass('display-none');


            }
            if (jQuery.inArray(formula, SDP3) !== -1) {
                //alert("Hello");
                $('#savingDepositF3').removeClass('display-none');

            }
            if (jQuery.inArray(formula, SDP6) !== -1) {
                //alert("Hello");
                $('#savingDepositF4').removeClass('display-none');

            }
            if (jQuery.inArray(formula, SDP5) !== -1) {
                //alert("Hello");
                $('#savingDepositF5').removeClass('display-none');

            }
            if (jQuery.inArray(formula, SDP1) !== -1) {
                $('#savingDepositF1').removeClass('display-none');
                if (jQuery.inArray(formula, SDP4) !== -1) {
                    $('#savingDepositF2Tenure').removeClass('display-none');
                } else {
                    $('#savingDepositF2Tenure').addClass('display-none');
                }
            }
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F1; ?>') {

                $('#allInOneAccountF1').removeClass('display-none');

            }
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F2; ?>') {

                $('#allInOneAccountF2').removeClass('display-none');

            }
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F3; ?>') {

                $('#allInOneAccountF3').removeClass('display-none');

            }
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F4; ?>') {

                $('#allInOneAccountF4').removeClass('display-none');

            }

        });
        $("select[name='product_type']").on("change", function () {
            $('#foreignCurrencyF1').addClass('display-none');
            $('#savingDepositF1').addClass('display-none');
            $('#savingDepositF3').addClass('display-none');
            $('#savingDepositF4').addClass('display-none');
            $('#savingDepositF5').addClass('display-none');
            $('#allInOneAccountF1').addClass('display-none');
            $('#allInOneAccountF2').addClass('display-none');
            $('#allInOneAccountF3').addClass('display-none');
            $('#allInOneAccountF4').addClass('display-none');

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
            $('#foreignCurrencyF1').addClass('display-none');
            $('#savingDepositF1').addClass('display-none');
            $('#savingDepositF3').addClass('display-none');
            $('#savingDepositF4').addClass('display-none');
            $('#savingDepositF5').addClass('display-none');
            $('#allInOneAccountF1').addClass('display-none');
            $('#allInOneAccountF2').addClass('display-none');
            $('#allInOneAccountF3').addClass('display-none');
            $('#allInOneAccountF4').addClass('display-none');

            var FDP1 = ['<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
            var SDP3 = ['<?php echo SAVING_DEPOSIT_F3; ?>', '<?php echo PRIVILEGE_DEPOSIT_F3; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F4; ?>'];
            var SDP5 = ['<?php echo SAVING_DEPOSIT_F5; ?>', '<?php echo PRIVILEGE_DEPOSIT_F5; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F6; ?>'];
            var SDP1 = [
                '<?php echo SAVING_DEPOSIT_F1; ?>', '<?php echo SAVING_DEPOSIT_F2; ?>',
                '<?php echo PRIVILEGE_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>',
                '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
            ];
            var SDP6 = [
                '<?php echo SAVING_DEPOSIT_F4; ?>', '<?php echo PRIVILEGE_DEPOSIT_F4; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F5; ?>'
            ];
            var SDP4 = [
                '<?php echo SAVING_DEPOSIT_F2; ?>', '<?php echo PRIVILEGE_DEPOSIT_F2; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F3; ?>'
            ];
            if (jQuery.inArray(formula, FDP1) !== -1) {
                $('#foreignCurrencyF1').removeClass('display-none');

            }
            if (jQuery.inArray(formula, SDP3) !== -1) {
                //alert("Hello");
                addCounter();
                $('#savingDepositF3').removeClass('display-none');

            }
            if (jQuery.inArray(formula, SDP6) !== -1) {
                //alert("Hello");
                $('#savingDepositF4').removeClass('display-none');

            }
            if (jQuery.inArray(formula, SDP5) !== -1) {
                //alert("Hello");
                $('#savingDepositF5').removeClass('display-none');

            }
            if (jQuery.inArray(formula, SDP1) !== -1) {
                $('#savingDepositF1').removeClass('display-none');
                if (jQuery.inArray(formula, SDP4) !== -1) {
                    $('#savingDepositF2Tenure').removeClass('display-none');
                } else {
                    $('#savingDepositF2Tenure').addClass('display-none');
                }
            }
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F1; ?>') {

                $('#allInOneAccountF1').removeClass('display-none');

            }
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F2; ?>') {

                $('#allInOneAccountF2').removeClass('display-none');

            }
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F3; ?>') {

                $('#allInOneAccountF3').removeClass('display-none');

            }
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F4; ?>') {

                $('#allInOneAccountF4').removeClass('display-none');

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
