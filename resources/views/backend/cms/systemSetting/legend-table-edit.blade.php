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
                @if(count($systemSetting))
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
                                                <option value="{{WEALTH_DEPOSIT}}" @if($systemSetting->page_type==WEALTH_DEPOSIT) selected @endif>{{WEALTH_DEPOSIT_MODULE}}</option>
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
                                        <div class="@if(isset($systemSetting->icon) && ($systemSetting->icon != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('icon', ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                        @if(isset($systemSetting->icon) && ($systemSetting->icon != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="javascript:void(0)" class="text-danger" title="close" onclick="removeImage(this, '{{ $systemSetting->id }}');"><i class="fas fa-times fa-lg"></i></a>
                                                    <img class="attachment-img" src="{!! asset($systemSetting->icon) !!}"
                                                         alt="Icon">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="text-muted col-sm-offset-2 col-md-12"><strong>Note:</strong> Image size should be 40*25 for better display</div>
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