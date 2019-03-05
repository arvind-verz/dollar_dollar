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

                        <h3 class="box-title">{{'Contact Enquiries'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a class="btn btn-app delete bulk_remove hide" title="Delete User"><i class="fa fa-trash"></i> <span class="badge"></span>Delete</a>
                        <input type="hidden" name="bulk_remove_type" value="bulk_enquiry_remove">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="contact-table"  class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort"></th>
                                                <th>Action</th>
                                                <th>Full&nbsp;name&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
                                                <th>Email&emsp;&emsp;&emsp;</th>
                                                <th>Contact&nbsp;number&emsp;&emsp;&emsp;</th>
                                                <th>Subject&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
                                                <th>Message&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</th>
                                                <th>Created on</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($contactEnquiries->count())
                                                @foreach($contactEnquiries as $contactEnquiry)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="bluk_remove[]" value="{{ $contactEnquiry->id }}">
                                                        </td>
                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->view==1)
                                                                <a class="btn btn-app view" title="Viw Contact Enquiry"
                                                                   href="{{ route("contact-enquiry.show",["id"=>$contactEnquiry->id]) }}">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete "
                                                                   title="Delete Contact Enquiry"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("contact-enquiry-destroy",["id"=>$contactEnquiry->id]) }}">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {!!   str_replace(' ', '&nbsp;', $contactEnquiry->full_name) !!}
                                                        </td>
                                                        <td>
                                                            {{ $contactEnquiry->email }}
                                                        </td>
                                                        <td>
                                                            {{ $contactEnquiry->country_code.' '.$contactEnquiry->telephone }}
                                                        </td>
                                                        <td>
                                                            {{ $contactEnquiry->subject }}
                                                        </td>
                                                        <td>
                                                            {{ $contactEnquiry->message }}
                                                        </td>
                                                        <td>
                                                            @if ($contactEnquiry->created_at == null)
                                                                {{$contactEnquiry->created_at}}
                                                            @endif
                                                                {!!  date("Y-m-d H:i", strtotime($contactEnquiry->created_at))   !!}

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
