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
            <h3 class="ps-heading mb-35"><span> Register </span> to DollarDollar.sg</h3>

            {!! Form::open(['url' => ['post-contact-enquiry'], 'class'=>'ps-form--contact ps-form--register', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 ">
                    <div class="ps-form__content">
                        <div class="form-group">
                            <label>Salutation</label>
                            <select class="form-control">
                                <option value="Mr.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Miss.">Miss.</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>First Name</label>
                            <input class="form-control" name="first_name" type="text" placeholder="Enter Name Here" value="{{ old('first_name') }}">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input class="form-control" name="last_name" type="text" placeholder="Enter Last Name Here" value="{{ old('last_name') }}">
                        </div>
                        <div class="form-group">
                            <label>Email Address</label>
                            <input class="form-control" type="email" name="email" placeholder="Enter Last Name Here" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label>Contact Number <span class="optional">(Optional)</span></label>
                            <input class="form-control" type="text" name="contact" placeholder="Enter Contact Number" value="{{ old('contact') }}">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password" placeholder="Enter Password Here">
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input class="form-control" type="password" name="confirm_password" placeholder="Confirm Password Here">
                        </div>
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
