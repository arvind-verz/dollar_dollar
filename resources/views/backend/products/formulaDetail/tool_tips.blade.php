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
            <li class="active">{{'Tool Tips '}}@if($toolTips){{EDIT_ACTION}}@else {{ADD_ACTION}}@endif</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box @if($toolTips) box-warning  @else box-info @endif ">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>

                        <h3 class="box-title">{{'Tool Tips '}}@if($toolTips){{EDIT_ACTION}}@else {{ADD_ACTION}}@endif</h3>
                    </div>

                    @if($toolTips)
                            <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => 'admin/tool-tip-update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            @if($productTypeId == ALL_IN_ONE_ACCOUNT)
                                <div class="form-group">
                                    <input type="hidden" name="promotion_id" value="{{$productTypeId}}"/>
                                    {{Form::label('salary', 'Salary',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('salary', $toolTips->salary, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('payment', 'Payment',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('payment',$toolTips->payment, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('spend', 'Spend',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('spend', $toolTips->spend, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('privilege', 'Privilege',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('privilege', $toolTips->privilege, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('loan', 'Loan',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('loan', $toolTips->loan, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                            @endif
                            @if($productTypeId == LOAN)
                                <div class="form-group">
                                    <input type="hidden" name="promotion_id" value="{{$productTypeId}}"/>
                                    {{Form::label('rate_type', 'Rate Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('rate_type', $toolTips->rate_type, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('tenure', 'Tenure',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('tenure',$toolTips->tenure, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('property_type', 'Property Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('property_type', $toolTips->property_type, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('completion', 'Completion',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('completion', $toolTips->completion, ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('loan', 'Loan',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('loan', $toolTips->loan, ['class' => 'form-control ', 'placeholder' => ''])}}
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
                        {!! Form::open(['class' => 'form-horizontal','url' => 'admin/tool-tip-update', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            @if($productTypeId == ALL_IN_ONE_ACCOUNT)
                                <div class="form-group">
                                    <input type="hidden" name="promotion_id" value="{{$productTypeId}}"/>
                                    {{Form::label('salary', 'Salary',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('salary', old('salary'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('payment', 'Payment',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('payment', old('payment'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('spend', 'Spend',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('spend', old('spend'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('privilege', 'Privilege',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('privilege', old('privilege'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('loan', 'Loan',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('loan', old('loan'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                            @endif
                            @if($productTypeId == LOAN)
                                <div class="form-group">
                                    <input type="hidden" name="promotion_id" value="{{$productTypeId}}"/>
                                    {{Form::label('rate_type', 'Rate Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('rate_type',old('rate_type'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('tenure', 'Tenure',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('tenure',old('tenure'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('property_type', 'Property Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('property_type', old('property_type'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('completion', 'Completion',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('completion',old('completion'), ['class' => 'form-control ', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                    <div class="form-group">
                                        {{Form::label('loan', 'Loan',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('loan',old('loan'), ['class' => 'form-control ', 'placeholder' => ''])}}
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
