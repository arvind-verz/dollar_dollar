@extends('frontend.layouts.app')
@section('content')
        <!-- Content Containers -->
<div class="main-container">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><strong>Order History</strong></li>
            </ul>
        </div>
    </div>
    <div class="fullcontainer">
        <div class="container">
            <div class="inner-container md">
                <div class="title3">Order History</div>
                @if($orderDetails->count())
                    {!! Form::open(['url' => ['search-order'], 'method' => 'POST' ]) !!}

                    <div class="search-toolbar">
                        <div class="toolbar-control-holder tool-date-holder">
                            <label>Order Date <span>(From)</span></label>

                            <div class="toolbar-control">
                                <div class="input-group date" id="order-start-date">
                                    <input type="text" name="order_start_date"
                                           value="@if(isset($inputs['order_start_date'])){{$inputs['order_start_date']}} @endif"
                                           class="form-control">
                                    <span class="input-group-addon"> <span class="jcon-calendar"></span></span>
                                    <script>$(function () {
                                            $("#order-start-date").datetimepicker({format: "DD-MM-YYYY"});
                                        });</script>
                                </div>
                            </div>
                            <label>To</label>

                            <div class="toolbar-control">
                                <div class="input-group date" id="order-end-date">
                                    <input type="text" name="order_end_date"
                                           value="@if(isset($inputs['order_end_date'])){{$inputs['order_end_date']}} @endif"
                                           class="form-control">
                                    <span class="input-group-addon"> <span class="jcon-calendar"></span></span>
                                    <script>$(function () {
                                            $("#order-end-date").datetimepicker({format: "DD-MM-YYYY"});
                                        });</script>
                                </div>
                            </div>
                        </div>
                        <div class="toolbar-control-holder tool-product-title">
                            <label>Product Title</label>

                            <div class="toolbar-control">
                                <input type="text" name="description"
                                       value="@if(isset($inputs['description'])){{$inputs['description']}} @endif"
                                       class="form-control">
                            </div>
                        </div>
                        <div class="toolbar-action">
                            <button type="submit" class="button">Search</button>
                        </div>
                        {!! Form::close() !!}

                    </div>

                    <div class="cart-content">
                        <div class="cart-grid">
                            <div class="scroll-container">
                                <table border="0" align="center" cellpadding="0" cellspacing="0" class="scrl-tbl">
                                    <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Order Number</th>
                                        <th>Product title</th>
                                        <th>Ordered on</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Self Collection</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($orderDetails as $orderDetail)
                                        <?php

                                        $mainPriceList = Helper::getMainPriceCat();

                                        if (in_array(Auth::user()->price_list, $mainPriceList['USD'])) {
                                            $priceTag = "USD";
                                        } else {
                                            $priceTag = "SGD";
                                        }

                                        ?>
                                        <tr>
                                            <td>{{$i}}</td>
                                            <td><a href="javascrip:;" class="btn  btn-blue orderNo"
                                                   data-id="{{$orderDetail->id}}"
                                                   data-reveal-id="CartModal">{{$orderDetail->customer_ref_no}}</a></td>

                                            @if(count($orderDetail->product_title)>1)
                                                <?php $productsTitles = $orderDetail->product_title;  ?>
                                                <td>
                                                    <div class="dropdown ">
                                                        <button class="btn btn-group-justified btn-blue dropdown-toggle "
                                                                type="button"
                                                                data-toggle="dropdown">{{$productsTitles[0]}}
                                                            &nbsp;<span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            @foreach($productsTitles as $productsTitle)
                                                                <li><a href="javascript:;">{{$productsTitle}}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </td>
                                            @else
                                                <td>{{  implode(',  ', $orderDetail->product_title) }}</td>
                                            @endif
                                            <td>{{date(" d / m / Y ", strtotime($orderDetail->created_at))}}</td>
                                            <td>{{$priceTag.' '.number_format($orderDetail->total_amount , 2, '.', ',' )}}
                                            </td>
                                            <td>
                                                @if($orderDetail->order_status == PROCESSING) Order is being processed
                                                @elseif($orderDetail->order_status == AWAITING_PAYMENT) Order
                                                acknowledgment sent and
                                                awaiting payment
                                                @elseif($orderDetail->order_status == PAID) Payment received
                                                @elseif($orderDetail->order_status == SHIPPED) Order shipped
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($orderDetail->self_collection==1)
                                                    <span class="nav-icon glyphicon glyphicon-ok "></span>
                                                @else
                                                    <span class="nav-icon glyphicon glyphicon-remove"></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(in_array($orderDetail->order_status,[PROCESSING,AWAITING_PAYMENT] ))
                                                    <a class="button btn-sm btn-dark" title="Delete Order History"
                                                       onclick="return confirm('Are you sure to delete this?')"
                                                       href="{{ route("orderHistoryDelete",["id"=>$orderDetail->id]) }}">DELETE
                                                    </a>
                                                @else
                                                    <a class="button btn-sm btn-light" title="Delete Order History"
                                                       style="pointer-events: none;"
                                                       onclick="return confirm('Are you sure to delete this?')"
                                                       href="{{ route("orderHistoryDelete",["id"=>$orderDetail->id]) }}">DELETE
                                                    </a>
                                                @endif

                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="cart-content">
                        <div class="cart-grid">
                            No current orders, please browse our products to start shopping!
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- Content Containers END -->
@endsection