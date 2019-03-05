@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( REPORT_MODULE )}}
            <small>{{REPORT_MODULE_SINGLE}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{CUSTOMER_DELETION_MODULE_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        {{-- <a href="{{ route('customer-report-excel') }}" class="btn btn-default pull-right">Export Excel</a>--}}
                        <i class="fa fa-file-text" aria-hidden="true"></i>

                        <h3 class="box-title">{{CUSTOMER_DELETION_MODULE_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <a class="btn btn-app delete bulk_remove hide" title="Delete User"><i class="fa fa-trash"></i>
                            <span class="badge"></span>Clear</a>
                        <input type="hidden" name="bulk_remove_type" value="bulk_user_clear_remove">
                        <table class="table table-bordered" id="customer-deletion-report">
                            <thead>
                            <tr>
                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort"></th>
                                <th>User Details</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Status</th>
                                <th>Updated by</th>
                                <th>Updated on</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($users) >0)
                                @foreach($users as $user)
                                    <?php
                                    $updatedBy = $user->updated_by;
                                    if ($user->updated_by == ADMIN_USER) {
                                        $adminUser = \App\Admin::join('role_type', 'role_type.id', '=', 'admins.role_type_id')
                                                ->where('admins.id', $user->updated_by_id)
                                                ->where('admins.delete_status', 0)
                                                ->select('role_type.name')
                                                ->first();
                                        if ($adminUser) {
                                            $updatedBy = $adminUser->name;
                                        } else {
                                            $updatedBy = null;
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="bluk_remove[]" value="{{ $user->id }}">
                                        </td>
                                        <td>
                                            {{$user->first_name.' '.$user->last_name}}
                                        </td>
                                        <td>
                                            {!! $user->email   !!}
                                        </td>
                                        <td>
                                            {!! $user->tel_phone   !!}
                                        </td>
                                        <td>
                                            @if($user->status==1)
                                                Deactivated
                                            @elseif($user->status==2)
                                                Deleted
                                            @endif
                                        </td>
                                        <td>
                                            {{$updatedBy}}
                                        </td>
                                        <td>
                                            @if($user->updated_on==null)
                                                {!! $user->updated_on !!}
                                            @else
                                                {!!  date("Y-m-d H:i", strtotime($user->updated_on))   !!}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
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