@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( CUSTOMER_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{CUSTOMER_MODULE}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i>

                        <h3 class="box-title">{{CUSTOMER_MODULE_SINGLE.'s'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a class="btn btn-app delete bulk_remove hide" title="Delete User"><i class="fa fa-trash"></i> <span class="badge"></span>Delete</a>
                        <input type="hidden" name="bulk_remove_type" value="bulk_customer_remove">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="users" class="table ">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort"></th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Contact Number</th>
                                                <th>Status</th>
                                                <th>Created on</th>
                                                <th>Updated on by user</th>
                                                <th>Updated on by admin</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($users) >0)

                                                @foreach($users as $user)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="bluk_remove[]" value="{{ $user->id }}">
                                                        </td>
                                                        <td>
                                                            {!!   $user->first_name !!}
                                                        </td>
                                                        <td>
                                                            {!! $user->last_name   !!}
                                                        </td>
                                                        <td>
                                                            {!! $user->email   !!}
                                                        </td>
                                                        <td>
                                                            {!! $user->tel_phone   !!}
                                                        </td>
                                                        <td>
                                                            @if($user->status==true)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($user->created_at==null)
                                                                {!! $user->created_at !!}
                                                            @else
                                                                {!!  date("Y-m-d h:i A", strtotime($user->created_at))   !!}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($user->updated_at_user==null)
                                                                {!! $user->updated_at_user !!}
                                                            @else
                                                                {!!  date("Y-m-d h:i A", strtotime($user->updated_at_user))   !!}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($user->updated_at_admin==null)
                                                                {!! $user->updated_at_admin !!}
                                                            @else
                                                                {!!  date("Y-m-d h:i A", strtotime($user->updated_at_admin))   !!}
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <!-- @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app view" title="Product View" href="{{ route("product-view", ["id"=>$user->id]) }}">
                                                                    <i class="fa fa-eye" aria-hidden="true"></i> Product View
                                                                </a>
                                                            @endif -->
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit User"
                                                                   href="{{ route("users.edit",["id"=>$user->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif
                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete" title="Delete User"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("user-destroy",["id"=>$user->id]) }}">
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

