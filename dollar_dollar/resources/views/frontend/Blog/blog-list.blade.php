@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
<?php //dd($id); ?>
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

    <div class="ps-breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li><a href="{{ route('index') }}"><i class="fa fa-home"></i> Home</a></li>
                @include('frontend.includes.breadcrumb')
            </ol>
        </div>
    </div>

    {{--Page content start--}}
    <main class="ps-main">
        <div class="container">
            <div class="row">
                @include('frontend.includes.blog-sidebar')
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <?php //dd($details); ?>
                    @if($details->count())
                        @foreach($details as $detail)
                            <?php //dd($detail); ?>
                            <div class="ps-post">
                                <div class="ps-post__thumbnail"><a class="ps-post__overlay"
                                                                   href="{{ url($detail->slug) }}"></a><img
                                            src="{{ asset($detail->blog_image) }}" alt=""></div>
                                <div class="ps-post__content"><a class="ps-post__title"
                                                                 href="{{ url($detail->slug) }}">{{$detail->name}}</a>
                                    <span class="ps-post__meta">{{$detail->menu_title}}</span>

                                    <p>{!! $detail->short_description !!}</p><a class="ps-post__morelink ps-btn"
                                                                                href="{{ url($detail->slug) }}">Read
                                        More</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {{ $details->links() }}
                </div>
            </div>
        </div>
    </main>

    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
