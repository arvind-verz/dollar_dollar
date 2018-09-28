@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( REPORT_MODULE )}}
            <small>{{REPORT_MODULE_SINGLE}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{CUSTOMER_MODULE_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</li>
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

                        <h3 class="box-title">{{CUSTOMER_MODULE_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="customer-report">
                            <thead>
                                <tr>
                                    <th style="display: none">User Details</th>
                                    <th>User Details</th>
                                    <th>Consent</th>
                                    <th>Bank Name</th>
                                    <th>Account Name</th>
                                    <th>Deposit Amount</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($customer_reports_groups))
                                    @foreach($customer_reports_groups as $customer_reports_group)
                                    @php
                                        $crs = $customer_reports->where('users_id', $customer_reports_group->users_id);
                                    @endphp
                                <tr>
                                    <td style="display: none">{{ ucfirst($customer_reports_group->first_name) . ' ' . ucfirst($customer_reports_group->last_name) }}<br/>{{ $customer_reports_group->email }}<br/>{{ $customer_reports_group->country_code . $customer_reports_group->tel_phone }}</td>
                                    <td >{{ ucfirst($customer_reports_group->first_name) . ' ' . ucfirst($customer_reports_group->last_name) }}<br/>{{ $customer_reports_group->email }}<br/>{{ $customer_reports_group->country_code . $customer_reports_group->tel_phone }}</td>
                                    <td >@if($customer_reports_group->adviser==1) Yes @else No @endif</td>
                                    {{ Helper::getCustomerReportData($customer_reports_group->users_id) }}
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
