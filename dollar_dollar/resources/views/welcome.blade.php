@extends('frontend.layouts.app')
@section('content')

        @php
        //home page id is 1
        $id=1;
        //get banners
        $banners=Helper::getBanners($id);
        //get banners
        $brands=Helper::getBrands();
        //get home page categories
        $homePage=Helper::getHomeCategories();
        //dd($homePage);
    @endphp

    <!-- Banner -->
    <div class="banner-holder home-banner">
        <div class="bn">
            <div class="flexslider">
                @if($banners)
                    <ul class="slides">
                        @foreach($banners as $banner)
                            <li><img src="{!!asset($banner->banner_image )!!}" alt=""/>
                                <div class="bn-caption">
                                    <div class="container">
                                        <div class="bn-content">
                                            <div>
                                                {!!$banner->title!!}
                                                {!!$banner->banner_content!!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <!-- Banner END -->

    <!-- Content Containers -->
    <div class="main-container">
        @if($homePage)
            <div class="fullcontainer">
                <div class="container">
                    <div class="inner-container md pb60">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row-inner">
                                    <div class="home-txt-pod">
                                        <div class=""
                                             style="">{!!$homePage->categories_title!!}</div>
                                        <a href="{!!$homePage->categories_link!!}" class="button btn-dark">view
                                            all</a></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row-inner">
                                    <div class="home-pod"><a href="{!!$homePage->first_category_link!!}">
                                            <figure><img src="{!! asset($homePage->first_category_image) !!}"
                                                         alt=""/></figure>
                                            <div class="pod-txt"
                                                 style="">{!!$homePage->first_category_title!!}</div>
                                        </a></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row-inner">
                                    <div class="home-pod"><a href="{!!$homePage->second_category_link!!}">
                                            <figure><img src="{!! asset($homePage->second_category_image) !!}"
                                                         alt=""/></figure>
                                            <div class="pod-txt"
                                                 style="color: {!!$homePage->second_category_title_color!!} !important;">{!!$homePage->second_category_title!!}</div>
                                        </a></div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row-inner">
                                    <div class="home-pod"><a href="{!!$homePage->third_category_link!!}">
                                            <figure><img src="{!! asset($homePage->third_category_image) !!}"
                                                         alt=""/></figure>
                                            <div class="pod-txt"
                                                 style="color: {!!$homePage->third_category_title_color!!} !important;">{!!$homePage->third_category_title!!}</div>
                                        </a></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row-inner">
                                    <div class="home-pod"><a href="{!!$homePage->fourth_category_link!!}">
                                            <figure><img src="{!! asset($homePage->fourth_category_image) !!}"
                                                         alt=""/></figure>
                                            <div class="pod-txt"
                                                 style="color: {!!$homePage->fourth_category_title_color!!} !important;">{!!$homePage->fourth_category_title!!}</div>
                                        </a></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row-inner">
                                    <div class="home-pod"><a href="{!!$homePage->fifth_category_link!!}">
                                            <figure><img src="{!! asset($homePage->fifth_category_image) !!}"
                                                         alt=""/></figure>
                                            <div class="pod-txt"
                                                 style="color: {!!$homePage->fifth_category_title_color!!} !important;">{!!$homePage->fifth_category_title!!}</div>
                                        </a></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="fullcontainer bg-img" style="background-image:url({!! asset('frontend/images/bg1.jpg') !!});">
            <div class="container white">
                <div class="promotion-holder">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="photoContainer equalheight height736 promotion-img"><img
                                        src="{!! asset($homePage->promotion_image) !!}"
                                        alt=""></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="equalheight height736">
                                <div class="promotion-txt"
                                     style="color: {!!$homePage->promotion_text_color!!} !important;">{!!$homePage->promotion_text  !!}
                                    <div class="title2"
                                         style="color: {!!$homePage->promotion_title_color!!}!important;">{!! $homePage->promotion_title !!}</div>
                                    <a href="#" class="button btn-bdr bdr-white">view promotion</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fullcontainer bg-img" style="background-image:url({!! asset('frontend/images/bottom-bg.jpg') !!});">
            <div class="container">
                <div class="inner-container">
                    <div class="title1 bdr-title text-center">Brands We Carry</div>
                    @if($brands)
                        <div class="slider client-slider">
                            <div id="client-slider" class="owl-carousel">
                                @foreach($brands as $brand)
                                    <div class="item">
                                        <figure><img src="{!! asset($brand->brand_logo) !!}" alt="{{$brand->title}}"/></figure>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection