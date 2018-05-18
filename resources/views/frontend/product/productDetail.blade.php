@extends('frontend.layouts.app')
@section('content')
        <!-- Banner -->
<div class="banner-holder inner-banner no-img">
    <div class="clear"></div>
</div>
<!-- Banner END -->
<?php

$division = strtoupper(str_pad($product->division, 4, "0", STR_PAD_RIGHT));
//dd($division[0]=B,$division[1]=1,$division[2]=1,$division[3]=0);

//check parent division if not exist catch error

if ($division[0] != "0") {
    $parent_category = \DB::table('categories')->where('division', substr($division, 0, 1) . '000')
            ->first();

}
?>
<!-- Content Containers -->
<div class="main-container">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="{{ route('index') }}">Home</a></li>
                @if(isset($product->division))
                    <li><a href="{{ url('/products') }}">Products</a></li>
                    <?php
                    $breadcums = Helper::getBreadCumsCategoryByDivision($product->division);
                    $breadCumsCount = count($breadcums) - 1;
                    ?>
                    @for($i=0; $i<=$breadCumsCount;$i++)
                    {{-- @php dd($breadcums[$i],$breadCumsCount); @endphp--}}
                            <!--
                    check if product division and breadcums division same
                    when category only one product that time redirect direct to product page
                    that time need to check for reducing double breadcum of category
                    -->
                    @if($breadcums[$i]['division'] == $product->division)
                        <li><strong>{{$breadcums[$i]['category']}}</strong></li>

                    @else
                        <li>
                            <a href="{{ route("get-products-category",["division"=>$breadcums[$i]['division']]) }}"> {{$breadcums[$i]['category']}}</a>
                        </li>
                    @endif
                    @endfor

                @else
                    <li><strong>Products</strong></li>
                @endif
            </ul>
        </div>
    </div>

    <div class="fullcontainer">
        <div class="container">
            <div class="inner-container md">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="row-inner">

                            <div class="image-gallery">
                                <div class="pro-big" id=""><img
                                            id="img_01"
                                            src="{!!  asset($product->main_image) !!}"
                                            data-zoom-image="{!!  asset($product->main_image) !!}"
                                            {{--data-zoom-image="{!!  asset($product->main_image) !!}"--}}
                                            class="responsive bdr  " style=" max-width:400px; max-height: 187px;"></div>
                                @if(count($product->image_array))
                                    <div id="gal1">
                                        <ul class="pro-thumb">

                                            <li><a href="#"
                                                   data-image="{!!  asset($product->main_image) !!}"
                                                        {{-- data-zoom-image="{!!  asset($product->main_image) !!}"--}}
                                                   data-zoom-image="{!!  asset($product->main_image) !!}"
                                                        ><img src="{!!  asset($product->main_image) !!}"
                                                              id="img_01" alt=""
                                                              class="responsive bdr "> </a>
                                            </li>
                                            @foreach($product->image_array as $image)
                                                <li>
                                                    <a href="#"
                                                       data-image="{!!  asset($image) !!}"
                                                            {{-- data-zoom-image="{!!  asset($product->main_image) !!}"--}}
                                                       data-zoom-image="{!!  asset($image) !!}"
                                                            ><img src="{!!  asset($image) !!}"
                                                                  id="img_01" alt=""
                                                                  class="responsive bdr"> </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="row-inner">
                            <div class="product-info-main">
                                <div class="title3">{{$product->page_title}} @if($parent_category)
                                        ( {{$parent_category->category}} )  @endif</div>

                                <div class="title5 mb10">Product Code & Goods Description</div>
                                @if($products->count() >1)
                                    <div class="product-code pb10">
                                        <select class="selectpicker" name="product_id"
                                                data-url="{{route('get-product')}}" data-style="" data-width="100%"
                                                id="selectProduct" onchange="changeProduct();">
                                            <option value="0">Please Select</option>
                                            @foreach($products as $p)
                                                <option value="{{$p->id}}">{{$p->item_no}}&emsp;{{$p->description}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="product-error display-none error text-danger" id="product-error"></div>
                                    <div class="price money display-none" id="price"></div>
                                    <div class="price display-none" id="original-price"></div>
                                    <div class="cart-pro-code pb30 weight display-none"
                                         style="padding-bottom:0px!important;"><strong>Chargeable
                                            weight: </strong> <span id="weight"></span>
                                    </div>
                                    <div class="cart-pro-code pb30 dimension display-none"><strong>Dimensions
                                            : </strong> <span id="dimension"></span>
                                    </div>
                                @else
                                    <div class="display-none">
                                        <select class="selectpicker" name="product_id"
                                                data-url="{{route('get-product')}}" data-style="" data-width="100%"
                                                id="selectProduct">
                                            <option value="{{$product->id}}">{{$product->item_no}}&emsp;{{$product->description}}
                                            </option>
                                        </select>
                                    </div>
                                    <label>
                                        {{$product->item_no}}&emsp;{{ $product->description}}
                                    </label>
                                    <div class="product-error display-none error text-danger" id="product-error"></div>
                                    @if (Auth::user())
                                        <?php
                                        $price = Helper::getPriceByProduct($product->id);
                                        if (!$price) {
                                            $price = $product->price;
                                        }
                                        ?>
                                        <div class="price money" id="price"> {{$price}}</div>

                                    @else
                                        <?php  $price = $product->price; ?>
                                        <div class="price money" id="price"> {{$price}}</div>
                                    @endif
                                    <div class="price display-none" id="original-price"> {{$price}}</div>
                                    <div class="cart-pro-code pb30 weight "
                                         style="padding-bottom:0px!important;"><strong>Chargeable
                                            weight: </strong> <span id="weight">{{$product->weight}}</span>
                                    </div>
                                    <div class="cart-pro-code pb30 dimension "><strong>Dimensions
                                            : </strong> <span id="dimension">{{$product->dimension}}</span>
                                    </div>
                                @endif


                                {!! $product->long_description !!}
                                <div class="title5 mb20">Quantity</div>
                                <div class="add-qty mb30">
                                    <button onclick="var result = document.getElementById('qty1'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 0 ) result.value--;return false;"
                                            class="qty-btn qty-dwn" type="button"><i class="jcon-minus"></i>
                                    </button>
                                    <input type="text" name="quantity" value="1" class="form-control qty" size="4"
                                           maxlength="12" id="qty1">
                                    <button onclick="var result = document.getElementById('qty1'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;"
                                            class="qty-btn qty-up"><i class="jcon-plus"></i></button>
                                    <div class="clear"></div>
                                </div>

                                {{--@php dd(Auth::check()); @endphp--}}
                                <div class="btn-holder">
                                    <a href="#" id="cart" class="button"
                                       data-auth="{{route('user.login.status')}}"
                                       data-url="{{route('add-to-cart')}}"
                                       data-reveal-id="CartModal"><i
                                                class="jcon-basket ileft"></i> add to cart</a>
                                    @if(count($product->brochure_array))
                                        <a href="{{ route("brochureDownload",["id"=>$product->id ]) }}"
                                           class="button btn-dark">Download brochure</a>
                                    @endif
                                    @if(count($product->manual_array))
                                        <a href="{{ route("manualDownload",["id"=>$product->id ]) }}"
                                           class="button btn-light">Download Manual</a>
                                    @endif
                                </div>
                                <div class="product-error display-none error text-danger" id="auth-error"></div>
                                <input type="hidden" id="promotion" value="0"/>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($product->technical_specification))
                    <div class="title5 mb20">Technical Specifications</div>
                    <div class="scroll-container">
                        <table border="0" align="center" cellpadding="0" cellspacing="0" class="scrl-tbl tbl-styled">
                            {!! $product->technical_specification !!}
                        </table>
                    </div>
                @endif


                @if(count($related_products) ||$recent_products)
                    <hr>
                @endif
                @if(count($related_products))
                    <div class="title5 text-center">Related Products</div>
                    <div class="slider product-slider">
                        <div id="product-slider" class="owl-carousel" data-count="{{count($related_products)}}">
                            @foreach($related_products as $related_product)
                                <div class="item">
                                    <div class="product-box"><a
                                                href="{{ route("get-product-detail",["id"=>$related_product->id]) }}">
                                            <div class="photoContainer bdr height736"><img
                                                        src="{{  asset($related_product->main_image) }}"
                                                        alt=""/>

                                                <div class="pro-ov">
                                                    <div class="grid-tb">
                                                        <div class="grid-tc">View more <i
                                                                    class="jcon-right-big"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-name">{{$related_product->category}}</div>
                                        </a></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(count($recent_products))
                <div class="title5 text-center">Recently View Products</div>
                    <div class="slider product-slider">
                        <div id="recent-product-slider" class="owl-carousel"
                             data-count="{{count($recent_products)}}">
                            @foreach($recent_products as $recent_product)
                                <div class="item">
                                    <div class="product-box"><a
                                                href="{{ route("get-product-detail",["id"=>$recent_product->id]) }}">
                                            <div class="photoContainer bdr height736"><img
                                                        src="{{  asset($recent_product->main_image) }}"
                                                        alt=""/>

                                                <div class="pro-ov">
                                                    <div class="grid-tb">
                                                        <div class="grid-tc">View more <i
                                                                    class="jcon-right-big"></i></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-name">{{$recent_product->category}}</div>
                                        </a></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

</div>
<script type="text/javascript">

    // Using custom configuration
    $("#img_01").elevateZoom({
        gallery: "gal1",
        imageCrossfade: true,
        zoomWindowOffetx: 10,
        scrollZoom: true,
        zoomWindowWidth: 300,
        zoomWindowHeight: 300,
        cursor: "crosshair",
        zoomType: "window",
        zoomLevel: 0.6,
        lensSize: 100,
    });


    $("#img_01").bind("click", function (e) {
        var ez = $('#img_01').data('elevateZoom');
        $.fancybox(ez.getGalleryList());
        return false;
    });

    $(document).ready(function () {
        $(".selectpicker").change(function () {
            $("#getDetail").submit();
        });

        var price = document.getElementById('price').innerHTML;


        if (!isNaN(price)) {
            price = changeNumberToMoneyFormat(price);
            $("#price").html(price);
        }


    });

</script>
@endsection