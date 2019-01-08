@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( BLOG_MODULE )}}
            <small>{{BLOG_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('filter-category', ['id' => $filterCategory]) }}">{{BLOG_MODULE}}</a></li>
            <li class="active">{{BLOG_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-warning ">
                    <!-- form start -->
                    {!! Form::open(['class' => 'form-horizontal','url' => ['admin/blog', $page->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">


                            <li><a href="#setting" data-toggle="tab">Setting</a></li>
                            <li><a href="#meta" data-toggle="tab">Meta</a></li>
                            <li class="active"><a href="#page " data-toggle="tab">Page</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{BLOG_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
                        </ul>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- Custom Tabs (Pulled to the right) -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="page">

                                    <div class="form-group">
                                        <input type="hidden" name="filter_category" value="{{$filterCategory}}"/>
                                        {{Form::label('name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('name', $page->name, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('blog_image', ' Image',['class'=>'col-sm-2 control-label'])}}
                                        <div class="@if(isset($page->blog_image) && ($page->blog_image != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('blog_image', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        @if(isset($page->blog_image) && ($page->blog_image != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="javascript:void(0)" class="text-danger" title="close" onclick="removeImage(this, '{{ $page->id }}');"><i class="fas fa-times fa-lg"></i></a>
                                                    <img class="attachment-img" src="{!! asset($page->blog_image) !!}"
                                                         alt="Banner Image">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image size should be 500*250 for better display</div>
                                    </div>
                                    <!-- <div class="form-group">
                                        {{Form::label('blog_image_ads', ' Image Ads',['class'=>'col-sm-2 control-label'])}}
                                        <div class="@if(isset($page->blog_image_ads) && ($page->blog_image_ads != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('blog_image_ads', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        @if(isset($page->blog_image_ads) && ($page->blog_image_ads != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="javascript:void(0)" class="text-danger" title="close" onclick="removeImageads(this, '{{ $page->id }}');"><i class="fas fa-times fa-lg"></i></a>
                                                    <img class="attachment-img" src="{!! asset($page->blog_image_ads) !!}"
                                                         alt="Blog Image ads">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image size should be 500*250 for better display</div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('blog_image_ads_link', 'Image Ads Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('blog_image_ads_link', $page->blog_image_ads_link, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        {{Form::label('short_description', 'Short Description',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('short_description', $page->short_description, ['id' => 'article-ckeditor', 'class' => 'form-control page-contents', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    @if($page->slug != HOME_SLUG)
                                        <div class="form-group">
                                            {{Form::label('contents', 'Contents',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                {{Form::textarea('contents', $page->contents, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => ''])}}
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Footer Info</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="Select Menu" name="contact_or_offer"
                                                    style="width: 100%;">
                                                <option value="null">Select display section</option>
                                                <option value="{{CONTACT_US_SECTION_VALUE}}"
                                                        @if(CONTACT_US_SECTION_VALUE == $page->contact_or_offer) selected="selected" @endif>{{CONTACT_US_SECTION}}</option>
                                                <option value="{{OFFER_SECTION_VALUE}}"
                                                        @if(OFFER_SECTION_VALUE == $page->contact_or_offer) selected="selected" @endif>{{OFFER_SECTION}}</option>
                                                        <option value="{{FOOTER3_VALUE}}" @if(FOOTER3_VALUE == $page->contact_or_offer) selected="selected" @endif>{{FOOTER3}}</option>
                                                <option value="{{FOOTER4_VALUE}}" @if(FOOTER3_VALUE == $page->contact_or_offer) selected="selected" @endif>{{FOOTER4}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Disable Ads?</label>

                                        <div class="col-sm-10">
                                            <select class="form-control select2"
                                                    data-placeholder="Select" name="disable_ads"
                                                    style="width: 100%;">
                                                <option value="null" >Select</option>
                                                <option value="1" @if($page->disable_ads==1) selected @endif>Yes</option>
                                                <option value="0" @if($page->disable_ads==0) selected @endif>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="meta">
                                    <div class="form-group">
                                        {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('title', $page->title, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('meta_title', 'Meta Title',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('meta_title',$page->meta_title, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('meta_keyword', 'Meta Keyword',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('meta_keyword', $page->meta_keyword, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    {{--<div class="form-group">
                                        {{Form::label('meta_description', 'Meta Description',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('meta_description', $page->meta_description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>--}}

                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane " id="setting">
                                    <div class="form-group">
                                        {{Form::label('slug', 'Slug',['class'=>'col-sm-2 control-label ',])}}
                                        <div class="col-sm-10">
                                            @if($page->is_dynamic == 0)
                                                {{Form::text('slug', $page->slug, ['class' => 'form-control lower-case', ])}}
                                            @else
                                                {{Form::text('slug', $page->slug, ['class' => 'form-control lower-case','disabled'=>'disabled' ])}}
                                            @endif
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Category</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="Select Sub menu of" name="menu_id"
                                                    style="width: 100%;">
                                                <option value="null" selected="selected">Select Category</option>
                                                @if($menus->count())
                                                    @foreach($menus as $singleMenu)
                                                        <option value="{{ $singleMenu->id }}"
                                                                @if($singleMenu->id == $page->menu_id) selected="selected" @endif>{{ $singleMenu->title }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Tags</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2" multiple="multiple"
                                                    data-placeholder="" name="tags[]"
                                                    style="width: 100%;">
                                                @foreach($tags as $tag)
                                                    <option value="{{ $tag->id }}" {{ (in_array($tag->id, $page->tags) ? 'selected' : '') }}>{{ $tag->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Only appear after login?</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="" name="after_login"
                                                    style="width: 100%;">
                                                <option value="1"
                                                        @if($page->after_login == 1) selected="selected" @endif>
                                                    Yes
                                                </option>
                                                <option value="0"
                                                        @if($page->after_login == 0) selected="selected" @endif>
                                                    No
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Status</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2 "
                                                    @if(($page->is_index == 1)) disabled="disabled" @endif
                                                    data-placeholder="" name="status"
                                                    style="width: 100%;">
                                                <option value="1" @if($page->status == 1) selected="selected" @endif>
                                                    Active
                                                </option>
                                                <option value="0" @if($page->status == 0) selected="selected" @endif>
                                                    Deactivate
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-content -->

                        </div>
                        <!-- nav-tabs-custom -->
                        {{Form::hidden('_method','PUT')}}
                        <div class="box-footer">
                            <a href="{{ route('filter-category', ['id' => $filterCategory]) }}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-warning pull-right"><i class="fa  fa-check"></i>
                                Update
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
<script>
function removeImage(ref, id) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('remove-image') }}",
                    data: "type=blog&id="+id,
                    cache: false,
                    success: function(data) {
                        if(data.trim()=='success') {
                            $(ref).parents(".col-sm-2").remove();
                        }
                    }
                });
            }
            function removeImageads(ref, id) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('remove-image') }}",
                    data: "type=blogads&id="+id,
                    cache: false,
                    success: function(data) {
                        if(data.trim()=='success') {
                            $(ref).parents(".col-sm-2").remove();
                        }
                    }
                });
            }
    </script>

