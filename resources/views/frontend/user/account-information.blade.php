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
    @include('frontend.includes.messages')
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
                        <ul class="ps-list--sidebar">
                            <li><a href="{{ url('profile-dashboard') }}">Profile Dashboard</a></li>
                            <li class="current"><a href="{{ url('account-information') }}">Profile Information</a></li>
                            <li><a href="{{ url('product-management') }}">Product Management</a></li>
                        </ul>
                       @include('frontend.includes.vertical-ads-profile')
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>Profile Information</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            <p>Hello, <strong>  {{ AUTH::user()->first_name . ' ' . AUTH::user()->last_name }}</strong></p>

                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/user.png" alt="">Account Information</h5><a
                                            href="{{ route('account-information.edit', ['id'    =>  AUTH::user()->id, 'location' => 'account-information']) }}">Edit</a>
                                </div>
                                <div class="ps-block__content">
                                    <h5>Contact Information</h5>

                                    <p><strong>
                                            Name: </strong> {{ AUTH::user()->first_name . ' ' . AUTH::user()->last_name }}
                                    </p>

                                    <p><strong> Email: </strong><a href="#">{{ AUTH::user()->email }}</a></p>
                                    <p><strong> Newsletter: </strong><a href="#">@if(AUTH::user()->email_notification==1) Yes @else No @endif</a></p>
                                    <p><strong> Consent to marketing information: </strong><a href="#">@if(AUTH::user()->adviser==1) Yes @else No @endif</a></p>
                                    <a
                                            class="ps-link"
                                            href="{{ route('user.resetpassword', ['id'    =>  AUTH::user()->id]) }}">Change
                                        password</a>
                                </div>
                            </div>
                            @include('frontend.includes.horizontal-ads')
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
