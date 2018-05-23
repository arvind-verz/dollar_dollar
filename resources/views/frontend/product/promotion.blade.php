@extends('frontend.layouts.app')
@section('content')
<?php
$slug = PROMOTION_SLUG ;
//get banners
$banners = Helper::getBanners($slug);
//dd($banners);
?>

        <!-- Banner -->
@if($banners)
    @foreach($banners as $banner)
        <div class="banner-holder inner-banner"><img src="{{ asset($banner->banner_image) }}" alt=""/>

            <div class="bn-caption">
                <div class="container">
                    <div class="bn-content">
                        <div>
                            {!! $banner->title !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        @endforeach
        @endif
                <!-- Banner END -->


        <!-- Content Containers -->
        <div class="main-container">
            <div class="breadcrumbs">
                <div class="container">
                    <ul>
                        <li><a href="{{ route('index') }}">Home</a></li>
                        <li><strong>Promotion</strong></li>
                    </ul>
                </div>
            </div>
            <div class="fullcontainer">
                <div class="container">
                    <div class="inner-container md pb20">
                        <div class="row">
                            @include('frontend.includes.sidebar')
                            <div class="col-md-9">
                                <div class="row-inner">
                                    <div class="title3">Promotion</div>
                                    @if($products->count())

                                        <div class="products-grid">
                                            <div class="row">
                                                @foreach($products as $product)
                                                    @php
                                                    $product=Helper::getProductUnserialize($product->id);
                                                    @endphp
                                                    <div class="col-sm-6 col-md-3">
                                                        <div class="row-inner">
                                                            <div class="product-box"><a
                                                                        href="{{ route("get-promotion-product-detail",["id"=>$product->id]) }}">
                                                                    <div class="photoContainer bdr height736"><img
                                                                                src="{!! asset(isset($product->main_image)? $product->main_image : '') !!}"
                                                                                alt=""/>

                                                                        <div class="pro-ov">
                                                                            <div class="grid-tb">
                                                                                <div class="grid-tc">View more <i
                                                                                            class="jcon-right-big"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-name">{{$product->description}}</div>
                                                                </a></div>
                                                        </div>
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
            </div>
        </div>
        @endsection
