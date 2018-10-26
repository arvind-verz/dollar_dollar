@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
    <?php
    $slug = HOME_SLUG;
    //get banners
    $banners = \Helper::getBanners($slug);
    $datetime = Helper::todayDate();
    ?>
    {{--Banner section start--}}
    @if($banners->count()>1)
        <div class="ps-home-banner">
            <div class="ps-slider--home owl-slider" data-owl-animated="fadeOut" data-owl-auto="true"
                 data-owl-dots="true" data-owl-duration="1000" data-owl-gap="0" data-owl-hoverpause="true"
                 data-owl-item="1" data-owl-item-lg="1" data-owl-item-md="1" data-owl-item-sm="1" data-owl-item-xs="1"
                 data-owl-loop="true" data-owl-mousedrag="on" data-owl-nav="false" data-owl-smartspeed="10"
                 data-owl-speed="5000">
                @foreach($banners as $banner)
                    @if($banner->display==1 && strtotime(date('Y-m-d', strtotime('now')))
    <=strtotime(date('Y-m-d', strtotime($banner->banner_expiry))) && strtotime(date('Y-m-d', strtotime('now')))>=strtotime(date('Y-m-d', strtotime($banner->banner_start_date))))
                        <a href="{{ !empty($banner->banner_link) ? $banner->banner_link : 'javascript:void(0)' }}"
                           target="_blank">
                            <div class="ps-banner bg--cover" data-background="{{asset($banner->banner_image )}}">
                                <img alt="" src="{{asset($banner->banner_image )}}">

                                <div class="ps-banner__content">
                                    {!! $banner->banner_content !!}
                                </div>
                                </img>
                            </div>
                        </a>
                    @else
                        <a href="{{ !empty($banner->fixed_banner_link) ? $banner->fixed_banner_link : 'javascript:void(0)' }}"
                           target="_blank">
                            <div class="ps-banner bg--cover" data-background="{{asset($banner->fixed_banner )}}">
                                <img alt="" src="{{asset($banner->fixed_banner )}}">
                                </img>
                            </div>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    @elseif($banners->count()== 1)
        @foreach($banners as $banner)
            <a href="{{ !empty($banner->fixed_banner_link) ? $banner->fixed_banner_link : 'javascript:void(0)' }}"
               target="_blank">
                <div class="ps-banner bg--cover" data-background="{{asset($banner->fixed_banner )}}">
                    <img alt="" src="{{asset($banner->fixed_banner )}}">
                    </img>
                </div>
            </a>
        @endforeach
    @endif
    {{--Banner section end--}}
    <div class="ps-home--links">
        <div class="container">
            <?php $i = 1; ?>
            @if($banners->count()>1)
                @foreach($banners as $banner)
                    <a href="javascript:clickSliderhome({{$i}})">
                        <div class="ps-block--home-link" data-mh="home-link">
                            {{ $banner->title }}
                            <p>
                                {{ $banner->description }}
                            </p>
                        </div>
                    </a>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
    </div>
    <div class="ps-home-search">
        <div class="ps-section__content" data-mh="home-search">
    <span>
      Need something?
    </span>
            <h4>
                Search Products
            </h4>
        </div>
        <form action="{{ route('product-search') }}" class="ps-form--search" data-mh="home-search" method="POST">
            <div class="form-group">
                <select class="form-control" name="account_type" required="required">
                    <option value="" disabled="disabled" selected="selected">
                        Select account Type
                    </option>
                    <option value="1">
                        Fixed Deposit
                    </option>
                    <option value="2">
                        Saving Deposit
                    </option>
                    <option value="3">
                        Privilege Deposit
                    </option>
                    <option value="4">
                        Foreign Currency
                    </option>
                    <option value="5">
                        All In One Account
                    </option>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control prefix_dollar" name="search_value" placeholder="Enter Placement" required=""
                       type="text" value="100000">
                <!-- <span class="suffix_k">K</span> -->
                </input>
            </div>
            <div class="form-group submit">
                <button class="ps-btn" type="submit">
                    Search Now
                    <i class="fa fa-search">
                    </i>
                </button>
            </div>
        </form>
    </div>
    {{--Brand section start--}}
    @if($brands->count())
        <div class="ps-home--partners">
            <div class="container">
                <div class="nav-outside owl-slider" data-owl-auto="true" data-owl-dots="false" data-owl-duration="1000"
                     data-owl-gap="0" data-owl-item="8" data-owl-item-lg="8" data-owl-item-md="6" data-owl-item-sm="4"
                     data-owl-item-xs="3" data-owl-loop="true" data-owl-mousedrag="on" data-owl-nav="true"
                     data-owl-speed="5000">
                    @foreach($brands as $brand)
                        <a class="active"
                           href="{{!empty($brand->brand_link) ? $brand->brand_link : 'javascript:void(0)'}}"
                           target="_blank">
                            <img alt="" src="{{ asset($brand->brand_logo) }}" style="padding:19px;"/>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    {{--Brand section end--}}
    {{--Brand section end--}}
    <input name="deposit_type" type="hidden" value="Fixed Deposit">
    <div class="ps-home-fixed-deposit ps-tabs-root">
        <div class="ps-section__header">
            <div class="container">
                <ul class="ps-tab-list">
                    <li class="current">
                        <a href="javascript:void(0);" data-promotion-type="{{FIX_DEPOSIT}}" class="product-tab">
                            Fixed Deposit
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-promotion-type="{{SAVING_DEPOSIT}}" class="product-tab">
                            Saving Deposit
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-promotion-type="{{PRIVILEGE_DEPOSIT}}" class="product-tab">
                            Privilege Deposit
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-promotion-type="{{FOREIGN_CURRENCY_DEPOSIT}}"
                           class="product-tab">
                            Foreign Currency
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-promotion-type="{{ALL_IN_ONE_ACCOUNT}}" class="product-tab">
                            All In One Account
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ps-section__content bg--cover" data-background="img/bg/home-bg.jpg">
            <div class="container">
                <div class="ps-tabs">
                    <div class="ps-tab active" id="tab-1">
                        <div class="ps-block--desposit">
                            <div class="ps-block__header">
                                <h3>
                                    <strong id="product-heading">
                                        Fixed Deposit
                                    </strong>
                                </h3>

                                <div class="ps-block__actions">
                                    <ul class="catListing clearfix">
                                        <li class="selected" id="catList1">
                                            <a class="aboutpage" id="showContent-1"
                                               data-order-by="{{MAXIMUM_INTEREST_RATE}}"
                                               target="showContent-container-1">
                                                Interest
                                            </a>
                                        </li>
                                        <li class="" id="catList2">
                                            <a class="aboutpage" id="showContent-2"
                                               data-order-by="{{MINIMUM_PLACEMENT_AMOUNT}}"
                                               target="showContent-container-2">
                                                Placement
                                            </a>
                                        </li>
                                        <li class="" id="catList3">
                                            <a class="aboutpage" id="showContent-3" data-order-by="{{PROMOTION_PERIOD}}"
                                               target="showContent-container-3">
                                                tenure
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="productGridContainer target-content" id="showContent-container-1">
                                <div class="product-row-01 clearfix pc-only" id="pc-slider">
                                    <?php
                                    $products = \Helper::getHomeProducts(FIX_DEPOSIT, 'maximum_interest_rate');
                                    $i = 1;$featured = [];
                                    ?>
                                    @if($products->count())
                                        @include('homePcProductsSlider')
                                    @endif
                                </div>
                                <div class="product-row-01 clearfix sp-only">
                                    <?php
                                    $products = \Helper::getHomeProducts(FIX_DEPOSIT, 'maximum_interest_rate');
                                    $i = 1;$featured = [];
                                    ?>
                                    @if($products->count())
                                        @include('homeSpProductsSlider')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Blog section start--}}
    <div class="ps-home-blog">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="ps-section__left">
                        <div class="ps-section__header">
                            <a href="{{ url('blog-list') }}">
                                <h3 class="ps-heading">
                                    <strong>
                                        Lastest Blog
                                    </strong>
                                </h3>
                            </a>

                            <div class="ps-slider-navigation" data-slider="ps-slider--home-blog">
                                <a class="ps-prev" href="javascript:void(0);">
                                    <i class="fa fa-caret-left">
                                    </i>
                                </a>
                                <a class="ps-next" href="javascript:void(0);">
                                    <i class="fa fa-caret-right">
                                    </i>
                                </a>
                            </div>
                        </div>
                        <div class="owl-slider owl-blog" data-owl-auto="true" data-owl-dots="false"
                             data-owl-duration="1000" data-owl-gap="0" data-owl-item="1" data-owl-item-lg="1"
                             data-owl-item-md="1" data-owl-item-sm="1" data-owl-item-xs="1" data-owl-loop="true"
                             data-owl-mousedrag="off" data-owl-nav="false" data-owl-speed="5000">
                            @foreach($blogs as $blog)
                                <div class="ps-post--home">
                                    <div class="ps-post__thumbnail">
                                        <a class="ps-post__overlay" href="{{ url($blog->slug) }}">
                                        </a>
                                        <img alt="" height="250px" src="{{ asset($blog->blog_image) }}">

                                        <div class="ps-post__posted">
                  <span class="date">
                    {{ date("d", strtotime($blog->created_at)) }}
                  </span>
                  <span class="month">
                    {{ date("M", strtotime($blog->created_at)) }}
                  </span>
                                        </div>
                                        </img>
                                    </div>
                                    <div class="ps-post__content">
                                        <a class="ps-post__title" href="{{ url($blog->slug) }}">
                                            {{ $blog->name }}
                                        </a>

                                        <p>
                                            {!! $blog->short_description !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="ps-section__right">
                        <div class="ps-fanpage">
                            <div class="fb-page" data-adapt-container-width="true" data-height="280"
                                 data-hide-cover="false" data-href="https://www.facebook.com/dollardollar.sg/"
                                 data-show-facepile="true" data-small-header="false" data-tabs="timeline"
                                 data-width="500">
                                <blockquote cite="https://www.facebook.com/dollardollar.sg/"
                                            class="fb-xfbml-parse-ignore">
                                    <a href="https://www.facebook.com/dollardollar.sg/">
                                        DollarDollar
                                    </a>
                                </blockquote>
                            </div>
                        </div>
                        <div class="ps-block--home-signup">
                            <h3>
                                Create an account to manage your privilege easily.
                                <strong>
                                    It is free!
                                </strong>
                            </h3>
                            <a class="ps-btn ps-btn--yellow" href="{{ url('login/facebook') }}">
                                <i class="fab fa-facebook-f">
                                </i>
                                Signup with facebook
                            </a>
                            <a class="ps-btn ps-btn--outline" href="{{ url('login/google') }}">
                                Sign Up with
                                email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("document").ready(function () {

                    $('.ps-next').click(function () {
                                owl.trigger('next.owl.carousel');
                            }
                    )
                    $('.ps-prev').click(function () {
                                owl.trigger('prev.owl.carousel', [300]);
                            }
                    )
                }
        );
        $("a.aboutpage").on("click", function () {
                    $("a.aboutpage").parent().removeClass("selected");
                    $(this).parent().addClass("selected");
                    var activeProduct = $('.ps-tab-list li').filter(".current");
                    var promotionType = $(activeProduct).find("a").attr("data-promotion-type");
                    var byOrderValue = $(this).attr("data-order-by");
                    getProductSliderDetails(promotionType, byOrderValue);
                }
        );
        $(".ps-tab-list li").on("click", function () {

                    //owlCarousel($('.owl-slider'));
                    $(".ps-tab-list li").removeClass("current");
                    $(this).addClass("current");
                    var promotionType = $(this).find("a").attr("data-promotion-type");
                    var byOrderValue = "<?php echo MAXIMUM_INTEREST_RATE; ?>";
                    var productHeading;
                    if (promotionType == '<?php echo FIX_DEPOSIT ;?>') {
                        productHeading = '<?php echo FIX_DEPOSIT_TITLE ;?>';
                    } else if (promotionType == '<?php echo SAVING_DEPOSIT ;?>') {
                        productHeading = '<?php echo SAVING_DEPOSIT_TITLE ;?>';
                    }
                    else if (promotionType == '<?php echo FOREIGN_CURRENCY_DEPOSIT ;?>') {
                        productHeading = '<?php echo FOREIGN_DEPOSIT_TITLE ;?>';
                    } else if (promotionType == '<?php echo PRIVILEGE_DEPOSIT ;?>') {
                        productHeading = '<?php echo PRIVILEGE_DEPOSIT_TITLE ;?>';
                    } else if (promotionType == '<?php echo ALL_IN_ONE_ACCOUNT ;?>') {
                        productHeading = '<?php echo ALL_IN_ONE_ACCOUNT_TITLE ;?>';
                    }
                    $('#product-heading').html(productHeading);
                    getProductSliderDetails(promotionType, byOrderValue);
                }
        );

        function getProductSliderDetails(promotionType, byOrderValue) {

            var target = $("#pc-slider");
            var targetId = "pc-slider";

            var resizeTimer;
            $(window).resize(function (e) {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function () {
                    if ($(window).width() <= 800) {
                        target = $("#sp-slider");
                        targetId = "sp-slider";
                    } else {
                        target = $("#pc-slider");
                        targetId = "pc-slider";
                    }
                }, 250);
            });

            $.ajax({
                method: "POST",
                url: "{{url('/get-product-slider-details')}}",
                data: {
                    promotion_type: promotionType,
                    by_order_value: byOrderValue,
                    target: targetId
                },
                cache: false,
                async: false,
                success: function (data) {

                    target.html(data);
                    var $owl = target.find('.owl-carousel');
                    $owl.trigger('destroy.owl.carousel');
                    $owl.html($owl.find('.owl-stage-outer').html()).removeClass('owl-loaded');

                    var t = $owl.data("owl-auto"), e = $owl.data("owl-loop"), o = $owl.data("owl-speed"), l = $owl.data("owl-gap"), d = $owl.data("owl-nav"), i = $owl.data("owl-dots"), n = $owl.data("owl-animate-in") ? $owl.data("owl-animate-in") : "", s = $owl.data("owl-animate-out") ? $owl.data("owl-animate-out") : "", m = $owl.data("owl-item"), w = $owl.data("owl-item-xs"), u = $owl.data("owl-item-sm"), r = $owl.data("owl-item-md"), p = $owl.data("owl-item-lg"), g = $owl.data("owl-nav-left") ? $owl.data("owl-nav-left") : "<i class='fa fa-angle-left'></i>", v = $owl.data("owl-nav-right") ? $owl.data("owl-nav-right") : "<i class='fa fa-angle-right'></i>", h = $owl.data("owl-duration"), f = $owl.data("owl-animated"), c = $owl.data("owl-smartspeed"), y = $owl.data("owl-hoverpause"), S = "on" == $owl.data("owl-mousedrag");
                    $owl.owlCarousel({
                        animateIn: n,
                        animateOut: s,
                        margin: l,
                        autoplay: t,
                        autoplayTimeout: o,
                        autoplayHoverPause: !0,
                        loop: e,
                        nav: d,
                        mouseDrag: S,
                        touchDrag: !0,
                        autoplaySpeed: h,
                        navSpeed: h,
                        dotsSpeed: h,
                        dragEndSpeed: h,
                        navText: [g, v],
                        dots: i,
                        items: m,
                        animateOut: f,
                        smartSpeed: c,
                        lazyLoad: !0,
                        beforeInit: true,
                        afterInit: true,
                        autoplayHoverPause: y,
                        responsive: {0: {items: w}, 480: {items: u}, 768: {items: r}, 992: {items: p}, 1200: {items: m}}
                    });
                }
            });
        }

    </script>
    {{--Blog section end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}
@endsection
