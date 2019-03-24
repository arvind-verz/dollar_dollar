@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( REPORT_MODULE )}}
            <small>{{REPORT_MODULE_SINGLE}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{CUSTOMER_UPDATE_DETAIL_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</li>
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

                        <h3 class="box-title">{{CUSTOMER_UPDATE_DETAIL_SINGLE . ' ' . REPORT_MODULE_SINGLE}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <a class="btn btn-app delete bulk_remove hide" title="Delete User"><i class="fa fa-trash"></i>
                            <span class="badge"></span>Clear</a>
                        <input type="hidden" name="bulk_remove_type" value="bulk_customer_update_detail_clear_remove">
                        <table class="table table-bordered" id="customer-update-detail-report">
                            <thead>
                            <tr>
                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort"></th>
                                <th>User&nbsp;Name</th>
                                <th>Old&nbsp;Detail</th>
                                <th>Update&nbsp;Detail</th>
                                <th>Updated&nbsp;By</th>
                                <th>Updated&nbsp;on</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($customerUpdateDetails) >0)
                                @foreach($customerUpdateDetails as $customerUpdateDetail)

                                    <tr>

                                        <td>
                                            <input type="checkbox" name="bluk_remove[]"
                                                   value="{{ $customerUpdateDetail->id }}">
                                        </td>
                                        <td>
                                            {{$customerUpdateDetail->first_name}} {{$customerUpdateDetail->last_name}}
                                        </td>
                                        <td>
                                            @if(!empty($customerUpdateDetail->old_detail))
                                                <?php
                                                $oldDetail = (array)\GuzzleHttp\json_decode($customerUpdateDetail->old_detail);
                                                ?>
                                                @foreach($oldDetail as $k => $v)
                                                    @if(in_array($k,['email_notification','adviser']))
                                                        @if($v==1)
                                                            {{ucfirst(str_replace('_',' ',$k))}} : Active<br/>
                                                        @else
                                                            {{ucfirst(str_replace('_',' ',$k))}} : Inactive<br/>
                                                        @endif
                                                    @else
                                                        {{ucfirst(str_replace('_',' ',$k))}} : {{$v}} <br/>
                                                    @endif

                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($customerUpdateDetail->updated_detail))
                                                <?php
                                                $updatedDetail = (array)\GuzzleHttp\json_decode($customerUpdateDetail->updated_detail);
                                                ?>
                                                @foreach($updatedDetail as $k => $v)
                                                    @if(in_array($k,['email_notification','adviser']))
                                                        @if($v==1)
                                                            {{ucfirst(str_replace('_',' ',$k))}} : Active<br/>
                                                        @else
                                                            {{ucfirst(str_replace('_',' ',$k))}} : Inactive<br/>
                                                        @endif
                                                    @else
                                                        {{ucfirst(str_replace('_',' ',$k))}} : {{$v}} <br/>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </td>
                                        <td>
                                            {!! $customerUpdateDetail->updated_by   !!}
                                        </td>

                                        <td>
                                            @if (!is_null($customerUpdateDetail->created_at))
                                                {!!  date("Y-m-d H:i:s", strtotime($customerUpdateDetail->created_at))   !!}
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