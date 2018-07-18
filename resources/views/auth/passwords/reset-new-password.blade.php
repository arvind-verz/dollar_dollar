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
    <title>Dollar Dollar</title>
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
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Reset Password</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('user.password.email') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</html>

