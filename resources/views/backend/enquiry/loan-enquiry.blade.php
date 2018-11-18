@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( ENQUIRY_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{ENQUIRY_MODULE}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages') 
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-book"></i>

                        <h3 class="box-title">{{'Loan Enquiries'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a class="btn btn-app delete bulk_remove hide" title="Delete User"><i class="fa fa-trash"></i> <span class="badge"></span>Delete</a>
                        <input type="hidden" name="bulk_remove_type" value="bulk_enquiry_remove">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="loan-table"  class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort"> Delete</th>
                                                <th>Full&nbsp;name&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
                                                <th>Email&emsp;&emsp;&emsp;</th>
                                                <th>Contact&nbsp;number&emsp;&emsp;&emsp;</th>
                                                <th>Rate type&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
                                                <th>Property type&emsp;&emsp;</th>
                                                <th>Loan amount&emsp;&emsp;</th>
                                                <th>Loan type&emsp;&emsp;</th>
                                                <th>Created on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($loanEnquiries->count())
                                                @foreach($loanEnquiries as $loanEnquiry)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="bluk_remove[]" value="{{ $loanEnquiry->id }}">
                                                        </td>
                                                        <td>
                                                            {!!   str_replace(' ', '&nbsp;', $loanEnquiry->full_name) !!}
                                                        </td>
                                                        <td>
                                                            {{ $loanEnquiry->email }}
                                                        </td>
                                                        <td>
                                                            {{ $loanEnquiry->country_code.' '.$loanEnquiry->telephone }}
                                                        </td>
                                                        <td>
                                                            {{ $loanEnquiry->rate_type }}
                                                        </td>
                                                        <td>
                                                            {{ $loanEnquiry->property_type }}
                                                        </td>
                                                        <td>
                                                            {{ $loanEnquiry->loan_amount }}
                                                        </td>
                                                        <td>
                                                            {{ $loanEnquiry->loan_type }}
                                                        </td>
                                                        <td>
                                                            @if ($loanEnquiry->created_at == null)
                                                                {{$loanEnquiry->created_at}}
                                                            @endif
                                                                {!!  date("Y-m-d h:i A", strtotime($loanEnquiry->created_at))   !!}

                                                        </td>
                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->view==1)
                                                                <a class="btn btn-app view" title="Viw Contact Enquiry"
                                                                   href="{{ route("loan-enquiry.show",["id"=>$loanEnquiry->id]) }}">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete "
                                                                   title="Delete Contact Enquiry"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("loan-enquiry-destroy",["id"=>$loanEnquiry->id]) }}">
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
    <style type="text/css">
        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
            line-height: 1 !important; /*Chrome- removes extra blank page at the bottom*/
        }
    </style>
@endsection
