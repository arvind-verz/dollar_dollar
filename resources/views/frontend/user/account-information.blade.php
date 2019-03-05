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
                            <p>Hello, <strong>  {{ AUTH::user()->first_name . ' ' . AUTH::user()->last_name }}</strong>
                            </p>

                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="/img/icons/user.png" alt="">Account Information</h5><a
                                            href="{{ route('account-information.edit', ['id'    =>  AUTH::user()->id, 'location' => 'account-information']) }}">Edit</a>
                                </div>
                                <div class="ps-block__content">
                                    <h5>Contact Information</h5>

                                    <p><strong>
                                            Name: </strong> {{ AUTH::user()->first_name . ' ' . AUTH::user()->last_name }}
                                    </p>

                                    <p><strong> Email: </strong>{{ AUTH::user()->email }}</p>

                                    <p><strong> Contact
                                            Number: </strong> {{ AUTH::user()->country_code . ' ' . AUTH::user()->tel_phone }}
                                    </p>

                                    <p><strong> Newsletter: </strong>@if(AUTH::user()->email_notification==1) Yes @else
                                            No @endif</p>

                                    <p><strong> Consent to marketing information: </strong>@if(AUTH::user()->adviser==1)
                                            Yes @else No @endif</p>

                                    <p><a
                                                class="ps-link"
                                                href="{{ route('user.resetpassword', ['id'    =>  AUTH::user()->id]) }}">Change
                                            password</a></p>

                                    <p><a href="" class="ps-link" data-toggle="modal" data-target="#myModalUser">
                                            Deactivate /
                                            Delete account </a>
                                    </p>
                                </div>
                            </div>
                            @include('frontend.includes.vertical-ads-profile')
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
    <div id="myModalUser" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are you sure?</h4>
                </div>
                {!! Form::open(['route' => ['account-information-delete', AUTH::user()->id], 'method'   => 'POST']) !!}

                <div class="modal-body">
                    <div class="row">
                        <div class="ps-block__content">
                            <div class="">
                                <input type="radio" class="" name="type" value="deactivate" checked="checked">
                                Deactivate - Your account will be temporary deactivated until you login again. You will no longer receive any newsletters or alerts for your deposit due from DollarDollar.sg
                                <br><br>
                                <input type="radio" class="" name="type" value="delete">
                                Delete - Your account will be permanently deleted and all your personal information will be removed from DollarDollar.sg
                            </div>
                            <div class="" style="padding: 20px 50px;">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <button type="submit" class="ps-btn " style="padding: 15px 0;">Submit</button>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <button type="" data-dismiss="modal" style="padding: 15px 0;"
                                            class="ps-btn ps-btn--outline">Cancel
                                    </button>
                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <img src="https://www.dollardollar.sg/frontend/images/logo_1535015224_7664b296e0e085eaa5e4852c2e8b11ba_1539598995.jpg"
                         alt="">
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection
