@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
    <?php
    $slug = CONTACT_SLUG;
    //get banners
    $banners = Helper::getBanners($slug);
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
            <h3 class="ps-heading mb-35"><span> Contact</span> us</h3>

            {!! Form::open(['url' => ['post-contact-enquiry'], 'class'=>'ps-form--enquiry ps-form--health-insurance', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 ">
                    <div class="ps-form__content">
                        <div class="form-group">
                            <label>Fullname</label>

                            <div class="form-icon"><i class="fa fa-user"></i>
                                <input class="form-control" type="text" name="full_name" placeholder="Enter Name Here"
                                       value="@if (Auth::user()){{Auth::user()->first_name.' '.Auth::user()->last_name}}@else {{old('full_name')}} @endif">
                            </div>
                            @if ($errors->has('full_name'))
                                <span class="text-danger">
                                                    <strong>{{ $errors->first('full_name') }}</strong>
                                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Email</label>

                            <div class="form-icon"><i class="fa fa-envelope"></i>
                                <input class="form-control" type="text" name="email"
                                       value="@if (Auth::user()){{Auth::user()->email}}@else {{old('email')}} @endif"
                                       placeholder="Enter Email Address Here">
                            </div>
                            @if ($errors->has('email'))
                                <span class="text-danger">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>

                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-icon"><i class="fa fa-globe"></i>
                                        <input class="form-control" type="text" placeholder="+65" name="country_code">
                                    </div>
                                    @if ($errors->has('country_code'))
                                        <span class="text-danger">
                                                    <strong>{{ $errors->first('country_code') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="col-xs-9">
                                    <div class="form-icon"><i class="fa fa-mobile-phone"></i>
                                        <input class="form-control only_numeric" type="text" placeholder="Enter Mobile Number"
                                               name="telephone"
                                               value="@if (Auth::user()){{Auth::user()->tel_phone}}@else{{old('telephone')}}@endif">

                                    </div>
                                    @if ($errors->has('telephone'))
                                        <span class="text-danger">
                                                    <strong>{{ $errors->first('telephone') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input class="form-control" type="text" placeholder="Enter Subject Here" name="subject"
                                   value="{{old('subject')}}">
                            @if ($errors->has('subject'))
                                <span class="text-danger">
                                                    <strong>{{ $errors->first('subject') }}</strong>
                                                    </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea cols="" rows="" class="form-control sm"
                                      name="message">{{old('message')}}</textarea>
                            @if ($errors->has('message'))
                                <span class="text-danger">
                                                    <strong>{{ $errors->first('message') }}</strong>
                                                    </span>
                            @endif
                        </div>
                        <div class="form-group recaptcha">{!! app('captcha')->display($attributes = [],
                                                   $lang = []) !!}
                            <span class="captcha-err"></span>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                            @endif</div>
                        <div class="form-group">
                            <button type="submit" class="ps-btn">Submit</button>
                        </div>
                    </div>
                </div>

                {!!$page->contents!!}

            </div>
            {!! Form::close() !!}
        </div>
    </main>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
