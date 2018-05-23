@extends('frontend.layouts.app')
@section('content')
<?php
//temp
$slug = PRODUCTS_SLUG;
//get banners
$banners = Helper::getBanners($slug);

?>

        <!-- Banner -->
@if($banners->count())
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
                        <li><strong>Products</strong></li>
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
                                    <div class="title3">Product Categories</div>
                                    <?php
                                    $id = 0;
                                    $parentCategories = Helper::getCategories($id);
                                    ?>
                                    @if($parentCategories['count'])
                                        @foreach($parentCategories['categories'] as $category)
                                            <?php
                                            $subOneCategories = Helper::getCategories($category->id);
                                            $loopCount = 1;
                                            ?>
                                            @if($subOneCategories['count'])
                                                <div class="title5">{{$category->category}}</div>
                                                <div class="products-grid">
                                                    <div class="row">

                                                        @foreach($subOneCategories['categories'] as $subOneCategory)
                                                            @if($loopCount <= 4)
                                                                <div class="col-sm-6 col-md-3">
                                                                    <div class="row-inner">
                                                                        <div class="product-box"><a
                                                                                    href="{{ route("get-products-category",["division"=>$subOneCategory->division]) }}">
                                                                                <div class="photoContainer bdr height736">
                                                                                    <img
                                                                                            src="{{ asset($subOneCategory->category_image) }}
                                                                                                    "
                                                                                            alt=""/>

                                                                                    <div class="pro-ov">
                                                                                        <div class="grid-tb">
                                                                                            <div class="grid-tc">
                                                                                                View more <i
                                                                                                        class="jcon-right-big"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="product-name">{{$subOneCategory->category}}
                                                                                </div>
                                                                            </a></div>
                                                                    </div>
                                                                </div>
                                                                <?php $loopCount++; ?>
                                                            @endif
                                                        @endforeach

                                                    </div>
                                                    @if($subOneCategories['count']>4)
                                                        <div class="product-btn-holder"><a
                                                                    href="{{ route("get-products-category",["division"=>$category->division]) }}"
                                                                    class="product-btn">VIEW
                                                                MORE</a></div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endsection