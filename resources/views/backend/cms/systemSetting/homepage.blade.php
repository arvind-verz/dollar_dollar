@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( SYSTEM_SETTING_MODULE )}}
            <small>{{SYSTEM_SETTING_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('system-setting-homepage.index') }}">{{SYSTEM_SETTING_MODULE_SINGLE}}</a></li>
            <li class="active">{{SYSTEM_SETTING_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-warning ">
                    <!-- form start -->
                    {!! Form::open(['class' => 'form-horizontal','url' => ['admin/system-setting-homepage'], 'method' => 'POST']) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li><a href="#homepage_links" data-toggle="tab">Homepage Links</a></li>
                            
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{SYSTEM_SETTING_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
                        </ul>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- Custom Tabs (Pulled to the right) -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="homepage_links">
                                    <div class="form-group">
                                        {{Form::label('homepage_link_title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('homepage_link_title', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('homepage_link_description', 'Description',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('homepage_link_description', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('homepage_link', 'Link',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('homepage_link', '', ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
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
                        <!-- /.box-footer -->
                        {!! Form::close() !!}
                        <hr>
                        <div class="box-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($systemSetting))
                                        @foreach($systemSetting as $setting)
                                    <tr>
                                        <td>{{ $setting->title }}</td>
                                        <td>{{ $setting->description }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-app edit" title="Edit Page" href="{{ route("system-setting-homepage.edit",["id"=>$setting->id]) }}"><i class="fa fa-edit"></i> Edit</a></td>
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