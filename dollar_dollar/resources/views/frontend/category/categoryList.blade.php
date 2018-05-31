@extends('frontend.layouts.app')
@section('content')
<?php
$slug = CATEGORY_SLUG;
$banners = Helper::getBanners($slug, $category->id);
$productBanners = Helper::getBanners($slug);
?>

        <!-- Banner -->
@if($banners->count())
    @foreach($banners as $banner)
        <div class="banner-holder inner-banner">
            <img src="{{ asset($banner->banner_image) }}" alt=""/>

            <div class="bn-caption">
                <div class="container">
                    <div class="bn-content">
                        <div>
                            {!!  $banner->title !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    @endforeach
@elseif($productBanners->count())
    @foreach($productBanners as $productBanner)
        <div class="banner-holder inner-banner">
            <img src="{{ asset($productBanner->banner_image) }}" alt=""/>

            <div class="bn-caption">
                <div class="container">
                    <div class="bn-content">
                        <div>
                            <h2><span style="color: #ffffff;">{{$category->category}}</span></h2>
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
                        @if(isset($division))
                            <li><a href="{{ url('/products') }}">Products</a></li>
                            <?php
                            $breadcums = Helper::getBreadCumsCategoryByDivision($division);
                            $breadCumsCount = count($breadcums) - 1;
                            ?>
                            @for($i=0; $i<=$breadCumsCount;$i++)
                                {{-- @php dd($breadcums[$i],$breadCumsCount); @endphp--}}
                                @if($i==$breadCumsCount)
                                    <li><strong>{{$breadcums[$i]['category']}}</strong></li>
                                @else
                                    <li><a
                                                href="{{ route("get-products-category",["division"=>$breadcums[$i]['division']]) }}"> {{$breadcums[$i]['category']}}</a>
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
                    <div class="inner-container md pb20">
                        <div class="row">
                            @include('frontend.includes.sidebar')
                            <div class="col-md-9">
                                <div class="row-inner">
                                    <div class="title3">{{$category->category}}</div>
                                    @if($categories->count())
                                        <div class="products-grid">
                                            <div class="row">
                                                @foreach($categories as $category)
                                                    <div class="col-sm-6 col-md-3">
                                                        <div class="row-inner">
                                                            <div class="product-box"><a
                                                                        href="{{ route("get-products-category",["division"=>$category->division]) }}">
                                                                    <div class="photoContainer bdr height736"><img
                                                                                src="{{ asset($category->category_image) }}"
                                                                                alt=""/>

                                                                        <div class="pro-ov">
                                                                            <div class="grid-tb">
                                                                                <div class="grid-tc">View more <i
                                                                                            class="jcon-right-big"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="product-name">{{$category->category}}</div>
                                                                </a></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-sm-6 col-md-3">
                                            <div class="row-inner">
                                                Opps! Product not found.
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