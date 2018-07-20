@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( BRAND_MODULE )}}
            <small>{{BRAND_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('brand.index') }}">{{BRAND_MODULE}}</a></li>
            <li class="active">{{BRAND_MODULE_SINGLE.' '.ADD_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>

                        <h3 class="box-title">{{BRAND_MODULE_SINGLE.' '.ADD_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => 'admin/brand', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('logo', 'Logo',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::file('brand_logo', ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('brand_link', 'Link',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('brand_link', old('brand_link'), ['id'=>'link','class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group" id="target-div">
                                <label class="col-sm-2 control-label">Target</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="" name="target"
                                            style="width: 100%;" id="target">
                                        <option value="_self">_self</option>
                                        <option value="_blank">_blank</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('view_order', 'View Order',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::number('view_order', (old('view_order') ?  old('view_order') :0), ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>

                            <div class="form-group">
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("brand.index")}}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i> Add
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
