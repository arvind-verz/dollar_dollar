@extends('frontend.layouts.app')
@section('description')
    <meta name="description" content="{{$page->meta_description}}">
@endsection
@section('keywords')
    <meta name="keywords" content="{{$page->meta_keyword}}">
@endsection
@section('author')
    <meta name="author" content="{{$page->meta_title}}">
@endsection
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
    @include('frontend.includes.messages')
    
    <main class="ps-main">
        <div class="container">
            <h3 class="ps-heading mb-35"><span> Register to DollarDollar.sg </span></h3>

            {!! Form::open(['route' => ['registration-add'], 'class'=>'ps-form--contact ps-form--register', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 ">
                    <input type="hidden" name="redirect_url" value="{{ isset($redirect_url) ? $redirect_url : '/home' }}">
                    <div class="ps-form__content">
                        <div class="form-group">
                            <label>Salutation</label>
                            <select class="form-control" name="salutation">
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Miss.">Miss.</option>
                            </select>
                            @if ($errors->has('salutation'))
                            <span class="text-danger">
                                <strong>
                                    {{ $errors->first('salutation') }}
                                </strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" name="first_name" type="text" placeholder="Enter Name Here" value="{{ old('first_name') }}">
                            @if ($errors->has('first_name'))
                            <span class="text-danger">
                                <strong>
                                    {{ $errors->first('first_name') }}
                                </strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" name="last_name" type="text" placeholder="Enter Last Name Here" value="{{ old('last_name') }}">
                            @if ($errors->has('last_name'))
                            <span class="text-danger">
                                <strong>
                                    {{ $errors->first('last_name') }}
                                </strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" type="email" name="email" placeholder="Enter Last Name Here" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <span class="text-danger">
                                <strong>
                                    {{ $errors->first('email') }}
                                </strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Contact Number <span class="optional">(Optional)</span></label>
                            <input class="form-control only_numeric" type="text" name="contact" placeholder="Enter Contact Number" value="{{ old('contact') }}">
                             @if ($errors->has('contact'))
                            <span class="text-danger">
                                <strong>
                                    {{ $errors->first('contact') }}
                                </strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Password <span class="optional">(Min. 8 characters)</span></label>
                            <input class="form-control" type="password" name="password" placeholder="Enter Password Here">
                           @if ($errors->has('password'))
                            <span class="text-danger">
                                <strong>
                                    {{ $errors->first('password') }}
                                </strong>
                            </span>
                            @endif  
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password Here">
                           @if ($errors->has('confirm_password'))
                                        <span class="text-danger">
                                            <strong>
                                                {{ $errors->first('confirm_password') }}
                                            </strong>
                                        </span>
                                        @endif
                        </div>
                        <div class="form-group recaptcha">
                            <label></label>
                            {!! app('captcha')->display($attributes = [],
                            $lang = []) !!}
                            <span class="captcha-err">
                            </span>
                            @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">
                                <strong>
                                    {{ $errors->first('g-recaptcha-response') }}
                                </strong>
                            </span>
                            @endif
                        </div>
                    
                        <!-- <div class="checkbox">
                            <label><input type="checkbox" name="notification"> Do you like to receive product notifications?</label>
                        </div> -->
                        <div class="checkbox">
                            <label><input type="checkbox" name="email_notification" checked="checked"> Subscribe to our weekly newsletter</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="adviser" checked="checked"> I would like to be informed of products, services, offers provided by dollardollar.sg and it’s business partners. I have consent to have marketing information sent to me via the various communication (SMS, voice call and emails).</label>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="ps-btn">Sign Up</button>
                            <a class="ps-btn ps-btn--blue p_facebook" href="@if(isset($redirect_url)) {{ route('social-login',['provider'=>'facebook','redirect_url'=>$redirect_url]) }} @else {{ url('login/facebook') }} @endif" style="color: #ffffff !important;"><i class="fab fa-facebook-f pr-10"></i> Connect with Facebook</a>
                        </div>
                        <div class="form-group">
                            <p>By signing up I agree to DollarDollar.sg’s <a href="{{ url('terms-and-condition') }}" target="_blank" class="important-underline">Term of Use</a> and <a href="{{ url('privacy-policy') }}" target="_blank" class="important-underline">Privacy Policy</a></p>
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
