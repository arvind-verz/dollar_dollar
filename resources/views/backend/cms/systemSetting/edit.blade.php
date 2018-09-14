@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( SYSTEM_SETTING_MODULE )}}
            <small>{{SYSTEM_SETTING_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('system-setting.index') }}">{{SYSTEM_SETTING_MODULE_SINGLE}}</a></li>
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
                    {!! Form::open(['class' => 'form-horizontal','url' => ['admin/system-setting', $systemSetting->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li><a href="#contact" data-toggle="tab">Contact</a></li>
                            <li><a href="#email" data-toggle="tab">Email</a></li>
                            <li class="active"><a href="#detail" data-toggle="tab">Basic Detail</a></li>
                            
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{SYSTEM_SETTING_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
                        </ul>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <!-- Custom Tabs (Pulled to the right) -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="detail">

                                    <div class="form-group">
                                        {{Form::label('logo', 'Logo',['class'=>'col-sm-2 control-label'])}}
                                        <div class="@if(isset($systemSetting->logo) && ($systemSetting->logo != ''))col-sm-8 @else col-sm-10 @endif">
                                            {{Form::file('logo', ['class' => 'form-control', 'placeholder' => ''])}}
                                            <p class="text-muted"><strong>Note:</strong> Logo size should be 260*55 for better display</p>
                                        </div>
                                        @if(isset($systemSetting->logo) && ($systemSetting->logo != ''))
                                            <div class=" col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <img class="attachment-img"
                                                         src="{!! asset($systemSetting->logo) !!}"
                                                         alt=" Logo">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('footer', 'Footer',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('footer', $systemSetting->footer, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('contact_us_section', 'Contact Us Now',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('contact_us_section', $systemSetting->contact_us_section, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('offer_section', 'What We Offer',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('offer_section', $systemSetting->offer_section, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('footer3', 'Footer 3',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('offer_section', $systemSetting->footer3, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('footer4', 'Footer 4',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::textarea('offer_section', $systemSetting->footer4, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>

                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="email">


                                    <div class="form-group">
                                        {{Form::label('email_sender_name', 'Email Sender Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('email_sender_name', $systemSetting->email_sender_name, ['class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('admin_email', 'admin',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('admin_email', $systemSetting->admin_email, ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('auto_email', 'Auto Email',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('auto_email', $systemSetting->auto_email, ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                </div>

                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="contact">
                                    <div class="form-group">
                                        {{Form::label('company_name', 'Company Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('company_name', $systemSetting->company_name, ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('contact_phone', 'Contact No',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('contact_phone', $systemSetting->contact_phone, ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('contact_email', 'Contact Email',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('contact_email', $systemSetting->contact_email, ['id' => '', 'class' => 'form-control', 'placeholder' => ''])}}
                                        </div>
                                    </div>
                                    @if(count($systemSetting->contact_addresses))
                                        <?php $i = 1 ?>
                                        @foreach($systemSetting->contact_addresses as $systemSetting->contact_address)
                                            <div class="form-group">
                                                @if($i==1)
                                                    {{Form::label('company_address', 'Company Addresses',['class'=>'col-sm-2 control-label'])}}
                                                @else
                                                    <label class="col-sm-2 control-label"></label>
                                                @endif
                                                <div class="col-sm-10">
                                                    <div class="input-group">
                                                        {{Form::textarea('contact_addresses[]', $systemSetting->contact_address, ['class' => 'form-control plain-text-area ', 'placeholder' => ''])}}
                                                        <span class="input-group-addon btn-info"
                                                              onClick="addMoreTextArea();"
                                                              id=""><i class="fa fa-plus-square"></i></span></div>
                                                </div>
                                            </div>
                                            <?php $i++ ?>
                                        @endforeach
                                    @else
                                        <div class="form-group">
                                            {{Form::label('company_address', 'Company Addresses',['class'=>'col-sm-2 control-label'])}}
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    {{Form::textarea('contact_addresses[]','', ['class' => 'form-control ', 'placeholder' => ''])}}
                                                    <span class="input-group-addon btn-info"
                                                          onClick="addMoreTextArea();"
                                                          id=""><i class="fa fa-plus-square"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                    @endif

                                    <div id="inner"></div>

                                </div>
                            </div>
                            <!-- /.tab-content -->

                        </div>
                        <!-- nav-tabs-custom -->
                        {{Form::hidden('_method','PUT')}}
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