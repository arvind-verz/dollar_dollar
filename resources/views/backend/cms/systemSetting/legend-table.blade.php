@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( SYSTEM_SETTING_LEGEND_MODULE_SINGLE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li>{{SYSTEM_SETTING_LEGEND_MODULE_SINGLE}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <!-- form start -->
                    {!! Form::open(['class' => 'form-horizontal','url' => ['admin/system-setting-legend-table'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{SYSTEM_SETTING_LEGEND_MODULE_SINGLE.' '.ADD_ACTION}}</li>
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
                                                <option value="{{FIX_DEPOSIT}}">{{FIX_DEPOSIT_MODULE}}</option>
                                                <option value="{{SAVING_DEPOSIT}}">{{SAVING_DEPOSIT_MODULE}}</option>
                                                <option value="{{ALL_IN_ONE_ACCOUNT}}">{{ALL_IN_ONE_ACCOUNT_DEPOSIT_MODULE}}</option>
                                                <option value="{{WEALTH_DEPOSIT}}">{{WEALTH_DEPOSIT_MODULE}}</option>
                                                <option value="{{FOREIGN_CURRENCY_DEPOSIT}}">{{FOREIGN_CURRENCY_DEPOSIT_MODULE}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('title', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('icon', 'Icon',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            <input type="file" name="icon" class="form-control">
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

                            <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i>
                                Add
                            </button>
                        </div>
                        <!-- /.box-footer -->
                        {!! Form::close() !!}
                        <hr>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($systemSetting))
                                    @foreach($systemSetting as $setting)
                                        <tr>
                                            <td>
                                                @if($setting->page_type == FIX_DEPOSIT)
                                                    {{FIX_DEPOSIT_MODULE}}
                                                @elseif($setting->page_type == SAVING_DEPOSIT)
                                                    {{SAVING_DEPOSIT_MODULE}}
                                                @elseif($setting->page_type == ALL_IN_ONE_ACCOUNT)
                                                    {{ALL_IN_ONE_ACCOUNT_DEPOSIT_MODULE}}
                                                @elseif($setting->page_type == WEALTH_DEPOSIT)
                                                    {{WEALTH_DEPOSIT_MODULE}}
                                                @elseif($setting->page_type == FOREIGN_CURRENCY_DEPOSIT)
                                                    {{FOREIGN_CURRENCY_DEPOSIT_MODULE}}
                                                @endif
                                            </td>
                                            <td class="">
                                                <div class="attachment-block clearfix ">
                                                    <img class="attachment-img"
                                                         src="{!! asset($setting->icon) !!}"
                                                         alt="Banner Image">
                                                </div>
                                            </td>
                                            <td>{{ $setting->title }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-app edit" title="Edit Page"
                                                   href="{{ route("system-setting-legend-table.edit",["id"=>$setting->id]) }}"><i
                                                            class="fa fa-edit"></i> Edit</a>
                                                <a class="btn btn-app delete" title="Delete Brand"
                                                   onclick="return confirm('Are you sure to delete this?')"
                                                   href="{{ route("system-setting-legend-table-destory",["id"=>$setting->id]) }}">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
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