@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( PRODUCT_MODULE )}}
            <small>{{$productType}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{$productType}}</li>
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

                        <h3 class="box-title">{{$productType}}</h3>
                        @if($productTypeId==LOAN)
                        <select name="filter_category" class="form-control"
                                style="width: 10em;float: right;margin-right: 10px;">
                            <option value="">-- Select --</option>
                            <option value="">
                                All
                            </option>
                            @php $rate_type = []; @endphp
                            @if($products->count())
                                @foreach($products as $product)
                                <?php
                                $productRange = null;
                                if ($product->product_range) {
                                    $range = \GuzzleHttp\json_decode($product->product_range);
                                    if (count($range)) {
                                        $productRange = $range[0];
                                    }
                                }
                                if($productTypeId==LOAN)
                                {
                                    if($productRange)
                                    {
                                        $rate_type[] = $productRange->rate_type;
                                    }
                                }

                                ?>
                                @endforeach
                                @foreach(array_unique($rate_type) as $value)
                                    <option>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                            <a href="{{ route('rate-type.index') }}"
                               class="btn btn-info pull-right mr-10"><i class="fa fa-gear"></i>
                                Rate Types
                            </a>
                        @endif
                        @if($productTypeId==ALL_IN_ONE_ACCOUNT || $productTypeId==LOAN)
                            <a href="{{ route('tool-tip',['productTypeId'=>$productTypeId]) }}"
                               class="btn btn-info pull-right mr-10"><i class="fa fa-gear"></i>
                                @if($toolTips)Edit Tool Tips @else  Add Tool Tips @endif
                            </a>
                        @endif
                        <a href="{{ route('default-search',['productTypeId'=>$productTypeId]) }}"
                           class="btn btn-info pull-right mr-10"><i class="fa fa-gear"></i>
                            @if($defaultSearch)Edit Default Search Values @else  Add Default Search Values @endif
                        </a>
                        <a href="{{ route('promotion-products-add',['productTypeId'=>$productTypeId]) }}"
                           class="btn btn-info pull-right mr-10 "><i
                                    class="fa fa-plus"></i> Add New Products</a>


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a class="btn btn-app delete bulk_remove hide" title="Delete User"><i class="fa fa-trash"></i>
                            <span class="badge"></span>Delete</a>

                        <div class="form-group col-md-2 bulk_status hide">
                            <span class="badge"></span>
                            <select class="form-control" name="select_type">
                                <option value="">-- Select --</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <input type="hidden" name="bulk_remove_type" value="bulk_product_remove">
                        <input type="hidden" name="bulk_update_type" value="bulk_product_status_update">
                        <table style="table-layout: fixed; width: 100%;" id="example">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="products" class="table ">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort">
                                                </th>
                                                <th>Action</th>
                                                <th>Product Name</th>
                                                <th>Bank Name</th>
                                                @if($productTypeId==LOAN)
                                                    <th>Rate Type</th>
                                                    <th>Property Type</th>
                                                @else
                                                    <th>Product Type</th>
                                                    <th>Formula Name</th>
                                                @endif
                                                <th>Featured</th>
                                                <th>Status</th>
                                                <th>@if($productTypeId==ALL_IN_ONE_ACCOUNT)Created on
                                                    @elseif($productTypeId==LOAN)
                                                        Completion Status
                                                    @else
                                                        Expiry @endif</th>
                                                <th>Updated on</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $i = 1; ?>
                                            @if($products->count())
                                                @foreach($products as $product)
                                                    <?php
                                                    $productRange = null;
                                                    if ($product->product_range) {
                                                        $range = \GuzzleHttp\json_decode($product->product_range);
                                                        if (count($range)) {
                                                            $productRange = $range[0];
                                                        }
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="bluk_remove[]"
                                                                   value="{{ $product->id }}">
                                                        </td>
                                                        <td>
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Product"
                                                                   href="{{ route("promotion-products-edit",["id"=>$product->id,'product_type_id'=>$productTypeId]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete" title="Delete Product"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("promotion-products-remove",["id"=>$product->id,'product_type_id'=>$productTypeId]) }}">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </a>
                                                            @endif

                                                        </td>
                                                        <td>{{ $product->product_name }}</td>
                                                        <td>{{ $product->bank_name }}</td>
                                                        @if($productTypeId==LOAN)
                                                            <td>@if($productRange) {{$productRange->rate_type}} @endif</td>
                                                            <td>@if($productRange) {{$productRange->property_type}} @endif</td>
                                                        @else
                                                            <td>{{ $product->promotion_type }}</td>
                                                            <td>{{ $product->promotion_formula }}</td>
                                                        @endif
                                                        <td>@if ($product->featured == 1)
                                                                Yes
                                                            @else
                                                                No
                                                            @endif
                                                        </td>
                                                        <td>@if ($product->status == 1)
                                                                Active
                                                            @else
                                                                Inactive
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($productTypeId==ALL_IN_ONE_ACCOUNT)
                                                                @if ($product->created_at == null)
                                                                    {{$product->created_at}}
                                                                @endif
                                                                {!!  date("Y-m-d H:i", strtotime($product->created_at))   !!}
                                                            @elseif($productTypeId==LOAN)
                                                                @if ($productRange)
                                                                    {{$productRange->completion_status}}
                                                                @endif
                                                            @else
                                                                @if ($product->promotion_period == ONGOING)
                                                                    {{ONGOING}}
                                                                @else
                                                                    <?php
                                                                    $todayDate = \Carbon\Carbon::today();
                                                                    $untilEndDate = null;
                                                                    if (!is_null($product->until_end_date)) {
                                                                        $untilEndDate = \Helper::convertToCarbonEndDate($product->until_end_date);
                                                                    }
                                                                    ?>

                                                                    @if ($untilEndDate != null && $untilEndDate > $todayDate) {!!  date("Y-m-d", strtotime($product->until_end_date))   !!} @else {{EXPIRED}}  @endif
                                                                @endif
                                                            @endif


                                                        </td>
                                                        <td>@if ($product->updated_at == null)
                                                                {{$product->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d H:i", strtotime($product->updated_at))   !!}
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
<script type="text/javascript">
$(document).ready(function() {

    
});

</script>
@endsection
