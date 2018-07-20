@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( BRAND_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{BRAND_MODULE}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-pie-chart"></i>

                        <h3 class="box-title">{{BRAND_MODULE_SINGLE.'s'}}</h3>
                        @if($CheckLayoutPermission[0]->create==1)
                            <a href="{{ route("brand.create") }}" class="">
                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.BRAND_MODULE_SINGLE}}
                                </button>
                            </a>
                        @endif


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="brands" class="table ">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Link</th>
                                                <th>Target</th>
                                                <th>Logo</th>
                                                <th>View Order</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($brands->count())
                                                @foreach($brands as $brand)
                                                    <tr>
                                                        <td>
                                                            {{ $brand->title }}
                                                        </td>
                                                        <td>
                                                            {!! $brand->brand_link   !!}
                                                        </td>
                                                        <td>
                                                            {!! $brand->target   !!}
                                                        </td>
                                                        <td>
                                                            <div class="attachment-block clearfix">
                                                                <img class="attachment-img"
                                                                     src="{!! asset($brand->brand_logo) !!}"
                                                                     alt="Brand Image">
                                                            </div>

                                                        </td>
                                                        <td>
                                                            {!! $brand->view_order   !!}
                                                        </td>
                                                        <td>
                                                            @if ($brand->created_at == null)
                                                                {{$brand->created_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime( $brand->created_at))   !!}

                                                        </td>
                                                        <td>@if ($brand->updated_at == null)
                                                                {{$brand->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($brand->updated_at ))   !!}

                                                        </td>
                                                        <td class="text-center">

                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Brand"
                                                                   href="{{ route("brand.edit",["id"=>$brand->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete" title="Delete Brand"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("brand-destroy",["id"=>$brand->id]) }}">
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
