<div id="CartModal" data-controls-modal="CartModal" data-backdrop="static" data-keyboard="false"
     class="reveal-modal xlarge"><a class="close-reveal-modal"><i class="jcon-cancel-1"></i></a>

    <div class="model-content">
        @if($orderDetails != null)

            <div class="scroll-container">
                <div class="cart-grid">

                    <table border="0" align="center" cellpadding="0" cellspacing="0" class="scrl-tbl">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>&nbsp;</th>
                            <th>Quantity</th>
                            <th>&nbsp;</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orderDetails as $orderDetail)
                            <tr>
                                <td>
                                    <div class="photoContainer bdr"><img
                                                src=" {{asset($orderDetail->main_image)}}    "
                                                alt=""></div>
                                </td>
                                <td>
                                    <div class="cart-pro-name title5 mb5">{{$orderDetail->description}}</div>
                                    <div class="cart-pro-code"><strong>Product Code: </strong>{{$orderDetail->item_no}}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="cart-price title6 mb0 cart-money"
                                         id="price-{{$orderDetail->order_detail_id}}">{{$orderDetail->order_price}}</div>
                                </td>
                                <td class="text-center">x</td>
                                <td class="text-center">
                                    <div class="cart-price title6 mb0 "
                                         id="">{{$orderDetail->order_quantity}}</div>
                                </td>
                                <td class="text-center">=</td>
                                <td class="text-center">
                                    <div class="cart-price title6 mb0 cart-money"
                                         id="total-{{$orderDetail->order_detail_id}}">{{$orderDetail->order_quantity * $orderDetail->order_price}}</div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <input type="hidden" name="grandTotal" id="grandTotal" value="{{$grandTotal}}"/>
            <div class="sub-total title5 text-right p30" id="">Subtotal: <span class="title6 red cart-money"
                                                                               id="grandTotalResult">{{$grandTotal}}</span>
                <div class="clear"></div>
            </div>
        @else
            <div class="scroll-container">
                <div class="cart-grid">
                    Opps! Order detail not found!
                </div>
            </div>
        @endif

    </div>

</div>

