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
                        <h3 class="ps-heading"><span> My </span> Account</h3>
                        <ul class="ps-list--sidebar">
                            <li><a href="{{ url('profile-dashboard') }}">My Profile Dashboard</a></li>
                            <li class="current"><a href="{{ url('account-information') }}">Account Information</a></li>
                            <li><a href="{{ url('product-management') }}">Product Management</a></li>
                        </ul>
                        @if(count($ads))
                        <div class="pt-2">
                            <a href="{{ isset($ads->ad_link) ? asset($ads[0]->ad_link) : '#' }}" target="_blank"><img src="{{ asset($ads[0]->ad_image) }}" alt=""></a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>Account Information</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            <p>Hello, <strong> {{ AUTH::user()->first_name }}</strong></p>
                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/user.png" alt="">Account Information</h5>
                                </div>
                                <div class="ps-block__content">
                                    {!! Form::open(['route' => ['account-information.update', AUTH::user()->id], 'method'   => 'POST']) !!}
                                    <h5>Contact Information</h5>
                                    <p><strong> Email: </strong> <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{ AUTH::user()->email }}"></p>
                                    <p><strong> First Name: </strong> <input type="text" class="form-control" name="first_name" placeholder="Enter first name" value="{{ AUTH::user()->first_name }}"></p>
                                    <p><strong> Last Name: </strong><input type="text" class="form-control" name="last_name" placeholder="Enter last name" value="{{ AUTH::user()->last_name }}"></p>
                                    
                                    <p><strong> Contact Number: </strong><input type="text" class="form-control only_numeric" name="tel_phone" placeholder="Enter contact number" value="{{ AUTH::user()->tel_phone }}"></p>
                                    <!-- <p><strong> Privacy: </strong>
                                        <select class="form-control" name="privacy">
                                                <option value="1" @if(1==AUTH::user()->notification) selected  @endif>DOD</option>
                                                <option value="2" @if(2==AUTH::user()->notification) selected @endif>Anytime</option>
                                                <option value="3" @if(3==AUTH::user()->notification) selected @endif>Occasionally</option>
                                            </select>
                                    </p> -->
                                    <p><strong> Email Notification for newsletter: </strong><input type="checkbox" class="form-control" name="email_notification" @if(AUTH::user()->email_notification==1) checked @endif></p>
                                    <p><strong> Allow a financial adviser to contact you: </strong><input type="checkbox" class="form-control" name="adviser" @if(AUTH::user()->adviser==1) checked @endif></p>
                                    <button type="submit" class="btn btn-success">Save</button>
                                    {!! Form::close() !!}
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
