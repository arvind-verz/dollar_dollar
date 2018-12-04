@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')



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
                <li><a href="{{ route('blog-list') }}"> Blog Main Page</a></li>
                <li><a href="{{ route('get-blog-by-category',['id'=>$page->menu_id]) }}">{{$page->menu_title}}</a></li>
                @include('frontend.includes.breadcrumb')
            </ol>
        </div>
    </div>

    {{--Page content start--}}
    <main class="ps-main">
        <div class="container">

            <div class="col-lg-8 col-md-12{{-- col-lg-push-5--}}">
                <div class="ps-post__thumbnail sp-only"><img src="{{ asset($page->blog_image) }}" alt=""></div>
                <div class="ps-post--detail">
                    <div class="ps-post__header">
                        <h3>{{$page->name}}</h3><span class="ps-post__meta"><a
                                    href="{{ url('get-blog-by-category/' . $page->menu_id)}}"> {{$page->menu_title}}</a></span>
                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_inline_share_toolbox"></div>
                    </div>
                    <div class="ps-post__content ps-document">
                        {!!  $page->contents!!}
                    </div>
                    <div class="ps-post__footer">
                        @if(count($tags))
                            <p>
                                <span>Tags:</span>
                                @foreach($tags as $tag)
                                    <a href="{{'tags/'.$tag->title}}">{{$tag->title}}</a>
                                @endforeach
                            </p>
                        @endif
                    </div>
                </div>
                @include('frontend.includes.horizontal-ads')
            </div>
            <div class="col-lg-4 col-md-12 {{--col-lg-pull-7--}}">
                <div class="ps-post--feature">
                    <div class="ps-post__thumbnail pc-only"><img src="{{ asset($page->blog_image) }}" alt=""></div>
                    @if(count($relatedBlog))
                        @foreach($relatedBlog as $blog)
                            @php $short_description = substr($blog->short_description, 0, 70).'...'; @endphp
                            <div class="ps-block--feature">
                                <div class="ps-block__thumbnail"><img src="{{ asset($blog->blog_image) }}" alt=""></div>
                                <div class="ps-block__content">
                                    <h4><a href="{{ url($blog->slug)}}">{{$blog->name}}</a></h4>

                                    <p>{!!  $short_description !!}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    @include('frontend.includes.vertical-ads')
                    <div class="ps-fanpage">
                        <div class="fb-page" data-href="https://www.facebook.com/dollardollar.sg/"
                             data-tabs="timeline" data-width="500" data-height="280" data-small-header="false"
                             data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/dollardollar.sg/"
                                        class="fb-xfbml-parse-ignore"><a
                                        href="https://www.facebook.com/dollardollar.sg/">DollarDollar</a>
                            </blockquote>
                        </div>
                    </div>

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
