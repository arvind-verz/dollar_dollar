@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( PAGE_MODULE )}}
            <small>{{PAGE_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('page.index') }}">{{PAGE_MODULE}}</a></li>
            <li class="active">{{PAGE_MODULE_SINGLE.' '.ADD_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <!-- form start -->
                    {!! Form::open(['class' => 'form-horizontal','url' => 'admin/page', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">


                            <li><a href="#setting" data-toggle="tab">Setting</a></li>
                            <li><a href="#meta" data-toggle="tab">Meta</a></li>
                            <li class="active"><a href="#page " data-toggle="tab">Page</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{PAGE_MODULE_SINGLE.' '.ADD_ACTION}}</li>
                        </ul>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- Custom Tabs (Pulled to the right) -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="page">

                                    <div class="form-group">
                                        {{Form::label('name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('icon', 'Icon',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('icon', old('icon'), ['class' => 'form-control iconpicker', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('contents', 'Contents',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('contents', old('contents'), ['id' => 'article-ckeditor', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Footer Info</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="Select Menu" name="contact_or_offer"
                                                    style="width: 100%;">
                                                <option value="null" >Select display section</option>
                                                <option value="{{CONTACT_US_SECTION_VALUE}}">{{CONTACT_US_SECTION}}</option>
                                                <option value="{{OFFER_SECTION_VALUE}}">{{OFFER_SECTION}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="meta">
                                    <div class="form-group">
                                        {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('title', old('title'), ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('meta_title', 'Meta Title',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('meta_title', old('meta_title'), ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('meta_keyword', 'Meta Keyword',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('meta_keyword', old('meta_keyword'), ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    {{--<div class="form-group">
                                        {{Form::label('meta_description', 'Meta Description',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('meta_description', old('meta_description'), ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>--}}

                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane " id="setting">
                                    <div class="form-group">
                                        {{Form::label('slug', 'Slug',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('slug', old('slug'), ['class' => 'form-control lower-case ', 'placeholder' => 'new-slug'])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Menu</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="Select Menu" name="menu_id"
                                                    style="width: 100%;">
                                                <option value="null" selected="selected">Select Menu</option>
                                                @if($menus->count())
                                                    @foreach($menus as $singleMenu)
                                                        <option value="{{ $singleMenu->id }}">{{ $singleMenu->title.' ('.$singleMenu->parent_menu.')' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Only appear after login?</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="after_login"
                                                    style="width: 100%;">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
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

                                </div>
                            </div>
                            <!-- /.tab-content -->

                        </div>
                        <!-- nav-tabs-custom -->
                        <div class="box-footer">
                            <a href="{{ route('page.index') }}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i>
                                Add
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
