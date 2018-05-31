@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( USER_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{USER_MODULE}}</li>
        </ol>
    </section>

            <!-- Main content -->
    <section class="content">
        @include('backend.admin.permissions.view')

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-user-secret"></i>

                        <h3 class="box-title">{{USER_MODULE_SINGLE.'s'}}</h3>
                        @if($CheckLayoutPermission[0]->create==1)
                            <a href="{{ route("admins.create") }}" class="">
                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.USER_MODULE_SINGLE}}
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

                                        <table id="admins" class="table ">
                                            <thead>
                                            <tr>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($admins->count())

                                                @foreach($admins as $admin)
                                                    <tr>
                                                        <td>
                                                            {!!   $admin->first_name !!}
                                                        </td>
                                                        <td>
                                                            {!! $admin->last_name   !!}
                                                        </td>
                                                        <td>
                                                            {!! $admin->email   !!}
                                                        </td>
                                                        <td>
                                                            {!! $admin->role !!}
                                                        </td>
                                                        <td>
                                                            @if($admin->created_at==null)
                                                                {!! $admin->created_at                                                                                                                                           !!}
                                                            @else
                                                                {!!  date("Y-m-d h:i A", strtotime($admin->created_at))   !!}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($admin->updated_at==null)
                                                                {!! $admin->updated_at !!}
                                                            @else
                                                                {!!  date("Y-m-d h:i A", strtotime($admin->updated_at))   !!}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Brand"
                                                                   href="{{ route("admins.edit",["id"=>$admin->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                    <a class="btn btn-app delete" title="Delete Brand"
                                                                       onclick="return confirm('Are you sure to delete this?')"
                                                                       href="{{ route("admins-destroy",["id"=>$admin->id]) }}">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </a>
                                                            @endif


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
