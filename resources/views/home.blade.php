@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
    <?php
    //dd(Auth::User()->first_name);
    
    $slug = HOME_SLUG;
    //get banners
    $banners = \Helper::getBanners($slug);
    ?>
    {{--Banner section start--}}

    @if($banners->count()>1)
        <div class="ps-home-banner">
            <div class="ps-slider--home owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
                 data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1"
                 data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000"
                 data-owl-mousedrag="on">
                @foreach($banners as $banner)
                    <div class="ps-banner bg--cover" data-background="{{asset($banner->banner_image )}}"><img
                                src="{{asset($banner->banner_image )}}" alt="">

                        <div class="ps-banner__content">
                            {!!$banner->banner_content!!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif($banners->count()== 1)
        @foreach($banners as $banner)
            <div class="ps-hero bg--cover" data-background="{{asset($banner->banner_image )}}"><img
                        src="{{asset($banner->banner_image )}}" alt=""></div>
        @endforeach
    @endif

    {{--Banner section end--}}

    <div class="ps-home--links">
        <div class="container">
            <div class="ps-block--home-link" data-mh="home-link"><a href="#">Grow Your Money Simply</a>

                <p>Curabitur aliquet quam posuere</p>
            </div>
            <div class="ps-block--home-link" data-mh="home-link"><a href="#">UOB Saving 1.1 %</a>

                <p>Curabitur aliquet quam posuere</p>
            </div>
            <div class="ps-block--home-link" data-mh="home-link"><a href="#">ocbc 360 - up to 3 %</a>

                <p>Curabitur aliquet quam posuere</p>
            </div>
            <div class="ps-block--home-link" data-mh="home-link"><a href="#">citibank</a>

                <p>Curabitur aliquet quam posuere</p>
            </div>
        </div>
    </div>

    <div class="ps-home-search">
        <div class="ps-section__content" data-mh="home-search"><span>Need something?</span>
            <h4>Search Products</h4>
        </div>
        <form class="ps-form--search" action="do_action" method="post" data-mh="home-search">
            <div class="form-group">
                <select class="form-control">
                    <option value="1">Select account Type</option>
                    <option value="2">Account type 1</option>
                    <option value="2">Account type 2</option>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Enter Placement">
            </div>
            <div class="form-group submit">
                <button class="ps-btn">Search Now<i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>

    {{--Brand section start--}}

    @if($brands->count())

        <div class="ps-home--partners">
            <div class="container">

                <div class="nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
                     data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="8" data-owl-item-xs="5"
                     data-owl-item-sm="6" data-owl-item-md="7" data-owl-item-lg="8" data-owl-duration="1000"
                     data-owl-mousedrag="on">
                    @foreach($brands as $brand)
                        <a href="{{$brand->brand_link}}" target="{{$brand->target}}"><img
                                    src="{{ asset($brand->brand_logo) }}" alt=""></a>
                    @endforeach

                </div>
            </div>
        </div>
    @endif
    {{--Brand section end--}}


    <div class="ps-home-fixed-deposit ps-tabs-root">
        <div class="ps-section__header">
            <div class="container">
                <ul class="ps-tab-list">
                    <li class="current"><a href="#tab-1">Fixed Deposit</a></li>
                    <li><a href="#tab-2">Saving Deposit</a></li>
                    <li><a href="#tab-3">Wealth Deposit</a></li>
                    <li><a href="#tab-4">All In One Account</a></li>
                    <li><a href="#tab-5">Foreign Currency</a></li>
                </ul>
            </div>
        </div>

        <div class="ps-section__content bg--cover" data-background="img/bg/home-bg.jpg">
            <div class="container">
                <div class="ps-tabs">
                    <div class="ps-tab active" id="tab-1">
                        <div class="ps-block--desposit">
                            <div class="ps-block__header">
                                <h3><strong>Fixed</strong>Deposit</h3>

                                <div class="ps-block__actions"><a class="ps-btn active" href="#">Interest</a><a
                                            class="ps-btn" href="#">Placement</a><a class="ps-btn" href="#">Tenor</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                                    <div class="ps-block--short-product"><img
                                                src="{{ asset('frontend/img/logo/1.png') }}" alt="">
                                        <h4>up to <strong> 1.3%</strong></h4>

                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>1.3%</p>

                                            <p><strong>Min:</strong> SGD $20,000</p>

                                            <p class="highlight">12 Months</p>
                                        </div>
                                        <a class="ps-btn" href="#">More info</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                                    <div class="ps-block--short-product"><img
                                                src="{{ asset('frontend/img/logo/2.png') }}" alt="">
                                        <h4>up to <strong> 1.3%</strong></h4>

                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>1.3%</p>

                                            <p><strong>Min:</strong> SGD $20,000</p>

                                            <p class="highlight">12 Months</p>
                                        </div>
                                        <a class="ps-btn" href="#">More info</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                                    <div class="ps-block--short-product"><img
                                                src="{{ asset('frontend/img/logo/2.png') }}" alt="">
                                        <h4>up to <strong> 1.3%</strong></h4>

                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>1.3%</p>

                                            <p><strong>Min:</strong> SGD $20,000</p>

                                            <p class="highlight">12 Months</p>
                                        </div>
                                        <a class="ps-btn" href="#">More info</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 ">
                                    <div class="ps-block--short-product"><img
                                                src="{{ asset('frontend/img/logo/2.png') }}" alt="">
                                        <h4>up to <strong> 1.3%</strong></h4>

                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>1.3%</p>

                                            <p><strong>Min:</strong> SGD $20,000</p>

                                            <p class="highlight">12 Months</p>
                                        </div>
                                        <a class="ps-btn" href="#">More info</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ps-tab" id="tab-2">
                        <h3>Tab 2 To be update</h3>
                    </div>
                    <div class="ps-tab" id="tab-3">
                        <h3>Tab 3 To be update</h3>
                    </div>
                    <div class="ps-tab" id="tab-4">
                        <h3>Tab 4 To be update</h3>
                    </div>
                    <div class="ps-tab" id="tab-5">
                        <h3>Tab 5 To be update</h3>
                    </div>
                </div>
                <div class="ps-section__footer"><a href="#">View all bank rates</a></div>
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
                            <h3 class="ps-heading">Lastest <strong> Blog</strong></h3>

                            <div class="ps-slider-navigation" data-slider="ps-slider--home-blog"><a class="ps-prev" href="javascript:void(0);"><i class="fa fa-caret-left"></i></a><a class="ps-next" href="javascript:void(0);"><i class="fa fa-caret-right"></i></a></div>
                        </div>
                        <div class="owl-slider owl-blog" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="1" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000" data-owl-mousedrag="off">
                            @foreach($blogs as $blog)
                            <div class="ps-post--home">
                                <div class="ps-post__thumbnail">
                                    <a class="ps-post__overlay" href="{{ url($blog->slug) }}"></a><img src="{{ asset($blog->blog_image) }}" alt="">

                                    <div class="ps-post__posted"><span class="date">19</span><span class="month">Nov</span></div>
                                </div>
                                <div class="ps-post__content">
                                    <a class="ps-post__title" href="{{ url($blog->slug) }}">{{ $blog->name }}</a>
                                    <p>{!! $blog->short_description !!}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="ps-section__right">
                        <div class="ps-fanpage"><img src="{{ asset('frontend/img/fanpage.png') }}" alt=""></div>
                        <div class="ps-block--home-signup">
                            <h3>Create an account to manage your wealth easily. <strong> It is free!</strong></h3><a class="ps-btn ps-btn--yellow" href="#"><i class="fa fa-facebook"></i> Signup with facebook</a><a class="ps-btn ps-btn--outline" href="#">Sign Up with email</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("document").ready(function() {
            var owl = $('.owl-blog');
            owl.owlCarousel({
                loop:true,
                margin:10,
                items: 1
            });
            $('.ps-next').click(function() {
                owl.trigger('next.owl.carousel');
            })
            $('.ps-prev').click(function() {
                owl.trigger('prev.owl.carousel', [300]);
            })
        });
    </script>
    {{--Blog section end--}}

    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}


@endsection