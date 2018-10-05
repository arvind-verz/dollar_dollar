@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( ENQUIRY_MODULE )}}
            <small>{{ENQUIRY_MODULE.' '.VIEW_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('investment-enquiry.index') }}">{{INVESTMENT_ENQUIRY_MODULE}}</a></li>
            <li class="active">{{INVESTMENT_ENQUIRY_MODULE.' '.VIEW_ACTION}}</li>
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
                                {{INVESTMENT_ENQUIRY_MODULE.' '.VIEW_ACTION}}</li>
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
                                        <th>1. What is current your financial goal?</th>
                                        <td>
                                            @if(isset($enquiry->goals))
                                                {{implode(', ',unserialize($enquiry->goals))}}

                                            @endif
                                        </td>

                                    </tr>
                                    @if(isset($enquiry->goal_other_value))
                                        <tr>
                                            <th>Other</th>
                                            <td>
                                                {{ $enquiry->goal_other_value }}
                                            </td>

                                        </tr>
                                    @endif
                                    <tr>
                                        <th>2. Do you have any experience in investment?</th>
                                        <td>
                                            {{ $enquiry->experience }}
                                        </td>

                                    </tr>
                                    @if(isset($enquiry->experience_detail))
                                        <tr>
                                            <th>Experience detail</th>
                                            <td>
                                                {{ $enquiry->experience_detail }}
                                            </td>

                                        </tr>
                                    @endif
                                    <tr>
                                        <th>3. Which Risk Profile do you fall into?</th>
                                        <td>
                                            @if(isset($enquiry->risks))
                                                {{implode(', ',unserialize($enquiry->risks))}}

                                            @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>4. What is your age?</th>
                                        <td>
                                            {{ $enquiry->age }}
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
                                    @if(isset($enquiry->other_value))
                                        <tr>
                                            <th>Other</th>
                                            <td>
                                                {{ $enquiry->other_value }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                    <div class="box-footer">
                        <a href="{{ route('investment-enquiry.index') }}"
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

