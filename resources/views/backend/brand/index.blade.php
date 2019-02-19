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
                        <a class="btn btn-app delete bulk_remove hide" title="Delete Brand"><i class="fa fa-trash"></i> <span class="badge"></span>Delete</a>
                        <div class="form-group col-md-2 bulk_status hide">
                          <span class="badge"></span>
                          <select class="form-control" name="select_type">
                            <option value="">-- Select --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                          </select>
                        </div> 
                        <input type="hidden" name="bulk_remove_type" value="bulk_brand_remove">
                        <input type="hidden" name="bulk_update_type" value="bulk_brand_status_update">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="brands" class="table ">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort"></th>
                                                <th>Action</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Link</th>
                                                <th>Target</th>
                                                <th>Logo</th>
                                                <th>View Order</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($brands->count())
                                                @foreach($brands as $brand)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="bluk_remove[]" value="{{ $brand->id }}">
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
                                                        <td>
                                                            {{ $brand->title }}
                                                        </td>
                                                        <td>
                                                            @if($brand->display==1)
                                                            Active
                                                            @else
                                                            Inactive
                                                            @endif
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
                                                            {!!  date("Y-m-d H:i", strtotime( $brand->created_at))   !!}

                                                        </td>
                                                        <td>@if ($brand->updated_at == null)
                                                                {{$brand->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d H:i", strtotime($brand->updated_at ))   !!}

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
