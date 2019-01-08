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
                        <table class="table table-bordered" id="customer-deletion-report">
                            <thead>
                                <tr>
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
                                    <tr>
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
                                            @if($user->delete_status==1)
                                                Deleted
                                            @elseif($user->status==0)
                                                Deactivated
                                            @endif
                                        </td>
                                        <td>
                                            {{$user->updated_by}}
                                        </td>
                                        <td>
                                            @if($user->updated_at==null)
                                                {!! $user->updated_at !!}
                                            @else
                                                {!!  date("Y-m-d h:i A", strtotime($user->updated_at))   !!}
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
