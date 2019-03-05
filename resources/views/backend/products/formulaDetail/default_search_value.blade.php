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
            <li class="active">{{'Default Search Values '}}@if($defaultSearch){{EDIT_ACTION}}@else {{ADD_ACTION}}@endif</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box @if($defaultSearch) box-warning  @else box-info @endif ">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>

                        <h3 class="box-title">{{'Default Search Values '}}@if($defaultSearch){{EDIT_ACTION}}@else {{ADD_ACTION}}@endif</h3>
                    </div>

                    @if($defaultSearch)
                            <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => 'admin/default-search-update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                <input type="hidden" name="promotion_id" value="{{$productTypeId}}"/>
                                {{Form::label('placement', 'Placement',['class'=>'col-sm-2 control-label '])}}
                                <div class="col-sm-10">
                                    {{Form::text('placement', $defaultSearch->placement, ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                </div>
                            </div>
                            @if($productTypeId == ALL_IN_ONE_ACCOUNT)
                                <div class="form-group">
                                    {{Form::label('salary', 'Salary',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('salary', $defaultSearch->salary, ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('payment', 'Payment',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('payment',$defaultSearch->payment, ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('spend', 'Spend',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('spend', $defaultSearch->spend, ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('privilege', 'Privilege',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('privilege', $defaultSearch->privilege, ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('loan', 'Loan',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('loan', $defaultSearch->loan, ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                            @endif
                            @if($productTypeId == LOAN)
                                <div class="form-group">
                                    {{Form::label('rate_type', 'Rate Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select class="form-control" name="rate_type">
                                            <option value="{{BOTH_VALUE}}"
                                                    @if(isset($defaultSearch->rate_type) && $defaultSearch->rate_type==BOTH_VALUE) selected @endif>{{BOTH_VALUE}}</option>
                                            <option value="{{FIXED_RATE}}"
                                                    @if(isset($defaultSearch->rate_type) && $defaultSearch->rate_type==FIXED_RATE) selected @endif>{{FIXED_RATE}}</option>
                                            <option value="{{FLOATING_RATE}}"
                                                    @if(isset($defaultSearch->rate_type) && $defaultSearch->rate_type==FLOATING_RATE) selected @endif>{{FLOATING_RATE}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('tenure', 'Tenure',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select class="form-control" name="tenure">
                                            @for($i=1;$i<=35;$i++)
                                                <option name="{{$i}}"
                                                        @if(isset($defaultSearch->tenure) && $defaultSearch->tenure==$i) selected @endif>{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('property_type', 'Property Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select class="form-control" name="property_type">

                                            <option value="{{HDB_PROPERTY}}"
                                                    @if(isset($defaultSearch->property_type) && $defaultSearch->property_type==HDB_PROPERTY) selected @endif>{{HDB_PROPERTY}}</option>
                                            <option value="{{PRIVATE_PROPERTY}}"
                                                    @if(isset($defaultSearch->property_type) && $defaultSearch->property_type==PRIVATE_PROPERTY) selected @endif>{{PRIVATE_PROPERTY}}</option>
                                            <option value="{{COMMERCIAL_PROPERTY}}"
                                                    @if(isset($defaultSearch->property_type) && $defaultSearch->property_type==COMMERCIAL_PROPERTY) selected @endif>{{COMMERCIAL_INDIVIDUAL_PROPERTY}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('completion', 'Completion',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select class="form-control" name="completion">
                                            <option value="{{COMPLETE}}"
                                                    @if(isset($defaultSearch->completion) && $defaultSearch->completion==COMPLETE) selected @endif>{{COMPLETE}}</option>
                                            <option value="{{BUC}}"
                                                    @if(isset($defaultSearch->completion) && $defaultSearch->completion==BUC) selected @endif>{{BUC}}</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{ route('promotion-products',['productTypeId'=>$productTypeId]) }}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-warning pull-right"><i class="fa  fa-check"></i> Update
                            </button>

                        </div>
                        {{Form::hidden('_method','PUT')}}
                                <!-- /.box-footer -->
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                    @else
                            <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => 'admin/default-search-update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                <input type="hidden" name="promotion_id" value="{{$productTypeId}}"/>
                                {{Form::label('placement', 'Placement',['class'=>'col-sm-2 control-label '])}}
                                <div class="col-sm-10">
                                    {{Form::text('placement', old('placement'), ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                </div>
                            </div>
                            @if($productTypeId == ALL_IN_ONE_ACCOUNT)
                                <div class="form-group">
                                    {{Form::label('salary', 'Salary',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('salary', old('salary'), ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('payment', 'Payment',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('payment', old('payment'), ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('spend', 'Spend',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('spend', old('spend'), ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('privilege', 'Privilege',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('privilege', old('privilege'), ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('loan', 'Loan',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('loan', old('loan'), ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                            @endif
                            @if($productTypeId == LOAN)
                                <div class="form-group">
                                    {{Form::label('rate_type', 'Rate Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select class="form-control" name="rate_type">
                                            <option value="{{BOTH_VALUE}}">{{BOTH_VALUE}}</option>
                                            <option value="{{FIXED_RATE}}">{{FIXED_RATE}}</option>
                                            <option value="{{FLOATING_RATE}}">{{FLOATING_RATE}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('tenure', 'Tenure',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select class="form-control" name="tenure">
                                            @for($i=1;$i<=35;$i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('property_type', 'Property Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select class="form-control" name="property_type">
                                            <option value="{{HDB_PROPERTY}}">{{HDB_PROPERTY}}</option>
                                            <option value="{{PRIVATE_PROPERTY}}">{{PRIVATE_PROPERTY}}</option>
                                            <option value="{{COMMERCIAL_PROPERTY}}">{{COMMERCIAL_INDIVIDUAL_PROPERTY}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('completion', 'Completion',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select class="form-control" name="completion">
                                            <option value="{{COMPLETE}}">{{COMPLETE}}</option>
                                            <option value="{{BUC}}">{{BUC}}</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{ route('promotion-products',['productTypeId'=>$productTypeId]) }}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i> Add
                            </button>

                        </div>
                        <!-- /.box-footer -->
                        {!! Form::close() !!}
                    </div>
                    <!-- /.box-body -->
                    @endif


                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
