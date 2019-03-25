@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( EMAIL_TEMPLATE_MODULE )}}
            <small>{{EMAIL_TEMPLATE_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('email-template.index') }}">{{EMAIL_TEMPLATE_MODULE}}</a></li>
            <li class="active">{{EMAIL_TEMPLATE_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
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

                        <h3 class="box-title">{{EMAIL_TEMPLATE_MODULE_SINGLE.' '.EDIT_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => ['admin/email-template/update', $emailTemplate->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('title', $emailTemplate->title, ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('email_subject', 'Subject',['class'=>' control-label col-sm-2'])}}
                                <div class="col-sm-10">
                                    {{Form::text('email_subject', $emailTemplate->subject, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=' control-label col-sm-2' for="contents">Contents :</label>

                                <div class="col-sm-10">
                                <textarea class="email-editor form-control" rows="5" id="contents"
                                          name="contents">{{  $emailTemplate->contents }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Status</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2 "
                                            @if(($emailTemplate->is_index == 1)) disabled="disabled" @endif
                                            data-placeholder="" name="status"
                                            style="width: 100%;">
                                        <option value="1" @if($emailTemplate->status == 1) selected="selected" @endif>
                                            Active
                                        </option>
                                        <option value="0" @if($emailTemplate->status == 0) selected="selected" @endif>
                                            Deactivate
                                        </option>
                                    </select>
                                </div>
                            </div>

                            {{Form::hidden('_method','PUT')}}

                            <div class="form-group">
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("email-template.index")}}"
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
@endsection