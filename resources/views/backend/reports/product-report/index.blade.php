@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( REPORT_MODULE )}}
            <small>{{REPORT_MODULE_SINGLE}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{PRODUCT_MODULE_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</li>
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

                        <h3 class="box-title">{{PRODUCT_MODULE_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="reports">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Type</th>
                                    <th>Deposit Amount</th>
                                    <th>Privacy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($product_reports))
                                    @foreach($product_reports as $product_report)
                                <tr>
                                    <td><img src="{{ asset($product_report->brand_logo) }}" width="50"> {{ $product_report->title }}</td>
                                    <td>-</td>
                                    <td>{{ $product_report->amount }}</td>
                                    <td>{{ $product_report->privacy }}</td>
                                </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td class="text-center" rows=5>No data found.</td>
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
