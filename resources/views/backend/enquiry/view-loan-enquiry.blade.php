@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( ENQUIRY_MODULE )}}
            <small>{{ENQUIRY_MODULE.' '.VIEW_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('loan-enquiry.index') }}">{{LOAN_ENQUIRY_MODULE}}</a></li>
            <li class="active">{{LOAN_ENQUIRY_MODULE.' '.VIEW_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-warning ">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li class="pull-left header"><i class="fa fa-edit"></i>
                                {{LOAN_ENQUIRY_MODULE.' '.VIEW_ACTION}}</li>
                        </ul>
                        <!-- /.box-header -->
                        <!-- /.box-header -->
                        <div class="box-body ">
                            
                            <table class="table  table-list-view">
                                @if($enquiry->count())
                                    <tr>
                                        
                                        <th>Full name</th>
                                        <td>
                                            {{ $enquiry->full_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>
                                            {{ $enquiry->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Contact number</th>
                                        <td>
                                            {{ $enquiry->country_code.' '.$enquiry->telephone }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Products</th>
                                        <td>
                                            @if(count($enquiry->product_names))
                                                {{implode(', ',$enquiry->product_names) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rate type</th>
                                        <td>
                                            {{ $enquiry->rate_type }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Property type</th>
                                        <td>
                                            {{ $enquiry->property_type }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Loan amount</th>
                                        <td>
                                            {{ $enquiry->loan_amount }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Loan type</th>
                                        <td>
                                            {{ $enquiry->loan_type }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Existing bank loan</th>
                                        <td>
                                            {{ $enquiry->existing_bank_loan }}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <div class="box-footer">
                        <a href="{{ route('loan-enquiry.index') }}"
                           class="btn btn-default"><i class="fa fa-arrow-left">
                            </i> Back</a>
                    </div>
                    <!-- /.box-footer -->

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

