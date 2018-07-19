<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dollar Dollar</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
@php
    //Register page id is 1
    $id=null;
    //get banners
    $banners=Helper::getBanners($id);
    //dd($banners);

    @endphp
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

                        <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group">
                            <div class="col-md-12">
                                <input id="email" type="text" class="rg-input form-control" name="email" value="{{ old('email') }}"
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
                                <input id="password" type="password" class="rg-input form-control" name="password"
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
                                <input id="password-confirm" type="password" class="rg-input form-control"
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
                                <button type="submit" class="button btn-primary btn-block"> Reset Password</button>
                            </div>
                        </div>

                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
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
    </div>
</body>
</html>
