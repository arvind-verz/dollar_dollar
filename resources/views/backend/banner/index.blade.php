@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( BANNER_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{BANNER_MODULE}}</li>
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

                        <h3 class="box-title">{{BANNER_MODULE_SINGLE.'s'}}</h3>
                        @if($CheckLayoutPermission[0]->create==1)
                            <a href="{{ route("banner.create") }}" class="">
                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.BANNER_MODULE_SINGLE}}
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

                                        <table id="banners" class="table ">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Content</th>
                                                <th>Page</th>
                                                <th>Target</th>
                                                <th>Image</th>
                                                <th>View Order</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($banners->count())
                                                @foreach($banners as $banner)
                                                    <tr>
                                                        <td>
                                                            {!!   strip_tags($banner->title) !!}
                                                        </td>
                                                        <td>
                                                            {!! strip_tags($banner->banner_content)   !!}
                                                        </td>
                                                        <td>
                                                            {!! $banner->label  !!}
                                                        </td>
                                                        <td>
                                                            {!! $banner->target   !!}
                                                        </td>
                                                        <td>
                                                            <div class="attachment-block clearfix">
                                                                <img class="attachment-img"
                                                                     src="{!! asset($banner->banner_image) !!}"
                                                                     alt="Banner Image">
                                                            </div>

                                                        </td>
                                                        <td>
                                                            {!! $banner->view_order   !!}
                                                        </td>
                                                        <td>
                                                            @if ($banner->created_at == null)
                                                                {{$banner->created_at}}
                                                            @endif
                                                                {!!  date("Y-m-d h:i A", strtotime($banner->created_at))   !!}

                                                        </td>
                                                        <td>@if ($banner->updated_at == null)
                                                                {{$banner->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($banner->updated_at))   !!}

                                                        </td>
                                                        <td class="text-center">

                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Banner"
                                                                   href="{{ route("banner.edit",["id"=>$banner->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                    <a class="btn btn-app delete" title="Delete Banner"
                                                                       onclick="return confirm('Are you sure to delete this?')"
                                                                       href="{{ route("banner-destroy",["id"=>$banner->id]) }}">
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
