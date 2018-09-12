@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( CUSTOMER_MODULE )}}
            <small>{{CUSTOMER_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('users.index') }}">{{CUSTOMER_MODULE_SINGLE}}</a></li>
            <li class="active">{{CUSTOMER_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
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

                        <h3 class="box-title">{{CUSTOMER_MODULE_SINGLE.' '.EDIT_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => ['admin/users', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Salutation</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="" name="salutation"
                                            style="width: 100%;">
                                        <option value={{MR}}
                                                @if($user->salutation == MR) selected="selected" @endif>
                                            {{MR}}
                                        </option>
                                        <option value={{MRS}}
                                        @if($user->salutation == MRS) selected="selected" @endif>
                                            {{MRS}}
                                        </option>
                                        <option value={{MISS}}
                                        @if($user->salutation == MISS) selected="selected" @endif>
                                            {{MISS}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('first_name', 'First Name',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('last_name', 'Last Name',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('email', 'Email',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('password', 'Password',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('password', '', ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('password_confirmation', 'Confirm Password',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('password_confirmation', '', ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('tel_phone', 'Contact Number',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('tel_phone', $user->tel_phone, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Status</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="" name="status"
                                            style="width: 100%;">
                                        <option value="1"
                                                @if($user->status == 1) selected="selected" @endif>
                                            Active
                                        </option>
                                        <option value="0"
                                                @if($user->status == 0) selected="selected" @endif>
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Newsletter</label>

                                <div class="col-sm-10">

                                    <input type="checkbox" value="1" name="email_notification" @if($user->email_notification==1) checked @endif>
                                        
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Consent to have marketing information</label>

                                <div class="col-sm-10">

                                        <input type="checkbox" value="1" name="adviser" @if($user->adviser==1) checked @endif>
                                            
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        {{Form::hidden('_method','PUT')}}
                        <div class="box-footer">
                            <a href="{{route("users.index")}}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i> Update
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
