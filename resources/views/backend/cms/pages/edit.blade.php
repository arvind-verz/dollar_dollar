@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( PAGE_MODULE )}}
            <small>{{PAGE_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('page.index') }}">{{PAGE_MODULE}}</a></li>
            <li class="active">{{PAGE_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-warning ">
                    <!-- form start -->
                    {!! Form::open(['class' => 'form-horizontal','url' => ['admin/page', $page->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">


                            <li><a href="#setting" data-toggle="tab">Setting</a></li>
                            <li><a href="#meta" data-toggle="tab">Meta</a></li>
                            <li class="active"><a href="#page " data-toggle="tab">Page</a></li>
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{PAGE_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
                        </ul>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- Custom Tabs (Pulled to the right) -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="page">

                                    <div class="form-group">
                                        {{Form::label('name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('name', $page->name, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    @if( !in_array($page->slug,[HOME_SLUG , BLOG_SLUG]) )
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
                                            </select>
                                        </div>
                                    </div>
                                    <?php
                                        $ads = json_decode($page->ads_placement);
                                        //dd($ads);
                                    ?>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_image_popup', 'Ad Horizontal Image Popup',['class'=>'col-sm-2 control-label'])}}
                                        <div class="@if(isset($ads[0]->ad_horizontal_image_popup) && ($ads[0]->ad_horizontal_image_popup != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('ad_horizontal_image_popup', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        @if(isset($ads[0]->ad_horizontal_image_popup) && ($ads[0]->ad_horizontal_image_popup != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="{{asset($ads[0]->ad_horizontal_image_popup)}}" target="_blank"><img class="attachment-img" src="{!! asset($ads[0]->ad_horizontal_image_popup) !!}"
                                                         alt="image"></a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('ad_horizontal_link_popup', 'Ad Horizontal Link Popup',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('ad_horizontal_link_popup', isset($ads[0]->ad_link_horizontal_popup) ? $ads[0]->ad_link_horizontal_popup : '' , ['id'=>'link_ad','class' => 'form-control', 'placeholder' => ''])}}
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
                                        <label class="col-sm-2 control-label">Menu</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="Select Sub menu of" name="menu_id"
                                                    style="width: 100%;">
                                                <option value="null" selected="selected">Select Menu</option>
                                                @if($menus->count())
                                                    @foreach($menus as $singleMenu)
                                                        <option value="{{ $singleMenu->id }}"
                                                                @if($singleMenu->id == $page->menu_id) selected="selected" @endif>{{ $singleMenu->title.'&emsp;('.$singleMenu->parent_menu.')' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Page Linked to</label>

                                        <div class="col-sm-10">

                                            <select class="form-control select2"
                                                    data-placeholder="Select Page Link" name="page_linked"
                                                    style="width: 100%;">
                                                <option value="null" selected="selected">Select Page Linked</option>
                                                @if($allpages->count())
                                                    @foreach($allpages as $singlepage)
                                                        <option value="{{ $singlepage->id }}"
                                                                @if($singlepage->id == $page->page_linked) selected="selected" @endif>{{ $singlepage->name }}</option>
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
                            <a href="{{ route('page.index') }}"
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

