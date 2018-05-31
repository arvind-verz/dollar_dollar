@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( CUSTOMER_MODULE )}}
            <small>{{CUSTOMER_MODULE_SINGLE.' '.IMPORT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('users.index') }}">{{CUSTOMER_MODULE}}</a></li>
            <li class="active">{{CUSTOMER_MODULE_SINGLE.' '.IMPORT_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="glyphicon glyphicon-import"></i>

                        <h3 class="box-title">{{CUSTOMER_MODULE_SINGLE.' '.IMPORT_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','route'=>['users-csv-import'],'method'=>'POST', 'files' => true]) !!}
                        <div class="box-body">
                            <div class="form-group">
                                {{Form::label('csv_file', 'CSV File',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {!! Form::file('csv_file', ['placeholder' => '','class' => 'form-control','id'=>'name']) !!}
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("users.index")}}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i> Import
                            </button>

                        </div>
                        <!-- /.box-footer -->
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
@endsection


