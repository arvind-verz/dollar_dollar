@extends('frontend.layouts.app')
@section('content')

<?php

//Register page id is 1
if ($productCategory == SPARE) {
    $slug = PRODUCTS_SLUG;
} elseif ($productCategory == SEARCH) {
    $slug = SEARCH_SLUG;
} else {
    $slug = PROMOTION_SLUG;
}
//get banners
$banners = Helper::getBanners($slug);
//dd($banners);

?>

        <!-- Banner -->
@if($banners->count())
    @foreach($banners as $banner)
        <div class="banner-holder inner-banner"><img src="{{ asset($banner->banner_image) }}" alt=""/>

            <div class="bn-caption">
                <div class="container">
                    <div class="bn-content">
                        <div>
                            {!! $banner->title!!}
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
                        @if(isset($productCategory))
                            @if(isset($parentCategory))
                                <li>
                                    <a href="{{ route("get-products-category",["division"=>$parentCategory->division]) }}"> {{$parentCategory->category}}</a>
                                </li>
                            @endif
                            <li><strong>{{$productCategory}} </strong></li>
                        @endif
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
                                    @if(isset($q))
                                        <div class="title3"> {{ $productCategory }} Result for {{$q}}</div>
                                    @else
                                        <div class="title3">{{$productCategory}} Products</div>
                                    @endif

                                    @if(count($productByCategories))

                                        <div class="products-grid">
                                            <div class="row">
                                                @foreach($productByCategories as $productCat)

                                                    <div class="col-sm-6 col-md-3">
                                                        <div class="row-inner">

                                                            <div class="product-box">
                                                                @if(isset($q))
                                                                    <a href="{{ route("get-search-product-detail",["id"=>$productCat[0]->id,"product_category"=>$productCategory,"search"=>$q]) }}">
                                                                        @else
                                                                            <a href="{{ route("get-search-product-detail",["id"=>$productCat[0]->id,"product_category"=>$productCategory]) }}">
                                                                                @endif
                                                                                @if($productCategory != SPARE)
                                                                                    <div class="photoContainer bdr height736">
                                                                                        <img
                                                                                                src="{!! asset(isset($productCat[0]->category_image)? $productCat[0]->category_image : '') !!}"
                                                                                                alt=""/>

                                                                                        <div class="pro-ov">
                                                                                            <div class="grid-tb">
                                                                                                <div class="grid-tc">
                                                                                                    View more
                                                                                                    <i
                                                                                                            class="jcon-right-big"></i>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                                @if($productCategory == SPARE)
                                                                                    <div class="product-name">{{$productCat[0]->item_no}}</div>
                                                                                @else

                                                                                    <div class="product-name">{{$productCat[0]->category}}</div>
                                                                                @endif
                                                                            </a>
                                                            </div>

                                                        </div>
                                                    </div>

                                                @endforeach

                                            </div>

                                        </div>
                                    @else
                                        <div class="products-grid">
                                            @if(isset($q))
                                                <div class="row">No details found for {{$q}}, try searching another
                                                    keyword!
                                                </div>
                                            @else
                                                @if ($productCategory == PROMOTION)
                                                    <div class="row">No ongoing promotions currently. Please check back
                                                        or register and sign up for our promotional emails to stay
                                                        updated!
                                                    </div>
                                                @endif
                                            @endif

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
