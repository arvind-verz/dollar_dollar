@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( ENQUIRY_MODULE )}}
            <small>{{ENQUIRY_MODULE.' '.VIEW_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('life-insurance-enquiry.index') }}">{{LIFE_INSURANCE_ENQUIRY_MODULE}}</a></li>
            <li class="active">{{LIFE_INSURANCE_ENQUIRY_MODULE.' '.VIEW_ACTION}}</li>
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
                                {{LIFE_INSURANCE_ENQUIRY_MODULE.' '.VIEW_ACTION}}</li>
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
                                        <th>1. What components of life insurance are you interested in?</th>
                                        <td>
                                            @if(isset($enquiry->components))
                                                {{implode(', ',unserialize($enquiry->components))}}

                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>2. What is your gender?</th>
                                        <td>
                                            {{ $enquiry->gender }}
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>3. What is your date of birth?</th>
                                        <td>
                                            {{ date("Y-m-d", strtotime($enquiry->dob)) }}
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>4. Are you a smoker?</th>
                                        <td>
                                            {{ $enquiry->smoke }}
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>5. When is the best time to reach you?</th>
                                        <td>
                                            @if(isset($enquiry->times))
                                                {{implode(', ',unserialize($enquiry->times))}}

                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>Other</th>
                                        <td>
                                            {{ $enquiry->other_value }}
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <div class="box-footer">
                        <a href="{{ route('life-insurance-enquiry.index') }}"
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

