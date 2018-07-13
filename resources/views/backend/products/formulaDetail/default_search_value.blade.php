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

                        <h3 class="box-title">{{$productType.' '}}@if($defaultSearch){{EDIT_ACTION}}@else {{ADD_ACTION}}@endif</h3>
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
                                    {{Form::label('wealth', 'Wealth',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('wealth', $defaultSearch->wealth, ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('loan', 'Loan',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('loan', $defaultSearch->loan, ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
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
                                    {{Form::label('wealth', 'Wealth',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('wealth', old('wealth'), ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('loan', 'Loan',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('loan', old('loan'), ['class' => 'form-control only_numeric', 'placeholder' => ''])}}
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
