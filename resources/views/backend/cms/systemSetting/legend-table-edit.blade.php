@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( SYSTEM_SETTING_LEGEND_MODULE )}}
            <small>{{SYSTEM_SETTING_LEGEND_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('system-setting-legend-table.index') }}">{{SYSTEM_SETTING_LEGEND_MODULE_SINGLE}}</a></li>
            <li class="active">{{SYSTEM_SETTING_LEGEND_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
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
                    {!! Form::open(['class' => 'form-horizontal','url' => ['admin/system-setting-legend-table', $systemSetting->id], 'method' => 'POST']) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li><a href="#homepage_links" data-toggle="tab">Homepage Links</a></li>
                            
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
                                                <option value="Fixed Deposit" @if($systemSetting->page_type=='Fixed Deposit') selected @endif>Fixed Deposit</option>
                                                <option value="Saving Deposit" @if($systemSetting->page_type=='Saving Deposit') selected @endif>Saving Deposit</option>
                                                <option value="Wealth Deposit" @if($systemSetting->page_type=='Wealth Deposit') selected @endif>Wealth Deposit</option>
                                                <option value="AIO Deposit" @if($systemSetting->page_type=='AIO Deposit') selected @endif>All in One Deposit</option>
                                                <option value="Foreign Currency Deposit" @if($systemSetting->page_type=='Foreign Currency Deposit') selected @endif>Foreign Currency Deposit</option>
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
                                        {{Form::label('icon', 'Icon',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            <input type="file" name="icon" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-content -->

                        </div>
                        <!-- nav-tabs-custom -->
                        <div class="box-footer">
                            <a href="{{ url('/admin') }}"
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

@endsection