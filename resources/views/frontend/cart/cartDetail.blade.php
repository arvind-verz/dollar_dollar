<div id="CartModal" data-controls-modal="CartModal" data-backdrop="static" data-keyboard="false"
     class="reveal-modal xlarge"><a class="close-reveal-modal"><i class="jcon-cancel-1"></i></a>

    <div class="model-content">
        @if($cartDetails != null)

            <div class="scroll-container">
                <div class="cart-grid">

                    <table border="0" align="center" cellpadding="0" cellspacing="0" class="scrl-tbl">
                        <thead>
                        <tr>
                            <th>&nbsp;</th>
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
                        @foreach($cartDetails as $cartDetail)
                            <tr>
                                <td><a href="javascript:void(0)" class="delete "
                                       onclick="return removeFromCart({{$cartDetail->order_detail_id}});"
                                       data-reveal-id=""><i
                                                class="jcon-cancel-circled"></i></a></td>
                                <td>
                                    <div class="photoContainer bdr"><img
                                                src=" {{asset($cartDetail->main_image)}}    "
                                                alt=""></div>
                                </td>
                                <td>
                                    <div class="cart-pro-name title5 mb5">{{$cartDetail->description}}</div>
                                    <div class="cart-pro-code"><strong>Product Code: </strong>{{$cartDetail->item_no}}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="cart-price title6 mb0 cart-money"
                                         id="price-{{$cartDetail->order_detail_id}}">{{$cartDetail->order_price}}</div>
                                </td>
                                <td class="text-center">x</td>
                                <td class="text-center">
                                    <div class="add-qty">
                                        <button onclick="quantityLess({{$cartDetail->order_detail_id}})"
                                                class="qty-btn qty-dwn" type="button"><i class="jcon-minus"></i>
                                        </button>
                                        <input type="text" name="quantity" value="{{$cartDetail->order_quantity}}"
                                               class="form-control qty" size="4"
                                               maxlength="12" id="qty-{{$cartDetail->order_detail_id}}"
                                               onchange="getPriceAndTotal({{$cartDetail->order_detail_id}})">
                                        <button onclick="quantityAdd({{$cartDetail->order_detail_id}})"
                                                class="qty-btn qty-up"><i class="jcon-plus"></i></button>
                                        <div class="clear"></div>
                                    </div>
                                </td>
                                <td class="text-center">=</td>
                                <td class="text-center">
                                    <div class="cart-price title6 mb0 cart-money"
                                         id="total-{{$cartDetail->order_detail_id}}">{{$cartDetail->order_quantity * $cartDetail->order_price}}</div>
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
            </div>
            <div class="summary-footer"><a href="{{ route("step1") }}" id="checkout" class="button fright">checkout<i
                            class="jcon-right-big iright"></i></a>
                <a href="{{ route("get-products-category",["division"=>$cartDetail->division]) }}"
                   class=" button btn-dark fleft"><i class="jcon-left-big ileft"></i>back to products</a>

                <div class="clear"></div>
            </div>
        @else
            <div class="scroll-container">
                <div class="cart-grid">
                    Your cart is empty, Browse our products to start shopping now!
                </div>
            </div>
        @endif

    </div>

</div>

