<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!--The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags-->
    <meta name="author" content="">
    @yield('og')
    <meta property="og:type" content="website"/>
    <link rel="shortcut icon" type="image/ico" href="{{ asset('favicon.ico') }}"/>
    <link rel="apple-touch-icon" type="image/ico" href="{{ asset('favicon.png') }}"/>
    <link href="{{ asset('images/favicon.ico') }}" rel="icon">
    <title>Speedo Marine (Pte) Ltd.</title>
    {{--<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">--}}

    <link href="{{ asset('frontend/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/jcon-font.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/owl.carousel.css') }}" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="{{ asset('frontend/js/html5.js') }}"></script>
    <![endif]-->


    <script type="text/javascript" src="{{ asset('frontend/js/respond.min.js') }}"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/jquery.meanmenu.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/owl.carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/plugins.js') }}"></script>

    <link href="{{ asset('frontend/css/bootstrap-select.min.css') }}" rel="stylesheet">

    <script type="text/javascript" src="{{ asset('frontend/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/js/typeahead.bundle.js') }}"></script>

    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1M-BnSt4XemrZLcrBFpQeiNN_wyZTBBo&region=GB"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    {{--<link rel="stylesheet" href="{{ URL::to('backend/assets/glyphicons/glyphicons.css') }}" type="text/css"/>--}}
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('frontend/css/responsive.css') }}" rel="stylesheet" type="text/css">

</head>
<div id="wrapper">
    <?php
    $slug = REGISTER_SLUG;
    //get banners
    $banners = Helper::getBanners($slug);
    //dd($banners);
    ?>

    <div class="lg-left">
        <div class="tp-btn-holder">
            <a href="{{ url('/login') }}" class="tp-btn active"><img src="{{asset('images/icon4.png')}} "
                                                                     alt=""><strong>Login</strong>Access your
                account</a>
            <a href="{{ url('/register') }}" class="tp-btn "><img src="{{asset('images/icon5.png')}}" alt=""><strong>Register</strong>Create
                your account</a>

            <div class="clear"></div>
        </div>
        <div class="grid-tb">
            <div class="grid-tc">
                <div class="title7 text-center"><strong>Create</strong> your account</div>
                <div class="form-horizontal register-form">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-inner">
                                    <input id="first_name" type="text" class="rg-input" name="first_name"
                                           value="@if (old('first_name')) {{old('first_name')  }} @endif"
                                           placeholder="First Name *">
                                    @if ($errors->has('first_name'))
                                        <span class="text-danger">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <input id="last_name" type="text" class="rg-input" name="last_name"
                                       value="{{ old('last_name') }}" placeholder="Last Name *">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="email" type="text" class="rg-input" name="email" value="{{ old('email') }}"
                                       placeholder="Email Address *">
                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="password" type="password" class="rg-input" name="password"
                                       placeholder="Password *">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="rg-input"
                                       name="password_confirmation" placeholder="Confirm Password *">
                                @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="tel_phone" type="text" class="rg-input" name="tel_phone"
                                       value="{{ old('tel_phone') }}" placeholder="Contact Number">
                                @if ($errors->has('tel_phone'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('tel_phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="company" type="text" class="rg-input" name="company"
                                       value="{{ old('company') }}" placeholder="Company">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center">All fields marked with an asterisk (<span
                                        class="red">*</span>) are required
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="checkbox checkbox-alt">
                                    <input type="hidden" name="subscribe" value=off>
                                    <input type="checkbox" name="subscribe" value=1
                                           {{ old('subscribe') ? 'checked' : '' }} id="C1">

                                    <label for="C1">Would you like to receive promotional emails from us?</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb0">
                            <div class="col-md-12">
                                <button type="submit" class="button btn-light-alt btn-block">create account</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($banners)
        @foreach($banners as $banner)
            <div class="lg-right bg-img" style="background-image:url({!!asset($banner->banner_image )!!});">
                <div class="grid-tb">
                    <div class="grid-tc">
                        <div class="lg-info">
                            <h2>{!!$banner->title!!}</h2>

                            <p style="color: {!!$banner->banner_content_color!!} !important;">{!!$banner->banner_content!!}</p>
                            <a href="{{ url('/') }}" class="button btn-bdr bdr-white">Return to
                                Home</a></div>
                    </div>
                </div>
            </div>
@endforeach
@endif
