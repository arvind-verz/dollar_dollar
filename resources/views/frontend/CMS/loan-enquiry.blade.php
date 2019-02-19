@extends('frontend.layouts.app')
@section('description')
    <meta name="description" content="{{$page->meta_description}}">
@endsection
@section('keywords')
    <meta name="keywords" content="{{$page->meta_keyword}}">
@endsection
@section('author')
    <meta name="author" content="{{$page->meta_title}}">
@endsection
@section('title', $page->title)
@section('content')
<?php
$slug = CONTACT_SLUG;
//get banners
$banners = Helper::getBanners($slug);
?>
{{--Banner section start--}}
@if($banners->count()>1)
<div class="ps-home-banner">
    <div class="ps-slider--home owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
        data-owl-gap="0" data-owl-nav="false" data-owl-dots="true" data-owl-item="1" data-owl-item-xs="1"
        data-owl-item-sm="1" data-owl-item-md="1" data-owl-item-lg="1" data-owl-duration="1000"
        data-owl-mousedrag="on">
        @foreach($banners as $banner)
        <div class="ps-banner bg--cover" data-background="{{asset($banner->banner_image )}}"><img
            src="{{asset($banner->banner_image )}}" alt="">
            <div class="ps-banner__content">
                {!!$banner->banner_content!!}
            </div>
        </div>
        @endforeach
    </div>
</div>
@elseif($banners->count()== 1)
@foreach($banners as $banner)
<div class="ps-hero bg--cover" data-background="{{asset($banner->banner_image )}}"><img
src="{{asset($banner->banner_image )}}" alt=""></div>
@endforeach
@endif
{{--Banner section end--}}
<div class="ps-breadcrumb">
    <div class="container">
        <ol class="breadcrumb">
            <li><a href="{{ route('index') }}"><i class="fa fa-home"></i> Home</a></li>
            @include('frontend.includes.breadcrumb')
        </ol>
    </div>
</div>
{{--Page content start--}}
<div class="container">
    @if(session('error'))
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-danger m-b-0">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
                {!! session('error') !!}
            </div>
        </div>
    </div>
    @endif
