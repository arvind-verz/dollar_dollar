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
                    @if(isset($menu))
                        <li><a href="{{ route('blog-list') }}"> Blog Main Page</a></li>
                        <li class="active">{{$menu->title}}</li>
                    @else
                        <li class="active">Blog Main Page</li>
                    @endif
                </ol>
        </div>
    </div>

    {{--Page content start--}}
    @include('frontend.includes.messages')
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
                                <div class="ps-post__thumbnail">
                                     @if($detail->blog_image)
                                    <a class="ps-post__overlay" href="{{ url($detail->slug) }}"></a>
                                                                  <img src="{{ asset($detail->blog_image) }}" alt="">
                                                                   @endif
                                                                   </div>
                                <div class="ps-post__content"><a class="ps-post__title"
                                                                 href="{{ url($detail->slug) }}">{{$detail->name}}</a>
                                    <span class="ps-post__meta"><a
                                                href="{{ url('get-blog-by-category/' . $detail->menu_id)}}">{{$detail->menu_title}}</a></span>

                                    <div class="ps-post-text"><?php
                                        $string = strip_tags($detail->short_description);
                                        if (strlen($string) > 300) {
                                        $stringCut = substr($string, 0, 300);
                                        $endPoint = strrpos($stringCut, ' ');
                                        $string = $endPoint? substr($stringCut, 0, $endPoint):substr($stringCut, 0);
                                        }
                                    ?>
                                    {{$string}}..<a class="ps-link " href="{{ url($detail->slug) }}">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {{ $details->links() }}
                        @include('frontend.includes.vertical-ads-sp-only')
                        <div class="mb-20"></div>
                        @include('frontend.includes.horizontal-ads')
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
