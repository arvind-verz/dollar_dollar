@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( RATE_TYPE_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a
                        href="{{ route('promotion-products',['productTypeId'=>LOAN]) }}">{{LOAN_MODULE}}</a>
            </li>
            @if(isset($id))
                <li class=""><a href="{{ route('rate-type.index') }}">{{RATE_TYPE_MODULE}}</a></li>
                <?php
                $breadcums = Helper::getBreadCumsCategoryByMenus($id);
                $breadCumsCount = count($breadcums) - 1;
                ?>
                @for($i=0; $i<=$breadCumsCount;$i++)
                    @if($i==$breadCumsCount)
                        <li class="active">{{$breadcums[$i]['title']}}</li>
                    @else
                        <li><a
                                    href="{{ route("getSubMenus",["id"=>$breadcums[$i]['id']]) }}"> {{$breadcums[$i]['title']}}</a>
                        </li>

                    @endif
                @endfor
            @else
                <li class="active">{{RATE_TYPE_MODULE}}</li>
            @endif
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-bars"></i>

                        <h3 class="box-title">{{RATE_TYPE_MODULE_SINGLE.'s'}}</h3>
                        @if($CheckLayoutPermission[0]->create==1)
                            <a href=" {{ route("rate-type.create") }}" class="">
                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.RATE_TYPE_MODULE_SINGLE}}
                                </button>
                            </a>
                        @endif


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{--<a class="btn btn-app delete bulk_remove hide" title="Delete Tags"><i class="fa fa-trash"></i>
                            <span class="badge"></span>Delete</a>

                        <div class="form-group col-md-2 bulk_status hide">
                            <span class="badge"></span>
                            <select class="form-control" name="select_type">
                                <option value="">-- Select --</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <input type="hidden" name="bulk_remove_type" value="bulk_rate_type_remove">
                        <input type="hidden" name="bulk_update_type" value="bulk_rate_type_status_update">--}}
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="rate-types" class="table">
                                            <thead>
                                            <tr>
                                               {{-- <th><input type="checkbox" name="all_bulk_remove" class="no-sort">
                                                    Delete/Update
                                                </th>--}}
                                                <th>Name</th>
                                                <th>Interest Rate</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($rateTypes->count())
                                                @foreach($rateTypes as $rateType)
                                                    <tr>
                                                        {{--<td>
                                                            <input type="checkbox" name="bluk_remove[]"
                                                                   value="{{ $rateType->id }}">
                                                        </td>--}}

                                                        <td>
                                                            {{ $rateType->name }}
                                                        </td>
                                                        <td>
                                                            {{$rateType->interest_rate}}%
                                                        </td>
                                                        <td>
                                                            @if (!empty($rateType->created_at))
                                                                {!!  date("Y-m-d h:i A", strtotime($rateType->created_at))   !!}
                                                            @endif


                                                        </td>
                                                        <td>@if (!empty($rateType->updated_at ))
                                                                {!!  date("Y-m-d h:i A", strtotime($rateType->updated_at))   !!}
                                                            @endif

                                                        </td>
                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Rate Type"
                                                                   href="{{ route("rate-type.edit",["id"=>$rateType->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete @if(($rateType->is_blog == 1 || $rateType->is_dynamic == 1)) disabled @endif"
                                                                   title="Delete Rate Type"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("rate-type-destroy",["id"=>$rateType->id]) }}">
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
