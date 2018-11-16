@extends('frontend.layouts.app')
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
        <div class="container">
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
                    <span>@if(!empty($page->icon))<i
                                class="{{ $page->icon }}"></i>@endif {{$pageHeading}} {{implode(' ',$pageName)}} </span>
                </h3>

                {!!  $page->contents !!}
            @else
                {!!  $page->contents !!}
            @endif
            {!! Form::open(['url' => ['post-loan-enquiry'], 'class'=>'ps-form--enquiry ps-form--health-insurance', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="ps-loan-from">
                <input type="hidden" name="product_ids"
                       value=" @if(isset($searchFilter['product_ids'])) {{$searchFilter['product_ids']}} @endif">
                <label>FULL NAME
                    <input class="full-name" @if(\Illuminate\Support\Facades\Auth::check()) readonly="readonly" @endif
                                       value="@if (Auth::user()){{Auth::user()->first_name.' '.Auth::user()->last_name}}@else {{old('full_name')}} @endif"
                                       name="full_name" type="text">

                </label>
                @if ($errors->has('full_name'))
                    <span class="text-danger" id="">
                                                    <strong>{{ $errors->first('full_name') }}</strong>
                                                    </span>
                @endif
                <label>EMAIL<input class="email" name="email" type="text" @if(\Illuminate\Support\Facades\Auth::check()) readonly="readonly" @endif
                                   value="@if (Auth::user()){{Auth::user()->email}}@else {{old('email')}} @endif"></label>
                @if ($errors->has('email'))
                    <span class="text-danger" id="other-value-error">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                @endif
                <label class="ps-loan-mobile">MOBILE<span><input type="text" name="country_code" value="+65"><input name="telephone" @if(\Illuminate\Support\Facades\Auth::check()) readonly="readonly" @endif
                                                                                 value="@if (Auth::user()){{Auth::user()->tel_phone}}@else{{old('telephone')}}@endif"
                                                                                 type="text"></span></label>
                @if ($errors->has('telephone'))
                    <span class="text-danger" id="">
                                                    <strong>{{ $errors->first('telephone') }}</strong>
                                                    </span>
                @endif
                <label>Rate Type <select class="form-control" name="rate_type_search" >
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
                <label>Loan Amount<input name="loan_amount" value="@if(isset($searchFilter['loan_amount'])) {{$searchFilter['loan_amount']}} @else {{old('loan_amount')}} @endif" type="text"></label>
                @if ($errors->has('loan_amount'))
                    <span class="text-danger" id="">
                                                    <strong>{{ $errors->first('loan_amount') }}</strong>
                                                    </span>
                @endif
                <label>Loan Type
                    <select name="loan_type">
                        <option value="">Loan Type</option>
                        <option value="New">New</option>
                        <option value="Refinance">Refinance</option>
                    </select>
                </label>
                @if ($errors->has('loan_type'))
                    <span class="text-danger" id="">
                                                    <strong>{{ $errors->first('loan_type') }}</strong>
                                                    </span>
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
        });
    </script>
@endsection
