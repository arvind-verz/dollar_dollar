@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( ACTIVITY_LOG_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{ACTIVITY_LOG_MODULE}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i>

                        <h3 class="box-title">{{ACTIVITY_LOG_MODULE_SINGLE.'s'}}</h3>

                        <div class=" pull-right">
                            @if($CheckLayoutPermission[0]->delete==1)
                                <a href="{{ route("activity-destroy") }}" class="">
                                    <button type="submit" class="btn btn-danger"><i
                                                class="fa fa-trash"></i> {{CLEAR_ACTION.' '.ACTIVITY_LOG_MODULE_SINGLE}}
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">

                        <table  class="table table-bordered"   id="activities">
                                            <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>IP</th>
                                                <th>Module</th>
                                                <th>Action</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(count($activities) >0)

                                                @foreach($activities as $activity)
                                                    <tr>
                                                        <td>
                                                            {!!   $activity['causer'] !!}
                                                        </td>
                                                        <td>
                                                            {!!   $activity['email'] !!}
                                                        </td>
                                                        <td>
                                                            {!! $activity['ip']   !!}
                                                        </td>
                                                        <td>
                                                            {!! $activity['module']   !!}
                                                        </td>
                                                        <td>
                                                            {!! $activity['action']   !!}
                                                        </td>
                                                        <td>
                                                            {!! $activity['msg']   !!}
                                                        </td>
                                                        <td>
                                                            {!! $activity['date']   !!}
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
