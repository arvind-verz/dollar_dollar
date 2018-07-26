@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( BANNER_MODULE )}}
            <small>{{BANNER_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('banner.index', ['type'=>$type]) }}">{{BANNER_MODULE}}</a></li>
            <li class="active">{{BANNER_MODULE_SINGLE.' '.ADD_ACTION}}</li>
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

                        <h3 class="box-title">{{BANNER_MODULE_SINGLE.' '.ADD_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => ['admin/banner-store', $type], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Page</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="" name="page" id="page"
                                            style="width: 100%;">
                                        <option value="null">Select Page</option>
                                        @if($pages->count())
                                            @foreach ($pages as $page)
                                                <option value="{{ $page->id }}"
                                                         @if($page->id == old('page')) selected="selected" @endif>{{ $page->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('title',  old('title'), ['id' => '', 'class' => 'form-control  ', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('description', 'Description',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('description', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('banner_content', 'Contents',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::textarea('banner_content', old('banner_content'), ['id' => 'article-ckeditor', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('banner_image', 'Image',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::file('banner_image', ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                                <div class="text-muted col-sm-offset-2"><strong>Note:</strong> Image size should be 1920*428 for better display</div>
                            </div>
                            <div class="form-group">
                                {{Form::label('banner_link', 'Link',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('banner_link', old('banner_link'), ['id'=>'', 'class' => 'form-control', 'placeholder' => ''])}}
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
                                    {{Form::text('view_order', (old('view_order') ?  old('view_order') :0), ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>

                            <div class="form-group">
                            </div>

                        </div>
                        <input type="hidden" name="type" value="{{ $type }}">
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("brand.index", ["type"=>$type])}}"
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
