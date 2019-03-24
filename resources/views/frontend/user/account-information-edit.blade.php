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
                            <p>Hello, <strong> {{ AUTH::user()->first_name . ' ' . AUTH::user()->last_name }}</strong></p>

                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="/img/icons/user.png" alt="">Account Information</h5>
                                </div>
                                <div class="ps-block__content">
                                    {!! Form::open(['route' => ['account-information.update', AUTH::user()->id], 'method'   => 'POST']) !!}
                                    <h5>Contact Information</h5>

                                    <p><strong> Email: </strong> <input type="email" class="form-control" name="email"
                                                                        placeholder="Enter email"
                                                                        value="{{ AUTH::user()->email }}"></p>

                                    <p><strong> First Name: </strong> <input type="text" class="form-control"
                                                                             name="first_name"
                                                                             placeholder="Enter first name"
                                                                             value="{{ AUTH::user()->first_name }}"></p>

                                    <p><strong> Last Name: </strong><input type="text" class="form-control"
                                                                           name="last_name"
                                                                           placeholder="Enter last name"
                                                                           value="{{ AUTH::user()->last_name }}"></p>

                                    <p><strong> Contact Number: </strong>

                                    <div class="col-xs-2 pl-0">
                                        <input type="text" class="form-control" name="country_code" placeholder="+65"
                                               value="{{ isset(AUTH::user()->country_code) ? AUTH::user()->country_code : '+65' }}">
                                    </div>
                                    <div class="col-xs-10 pr-0">
                                        <input type="text" class="form-control only_numeric" name="tel_phone"
                                               placeholder="Enter contact number" value="{{ AUTH::user()->tel_phone }}">
                                    </div>
                                    </p>
                                    <!-- <p><strong> Privacy: </strong>
                                        <select class="form-control" name="privacy">
                                                <option value="1" @if(1==AUTH::user()->notification) selected  @endif>DOD</option>
                                                <option value="2" @if(2==AUTH::user()->notification) selected @endif>Anytime</option>
                                                <option value="3" @if(3==AUTH::user()->notification) selected @endif>Occasionally</option>
                                            </select>
                                    </p> -->
                                    {!! Form::hidden('location', isset($location) ? $location : '')  !!}
                                    <p><strong> Subscribe to our weekly newsletter </strong><input type="checkbox"
                                                                                                   class="form-control" value="1"
                                                                                                   name="email_notification"
                                                                                                   @if(AUTH::user()->email_notification==1) checked @endif>
                                    </p>

                                    <p><input type="checkbox" class="form-control" name="adviser" value="1"
                                              @if(AUTH::user()->adviser==1) checked @endif><strong> I would like to be
                                            informed of products, services, offers provided by dollardollar.sg and it’s
                                            business partners. I have consent to have marketing information sent to me
                                            via the various communication (SMS, voice call and emails). </strong></p>
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
