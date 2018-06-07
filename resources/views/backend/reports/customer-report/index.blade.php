@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( REPORT_MODULE )}}
            <small>{{REPORT_MODULE_SINGLE}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
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
                        <i class="fa fa-file-text" aria-hidden="true"></i>

                        <h3 class="box-title">{{CUSTOMER_MODULE_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="report">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Bank Name</th>
                                    <th>Account Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Deposit Amount</th>
                                    <th>Privacy</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($customer_reports))
                                    @foreach($customer_reports as $customer_report)
                                <tr>
                                    <td>{{ ucfirst($customer_report->first_name) . ' ' . ucfirst($customer_report->last_name) }}</td>
                                    <td><img src="{{ asset($customer_report->brand_logo) }}" width="50"> {{ $customer_report->title }}</td>
                                    <td>{{ ucwords($customer_report->account_name) }}</td>
                                    <td>{{ $customer_report->email }}</td>
                                    <td>{{ $customer_report->tel_phone }}</td>
                                    <td>{{ $customer_report->amount }}</td>
                                    <td>{{ $customer_report->privacy }}</td>
                                    <td> @if($customer_report->status==1)
                                            Active
                                        @else
                                            Inactive
                                        @endif</td>
                                </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td class="text-center" rows=8>No data found.</td>
                                </tr>
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
