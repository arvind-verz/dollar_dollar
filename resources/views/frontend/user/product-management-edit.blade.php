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
                       <div class="pt-2">
                            <a href="{{ isset($systemSetting->profile_ads_link) ? asset($systemSetting->profile_ads_link) : '#' }}" target="_blank"><img src="{{ isset($systemSetting->profile_ads) ? asset($systemSetting->profile_ads) : '' }}" alt=""></a>
                        </div>
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
                                                <option value="0"  @if(0==$product_management->bank_id) selected @endif>Other</option>
                                            </select>
                                            <input type="text" class="form-control hide" name="bank_id_other" value="{{ $product_management->other_bank }}" placeholder="Enter bank name">
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
                                            <span class="suffix_k">K</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Tenor</label>
                                            <input type="text" class="form-control only_numeric" name="tenure" value="{{ $product_management->tenure }}">
                                        </div>
                                    </div>
                                    @php $product_reminder = json_decode($product_management->product_reminder);if(!$product_reminder) {$product_reminder=[];} @endphp
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Reminder</label>
                                            <select class="form-control select2" name="reminder[]" multiple="multiple">
                                                <option value="1 Day" @if(in_array('1 Day', $product_reminder)) selected @endif>1 Day</option>
                                                <option value="1 Week" @if(in_array('1 Week', $product_reminder)) selected @endif>1 Week</option>
                                                <option value="2 Week" @if(in_array('2 Week', $product_reminder)) selected @endif>2 Week</option>
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
    <script type="text/javascript">
        $("select[name='bank_id']").on("change", function() {
            var value = $(this).val();
            
            if(value==0) {
                $(this).attr("required", false);
                $("input[name='bank_id_other']").removeClass("hide").attr("required", true);
            }
            else {
                $(this).attr("required", true);
                $("input[name='bank_id_other']").addClass("hide").attr("required", false);
            }
        });

        var value = $("select[name='bank_id']").val();
            
        if(value==0) {
            $("select[name='bank_id']").attr("required", false);
            $("input[name='bank_id_other']").removeClass("hide").attr("required", true);
        }
        else {
            $("select[name='bank_id']").attr("required", true);
            $("input[name='bank_id_other']").addClass("hide").attr("required", false);
        }
    </script>
    <script type="text/javascript">
        $(document).ready( function () {
            $('.select2').select2();
        } );
    </script>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
