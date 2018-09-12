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
    <main class="ps-main">
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
                        <h3 class="ps-heading mb-35">
                            <span>@if(!empty($page->icon))<i class="{{ $page->icon }}"></i>@endif {{$pageHeading}} {{implode(' ',$pageName)}} </span>
                        </h3>

                        {!!  $page->contents !!}
            @else
                {!!  $page->contents !!}
            @endif
            {!! Form::open(['url' => ['investment-enquiry'], 'class'=>'ps-form--enquiry ps-form--health-insurance', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                <h5 class="ps-heading--3">1. What type of life insurance are you looking for?</h5>

                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="component-1" value="{{COMPONENTS_PROTECTION}}"
                           name="components[]"
                    @if (!is_null(old('components'))) {{ in_array(COMPONENTS_PROTECTION,old('components'))? "CHECKED" : "" }} @endif/>
                    <label for="component-1">{{COMPONENTS_PROTECTION}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="component-3" value="{{COMPONENTS_SAVING}}"
                           name="components[]"
                    @if (!is_null(old('components'))) {{ in_array(COMPONENTS_SAVING,old('components'))? "CHECKED" : "" }} @endif/>
                    <label for="component-3">{{COMPONENTS_SAVING}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="component-2" value="{{COMPONENTS_INVESTMENT}}"
                           name="components[]"
                    @if (!is_null(old('components'))) {{ in_array(COMPONENTS_INVESTMENT,old('components'))? "CHECKED" : "" }} @endif/>
                    <label for="component-2">{{COMPONENTS_INVESTMENT}}</label>
                </div>
                @if ($errors->has('components'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('components') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <h5 class="ps-heading--3">2. What is your gender?</h5>

                <div class="ps-radio ps-radio--inline">
                    <input class="form-control" type="radio" value="{{GENDER_MALE}}" id="gender-1" name="gender"
                           @if (old('gender')==GENDER_MALE) checked="CHECKED"@endif/>
                    <label for="gender-1">{{GENDER_MALE}}</label>
                </div>
                <div class="ps-radio ps-radio--inline">
                    <input class="form-control" type="radio" value="{{GENDER_FEMALE}}" id="gender-2" name="gender"
                           @if (old('gender')==GENDER_FEMALE) checked="CHECKED"@endif/>
                    <label for="gender-2">{{GENDER_FEMALE}}</label>
                </div>
                @if ($errors->has('gender'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('gender') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <h5 class="ps-heading--3">3. What is your date of birth?</h5>

                <div class="ps-form-icon max-500"><i class="fa fa-calendar"></i>
                    <input class="form-control " id="datepicker" value="{{old('dob')}}" name="dob" type="text" placeholder="">
                </div>
                @if ($errors->has('dob'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('dob') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <h5 class="ps-heading--3">4. Are you a smoker?</h5>

                <p>Have you smoked any nicotine or tobacco products in the last 12 months?</p>

                <div class="ps-radio ps-radio--inline">
                    <input class="form-control" type="radio" value="{{YES}}" id="smoke-1" name="smoke"
                           @if (old('smoke')==YES) checked="CHECKED"@endif/>
                    <label for="smoke-1">{{YES}}</label>
                </div>
                <div class="ps-radio ps-radio--inline">
                    <input class="form-control" type="radio" value="{{NO}}" id="smoke-2" name="smoke"
                           @if (old('smoke')==NO) checked="CHECKED"@endif/>
                    <label for="smoke-2">{{NO}}</label>
                </div>
                @if ($errors->has('smoke'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('smoke') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <h5 class="ps-heading--3">5. When is the best time to reach you?</h5>

                <p>One of representative from DollarDollar's partner will go through the different quotes from different insurers that is most suitable to your needs. I consent that this assigned representative can contact me via the various communication (Voice Call, SMS and Email)</p>

                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="time-1" value="{{TIME_ANYTIME}}" name="time[]"
                    @if (!is_null(old('time'))) {{ in_array(TIME_ANYTIME,old('time'))? "CHECKED" : "" }} @endif/>
                    <label for="time-1">{{TIME_ANYTIME}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="time-2" value="{{TIME_MORNING}}" name="time[]"
                    @if (!is_null(old('time'))) {{ in_array(TIME_MORNING,old('time'))? "CHECKED" : "" }} @endif/>
                    <label for="time-2">{{TIME_MORNING}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="time-3" value="{{TIME_AFTERNOON}}" name="time[]"
                    @if (!is_null(old('time'))) {{ in_array(TIME_AFTERNOON,old('time'))? "CHECKED" : "" }} @endif/>
                    <label for="time-3">{{TIME_AFTERNOON}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="time-4" value="{{TIME_EVENING}}" name="time[]"
                    @if (!is_null(old('time'))) {{ in_array(TIME_EVENING,old('time'))? "CHECKED" : "" }} @endif/>
                    <label for="time-4">{{TIME_EVENING}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="time-5" value="{{TIME_OTHER}}" name="time[]"
                    @if (!is_null(old('time'))) {{ in_array(TIME_OTHER,old('time'))? "CHECKED" : "" }} @endif/>
                    <label for="time-5">{{TIME_OTHER}}</label>
                </div>
                <div class="short-form mb-10">
                    <input class="form-control" type="text" id="other_value" name="other_value"
                           onkeyup="checkOtherValidation(this)" placeholder="Please Specify"
                           value="{{old('other_value')}}">
                </div>
                @if ($errors->has('other_value'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('other_value') }}</strong>
                                                    </span>
                @endif
                @if ($errors->has('time'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('time') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>Fullname</label>

                <div class="form-icon"><i class="fa fa-user"></i>
                    <input class="form-control" type="text" name="full_name" placeholder="Enter Name Here"
                           value="@if (Auth::user()){{Auth::user()->first_name.' '.Auth::user()->last_name}}@else {{old('full_name')}} @endif">
                </div>
                @if ($errors->has('full_name'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('full_name') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>Email</label>

                <div class="form-icon"><i class="fa fa-envelope"></i>
                    <input class="form-control" type="text" name="email"
                           value="@if (Auth::user()){{Auth::user()->email}}@else {{old('email')}} @endif"
                           placeholder="Enter Email Address Here">
                </div>
                @if ($errors->has('email'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <label>Mobile</label>

                <div class="row">
                    <div class="col-xs-3">
                        <div class="form-icon"><i class="fa fa-globe"></i>
                            <input class="form-control" type="text" placeholder="+65" name="country_code"
                                   value="{{ old('country_code') ? old('country_code') : (Auth::user()->country_code) ? Auth::user()->country_code : '+65' }}">
                                   <a href="{{ route('account-information.edit', ['id'    =>  AUTH::user()->id, 'location'  =>  'life-insurance-enquiry']) }}">Edit Info</a>
                        </div>
                        @if ($errors->has('country_code'))
                            <span class="text-danger">
                                                    <strong>{{ $errors->first('country_code') }}</strong>
                                                    </span>
                        @endif
                    </div>
                    <div class="col-xs-9">
                        <div class="form-icon"><i class="fa fa-mobile-phone"></i>
                            <input class="form-control" type="text" placeholder="Enter Mobile Number"
                                   name="telephone"
                                   value="@if (Auth::user()){{Auth::user()->tel_phone}}@else{{old('telephone')}}@endif">

                        </div>
                        @if ($errors->has('telephone'))
                            <span class="text-danger">
                                                    <strong>{{ $errors->first('telephone') }}</strong>
                                                    </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="form-group submit">
                <button class="ps-btn">Submit</button>
            </div>
            </form>
        </div>
    </main>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}
<script type="text/javascript">
    $(document).ready(function() {
        inputs_checked();
        /*var inputs = $("input[name='other_value'], input[name='full_name'], input[name='email'], input[name='country_code'], input[name='telephone']");
        inputs.prop("disabled", true);
        $("input[name='components[]'], input[name='gender'], input[name='smoke'], input[name='time[]']").on("change", function() {
            inputs_checked();
        });*/

        function inputs_checked() {
            $("input[name='other_value'], input[name='full_name'], input[name='email'], input[name='country_code'], input[name='telephone']").prop("disabled", true);
        } 
    });

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
