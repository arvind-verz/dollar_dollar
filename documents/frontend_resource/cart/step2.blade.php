@extends('frontend.layouts.app')
@section('content')
        <!-- Content Containers -->
<div class="main-container">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="{{route('index')}}">Home</a></li>
                <li><a href="{{ route("step1") }}">Shopping Cart</a></li>
                <li><strong>Shipping Info</strong></li>
            </ul>
        </div>
    </div>
    <div class="fullcontainer">
        <div class="container">
            <div class="inner-container md">
                <p>All prices and charges displayed are before 7% GST (if applicable). $30 delivery charge will be
                    applied to all local deliveries for orders below SGD200, overseas delivery charges will be quoted
                    separately in our order acknowledgement.</p>

                <div id="crumbs" class="pb30">
                    <ul>
                        <li class="active">
                            <div><span>1</span>Shopping cart</div>
                        </li>
                        <li class="active">
                            <div><span>2</span>Shipping info</div>
                        </li>
                        <li>
                            <div><span>3</span>order sent to speedo</div>
                        </li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="item-details pb30"><strong>Shipping Information</strong></div>
                {{--Error or Success--}}
                @include('frontend.includes.messages')
                <div class="cart-content">
                    {!! Form::open(['url' => ['create-order'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Company Name</label>

                                <div class="col-md-10">
                                    <div class="form-inner">
                                        <input class="form-control" placeholder="Co. Name" name="company"
                                               value="{{ old('company') ? old('company') : $user->company }}"
                                               type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Shipping Address</label>

                                <div class="col-md-10">
                                    <input class="form-control" placeholder="Co. Address" type="text"
                                           id="shipping_address"
                                           name="shipping_address"
                                           value="{{ old('shipping_address') ? old('shipping_address') :$user->shipping_address}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <div class="checkbox">
                                        <input type="hidden" name="self_collection" value=off>
                                        <input type="checkbox" id="C1" name="self_collection" value=1>
                                        <label for="C1">Self-collection</label>
                                    </div>
                                </div>
                                <div class="col-md-8"><span class="red">* </span>
                                    For arrangements via your own forwarder, please indicate instructions in the Remarks
                                    box.
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Billing Address</label>

                                <div class="col-md-10">
                                    <input class="form-control" placeholder="Co. Address" type="text"
                                           name="billing_address" id="billing_address"
                                           value="{{ old('billing_address') ? old('billing_address') : $user->billing_address}}"
                                           @if(isset($user->billing_address)) readonly @endif>
                                </div>
                            </div>
                            @if(!$user->billing_address)
                                <div class="form-group">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-10">
                                        <div class="checkbox">
                                            <input type="checkbox" id="C3" name="same_as_shipping"><label for="C3">Same
                                                as
                                                shipping address</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-md-2 control-label">Contact Person</label>

                                <div class="col-md-4">
                                    <div class="form-inner">
                                        <input class="form-control" type="text" name="contact_person"
                                               value="{{ old('contact_person') ? old('contact_person') : $user->first_name.' '.$user->last_name}}">
                                    </div>
                                </div>
                                <label class="col-md-2 control-label">Telephone Number</label>

                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="tel_phone"
                                           value="{{ old('tel_phone') ? old('tel_phone') : $user->tel_phone}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Email Address</label>

                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="email"
                                           value="{{ old('email') ? old('email') : $user->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Remarks(Optional)</label>

                                <div class="col-md-10">
                                    <textarea class="form-control"
                                              name="remark">{{ old('remark') ? old('remark') :''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="price_list" id="price-list-id"
                           value="@if(Auth::user()->price_list != null){{Auth::user()->price_list}} @else 1 @endif"/>

                    <div class="summary-footer pt30">
                        <button type="submit" class="button fright">Create Order<i
                                    class="jcon-right-big iright"></i></button>
                        <a href="{{ route("step1") }}" class="button btn-dark fleft"><i class="jcon-left-big ileft"></i>back</a>

                        <div class="clear"></div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Containers END -->
<script>
    $(document).ready(function () {
        var result = document.getElementById('price-list-id');

        $("#selectPrice").on('change', function () {
            // Does some stuff and logs the event to the console
            var result = document.getElementById('price-list-id');
            var selectPrice = document.getElementById("selectPrice");
            var priceList = selectPrice.options[selectPrice.selectedIndex].value;

            if (priceList == "USD-A") {
                result.value = "1";
            }
            else {
                result.value = "7";
            }
        });

        var sameAsShipping = $("input[name='same_as_shipping']");
        var shippingAddress = document.getElementById('shipping_address');
        var billingAddress = document.getElementById('billing_address');
        sameAsShipping.change(function () {
            if (this.checked) {
                billingAddress.value = shippingAddress.value;

            } else {
                billingAddress.value = null;
            }
        });


    });
</script>
@endsection