</div>
<!-- my code -->
<div class="ps-page--deposit ps-loan">
    <div class="container ps-document">
        <?php
        //$pageName = strtok($page->name, " ");;
        $pageName = explode(' ', trim($page->name));
        $pageHeading = $pageName[0];
        // $a =  array_shift($arr);
        unset($pageName[0]);
        ?>
        {{--Page content start--}}
        @if($page->slug!=THANK_SLUG)
        <h3 class="ps-heading mb-20">
        <span>@if(!empty($page->icon))<i class="{{ $page->icon }}"></i>@endif {{$pageHeading}} {{implode(' ',$pageName)}} </span>
        </h3>
        {!!  $page->contents !!}
        @else
        {!!  $page->contents !!}
        @endif
        {!! Form::open(['url' => ['post-loan-enquiry'], 'class'=>'ps-form--enquiry ps-form--health-insurance', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="ps-loan-from">
            <input type="hidden" name="product_ids"
            value=" @if(isset($searchFilter['product_ids'])) {{$searchFilter['product_ids']}} @else {{old('product_ids')}} @endif">
            <label>FULL NAME
                <input class="full-name" @if(\Illuminate\Support\Facades\Auth::check()) readonly="readonly" @endif
                value="@if (Auth::user()){{Auth::user()->first_name.' '.Auth::user()->last_name}}@else {{old('full_name')}} @endif"
                name="full_name" type="text" >
            </label>
            @if ($errors->has('full_name'))
            <span class="text-danger" id="">
                <strong>{{ $errors->first('full_name') }}</strong>
            </span>
            @endif
            <label>EMAIL<input class="email" name="email" type="text"
                @if(\Illuminate\Support\Facades\Auth::check()) readonly="readonly" @endif
            value="@if (Auth::user()){{Auth::user()->email}}@else {{old('email')}} @endif"></label>
            @if ($errors->has('email'))
            <span class="text-danger" id="other-value-error">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
           
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-4"> <label class="">Country Code<input type="text" name="country_code"
                        value="+65" placeholder="" > @if ($errors->has('country_code'))
                        <span class="text-danger mt-5" id="">
                            <strong>{{ $errors->first('country_code') }}</strong>
                        </span>
                    @endif </label></div>
                    <div class="col-md-9 col-lg-9 col-sm-9 col-xs-8"><label class="">Mobile<input name="telephone" class=""
                        @if(\Illuminate\Support\Facades\Auth::check()) readonly="readonly"
                        @endif
                        value="@if (Auth::user()){{Auth::user()->tel_phone}}@else{{old('telephone')}}@endif"
                        type="text" placeholder="Telephone only">
                        @if ($errors->has('telephone'))
                        <span class="text-danger mt-5" id="">
                            <strong>{{ $errors->first('telephone') }}</strong>
                        </span>
                        @endif
                        </label>
                    </div>
                </div>
           
            <label>Rate Type <select class="form-control" name="rate_type_search">
                <option value="{{BOTH_VALUE}}"
                @if(isset($searchFilter['rate_type_search']) && $searchFilter['rate_type_search']==BOTH_VALUE) selected @endif>{{BOTH_VALUE}}</option>
                <option value="{{FIX_RATE}}"
                @if(isset($searchFilter['rate_type_search']) && $searchFilter['rate_type_search']==FIX_RATE) selected @endif>{{FIX_RATE}}</option>
                <option value="{{FLOATING_RATE}}"
                @if(isset($searchFilter['rate_type_search']) && $searchFilter['rate_type_search']==FLOATING_RATE) selected @endif>{{FLOATING_RATE}}</option>
            </select></label>
            @if ($errors->has('rate_type_search'))
            <span class="text-danger" id="">
                <strong>{{ $errors->first('rate_type_search') }}</strong>
            </span>
            @endif
            <label>Property Type
                <select class="form-control" name="property_type_search">
                    <option value="{{ALL}}"
                    @if(isset($searchFilter['property_type_search']) && $searchFilter['property_type_search']==ALL) selected @endif>{{ALL}}</option>
                    <option value="{{HDB_PROPERTY}}"
                    @if(isset($searchFilter['property_type_search']) && $searchFilter['property_type_search']==HDB_PROPERTY) selected @endif>{{HDB_PROPERTY}}</option>
                    <option value="{{PRIVATE_PROPERTY}}"
                    @if(isset($searchFilter['property_type_search']) && $searchFilter['property_type_search']==PRIVATE_PROPERTY) selected @endif>{{PRIVATE_PROPERTY}}</option>
                </select>
            </label>
            @if ($errors->has('property_type_search'))
            <span class="text-danger" id="">
                <strong>{{ $errors->first('property_type_search') }}</strong>
            </span>
            @endif
            <label>Loan Amount<input name="loan_amount" class="only_numeric"
                value="@if(isset($searchFilter['loan_amount'])) {{str_replace( ',', '',$searchFilter['loan_amount'])}}@else {{old('loan_amount')}}@endif"
            type="text"></label>
            @if ($errors->has('loan_amount'))
            <span class="text-danger" id="">
                <strong>{{ $errors->first('loan_amount') }}</strong>
            </span>
            @endif
            <label>Loan Type
                <select name="loan_type">
                    <option value="">Loan Type</option>
                    <option value="New" @if(old('loan_type')=="New") selected @endif>New</option>
                    <option value="Refinance" @if(old('loan_type')=="Refinance") selected @endif>Refinance</option>
                </select>
                @if ($errors->has('loan_type'))
                <span class="text-danger" id="">
                    <strong>{{ $errors->first('loan_type') }}</strong>
                </span>
                @endif
                
            </label>
            <label class="hide refinance-loan">Existing Bank Loan<input class="" name="existing_bank_loan"
                value="{{old('existing_bank_loan')}}"
            type="text" placeholder="E.g UOB">
                @if ($errors->has('existing_bank_loan'))
                    <span class="text-danger" id="">
                    <strong>{{ $errors->first('existing_bank_loan') }}</strong>
                </span>
                @endif
            </label>
            
            <div class="ps-form__content mt-5 mb-5">
                <div class=" recaptcha">
                    <p>One of representative from DollarDollar’s partner will go through the different home  loan available from different banks that is most suitable for you. I consent that this assigned representative can contact me via various communication (Voice Call, SMS and Email)</p>
                    {!! app('captcha')->display($attributes = [],
                    $lang = []) !!}
                    <span class="captcha-err">
                    </span>
                    @if ($errors->has('g-recaptcha-response'))
                    <span class="text-danger">
                        <strong>
                        {{ $errors->first('g-recaptcha-response') }}
                        </strong>
                    </span>
                    @endif
                </div>
            </div>
            @if(\Illuminate\Support\Facades\Auth::check())
            <label>
                <div class="form-icon">
                    <a href="{{ route('account-information.edit', ['id'    =>  AUTH::user()->id, 'location'  =>  'loan-enquiry']) }}" class="standard-link">Edit
                    Info</a>
                </div>
            </label>
            @endif
            <button type="submit">SUBMIT</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>
<!-- end my code -->
{{--Page content end--}}
{{--contact us or what we offer section start--}}
@if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
{!! $systemSetting->{$page->contact_or_offer} !!}
@endif
{{--contact us or what we offer section end--}}
<script type="text/javascript">
$(document).ready(function () {
//Date picker
$('#datepicker').datepicker({
autoclose: true,
changeMonth: true,
changeYear: true,
yearRange: "-100:+0",
dateFormat: "yy-mm-dd"
});
var value = $("select[name=loan_type]").val();
if (value == 'Refinance') {
$(".refinance-loan").removeClass("hide");
}
else {
$(".refinance-loan").addClass("hide");
}
});
$("select[name='loan_type']").on("change", function () {
var value = $(this).val();
if (value == 'Refinance') {
$(".refinance-loan").removeClass("hide");
$("input[name=existing_bank_loan]").val('');
}
else {
$(".refinance-loan").addClass("hide");
}
});
</script>
@endsection