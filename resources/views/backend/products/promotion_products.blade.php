@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( PRODUCT_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{PRODUCT_MODULE}}</li>
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

                        <h3 class="box-title">{{'Product List'}}</h3>


                        <a href="{{ route('promotion-products-add') }}" class="btn btn-info pull-right"><i
                                    class="fa fa-plus"></i> Add New Products</a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="products" class="table ">
                                            <thead>
                                            <tr>

                                                <th>Product Name</th>
                                                <th>Bank Name</th>
                                                <th>Product Type </th>
                                                <th>Formula Name </th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @if($products->count())
                                                @foreach($products as $product)
                                                    <tr>

                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->bank_name }}</td>
                                                        <td>{{ $product->promotion_type }}</td>
                                                        <td>{{ $product->promotion_formula }}</td>
                                                        <td>@if ($product->created_at == null)
                                                                {{$product->created_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($product->created_at))   !!}
                                                        </td>
                                                        <td>@if ($product->updated_at == null)
                                                                {{$product->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($product->updated_at))   !!}
                                                        </td>

                                                        <td>
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                {{--<a class="btn btn-app edit" title="Edit Product"
                                                                   href="{{ route("promotion-products-edit",["id"=>$product->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>--}}
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                               {{-- <a class="btn btn-app delete" title="Delete Product"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("promotion-products-remove",["id"=>$product->id]) }}">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </a>--}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">No data found.</td>
                                                </tr>
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
