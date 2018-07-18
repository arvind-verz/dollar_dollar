<?php
    $slug = LOGIN_SLUG;
     $page = DB::table('pages')->LeftJoin('menus', 'menus.id', '=', 'pages.menu_id')
            ->where('pages.slug', $slug)
            ->where('pages.delete_status', 0)
            ->where('pages.status', 1)
            ->select('pages.*', 'menus.title as menu_title', 'menus.id as menu_id')
            ->first();
        //dd(DB::getQueryLog())
        if (!$page) {
            return redirect(url('/'))->with('error', "Opps! page not found");
        } else {
            $systemSetting = \Helper::getSystemSetting();
            if (!$systemSetting) {
                return back()->with('error', OPPS_ALERT);
            }
        }
    
?>
@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
    <?php
     
   
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
    @if(count($errors) > 0)
    <div class="col-md-12">
        <div class="box-body">
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4>
                @foreach($errors->all() as $error)
                    <p>
                        {!!  $error !!}
                    </p>
                @endforeach

            </div>
        </div>
    </div>
    @endif
    <main class="ps-main">
        <div class="container">
            <h3 class="ps-heading mb-35"><span> Login </span> to your account</h3>

            {!! Form::open(['route' => ['login'], 'class'=>'ps-form--login ps-form--contact', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 ">
                    <div class="ps-form__content">
                        <div class="form-group">
                            <label>Email</label>
                            <div class="form-icon"><i class="fa fa-envelope"></i>
                                <input class="form-control" type="text" name="email" placeholder="Enter Email Address Here">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="form-icon"><i class="fa fa-lock"></i>
                                <input class="form-control" type="password" name="password" placeholder="Enter Password Here">
                            </div>
                        </div>
                        <div class="form-group actions">
                            <div class="ps-checkbox ps-checkbox--inline">
                                <input class="form-control" type="checkbox" id="remember" name="remember" />
                                <label for="remember">Remember Me</label>
                            </div><a href="{{ route('password.request') }}">Forgot password</a>
                        </div>
                       <div class="form-group recaptcha">{!! app('captcha')->display($attributes = [],
                                                   $lang = []) !!}
                                <span class="captcha-err"></span>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                @endif</div>
                        <div class="form-group submit">
                            <div class="row">
                                <div class="col-xs-6">
                                    <button type="submit" class="ps-btn">Login</button>
                                </div>
                                <div class="col-xs-6"><a class="ps-btn ps-btn--outline" href="{{ url('registration') }}">Signup</a></div>
                            </div><a class="ps-btn ps-btn--blue" href="{{ url('login/facebook') }}">Connect with Facebook</a>
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
