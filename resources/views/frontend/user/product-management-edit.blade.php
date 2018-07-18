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
    @include('frontend.includes.messages')
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
                            <li><a href="{{ url('profile-dashboard') }}">My Profile Dashboard</a></li>
                            <li><a href="{{ url('account-information') }}">Account Information</a></li>
                            <li class="current"><a href="{{ url('product-management') }}">Product Management</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>Product Management</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            {!! Form::open(['route' => ['product-management.update', $product_management->id], 'class'  =>  'ps-form--product-management', 'method' =>  'POST']) !!}
                                <div class="ps-form__header"><a class="ps-btn" href="#">Add Products</a></div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Bank <sup>*</sup></label>
                                            <select class="form-control" name="bank_id" required="required">
                                                <option value="">Please select</option>
                                                @foreach($brands as $bank)

                                                    <option value="{{ $bank->id }}" @if($bank->id==$product_management->bank_id) selected @endif>{{ $bank->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Account Name</label>
                                            <input class="form-control" name="account_name" type="text" placeholder="Enter Account Name" value="{{ $product_management->account_name }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Amount <sup>*</sup></label>
                                            <input class="form-control" required="required" name="amount" type="text" placeholder="Enter Amount"  value="{{ $product_management->amount }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Tenor</label>
                                            <select class="form-control" name="tenure">
                                                <option value="">Please select</option>
                                                <option value="1" @if(1==$product_management->tenure) selected @endif>1</option>
                                                <option value="2" @if(2==$product_management->tenure) selected @endif>2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Privacy</label>
                                            <select class="form-control" name="privacy">
                                                <option value="DOD" @if('DOD'==$product_management->privacy) selected  @endif>DOD</option>
                                                <option value="Anytime" @if('Anytime'==$product_management->privacy) selected @endif>Anytime</option>
                                                <option value="Occasionally" @if('Occasionally'==$product_management->privacy) selected @endif>Occasionally</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input class="form-control datepicker" name="start_date" type="text" placeholder="" autocomplete="off" value="{{ date("Y-m-d", strtotime($product_management->start_date)) }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input class="form-control datepicker" name="end_date" type="text" placeholder="" autocomplete="off" value="{{ date("Y-m-d", strtotime($product_management->end_date)) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Interested earned</label>
                                            <input class="form-control" name="interest_earned" type="text" placeholder="Enter Interest Earned" value="{{ $product_management->interest_earned }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group submit">
                                    <p>"<span>*</span>" are mandatory fields.</p>
                                    <button type="submit" class="ps-btn">Submit</button>
                                </div>
                            {{ Form::close() }}
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
