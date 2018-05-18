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
                <li><strong>Change Password</strong></li>
            </ul>
        </div>
    </div>
    {{--Error or Success--}}
    @include('frontend.includes.messages')
    {{--Error or Success message end--}}
    <div class="fullcontainer">
        <div class="container">
            <div class="inner-container md">
                <div class="title3">Change Password</div>
                <div class="cart-content">
                    {!! Form::open(['url' => ['user/change-password', $user->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div>
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Password</label>

                                <div class="col-md-10">
                                    <div class="form-inner">
                                        <input class="form-control" type="password" name="password"
                                               placeholder="Password">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Confirm Password</label>

                                <div class="col-md-10">
                                    <input class="form-control" name="password_confirmation" type="password"
                                           placeholder="Confirm Password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
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