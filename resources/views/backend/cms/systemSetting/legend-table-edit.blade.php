@extends('backend.layouts.app')
@section('content')
<section class="content-header">
    <h1>
    {{strtoupper( SYSTEM_SETTING_LEGEND_MODULE_SINGLE )}}
    <small>{{EDIT_ACTION}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
        <li><a href="{{ route('system-setting-legend-table.index') }}">{{SYSTEM_SETTING_LEGEND_MODULE_SINGLE}}</a></li>
        <li class="active">{{EDIT_ACTION}}</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        @include('backend.inc.messages')
        <div class="col-xs-12">
            @if($systemSetting)
            <div class="box box-warning ">
                <!-- form start -->
                {!! Form::open(['class' => 'form-horizontal','url' => ['admin/system-setting-legend-table', $systemSetting->id], 'method' => 'POST' , 'enctype' => 'multipart/form-data']) !!}
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs pull-right">
                        <li class="pull-left header"><i class="fa fa-edit"></i>
                        {{SYSTEM_SETTING_LEGEND_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
                    </ul>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Custom Tabs (Pulled to the right) -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="homepage_links">
                                <div class="form-group">
                                    {{Form::label('page_type', 'Type',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        <select name="page_type" class="form-control">
                                            <option value="">Select</option>
                                            <option value="{{FIX_DEPOSIT}}" @if($systemSetting->page_type==FIX_DEPOSIT) selected @endif>{{FIX_DEPOSIT_MODULE}}</option>
                                            <option value="{{SAVING_DEPOSIT}}" @if($systemSetting->page_type==SAVING_DEPOSIT) selected @endif>{{SAVING_DEPOSIT_MODULE}}</option>
                                            <option value="{{ALL_IN_ONE_ACCOUNT}}" @if($systemSetting->page_type==ALL_IN_ONE_ACCOUNT) selected @endif>{{ALL_IN_ONE_ACCOUNT_DEPOSIT_MODULE}}</option>
                                            <option value="{{PRIVILEGE_DEPOSIT}}" @if($systemSetting->page_type==PRIVILEGE_DEPOSIT) selected @endif>{{PRIVILEGE_DEPOSIT_MODULE}}</option>
                                            <option value="{{FOREIGN_CURRENCY_DEPOSIT}}" @if($systemSetting->page_type==FOREIGN_CURRENCY_DEPOSIT) selected @endif>{{FOREIGN_CURRENCY_DEPOSIT_MODULE}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10">
                                        {{Form::text('title', $systemSetting->title, ['id' => '', 'class' => 'form-control', 'placeholder' => '' ])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    {{Form::label('icon', ' Icon',['class'=>'col-sm-2 control-label'])}}
                                    <div class="col-sm-10 ">
                                        {{Form::text('icon', $systemSetting->icon,['class' => 'form-control', 'placeholder' => ''])}}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Icon Background</label>
                                    <div class="col-sm-10">
                                        <div class="col-sm-10 input-group my-colorpicker1 colorpicker-element">
                                            <input type="text" value="{{$systemSetting->icon_background}}" name="icon_background" class="form-control ">
                                            <div class="input-group-addon">
                                                <i style="background-color: rgb(195, 33, 33);"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Status</label>
                                    <div class="col-sm-10">
                                        <select class="form-control select2"
                                            data-placeholder="" name="status"
                                            style="width: 100%;">
                                            <option value="1" @if($systemSetting->status == "1") selected="selected" @endif>
                                                Active
                                            </option>
                                            <option value="0" @if($systemSetting->status == "0") selected="selected" @endif>
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
                    <div class="box-footer">
                        <a href="{{ route('system-setting-legend-table.index') }}"
                            class="btn btn-default"><i class="fa fa-close">
                        </i> Cancel</a>
                        <button type="submit" class="btn btn-warning pull-right"><i class="fa  fa-check"></i>
                        Update
                        </button>
                    </div>
                    {{Form::hidden('_method','PUT')}}
                    <!-- /.box-footer -->
                    {!! Form::close() !!}
                    
                </div>
                <!-- /.box-body -->
            </div>
            @endif
            <!-- /.box -->
        </div>
        
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<script>
$(function () {
//Colorpicker
$('.my-colorpicker1').colorpicker()

});
function removeImage(ref, id) {
$.ajax({
method: "POST",
url: "<?php echo e(route('remove-image')); ?>",
data: "type=<?php echo SYSTEM_SETTING_LEGEND_MODULE_SINGLE; ?>&id="+id,
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