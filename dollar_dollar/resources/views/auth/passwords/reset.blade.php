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
    @php
    //Register page id is 1
    $id=6;
    //get banners
    $banners=Helper::getBanners($id);
    //dd($banners);

    @endphp

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
                {{--Error or Success--}}
                @include('frontend.includes.messages')
                {{--Error or Success message end--}}
                <div class="title7 text-center"><strong>Reset</strong> your Password?</div>
                <div class="login-form">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

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
                                       placeholder="New Password *">
                                @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="rg-input"
                                       name="password_confirmation" placeholder="Confirm New Password *">
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb0">
                            <div class="col-md-12">
                                <button type="submit" class="button btn-light-alt btn-block"> Reset Password</button>
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
                            <a href="{{ url($banner->banner_link) }}" class="button btn-bdr bdr-white">Return to
                                Home</a></div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
</html>

