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

                        <h3 class="box-title">{{INVESTMENT_ENQUIRY_MODULE}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a class="btn btn-app delete bulk_remove hide" title="Delete User"><i class="fa fa-trash"></i> <span class="badge"></span>Delete</a>
                        <input type="hidden" name="bulk_remove_type" value="bulk_life_insurance_remove">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="investment" class="table ">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort"> Delete</th>
                                                <th>Full name</th>
                                                <th>Email</th>
                                                <th>Contact number</th>
                                                <th>1. What type of life insurance are you looking for?</th>
                                                <th>2. What is your gender?</th>
                                                <th>3. What is your date of birth?</th>
                                                <th>4. Are you a smoker?</th>
                                                <th>5. When is the best time to reach you?</th>
                                                <th>Other </th>
                                                <th>Created on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($enquiries->count())
                                                @foreach($enquiries as $enquiry)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="bluk_remove[]" value="{{ $enquiry->id }}">
                                                        </td>
                                                        <td>
                                                            {{ $enquiry->full_name }}
                                                        </td>
                                                        <td>
                                                            {{ $enquiry->email }}
                                                        </td>
                                                        <td>
                                                            {{ $enquiry->country_code.' '.$enquiry->telephone }}
                                                        </td>
                                                        <td>
                                                            @if(isset($enquiry->components))
                                                                {{implode(', ',unserialize($enquiry->components))}}

                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $enquiry->gender }}
                                                        </td><td>
                                                            {{ date("Y-m-d", strtotime($enquiry->dob)) }}
                                                        </td><td>
                                                            {{ $enquiry->smoke }}
                                                        </td>
                                                        <td>
                                                            @if(isset($enquiry->times))
                                                                {{implode(', ',unserialize($enquiry->times))}}

                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $enquiry->other_value }}
                                                        </td>
                                                        <td>
                                                            @if ($enquiry->created_at == null)
                                                                {{$enquiry->created_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($enquiry->created_at))   !!}
                                                        </td>
                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->view==1)
                                                                <a class="btn btn-app view" title="View Enquiry"
                                                                   href="{{ route("investment-enquiry.show",["id"=>$enquiry->id]) }}">
                                                                    <i class="fa fa-eye"></i> View
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete "
                                                                   title="Delete Enquiry"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("investment-enquiry-destroy",["id"=>$enquiry->id]) }}">
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
