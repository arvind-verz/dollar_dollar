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
                            {!! $banner->banner_content !!}
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
            <?php $i = 1; ?>
            @if($banners->count()>1)
                @foreach($banners as $banner)
                    <a href="javascript:clickSliderhome({{$i}})" >
                        <div class="ps-block--home-link" data-mh="home-link">
                            {{ $banner->title }}
                            <p>{{ $banner->description }}</p>
                        </div>
                    </a>
                    <?php $i++; ?>
                @endforeach
            @endif
        </div>
    </div>

    <div class="ps-home-search">
        <div class="ps-section__content" data-mh="home-search"><span>Need something?</span>
            <h4>Search Products</h4>
        </div>
        <form class="ps-form--search" action="{{ route('product-search') }}" method="POST" data-mh="home-search">
            <div class="form-group">
                <select class="form-control" name="account_type">
                    <option value="">Select account Type</option>
                    <option value="1">Fixed Deposit</option>
                    <option value="2">Saving Deposit</option>
                    <option value="3">Wealth Deposit</option>
                    <option value="4">Foreign Currency</option>
                    <option value="5">All In One Account</option>
                </select>
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="search_value" placeholder="Enter Placement">
            </div>
            <div class="form-group submit">
                <button type="submit" class="ps-btn">Search Now<i class="fa fa-search"></i></button>
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
                        <a href="#" target="{{$brand->target}}"><img
                                    src="{{ asset($brand->brand_logo) }}" alt=""></a>
                    @endforeach

                </div>
            </div>
        </div>
    @endif
    {{--Brand section end--}}

    <input type="hidden" name="deposit_type" value="Fixed Deposit">

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
                  <h3><strong>Fixed Deposit</strong></h3>
                  <div class="ps-block__actions">
                      <ul class="catListing clearfix">
                          <li id="catList1" class="selected"><a class="aboutpage" target="showContent-container-1" id="showContent-1">Interest</a></li>
                          <li id="catList2" class=""><a class="aboutpage" target="showContent-container-2" id="showContent-2">Placement</a></li>
                          <li id="catList3" class=""><a class="aboutpage" target="showContent-container-3" id="showContent-3">Tenor</a></li>
                      </ul>
                  </div>
                </div>
                <div class="productGridContainer target-content" id="showContent-container-1">
                    <div class="display_fixed nav-outside owl-slider owl-carousel owl-theme owl-loaded" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-nav-left="<i class='fa fa-angle-left'></i>" data-owl-nav-right="<i class='fa fa-angle-right'></i>">
                            @php $i = 1; @endphp
                            @foreach($promotion_products as $products)
                                @if($products->promotion_type_id==1 && $i<=4)
                                        <div class="ps-block--short-product"><img
                                                    src="{{ asset($products->brand_logo) }}" alt="">
                                            <h4>up to <strong> {{ $products->maximum_interest_rate }}
                                                    %</strong></h4>

                                            <div class="ps-block__info">
                                                <p><strong> rate: </strong>1.3%</p>

                                                <p><strong>Min:</strong> SGD
                                                    ${{ $products->minimum_placement_amount }}</p>

                                                <p class="highlight">{{ $products->promotion_period }}
                                                    Months</p>
                                            </div>
                                            <a class="ps-btn" href="{{ url('fixed-deposit-mode') }}">More
                                                info</a>
                                        </div>
                                    @php $i++; @endphp
                                @endif

                            @endforeach
                    </div>
                </div>
              </div>
            </div>
            <div class="ps-tab" id="tab-2">
              <div class="ps-block--desposit">
                <div class="ps-block__header">
                  <h3><strong>Saving Deposit</strong></h3>
                  <div class="ps-block__actions">
                      <ul class="catListing clearfix">
                          <li id="catList1" class="selected"><a class="aboutpage" target="showContent-container-1" id="showContent-1">Interest</a></li>
                          <li id="catList2" class=""><a class="aboutpage" target="showContent-container-2" id="showContent-2">Placement</a></li>
                          <li id="catList3" class=""><a class="aboutpage" target="showContent-container-3" id="showContent-3">Tenor</a></li>
                      </ul>
                  </div>
                </div>
                <div class="productGridContainer target-content" id="showContent-container-1">
                    <div class="display_saving nav-outside owl-slider owl-carousel owl-theme owl-loaded" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-nav-left="<i class='fa fa-angle-left'></i>" data-owl-nav-right="<i class='fa fa-angle-right'></i>">
                            @php $i = 1; @endphp
                            @foreach($promotion_products as $products)
                                @if($products->promotion_type_id==2 && $i<=4)
                                        <div class="ps-block--short-product"><img
                                                    src="{{ asset($products->brand_logo) }}" alt="">
                                            <h4>up to <strong> {{ $products->maximum_interest_rate }}
                                                    %</strong></h4>

                                            <div class="ps-block__info">
                                                <p><strong> rate: </strong>1.3%</p>

                                                <p><strong>Min:</strong> SGD
                                                    ${{ $products->minimum_placement_amount }}</p>

                                                <p class="highlight">{{ $products->promotion_period }}
                                                    Months</p>
                                            </div>
                                            <a class="ps-btn" href="{{ url('fixed-deposit-mode') }}">More
                                                info</a>
                                        </div>
                                    @php $i++; @endphp
                                @endif

                            @endforeach
                    </div>
                </div>
              </div>
            </div>
            <div class="ps-tab" id="tab-3">
              <div class="ps-block--desposit">
                <div class="ps-block__header">
                  <h3><strong>Wealth Deposit</strong></h3>
                  <div class="ps-block__actions">
                      <ul class="catListing clearfix">
                          <li id="catList1" class="selected"><a class="aboutpage" target="showContent-container-1" id="showContent-1">Interest</a></li>
                          <li id="catList2" class=""><a class="aboutpage" target="showContent-container-2" id="showContent-2">Placement</a></li>
                          <li id="catList3" class=""><a class="aboutpage" target="showContent-container-3" id="showContent-3">Tenor</a></li>
                      </ul>
                  </div>
                </div>
                <div class="productGridContainer target-content" id="showContent-container-1">
                    <div class="display_wealth nav-outside owl-slider owl-carousel owl-theme owl-loaded" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-nav-left="<i class='fa fa-angle-left'></i>" data-owl-nav-right="<i class='fa fa-angle-right'></i>">
                            @php $i = 1; @endphp
                            @foreach($promotion_products as $products)
                                @if($products->promotion_type_id==WEALTH_DEPOSIT && $i<=4)
                                        <div class="ps-block--short-product"><img
                                                    src="{{ asset($products->brand_logo) }}" alt="">
                                            <h4>up to <strong> {{ $products->maximum_interest_rate }}
                                                    %</strong></h4>

                                            <div class="ps-block__info">
                                                <p><strong> rate: </strong>1.3%</p>

                                                <p><strong>Min:</strong> SGD
                                                    ${{ $products->minimum_placement_amount }}</p>

                                                <p class="highlight">{{ $products->promotion_period }}
                                                    Months</p>
                                            </div>
                                            <a class="ps-btn" href="{{ url('fixed-deposit-mode') }}">More
                                                info</a>
                                        </div>
                                    @php $i++; @endphp
                                @endif

                            @endforeach
                    </div>
                </div>
              </div>
            </div>
            <div class="ps-tab" id="tab-4">
              <div class="ps-block--desposit">
                <div class="ps-block__header">
                  <h3><strong>All In One Account</strong></h3>
                  <div class="ps-block__actions">
                      <ul class="catListing clearfix">
                          <li id="catList1" class="selected"><a class="aboutpage" target="showContent-container-1" id="showContent-1">Interest</a></li>
                          <li id="catList2" class=""><a class="aboutpage" target="showContent-container-2" id="showContent-2">Placement</a></li>
                          <li id="catList3" class=""><a class="aboutpage" target="showContent-container-3" id="showContent-3">Tenor</a></li>
                      </ul>
                  </div>
                </div>
                <div class="productGridContainer target-content" id="showContent-container-1">
                    <div class="display_aio nav-outside owl-slider owl-carousel owl-theme owl-loaded" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-nav-left="<i class='fa fa-angle-left'></i>" data-owl-nav-right="<i class='fa fa-angle-right'></i>">
                            @php $i = 1; @endphp
                            @foreach($promotion_products as $products)
                                @if($products->promotion_type_id==ALL_IN_ONE_ACCOUNT && $i<=4)
                                        <div class="ps-block--short-product"><img
                                                    src="{{ asset($products->brand_logo) }}" alt="">
                                            <h4>up to <strong> {{ $products->maximum_interest_rate }}
                                                    %</strong></h4>

                                            <div class="ps-block__info">
                                                <p><strong> rate: </strong>1.3%</p>

                                                <p><strong>Min:</strong> SGD
                                                    ${{ $products->minimum_placement_amount }}</p>

                                                <p class="highlight">{{ $products->promotion_period }}
                                                    Months</p>
                                            </div>
                                            <a class="ps-btn" href="{{ url('fixed-deposit-mode') }}">More
                                                info</a>
                                        </div>
                                    @php $i++; @endphp
                                @endif

                            @endforeach
                    </div>
                </div>
              </div>
            </div>
            <div class="ps-tab" id="tab-5">
              <div class="ps-block--desposit">
                <div class="ps-block__header">
                  <h3><strong>Foreign Currency</strong></h3>
                  <div class="ps-block__actions">
                      <ul class="catListing clearfix">
                          <li id="catList1" class="selected"><a class="aboutpage" target="showContent-container-1" id="showContent-1">Interest</a></li>
                          <li id="catList2" class=""><a class="aboutpage" target="showContent-container-2" id="showContent-2">Placement</a></li>
                          <li id="catList3" class=""><a class="aboutpage" target="showContent-container-3" id="showContent-3">Tenor</a></li>
                      </ul>
                  </div>
                </div>
                <div class="productGridContainer target-content" id="showContent-container-1">
                    <div class="display_foreign_currency nav-outside owl-slider owl-carousel owl-theme owl-loaded" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="20" data-owl-nav="true" data-owl-dots="false" data-owl-item="4" data-owl-item-xs="1" data-owl-item-sm="2" data-owl-item-md="3" data-owl-item-lg="4" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-nav-left="<i class='fa fa-angle-left'></i>" data-owl-nav-right="<i class='fa fa-angle-right'></i>">
                            @php $i = 1; @endphp
                            @foreach($promotion_products as $products)
                                @if($products->promotion_type_id==FOREIGN_CURRENCY_DEPOSIT && $i<=4)
                                        <div class="ps-block--short-product"><img
                                                    src="{{ asset($products->brand_logo) }}" alt="">
                                            <h4>up to <strong> {{ $products->maximum_interest_rate }}
                                                    %</strong></h4>

                                            <div class="ps-block__info">
                                                <p><strong> rate: </strong>1.3%</p>

                                                <p><strong>Min:</strong> SGD
                                                    ${{ $products->minimum_placement_amount }}</p>

                                                <p class="highlight">{{ $products->promotion_period }}
                                                    Months</p>
                                            </div>
                                            <a class="ps-btn" href="{{ url('fixed-deposit-mode') }}">More
                                                info</a>
                                        </div>
                                    @php $i++; @endphp
                                @endif

                            @endforeach
                    </div>
                </div>
              </div>
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

                            <div class="ps-slider-navigation" data-slider="ps-slider--home-blog"><a class="ps-prev"
                                                                                                    href="javascript:void(0);"><i
                                            class="fa fa-caret-left"></i></a><a class="ps-next"
                                                                                href="javascript:void(0);"><i
                                            class="fa fa-caret-right"></i></a></div>
                        </div>
                        <div class="owl-slider owl-blog" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
                             data-owl-gap="0" data-owl-nav="false" data-owl-dots="false" data-owl-item="1"
                             data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1"
                             data-owl-duration="1000" data-owl-mousedrag="off">
                            @foreach($blogs as $blog)
                                <div class="ps-post--home">
                                    <div class="ps-post__thumbnail">
                                        <a class="ps-post__overlay" href="{{ url($blog->slug) }}"></a><img
                                                src="{{ asset($blog->blog_image) }}" alt="" height="250px">

                                        <div class="ps-post__posted"><span
                                                    class="date">{{ date("d", strtotime($blog->created_at)) }}</span><span
                                                    class="month">{{ date("M", strtotime($blog->created_at)) }}</span>
                                        </div>
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
                            <h3>Create an account to manage your wealth easily. <strong> It is free!</strong></h3><a
                                    class="ps-btn ps-btn--yellow" href="{{ url('login/facebook') }}"><i
                                        class="fa fa-facebook"></i> Signup with facebook</a><a
                                    class="ps-btn ps-btn--outline" href="{{ url('login/google') }}">Sign Up with
                                email</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("document").ready(function () {
            var owl = $('.owl-blog');
            owl.owlCarousel({
                loop: true,
                margin: 10,
                items: 1
            });
            $('.ps-next').click(function () {
                owl.trigger('next.owl.carousel');
            })
            $('.ps-prev').click(function () {
                owl.trigger('prev.owl.carousel', [300]);
            })
        });

        $(".ps-tab-list li").on("click", function() {
            $(".ps-tab-list li").removeClass("current");
            $(this).addClass("current");
        });
        $("a.aboutpage").on("click", function () {
            $("a.aboutpage").parent().removeClass("selected");
            $(this).parent().addClass("selected");
            var title = $(this).parents(".ps-block__header").find("h3 strong").text();
            var target = $(this).attr("target");
            $(this).parents(".ps-block__header").next().attr("id", target);
            
            $("input[name='deposit_type']").val(title);
            if (title == 'Fixed Deposit') {
                $(".view_all_types a").attr("href", '{{ url("fixed-deposit-mode") }}');
            }
            else if (title == 'Saving Deposit') {
                $(".view_all_types a").attr("href", '{{ url("saving-deposit-mode") }}');
            }
            else if (title == 'Wealth Deposit') {
                $(".view_all_types a").attr("href", '{{ url("wealth-deposit-mode") }}');
            }
            else if (title == 'All In One Account') {
                $(".view_all_types a").attr("href", '{{ url("all-in-one-deposit-mode") }}');
            }
            else if (title == 'Foreign Currency') {
                $(".view_all_types a").attr("href", '{{ url("foreign-currency-deposit-mode") }}');
            }
            else {
                $(".view_all_types a").attr("href", '{{ url("fixed-deposit-mode") }}');
            }
        });

        $.ajax({
            method: 'POST',
            url: '{{ route('deposit-type') }}',
            data: {type: 'Interest', promotion_type:'<?php echo FIX_DEPOSIT ; ?>'},
            cache: false,
            success: function (data) {
                //alert(data);
                $("div.display_fixed").html(data);
            }
        });
        $("a.aboutpage").on("click", function () {
            $("a.aboutpage").removeClass("active");
            $(this).addClass("active");
            var title = $("input[name='deposit_type']").val();
            var value = $(this).text();
            if (title == 'Fixed Deposit') {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('deposit-type') }}',
                    data: {type: value, promotion_type:'<?php echo FIX_DEPOSIT ; ?>'},
                    cache: false,
                    success: function (data) {
                        
                        $("div.display_fixed").html(data);
                    }
                });
            }

            else if (title == 'Saving Deposit') {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('deposit-type') }}',
                    data: {type: value, promotion_type:'<?php echo SAVING_DEPOSIT ; ?>'},
                    cache: false,
                    success: function (data) {
                        $("div.display_saving").html(data);
                    }
                });
            }
            else if (title == 'Wealth Deposit') {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('deposit-type') }}',
                    data: {type: value, promotion_type:'<?php echo WEALTH_DEPOSIT ; ?>'},
                    cache: false,
                    success: function (data) {
                        //alert(data);
                        $("div.display_fixed").html(data);
                    }
                });
            }
            else if (title == 'All In One Account') {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('deposit-type') }}',
                    data: {type: value, promotion_type:'<?php echo ALL_IN_ONE_ACCOUNT ; ?>'},
                    cache: false,
                    success: function (data) {
                        //alert(data);
                        $("div.display_fixed").html(data);
                    }
                });
            }
            else if (title == 'Foreign Currency') {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('deposit-type') }}',
                    data: {type: value, promotion_type:'<?php echo FOREIGN_CURRENCY_DEPOSIT ; ?>'},
                    cache: false,
                    success: function (data) {
                        //alert(data);
                        $("div.display_fixed").html(data);
                    }
                });
            }
            else {
                $.ajax({
                    method: 'POST',
                    url: '{{ route('deposit-type') }}',
                    data: 'type=Interest',
                    cache: false,
                    success: function (data) {
                        //alert(data);
                        $("div.display_fixed").html(data);
                    }
                });
            }
        });
    </script>
    {{--Blog section end--}}

    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}


@endsection
