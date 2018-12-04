@extends('frontend.layouts.app')
@section('content')
        <!-- Banner -->
<div class="banner-holder inner-banner no-img">
    <div class="clear"></div>
</div>
<!-- Banner END -->

<!-- Content Containers -->
<div class="main-container">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><strong>Profile</strong></li>
            </ul>
        </div>
    </div>
    {{--Error or Success--}}
    @include('frontend.includes.messages')
    {{--Error or Success message end--}}
    <div class="fullcontainer">
        <div class="container">
            <div class="inner-container md">
                <div class="title3">Account Settings</div>
                <div class="cart-content">
                    {!! Form::open(['url' => ['user/account-setting', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-2 control-label">First Name</label>

                                <div class="col-md-4">
                                    <div class="form-inner">
                                        <input class="form-control" name="first_name" value="{{$user->first_name}}"
                                               type="text" placeholder="First Name">
                                        @if ($errors->has('first_name'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <label class="col-md-2 control-label">Last Name</label>

                                <div class="col-md-4">
                                    <input class="form-control" name="last_name" value="{{$user->last_name}}"
                                           type="text" placeholder="Last Name">
                                    @if ($errors->has('last_name'))
                                        <span class="text-danger">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Email Address</label>

                                <div class="col-md-10">
                                    <input class="form-control" name="email" type="text" value="{{$user->email}}"
                                           disabled>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Telephone Number</label>

                                <div class="col-md-4">
                                    <div class="form-inner">
                                        <input class="form-control" type="text" name="tel_phone"
                                               value="{{$user->tel_phone}}">
                                        @if ($errors->has('tel_phone'))
                                            <span class="text-danger">
                                        <strong>{{ $errors->first('tel_phone') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <label class="col-md-2 control-label">Company</label>

                                <div class="col-md-4">
                                    <input class="form-control" type="text" name="company" value="{{$user->company}}"
                                           disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Shipping Address</label>

                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="shipping_address"
                                           value="{{$user->shipping_address}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Billing Address</label>

                                <div class="col-md-10">
                                    <input class="form-control" type="text"
                                           value="{{$user->billing_address}}" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-10 ">
                                    <input type="hidden" name="subscribe" value=off>
                                    <input type="checkbox" class=" " name="subscribe" value=1
                                           @if($user->subscribe == 1) checked @endif id="C1">
                                    <label for="C1" class="control-label ">Would you like to receive promotional emails
                                        from us?</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{Form::hidden('_method','PUT')}}

                    <div class="summary-footer">
                        <button type="submit" class="button fright">Submit</button>
                        <div class="clear"></div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Containers END -->
<div class="clear"></div>
<div class="pushContainer"></div>
<div class="clear"></div>
@endsection