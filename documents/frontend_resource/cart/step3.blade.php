@extends('frontend.layouts.app')
@section('content')
        <!-- Content Containers -->
<div class="main-container">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><strong>Order Sent </strong></li>
            </ul>
        </div>
    </div>
    <div class="fullcontainer">
        <div class="container">
            <div class="inner-container md">
                <p>All prices and charges displayed are before 7% GST (if applicable). $30 delivery charge will be applied to all local deliveries for orders below SGD200, overseas delivery charges will be quoted separately in our order acknowledgement.</p>
                <div id="crumbs" class="pb30">
                    <ul>
                        <li class="active">
                            <div><span>1</span>Shopping cart</div>
                        </li>
                        <li class="active">
                            <div><span>2</span>Shipping info</div>
                        </li>
                        <li class="active">
                            <div><span>3</span>order sent to speedo</div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="item-details pb30"><strong>Order Sent to Speedo</strong></div>
                <div class="cart-content">
                    <div class="order-left"> <img src="images/logo.png" alt="" width="172">
                        <div class="title4 mb10">Order Sent!</div>
                        Thank you for your order, an order acknowledgment will be sent to your email address provided.</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Containers END -->
@endsection