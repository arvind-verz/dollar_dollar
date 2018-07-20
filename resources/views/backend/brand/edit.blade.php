@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( BRAND_MODULE )}}
            <small>{{BRAND_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('brand.index') }}">{{BRAND_MODULE}}</a></li>
            <li class="active">{{BRAND_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-warning ">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>

                        <h3 class="box-title">{{BRAND_MODULE_SINGLE.' '.EDIT_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => ['admin/brand', $brand->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('title', $brand->title, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('logo', 'Logo',['class'=>'col-sm-2 control-label'])}}
                                <div class="@if(isset($brand->brand_logo) && ($brand->brand_logo != ''))col-sm-8 @else col-sm-10 @endif">
                                    {{Form::file('brand_logo', ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                                @if(isset($brand->brand_logo) && ($brand->brand_logo != ''))
                                    <div class=" col-sm-2">
                                        <div class="attachment-block clearfix">
                                            <img class="attachment-img" src="{!! asset($brand->brand_logo) !!}"
                                                 alt="Brand Image">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{Form::label('brand_link', 'Link',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('brand_link', $brand->brand_link, ['id'=>'link','class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group" id="target-div">
                                <label class="col-sm-2 control-label">Target</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="" name="target"
                                            style="width: 100%;" id="target">
                                        <option value="_self"
                                                @if($brand->target == '_self') selected="selected" @endif> _self
                                        </option>
                                        <option value="_blank"
                                                @if($brand->target == '_blank') selected="selected" @endif> _blank
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('view_order', 'View Order',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('view_order', $brand->view_order ?  $brand->view_order :0, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            {{Form::hidden('_method','PUT')}}

                            <div class="form-group">
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("brand.index")}}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-warning pull-right"><i class="fa  fa-check"></i> Update
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