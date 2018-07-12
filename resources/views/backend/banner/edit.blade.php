@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( BANNER_MODULE )}}
            <small>{{BANNER_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('banner.index') }}">{{BANNER_MODULE}}</a></li>
            <li class="active">{{BANNER_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
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

                        <h3 class="box-title">{{BANNER_MODULE_SINGLE.' '.EDIT_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => ['admin/banner', $banner->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Page</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="Select Page " name="page" id="page"
                                            style="width: 100%;">
                                        <option value="null">Select Page</option>
                                        @if($pages->count())
                                            @foreach ($pages as $page)
                                                <option value="{{ $page->id }}"
                                                        @if($page->id == $banner->page_id) selected="selected" @endif>{{ $page->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>                            
                            <div class="form-group">
                                {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('title',  $banner->title, ['id' => '', 'class' => 'form-control  ', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('description', 'Description',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('description',  $banner->description, ['id' => '', 'class' => 'form-control  ', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('banner_content', ' Content',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::textarea('banner_content',  $banner->banner_content, ['id' => '', 'class' => 'form-control text-color-base ', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('banner_image', ' Image',['class'=>'col-sm-2 control-label'])}}
                                <div class="@if(isset($banner->banner_image) && ($banner->banner_image != ''))col-sm-8 @else col-sm-10 @endif">
                                    {{Form::file('banner_image', ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                                @if(isset($banner->banner_image) && ($banner->banner_image != ''))
                                    <div class=" col-sm-2">
                                        <div class="attachment-block clearfix">
                                            <img class="attachment-img" src="{!! asset($banner->banner_image) !!}"
                                                 alt="Banner Image">
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                {{Form::label('banner_link', ' Link',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('banner_link', $banner->banner_link, ['id'=>'','class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group" id="target-div">
                                <label class="col-sm-2 control-label">Target</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="" name="target"
                                            style="width: 100%;" id="target">
                                        <option value="_self"
                                                @if($banner->target == '_self') selected="selected" @endif> _self
                                        </option>
                                        <option value="_blank"
                                                @if($banner->target == '_blank') selected="selected" @endif> _blank
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('view_order', 'View Order',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::number('view_order', ($banner->view_order ? $banner->view_order :0), ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>

                            <div class="form-group">
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            {{Form::hidden('_method','PUT')}}
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
