@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')

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
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                    <div class="ps-sidebar">
                        <h3 class="ps-heading"><span> My </span> Account</h3>
                        <ul class="ps-list--sidebar">
                            <li class="current"><a href="{{ url('profile-dashboard') }}">My Profile Dashboard</a></li>
                            <li><a href="{{ url('account-information') }}">Account Information</a></li>
                            <li><a href="{{ url('product-management') }}">Product Management</a></li>
                        </ul>
                        <div class="pt-2">
                            <a href="{{ isset($banners[0]->banner_link) ? asset($banners[0]->banner_link) : '' }}" target="_blank"><img src="{{ isset($banners[0]->banner_image) ? asset($banners[0]->banner_image) : '' }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>My Profile Dashboard</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            <p>Hello, <strong> {{ AUTH::user()->first_name }}</strong></p>
                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/user.png" alt="">Account Information</h5>
                                </div>
                                <div class="ps-block__content">
                                    <h5>Contact Information</h5>
                                    <p><strong> Name: </strong> {{ AUTH::user()->first_name }}</p>
                                    <p><strong> Email: </strong><a href="#">{{ AUTH::user()->email }}</a></p>
                                </div>
                            </div>
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
