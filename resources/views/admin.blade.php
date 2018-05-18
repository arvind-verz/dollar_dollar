@extends('backend.layouts.app')

@section('content')
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        @include('backend.inc.messages')
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <i class="fa fa-hand-peace-o"></i>

                    <h3 class="box-title">Welcome</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <h1>
                        <span class="text-info">Hello!</span> {{ ( Auth::user()->first_name.' '.Auth::user()->last_name) }}
                    </h1>
                    <h4>Welcome to the <span class="text-info">Dollar Dollar</span> Administration</h4>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->

    </div>
    <!-- /.row (main row) -->

</section>
<!-- /.content -->
@endsection
