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
                            <h3>Forgot Your Password?</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/user.png" alt="">Forgot Password</h5>
                                </div>
                                <div class="ps-block__content">
                                    {!! Form::open(['route' => ['forgot-password'], 'method'   => 'POST']) !!}
                                    <p>
                                        <strong>E-Mail Address</strong>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >
                                    </p>
                                    <button type="submit" class="btn btn-success">Send Email</button>
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
