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
            <li class="active">{{PRODUCT_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
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

                            <li><a href="#basic-detail" data-toggle="tab">Other Detail</a></li>
                            <li><a href="#formula-detail" data-toggle="tab">Formula Detail</a></li>
                            <li class="active"><a href="#product-detail" data-toggle="tab">Product Detail</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{PRODUCT_MODULE_SINGLE.' '.ADD_ACTION}}</li>

                        </ul>
                        <div class="box-body">

                            {!! Form::open(['id'=>'addProduct','class' => 'form-horizontal','route' => ['promotion-products-update',$product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <!-- Custom Tabs (Pulled to the right) -->
                            <input type="hidden" name="product_id" id="product-id" value="{{$product->id}}" />
                            <div class="tab-content">
                                <div class="tab-pane active" id="product-detail">
                                    <div class="form-group">
                                        {{Form::label('name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('name', $product->product_name, ['id'=>'name','class' => 'form-control', 'placeholder' => ''])}}
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
                                                                @if($product->bank_id == $bank->id) selected="selected" @endif>{{$bank->title}}</option>
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
                                                                @if($product->promotion_type_id == $product_type->id) selected="selected" @endif>{{$product_type->name}}</option>
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
                                            </select>
                                            <input type="hidden" id="hidden-formula" value="{{ $product->formula_id }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('minimum_placement_amount', 'Minimum Placement Amount',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('minimum_placement_amount', $product->minimum_placement_amount, ['id'=>'minimum-placement-amount','class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('maximum_interest_rate', 'Maximum Interest Rate',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('maximum_interest_rate',  $product->maximum_interest_rate, ['id'=>'maximum-interest-rate','class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('promotion_period', 'Placement Period',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('promotion_period',  $product->promotion_period, ['id'=>'promotion-period','class' => 'form-control only_numeric', 'placeholder' => ''])}}
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
                                                       name="promotion_start_date" id="promotion_start_date"
                                                       value="{{  date('Y-m-d',strtotime($product->promotion_start ))}}">

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
                                                       name="promotion_end_date" id="promotion_end_date"
                                                       value="{{ date('Y-m-d', strtotime($product->promotion_end )) }}">

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
                                                <option value="1" @if($product->status == 1) selected="selected" @endif >
                                                    Active
                                                </option>
                                                <option value="0" @if($product->status == 0) selected="selected" @endif>
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
                                                <option value="0" @if($product->featured == 0) selected="selected" @endif >
                                                    No
                                                </option>
                                                <option value="1" @if($product->featured == 1) selected="selected" @endif>
                                                    Yes
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="formula-detail">
                                    @include('backend.products.formulaDetail.fixDepositF1')
                                    @include('backend.products.formulaDetail.savingDepositF1')
                                    @include('backend.products.formulaDetail.savingDepositF3')
                                    @include('backend.products.formulaDetail.savingDepositF5')
                                </div>
                                <div class="tab-pane" id="basic-detail">
                                    <div class="form-group">
                                        {{Form::label('product_footer', 'Other Detail',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('product_footer', $product->product_footer, ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <?php
                                        $ads = $product->ads_placement;
                                    ?>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_image', 'Ad Horizontal Image',['class'=>'col-sm-2 control-label'])}}
                                        <div class="@if(isset($ads[0]->ad_image_horizontal) && ($ads[0]->ad_image_horizontal != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('ad_horizontal_image', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        @if(isset($ads[0]->ad_image_horizontal) && ($ads[0]->ad_image_horizontal != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="{{asset($ads[0]->ad_image_horizontal)}}" target="_blank"><img class="attachment-img" src="{!! asset($ads[0]->ad_image_horizontal) !!}"
                                                         alt="image"></a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_link', 'Ad Horizontal Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_horizontal_link', isset($ads[0]->ad_link_horizontal) ? $ads[0]->ad_link_horizontal : '' , ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_image_vertical', 'Ad Vertical Image',['class'=>'col-sm-2 control-label'])}}
                                        <div class="@if(isset($ads[1]->ad_image_vertical) && ($ads[1]->ad_image_vertical != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('ad_image_vertical', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        @if(isset($ads[1]->ad_image_vertical) && ($ads[1]->ad_image_vertical != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="{{asset($ads[1]->ad_image_vertical)}}" target="_blank"><img class="attachment-img" src="{!! asset($ads[1]->ad_image_vertical) !!}"
                                                         alt="image"></a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_vertical_link', 'Ad Vertical Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_vertical_link',  isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' , ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                </div>
                                {{Form::hidden('_method','PUT')}}
                                <!-- /.box-body -->
                                <div class="box-footer wizard">
                                    <a href="{{ route('promotion-products') }}"
                                       class="btn btn-default back"><i class="fa fa-close">
                                        </i> Cancel</a>
                                    <a href="javascript:;" class="btn btn-warning previous"><i
                                                class="fa  fa-angle-double-left"></i> Previous</a>
                                    <a href="javascript:;" class=" btn btn-warning pull-right next">Next <i
                                                class="fa  fa-angle-double-right "></i></a>
                                    <button type="submit" class="btn btn-info pull-right finish"><i
                                                class="fa  fa-check"></i>
                                        Update
                                    </button>
                                    </ul>
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
            if (formula == '<?php echo FIX_DEPOSIT_F1; ?>') {
                $('#fixDepositF1').removeClass('display-none');

            }if (formula == '<?php echo SAVING_DEPOSIT_F1; ?>' || formula == '<?php echo SAVING_DEPOSIT_F2; ?>' || formula == '<?php echo SAVING_DEPOSIT_F4; ?>' ) {
                $('#savingDepositF1').removeClass('display-none');

            }if (formula == '<?php echo SAVING_DEPOSIT_F3; ?>') {
                $('#savingDepositF3').removeClass('display-none');

            }if (formula == '<?php echo SAVING_DEPOSIT_F5; ?>') {
                $('#savingDepositF5').removeClass('display-none');

            }

        });
        $("select[name='product_type']").on("change", function () {
            $('#fixDepositF1').addClass('display-none');
            $('#savingDepositF1').addClass('display-none');
            $('#savingDepositF3').addClass('display-none');
            $('#savingDepositF5').addClass('display-none');

            var promotion_type = $(this).val();
            var formula = $("#formula").val();
            //alert(formula);
            $.ajax({
                method: "POST",
                url: "{{url('/admin/promotion-products/get-formula')}}",
                data: {promotion_type: promotion_type, formula: formula},
                cache: false,
                success: function (data) {
                    <?php $product->product_range = [] ?>
                    $("select[name='formula']").html(data);
                }
            });

        });
        $("select[name='formula']").on("change", function () {
            var formula = $(this).val();
            $('#fixDepositF1').addClass('display-none');
            $('#savingDepositF1').addClass('display-none');
            $('#savingDepositF3').addClass('display-none');
            $('#savingDepositF5').addClass('display-none');

            if (formula == '<?php echo FIX_DEPOSIT_F1; ?>') {
                $('#fixDepositF1').removeClass('display-none');

            }if (formula == '<?php echo SAVING_DEPOSIT_F1; ?>' || formula == '<?php echo SAVING_DEPOSIT_F2; ?>' || formula == '<?php echo SAVING_DEPOSIT_F4; ?>') {
                $('#savingDepositF1').removeClass('display-none');

            }if (formula == '<?php echo SAVING_DEPOSIT_F3; ?>') {
                $('#savingDepositF3').removeClass('display-none');

            }if (formula == '<?php echo SAVING_DEPOSIT_F5; ?>') {
                //alert("Hello");
                $('#savingDepositF5').removeClass('display-none');

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