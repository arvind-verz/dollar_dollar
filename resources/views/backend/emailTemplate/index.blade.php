@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( EMAIL_TEMPLATE_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{EMAIL_TEMPLATE_MODULE}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-envelope"></i>

                        <h3 class="box-title">{{EMAIL_TEMPLATE_MODULE.'s'}}</h3>
                        @if($CheckLayoutPermission[0]->create==1)
                            <a href="{{ route("email-template.create") }}" class="">
                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.EMAIL_TEMPLATE_MODULE_SINGLE}}
                                </button>
                            </a>
                        @endif


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="email-templates" class="table ">
                                            <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Email Template</th>
                                                <th>Status</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($emailTemplates->count())
                                                @foreach($emailTemplates as $emailTemplate)
                                                    <tr>
                                                        <td class="text-center">

                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Email Template"
                                                                   href="{{ route("email-template.edit",["id"=>$emailTemplate->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                           {{-- @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete" title="Delete Brand"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("brand-destroy",["id"=>$emailTemplate->id]) }}">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </a>
                                                            @endif--}}


                                                        </td>
                                                        <td>
                                                            {{$emailTemplate->title}}
                                                        </td>
                                                        <td>
                                                            @if($emailTemplate->status==1)
                                                                Active
                                                            @else
                                                                Deactivate
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($emailTemplate->created_at == null)
                                                                {{$emailTemplate->created_at}}
                                                            @endif
                                                            {!!  date("Y-m-d H:i", strtotime($emailTemplate->created_at))   !!}

                                                        </td>
                                                        <td>@if ($emailTemplate->updated_at == null)
                                                                {{$emailTemplate->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d H:i", strtotime($emailTemplate->updated_at))   !!}

                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>


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
