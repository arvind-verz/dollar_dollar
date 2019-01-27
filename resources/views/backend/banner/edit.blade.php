@extends('backend.layouts.app')
@section('content')
<section class="content-header">
    <h1>
    {{strtoupper( BANNER_MODULE )}}
    <small>{{BANNER_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
        <li><a href="{{ route('banner.index', ["type"=>$type]) }}">{{BANNER_MODULE}}</a></li>
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
                    {!! Form::open(['class' => 'form-horizontal','url' => ['admin/banner-update', $banner->id, $type], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
                            {{Form::label('banner_image', 'Default Banner Image',['class'=>'col-sm-2 control-label'])}}
                            <div class="@if(isset($banner->banner_image) && ($banner->banner_image != ''))col-sm-8 @else col-sm-10 @endif">
                                {{Form::file('banner_image', ['class' => 'form-control', 'placeholder' => ''])}}
                                <div class="text-muted"><strong>Note:</strong> Image size should be @if($type=="inner-page")1920*360 @else 1200*360 @endif for better display</div>
                            </div>
                            @if(isset($banner->banner_image) && ($banner->banner_image != ''))
                            <div class=" col-sm-2">
                                <div class="attachment-block clearfix">
                                    <a href="javascript:void(0)" class="text-danger" title="close" onclick="removeImage(this, '{{ $banner->id }}');"><i class="fas fa-times fa-lg"></i></a>
                                    <img class="attachment-img" src="{!! asset($banner->banner_image) !!}"
                                    alt="Default Banner Image">
                                </div>
                            </div>
                            @endif
                            
                        </div>
                        <div class="form-group">
                            {{Form::label('banner_link', 'Default Banner Link',['class'=>'col-sm-2 control-label'])}}
                            <div class="col-sm-10">
                                {{Form::text('banner_link', $banner->banner_link, ['id'=>'','class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>
                        @if($type=='home-page')
                        <div class="form-group">
                            <input type="hidden" id="paid-ads-status" name="paid_ads_status" value="{{$banner->paid_ads_status}}"/>
                            <label class="col-sm-2 col-lg-2 col-md-2 control-label">Paid Ads</label>
                            <div class="col-sm-2 col-lg-2 col-md-2" id="paid-ads">
                                @if($banner->paid_ads_status==1)
                                <button type="button" data-status="true" id=""
                                class="btn btn-block btn-success btn-social"
                                onclick="changePaidAdsStatus(this)"><i class="fa fa-check"></i> Enable
                                </button>
                                @else
                                <button type="button" data-status="false" id="" class="btn btn-block btn-danger  btn-social" onclick="changePaidAdsStatus(this)"><i class="fa fa-times"></i>Disable</button>
                                @endif
                            </div>
                            <div class="col-sm-8 col-lg-8 col-md-8"></div>
                            
                        </div>
                        <div class="form-group">
                            {{Form::label('fixed_banner', 'Paid Banner Image',['class'=>'col-sm-2 control-label '])}}
                            <div class="@if(isset($banner->fixed_banner) && ($banner->fixed_banner != ''))col-sm-8 @else col-sm-10 @endif">
                                @if($banner->paid_ads_status==0)
                                {{Form::file('fixed_banner', ['class' => 'form-control paid-ad', 'disabled' => 'disabled'])}}
                                
                                @else
                                {{Form::file('fixed_banner', ['class' => 'form-control paid-ad', 'placeholder' => ''])}}
                                
                                @endif
                                
                                <div class="text-muted"><strong>Note:</strong> Image size should be @if($type=="inner-page")1920*360 @else 1200*360 @endif for better display</div>
                            </div>
                            @if(isset($banner->fixed_banner) && ($banner->fixed_banner != ''))
                            <div class=" col-sm-2">
                                <div class="attachment-block clearfix">
                                    <a href="javascript:void(0)" class="text-danger" title="close" onclick="removeImage(this, '{{ $banner->id }}');"><i class="fas fa-times fa-lg"></i></a>
                                    <img class="attachment-img" src="{!! asset($banner->fixed_banner) !!}"
                                    alt="Paid Banner Image">
                                </div>
                            </div>
                            @endif
                            
                        </div>
                        <div class="form-group">
                            {{Form::label('fixed_banner_link', 'Paid Banner Link',['class'=>'col-sm-2 control-label'])}}
                            @if($banner->paid_ads_status==0) <div class="col-sm-10 ">
                                {{Form::text('fixed_banner_link', $banner->fixed_banner_link, ['id'=>'','class' => 'form-control paid-ad-text','readonly'=>'readonly', 'placeholder' => ''])}}
                            </div>
                            @else
                            <div class="col-sm-10 ">
                                {{Form::text('fixed_banner_link', $banner->fixed_banner_link, ['id'=>'','class' => 'form-control paid-ad-text', 'placeholder' => ''])}}
                            </div>
                            @endif
                            
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Ad Range Date </label>
                            <div class="col-sm-10">
                                <input type="text" name="ad_range_date" class="form-control date_range paid-ad" @if($banner->paid_ads_status==0) disabled="disabled" @endif
                                value="@if(empty($banner->banner_start_date) || empty($banner->banner_end_date))  @else {{ date('Y/m/d', strtotime($banner->banner_start_date)) .' - '. date('Y/m/d', strtotime($banner->banner_end_date)) }} @endif"
                                autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 control-label">
                                <label>Activate?</label>
                            </div>
                            <div class="col-sm-10">
                                <select class="form-control" name="display">
                                    <option value="1" @if($banner->display==1) selected @endif>Yes</option>
                                    <option value="0" @if($banner->display==0) selected @endif>No</option>
                                </select>
                            </div>
                        </div>
                        @endif
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
                        <!--<div class="form-group">
                            {{Form::label('view_order', 'View Order',['class'=>'col-sm-2 control-label'])}}
                            <div class="col-sm-10">
                                {{Form::text('view_order', ($banner->view_order ? $banner->view_order :0), ['class' => 'form-control', 'placeholder' => ''])}}
                            </div>
                        </div>-->
                        
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        {{Form::hidden('_method','PUT')}}
                        <a href="{{ route('banner.index', ['type'=>$type]) }}"
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
<script>
function removeImage(ref, id) {
$.ajax({
method: "POST",
url: "{{ route('remove-image') }}",
data: "type=banner&id="+id,
cache: false,
success: function(data) {
if(data.trim()=='success') {
$(ref).parents(".col-sm-2").remove();
}
}
});
}
</script>
@endsection