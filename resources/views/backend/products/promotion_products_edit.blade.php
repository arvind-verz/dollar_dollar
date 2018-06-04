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
                <div class="box box-warning ">
                    <div class="box-header with-border">
                        <i class="fa fa-book"></i>

                        <h3 class="box-title">{{'Edit Promotion'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['class' => 'form-horizontal','route' => ['promotion-products-update', $product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" placeholder=""
                                       value="{{ $product->name }}">
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
                                                    @if( $product->promotion_type_id == $product_type->id) selected="selected" @endif>{{$product_type->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Formula</label>

                            <div class="col-sm-10">
                                <select class="form-control" id="formula" name="formula">
                                    <option value="">None</option>
                                </select>
                                <input type="hidden" id="hidden-formula" value="{{$product->formula_id}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Min Placement</label>

                            <div class="col-sm-10">
                                <input type="number" name="min_placement" class="form-control" placeholder=""
                                       value="{{ $product->min_range }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Max Placement</label>

                            <div class="col-sm-10">
                                <input type="number" name="max_placement" class="form-control" placeholder=""
                                       value="{{ $product->max_range }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Promotion Start Date</label>

                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" name="promotion_start_date"
                                           id="datepicker"
                                           value="{{date('Y-m-d', strtotime($product->promotion_start ))  }}">
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
                                    <input type="text" class="form-control pull-right" name="promotion_end_date"
                                           id="datepicker1"
                                           value="{{date('Y-m-d', strtotime($product->promotion_end ))  }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Tenure</label>

                            <div class="col-sm-10">
                                <input type="number" name="tenure" class="form-control" placeholder=""
                                       value="{{ $product->tenure }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Bonus Interest</label>

                            <div class="col-sm-10">
                                <input type="text" name="bonus_interest" class="form-control only_numeric"
                                       placeholder="" value="{{ $product->bonus_interest }}">
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('criteria', 'Criteria',['class'=>'col-sm-2 control-label'])}}
                            <div class="col-sm-10">
                                {{Form::textarea('criteria', $product->criteria , ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('key_points', 'Key Points',['class'=>'col-sm-2 control-label'])}}
                            <div class="col-sm-10">
                                {{Form::textarea('key_points', $product->key_points , ['id' => '', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('ad_poster', 'Advertisement Image',['class'=>'col-sm-2 control-label'])}}
                            <div class="@if(isset($product->ad_image) && ($product->ad_image != ''))col-sm-8 @else col-sm-10 @endif">
                                {{Form::file('ad_poster', ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                            @if(isset($product->ad_image) && ($product->ad_image != ''))
                                <div class=" col-sm-2">
                                    <div class="attachment-block clearfix">
                                        <a href="{{ asset($product->ad_image) }}" target="_blank" > <img class="attachment-img" src="{!! asset($product->ad_image) !!}"
                                             alt="Advertisement Image"></a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Advertisement Type</label>

                            <div class="col-sm-10">

                                <select class="form-control select2"
                                        name="ad_type"
                                        style="width: 100%;">
                                    <option value="" selected="selected">None</option>
                                    <option value="1" @if($product->ad_type  == 1) selected="selected" @endif>Horizontal
                                    </option>
                                    <option value="2" @if($product->ad_type  == 2) selected="selected" @endif>Vertical
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('ad_link', 'Advertisement Link',['class'=>'col-sm-2 control-label'])}}
                            <div class="col-sm-10">
                                {{Form::text('ad_link', $product->ad_link , ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>

                        <div class="form-group">
                            {{Form::label('main_page_link', 'Main Page Link',['class'=>'col-sm-2 control-label'])}}
                            <div class="col-sm-10">
                                {{Form::text('main_page_link', $product->main_page_link , ['id'=>'link_main_page','class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            {{Form::label('tc_link', 'T&C Link',['class'=>'col-sm-2 control-label'])}}
                            <div class="col-sm-10">
                                {{Form::text('tc_link', $product->tc_link , ['id'=>'link_tc','class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>

                            <div class="col-sm-10">

                                <select class="form-control select2"
                                        name="status"
                                        style="width: 100%;">

                                    <option value="1" @if($product->status == 1) selected="selected" @endif>Active</option>
                                    <option value="0"
                                            @if(!is_null($product->status) && ($product->status == 0)) selected="selected" @endif>
                                        Deactivate

                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Featured</label>

                            <div class="col-sm-10">

                                <select class="form-control select2"
                                        name="featured"
                                        style="width: 100%;">

                                    <option value="0"
                                            @if(!is_null($product->featured) && ($product->featured == 0)) selected="selected" @endif >
                                        No
                                    </option>
                                    <option value="1" @if($product->featured == 1) selected="selected" @endif>Yes
                                    </option>

                                </select>
                            </div>
                        </div>
                        {{Form::hidden('_method','PUT')}}
                        <div class="box-footer">
                            <a href="{{ route('promotion-products') }}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-warning pull-right"><i class="fa  fa-check"></i>
                                Update
                            </button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>

    <!-- /.content -->
    <script type="text/javascript">
        $(document).ready(function () {
            var promotion_type = $("#product-type").val();
            var formula = $("#hidden-formula").val();
            //alert(promotion_type.length + ' ' + formula );
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
