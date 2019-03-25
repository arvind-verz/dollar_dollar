@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( EMAIL_TEMPLATE_MODULE )}}
            <small>{{EMAIL_TEMPLATE_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('email-template.index') }}">{{EMAIL_TEMPLATE_MODULE}}</a></li>
            <li class="active">{{EMAIL_TEMPLATE_MODULE_SINGLE.' '.ADD_ACTION}}</li>
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

                        <h3 class="box-title">{{EMAIL_TEMPLATE_MODULE_SINGLE.' '.ADD_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => 'admin/email-template/store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name"
                                       class="control-label col-sm-2">Title
                                </label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="email_template">
                                        <option value="">-Select Template Name-</option>
                                        @foreach($emailTemplates as $emailTemplate)
                                            <option value="{{ $emailTemplate->id }}">{{$emailTemplate->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('email_subject', 'Subject',['class'=>' control-label col-sm-2'])}}
                                <div class="col-sm-10">
                                    {{Form::text('email_subject', old('email_subject'), ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=' control-label col-sm-2' for="contents">Contents :</label>

                                <div class="col-sm-10">
                                <textarea class="email-editor form-control" rows="5" id="contents"
                                          name="contents">{{ old('contents') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2 control-label">
                                    <label>Status</label>
                                </div>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("email-template.index")}}"
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
