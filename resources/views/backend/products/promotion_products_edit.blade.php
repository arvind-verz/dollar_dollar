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
                        href="{{ route('promotion-products',['productTypeId'=>$product->promotion_type_id]) }}">{{$productType}}</a>
            </li>
            <li class="active">{{'Product '.EDIT_ACTION}}</li>
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

                            <li><a href="#basic-detail" data-toggle="tab" class="pointer-disable">Other Detail</a></li>
                            <li><a href="#formula-detail" data-toggle="tab" class="pointer-disable">Formula Detail</a>
                            </li>
                            <li class="active"><a href="#product-detail" data-toggle="tab" class="pointer-disable">Product
                                    Detail</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{'Product '.EDIT_ACTION}}</li>

                        </ul>
                        <div class="box-body">

                            {!! Form::open(['id'=>'addProduct','class' => 'form-horizontal','route' => ['promotion-products-update',$product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <!-- Custom Tabs (Pulled to the right) -->
                            <input type="hidden" name="product_id" id="product-id" value="{{$product->id}}"/>

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
                                        {{Form::label('bank_sub_title', 'Bank Sub Title',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('bank_sub_title', $product->bank_sub_title, ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
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
                                                                @if($product->promotion_type_id == $product_type->id) selected="selected" @endif>{{$product_type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="apply-link">

                                        <input type="hidden" id="apply-link-status" name="apply_link_status"
                                               value="{{$product->apply_link_status}}"/>
                                        {{Form::label('apply_link', 'Apply Button Link',['class'=>'col-sm-2 control-label'])}}
                                        @if(empty($product->apply_link_status))
                                            <div class="col-sm-8">
                                                {{Form::text('apply_link', $product->apply_link, ['id'=>'link_ad','class' => 'form-control', 'placeholder' => '', 'readonly'=>'readonly'])}}
                                            </div>
                                        @else
                                            <div class="col-sm-8">
                                                {{Form::text('apply_link', $product->apply_link, ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                            </div>
                                        @endif

                                        <div class="col-sm-2 " id="apply-status">
                                            @if(empty($product->apply_link_status))
                                                <button type="button" data-status="false" id=""
                                                        class="btn btn-block btn-danger  btn-social"
                                                        onclick="changeApplyStatus(this)"><i class="fa fa-times"></i>Disable
                                                </button>
                                            @else
                                                <button type="button" data-status="true" id=""
                                                        class="btn btn-block btn-success btn-social"
                                                        onclick="changeApplyStatus(this)"><i class="fa fa-check"></i>
                                                    Enable
                                                </button>
                                            @endif
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
                                    <div class="form-group display-none" id="none-formula-slider">
                                        <label class="col-sm-2 control-label">Slider Display Status</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="slider_status" id="slider-status"
                                                    style="width: 100%;">
                                                <option value="0"
                                                        @if($product->slider_status == 0) selected="selected" @endif >
                                                    No
                                                </option>
                                                <option value="1"
                                                        @if($product->slider_status == 1) selected="selected" @endif>
                                                    Yes
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @if($product->promotion_type_id==ALL_IN_ONE_ACCOUNT)
                                        {{Form::label('minimum_placement_amount', 'Maximum Placement Amount',['class'=>'col-sm-2 control-label','id'=>'placement-amount-content'])}}
                                        @else
                                        {{Form::label('minimum_placement_amount', 'Minimum Placement Amount',['class'=>'col-sm-2 control-label','id'=>'placement-amount-content'])}}
                                        @endif
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

                                        <label for="promotion_period"
                                               class="col-sm-2 control-label">@if($product->promotion_type_id==ALL_IN_ONE_ACCOUNT)
                                                Criteria @else Placement Period @endif</label>

                                        <div class="@if($product->promotion_type_id==ALL_IN_ONE_ACCOUNT) col-sm-10 @else col-sm-8  @endif">
                                            <input type="text"
                                                   class="form-control @if($product->promotion_type_id==ALL_IN_ONE_ACCOUNT) only_numeric @endif"
                                                   name="promotion_period" id="promotion-period"
                                                   onchange="addCounter(this);"
                                                   value="{{$product->promotion_period}}"
                                                    {{--@if(($product->promotion_start==null) && ($product->promotion_end==null)) readonly="readonly" @endif--}}>
                                        </div>
                                        @if($product->promotion_type_id!=ALL_IN_ONE_ACCOUNT)
                                            <div class="col-sm-2 " id="ongoing-1">

                                                @if($product->promotion_period==ONGOING)
                                                    <button type="button" data-status="true" id="ongoing-status-1"
                                                            class="btn btn-block btn-success btn-social"
                                                            onclick="changeOnGoingStatus1(this)"><i
                                                                class="fa fa-check"></i>
                                                        Ongoing
                                                    </button>
                                                @else
                                                    <button type="button" data-status="false" id="ongoing-status-1"
                                                            class="btn btn-block btn-danger btn-social"
                                                            onclick="changeOnGoingStatus1(this)"><i
                                                                class="fa fa-times"></i>
                                                        Ongoing
                                                    </button>
                                                @endif
                                            </div>
                                        @endif

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
                                                       data-date="{{ $product->promotion_start ? date('Y-m-d', strtotime($product->promotion_start )) : null }}"
                                                       name="promotion_start_date" id="promotion_start_date"
                                                       onchange="dateChange(this);"
                                                       value="{{ $product->promotion_start? date('Y-m-d',strtotime($product->promotion_start )) : null}}">

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
                                                       onchange="dateChange(this);"
                                                       data-date="{{ $product->promotion_end ? date('Y-m-d', strtotime($product->promotion_end )) : null }}"
                                                       value="{{ $product->promotion_end ? date('Y-m-d', strtotime($product->promotion_end )) : null }}">

                                                <div class="input-group-addon ">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 " id="ongoing">
                                            @if(($product->promotion_start==null) && ($product->promotion_end==null))
                                                <button type="button" data-status="true" id="ongoing-status"
                                                        class="btn btn-block btn-success btn-social"
                                                        onclick="changeOnGoingStatus(this)"><i class="fa fa-check"></i>
                                                    Ongoing
                                                </button>
                                            @else
                                                <button type="button" data-status="false" id="ongoing-status"
                                                        class="btn btn-block btn-danger btn-social"
                                                        onclick="changeOnGoingStatus(this)"><i class="fa fa-times"></i>
                                                    Ongoing
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group " id="until-end-section">
                                        <label for="title" class="col-sm-2 control-label">Until End Date</label>

                                        <div class="col-sm-10 ">

                                            <div class="input-group date ">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-danger">
                                                        Date
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control pull-right datepicker1"
                                                       data-date="{{ old('until_end_date') ? date('Y-m-d', strtotime(old('until_end_date'))) :date('Y-m-d', time())  }}"
                                                       name="until_end_date" id="until-end-date" @if($product->promotion_period==ONGOING) disabled="disabled" @endif
                                                        {{--@if((!empty($product->promotion_start)) || (!empty($product->promotion_end))) disabled="disabled" @endif--}}
                                                       data-date="{{ $product->until_end_date ? date('Y-m-d', strtotime($product->until_end_date )) : null }}"
                                                       value="{{ $product->until_end_date ? date('Y-m-d', strtotime($product->until_end_date )) : null }}">

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
                                                <option value="1"
                                                        @if($product->status == 1) selected="selected" @endif >
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
                                                <option value="0"
                                                        @if($product->featured == 0) selected="selected" @endif >
                                                    No
                                                </option>
                                                <option value="1"
                                                        @if($product->featured == 1) selected="selected" @endif>
                                                    Yes
                                                </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="formula-detail">
                                    <div class="form-group display-none " id="currencyDiv">
                                        <label for="title" class="col-sm-2 control-label">Currency Type</label>
                                        <?php $currencyId = isset($product->currency) ? $product->currency : null; ?>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="currency" id="currency">
                                                <option value="">None</option>
                                                @if($currencies->count())
                                                    @foreach($currencies as $currency)
                                                        <option value="{{$currency->id}}"
                                                                @if($currencyId ==$currency->id) selected="selected" @endif>{{$currency->currency.' ('.($currency->code.')')}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                        </div>
                                    </div>
                                    <div class="form-group " id="formula-details-error-section">
                                        <h3 class="col-sm-12 col-md-12 col-lg-12 text-danger"> Formula details
                                            unavailable</h3>
                                    </div>
                                    @include('backend.products.formulaDetail.fixDepositF1')
                                    @include('backend.products.formulaDetail.savingDepositF1')
                                    @include('backend.products.formulaDetail.savingDepositF3')
                                    @include('backend.products.formulaDetail.savingDepositF4')
                                    @include('backend.products.formulaDetail.savingDepositF5')
                                    @include('backend.products.formulaDetail.allInOneAccountF1')
                                    @include('backend.products.formulaDetail.allInOneAccountF2')
                                    @include('backend.products.formulaDetail.allInOneAccountF3')
                                    @include('backend.products.formulaDetail.allInOneAccountF4')
                                    @include('backend.products.formulaDetail.allInOneAccountF5')
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
                                                    <a href="javascript:void(0)" class="text-danger" title="close"
                                                       onclick="removeImage(this, '{{ $product->id }}', 'horizontal');"><i
                                                                class="fas fa-times fa-lg"></i></a><img
                                                            class="attachment-img"
                                                            src="{!! asset($ads[0]->ad_image_horizontal) !!}"
                                                            alt="image"></a>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image
                                            size should be @if($product->promotion_type_id==ALL_IN_ONE_ACCOUNT)1140*160 @else 1140*160 @endif for better display
                                        </div>
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
                                                    <a href="javascript:void(0)" class="text-danger" title="close"
                                                       onclick="removeImage(this, '{{ $product->id }}', 'vertical');"><i
                                                                class="fas fa-times fa-lg"></i></a><img
                                                            class="attachment-img"
                                                            src="{!! asset($ads[1]->ad_image_vertical) !!}"
                                                            alt="image">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image
                                            size should be 280*140 for better display
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_vertical_link', 'Ad Vertical Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_vertical_link',  isset($ads[1]->ad_link_vertical) ? $ads[1]->ad_link_vertical : '' , ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_image_popup', 'Ad Horizontal Image Popup Bottom',['class'=>'col-sm-2 control-label'])}}
                                        <div class="@if(isset($ads[2]->ad_horizontal_image_popup) && ($ads[2]->ad_horizontal_image_popup != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('ad_horizontal_image_popup', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        @if(isset($ads[2]->ad_horizontal_image_popup) && ($ads[2]->ad_horizontal_image_popup != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="javascript:void(0)" class="text-danger" title="close"
                                                       onclick="removeImage(this, '{{ $product->id }}', 'horizontal_popup');"><i
                                                                class="fas fa-times fa-lg"></i></a><img
                                                            class="attachment-img"
                                                            src="{!! asset($ads[2]->ad_horizontal_image_popup) !!}"
                                                            alt="image">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image
                                            size should be 1140*500 for better display
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_link_popup', 'Ad Horizontal Link Popup Bottom',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_horizontal_link_popup', isset($ads[2]->ad_link_horizontal_popup) ? $ads[2]->ad_link_horizontal_popup : '' , ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_image_popup_top', 'Ad Horizontal Image Popup Top',['class'=>'col-sm-2 control-label'])}}
                                        <div class="@if(isset($ads[3]->ad_horizontal_image_popup_top) && ($ads[3]->ad_horizontal_image_popup_top != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('ad_horizontal_image_popup_top', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        @if(isset($ads[3]->ad_horizontal_image_popup_top) && ($ads[3]->ad_horizontal_image_popup_top != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="javascript:void(0)" class="text-danger" title="close"
                                                       onclick="removeImage(this, '{{ $product->id }}', 'vertical_popup');"><i
                                                                class="fas fa-times fa-lg"></i></a><img
                                                            class="attachment-img"
                                                            src="{!! asset($ads[3]->ad_horizontal_image_popup_top) !!}"
                                                            alt="image">
                                                </div>
                                            </div>

                                        @endif
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image
                                            size should be 1140*500 for better display
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_link_popup_top', 'Ad Horizontal Link Popup Top',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_horizontal_link_popup_top', isset($ads[3]->ad_link_horizontal_popup_top) ? $ads[3]->ad_link_horizontal_popup_top : '' , ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {{Form::hidden('_method','PUT')}}
                                    <!-- /.box-body -->
                            <div class="box-footer wizard">
                                <a href="{{ route('promotion-products',['productTypeId'=>$product->promotion_type_id]) }}"
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
            if ((promotion_type.length != 0) /*&& (formula.length != 0)*/) {
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
            /*if (promotion_type == '<?php echo ALL_IN_ONE_ACCOUNT ; ?>') {
                $('#apply-link').removeClass('display-none');
                $('#placement-amount-content').html("Maximum Placement Amount");
            } else {
                $('#apply-link').addClass('display-none');
                $('#placement-amount-content').html("Minimum Placement Amount");

            }*/

            if (promotion_type == '<?php echo FOREIGN_CURRENCY_DEPOSIT ; ?>') {
                $('#currencyDiv').removeClass('display-none');
            } else {
                $('#currencyDiv').addClass('display-none');
            }

            var FDP1 = ['<?php echo FIX_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F6; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
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
            var utilFormula = [
                '<?php echo SAVING_DEPOSIT_F1; ?>',
                '<?php echo PRIVILEGE_DEPOSIT_F1; ?>',
                '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>',
            ];
            /*if (jQuery.inArray(formula, utilFormula) !== -1) {

             $('#until-end-section').removeClass('display-none');


             }*/

            if (formula.length == 0) {
                $('#formula-details-error-section').removeClass('display-none');
                $('#none-formula-slider').removeClass('display-none');
            } else {
                $('#formula-details-error-section').addClass('display-none');
                $('#none-formula-slider').addClass('display-none');
            }
            if (jQuery.inArray(formula, FDP1) !== -1) {
                $('#fixDepositF1').removeClass('display-none');
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
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F5; ?>') {

                $('#allInOneAccountF5').removeClass('display-none');

            }
        });
        $("select[name='product_type']").on("change", function () {
            $('#fixDepositF1').addClass('display-none');
            $('#savingDepositF1').addClass('display-none');
            $('#savingDepositF3').addClass('display-none');
            $('#savingDepositF4').addClass('display-none');
            $('#savingDepositF5').addClass('display-none');
            $('#allInOneAccountF1').addClass('display-none');
            $('#allInOneAccountF2').addClass('display-none');
            $('#allInOneAccountF3').addClass('display-none');
            $('#allInOneAccountF4').addClass('display-none');
            $('#allInOneAccountF5').addClass('display-none');
            $('#until-end-section').addClass('display-none');
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
            $('#savingDepositF4').addClass('display-none');
            $('#savingDepositF5').addClass('display-none');
            $('#allInOneAccountF1').addClass('display-none');
            $('#allInOneAccountF2').addClass('display-none');
            $('#allInOneAccountF3').addClass('display-none');
            $('#allInOneAccountF4').addClass('display-none');
            $('#allInOneAccountF5').addClass('display-none');
            $('#until-end-section').addClass('display-none');
            var FDP1 = ['<?php echo FIX_DEPOSIT_F1; ?>', '<?php echo PRIVILEGE_DEPOSIT_F6; ?>', '<?php echo FOREIGN_CURRENCY_DEPOSIT_F1; ?>'];
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
            var utilFormula = [
                '<?php echo SAVING_DEPOSIT_F1; ?>',
                '<?php echo PRIVILEGE_DEPOSIT_F1; ?>',
                '<?php echo FOREIGN_CURRENCY_DEPOSIT_F2; ?>',
            ];
            if (formula.length == 0) {
                $('#formula-details-error-section').removeClass('display-none');
                $('#none-formula-slider').removeClass('display-none');
            } else {
                $('#formula-details-error-section').addClass('display-none');
                $('#none-formula-slider').addClass('display-none');
            }
            if (jQuery.inArray(formula, utilFormula) !== -1) {

                $('#until-end-section').removeClass('display-none');


            }
            if (jQuery.inArray(formula, FDP1) !== -1) {
                $('#fixDepositF1').removeClass('display-none');

            }
            if (jQuery.inArray(formula, SDP3) !== -1) {
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
            if (formula == '<?php echo ALL_IN_ONE_ACCOUNT_F5; ?>') {

                $('#allInOneAccountF5').removeClass('display-none');

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
            /*if (promotion_type == '<?php echo ALL_IN_ONE_ACCOUNT ; ?>') {
                $('#apply-link').removeClass('display-none');
            } else {
                $('#apply-link').addClass('display-none');
            }*/
            if (promotion_type == '<?php echo FOREIGN_CURRENCY_DEPOSIT ; ?>') {
                $('#currencyDiv').removeClass('display-none');
            } else {
                $('#currencyDiv').addClass('display-none');
            }

        });

        function removeImage(ref, id, ad_type) {
            $.ajax({
                method: "POST",
                url: "{{ route('remove-image') }}",
                data: "type=product&id=" + id + "&ad_type=" + ad_type,
                cache: false,
                success: function (data) {
                    if (data.trim() == 'success') {
                        $(ref).parents(".col-sm-2").remove();
                    }
                }
            });
        }
    </script>
@endsection