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
                    <div class="box-header with-border">
                        <i class="fa fa-book"></i>

                        <h3 class="box-title">{{'Add New Promotion'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['class' => 'form-horizontal','route' => 'promotion-products-add-db', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Product Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="product_name" class="form-control" placeholder="" value="{{ old('product_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Bank</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="bank">
                                    <option value="">None</option>
                                    @if($banks->count())
                                        @foreach($banks as $bank)
                                            <option value="{{$bank->id}}" @if(old('bank')==$bank->id) selected="selected" @endif>{{$bank->title}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Product Type</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="product_type">
                                    <option value="">None</option>
                                    @if($promotion_types->count())
                                        @foreach($promotion_types as $product_type)
                                            <option value="{{$value->id}}" @if(old('product_type') == $product_type->id) selected="selected" @endif>{{$value->name}}</option>
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
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Min Placement</label>
                            <div class="col-sm-10">
                                <input type="number" name="min_placement" class="form-control" placeholder="" value="{{ old('min_range') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Max Placement</label>
                            <div class="col-sm-10">
                                <input type="number" name="max_placement" class="form-control" placeholder="" value="{{ old('max_range') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Promotion Start Date</label>
                            <div class="col-sm-10">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" name="promotion_start" id="datepicker" value="{{ old('promotion_start') }}">
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
                                    <input type="text" class="form-control pull-right" name="promotion_end" id="datepicker1" value="{{ old('promotion_end') }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Tenure</label>
                            <div class="col-sm-10">
                                <input type="number" name="tenure" class="form-control" placeholder="" value="{{ old('tenure') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Bonus Interest</label>
                            <div class="col-sm-10">
                                <input type="text" name="bonus_interest" class="form-control only_numeric" placeholder=""  value="{{ old('bonus_interest') }}">
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
                                                <option value="1">Horizontal</option>
                                                <option value="0">Vertical</option>
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
                                                <option value="1">Active</option>
                                                <option value="0">Deactivate</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Featured</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="featured"
                                                    style="width: 100%;">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                    </div>
                            
                        <div class="box-footer">
                            <a href="{{ route('promotion-products') }}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i>
                                Add
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
        $("select[name='promotion_type']").on("change", function() {
            var promotion_type = $(this).val();
//alert(promotion_type);
            $.ajax({
                method: "GET",
                url: "{{url('/admin/promotion-products/get-formula/')}}"+'/'+promotion_type,
                data: "",
                cache: false,
                success: function(data) {
                    $("select[name='formula_id']").html(data);
                }
            });
        });

    </script>
@endsection
