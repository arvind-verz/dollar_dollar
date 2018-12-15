<?php
$details = \Helper::get_page_detail(FORGOT_PASSWORD_RESET);
$brands = $details['brands'];
$page = $details['page'];
$systemSetting = $details['systemSetting'];
$banners = $details['banners'];
?>
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
   <!-- @if(count($errors) > 0)
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
    @endif-->
    @if(session('status'))
        <div class="col-md-12">
            <div class="box-body">
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    <p>
                        {!! session('status') !!}
                    </p>
                </div>
            </div>
        </div>
    @endif
    <main class="ps-main">
        <div class="container">
            <div class="row">

                <div class="  col-lg-offset-2  col-md-offset-2  col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>Change your password</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/user.png" alt="">Change password</h5>
                                </div>
                                <div class="ps-block__content">
                                    {!! Form::open(['route' => ['forgot-password-reset'], 'method'   => 'POST']) !!}
                                    <input type="hidden" name="token" value="{{$token}}">

                                    <p><strong> Email Address : </strong><input type="text" class="form-control"
                                                                              name="email"
                                                                              placeholder=""
                                                                              value="{{ old('email') }}">
                                                                               @if ($errors->has('email'))
                                        <span class="text-danger">
                                            <strong>
                                                {{ $errors->first('email') }}
                                            </strong>
                                        </span>
                                        @endif
                                                                              </p>

                                    <p><strong> New Password: </strong><input type="password" class="form-control"
                                                                              name="password"
                                                                              placeholder=""
                                                                              value="{{ old('password') }}">
                                                                               @if ($errors->has('password'))
                                        <span class="text-danger">
                                            <strong>
                                                {{ $errors->first('password') }}
                                            </strong>
                                        </span>
                                        @endif
                                                                              </p>

                                    <p><strong> Confirm Password: </strong><input type="password"
                                                                                  class="form-control"
                                                                                  name="confirm_password"
                                                                                  placeholder=""
                                                                                  value="">
                                                                                  @if ($errors->has('confirm_password'))
                                        <span class="text-danger">
                                            <strong>
                                                {{ $errors->first('confirm_password') }}
                                            </strong>
                                        </span>
                                        @endif
                                                                                  </p>
                                    <button type="submit" class="btn btn-success">Change my password</button>
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
