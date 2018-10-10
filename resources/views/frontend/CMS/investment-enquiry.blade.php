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
                <h3 class="ps-heading mb-20">
                    <span>@if(!empty($page->icon))<i
                                class="{{ $page->icon }}"></i>@endif {{$pageHeading}} {{implode(' ',$pageName)}} </span>
                </h3>

                {!!  $page->contents !!}
            @else
                {!!  $page->contents !!}
            @endif
            {!! Form::open(['url' => ['investment-enquiry'], 'class'=>'ps-form--enquiry ps-form--health-insurance', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            <div class="form-group">
                <h5 class="ps-heading--3">1. What is current your financial goal?</h5>

                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="goal-1" value="{{GOAL_INCOME}}"
                           name="goals[]"
                    @if (!is_null(old('goals'))) {{ in_array(GOAL_INCOME,old('goals'))? "CHECKED" : "" }} @endif/>
                    <label for="goal-1">{{GOAL_INCOME}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="goal-2" value="{{GOAL_FAMILY}}"
                           name="goals[]"
                    @if (!is_null(old('goals'))) {{ in_array(GOAL_FAMILY,old('goals'))? "CHECKED" : "" }} @endif/>
                    <label for="goal-2">{{GOAL_FAMILY}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="goal-3" value="{{GOAL_RETIREMENT}}"
                           name="goals[]"
                    @if (!is_null(old('goals'))) {{ in_array(GOAL_RETIREMENT,old('goals'))? "CHECKED" : "" }} @endif/>
                    <label for="goal-3">{{GOAL_RETIREMENT}}</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control" type="checkbox" id="goal-4" value="{{GOAL_OTHER}}" name="goals[]"
                    @if (!is_null(old('goals'))) {{ in_array(GOAL_OTHER,old('goals'))? "CHECKED" : "" }} @endif/>
                    <label for="goal-4">{{GOAL_OTHER}}</label>
                </div>
                <div class="short-form mb-10 hide">
                    <input class="form-control" type="text" id="goal-other-value" name="goal_other_value"
                           data-target="goal-4"
                           onkeyup="checkOtherValidation(this)" placeholder="Please Specify"
                           value="{{old('goal_other_value')}}">
                </div>
                @if ($errors->has('goal_other_value'))
                    <span class="text-danger" id="goal-other-value-error">
                                                    <strong>{{ $errors->first('goal_other_value') }}</strong>
                                                    </span>
                @endif
                @if ($errors->has('goals'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('goals') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <h5 class="ps-heading--3">2. Do you have any investment experience before?</h5>

                <div class="ps-radio ps-radio--inline">
                    <input class="form-control" type="radio" value="{{YES}}" id="level-1" name="experience"
                           @if (old('experience')==YES) checked="CHECKED"@endif/>
                    <label for="level-1">{{YES}}</label>
                </div>
                <div class="ps-radio ps-radio--inline">
                    <input class="form-control" type="radio" value="{{NO}}" id="level-2" name="experience"
                           @if (old('experience')==NO) checked="CHECKED"@endif />
                    <label for="level-2">{{NO}}</label>
                </div>
                @if ($errors->has('experience'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('experience') }}</strong>
                                                    </span>
                @endif
                <div class="short-form mb-10 hide">
                    <label>Please state the type of investment you have invested before (e.g Unit Trust, Bonds, etc…)</label>
                    <input class="form-control" type="text" id="experience-detail" name="experience_detail"
                           placeholder=""
                           value="">
                </div>
                @if ($errors->has('experience_detail'))
                    <span class="text-danger" id="experience-detail-error">
                                                    <strong>{{ $errors->first('experience_detail') }}</strong>
                                                    </span>
                @endif

            </div>
            <div class="form-group">
                <h5 class="ps-heading--3">3. Which Risk Profile do you fall into?</h5>

                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control risk-radio" type="checkbox" id="risk-1" value="{{RISK_CONSERVATIVE}}"
                           name="risks[]"
                    @if (!is_null(old('risks'))) {{ in_array(RISK_CONSERVATIVE,old('risks'))? "CHECKED" : "" }} @endif/>
                    <label for="risk-1"><strong>Conservative</strong> - Your primary goal is to protect your capital and
                        seek moderate
                        returns. You do not wish to take more than a low level of risk and is uncomfortable with short
                        term price fluctuations.</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control risk-radio" type="checkbox" id="risk-2" value="{{RISK_MODERATE}}"
                           name="risks[]"
                    @if (!is_null(old('risks'))) {{ in_array(RISK_MODERATE,old('risks'))? "CHECKED" : "" }} @endif/>
                    <label for="risk-2"><strong>Moderately Conservative</strong> - You have a general understanding of
                        the investment
                        markets, but would like to have a broader understanding in order to explore the possibilities.
                        You are willing to accept minor price fluctuations.</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control risk-radio" type="checkbox" id="risk-3" value="{{RISK_BALANCED}}"
                           name="risks[]"
                    @if (!is_null(old('risks'))) {{ in_array(RISK_BALANCED,old('risks'))? "CHECKED" : "" }} @endif/>
                    <label for="risk-3"><strong>Balanced</strong> - You wish to adopt a diversified portfolio to
                        somewhat protect you
                        from inflation and tax. Therefore you are willing to accept some price fluctuations in exchange
                        for some potential capital growth.</label>
                </div>
                <div class="ps-checkbox ps-checkbox--inline">
                    <input class="form-control risk-radio" type="checkbox" id="risk-4" value="{{RISK_GROWTH}}"
                           name="risks[]"
                    @if (!is_null(old('risks'))) {{ in_array(RISK_GROWTH,old('risks'))? "CHECKED" : "" }} @endif/>
                    <label for="risk-4"><strong>Growth</strong> - You can accept very high levels of variability in
                        investment returns,
                        as you understand that the higher the risks associated with investments, potentially the higher
                        level of returns expected.</label>
                </div>
                @if ($errors->has('risks'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('risks') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <h5 class="ps-heading--3">4. What is your age?</h5>
                <input class="form-control only_numeric" type="text" id="age" name="age" data-target=""
                        placeholder=""
                       value="{{old('age')}}">
                @if ($errors->has('age'))
                    <span class="text-danger">
                                                    <strong>{{ $errors->first('age') }}</strong>
                                                    </span>
                @endif
            </div>
            <div class="form-group">
                <h5 class="ps-heading--3">5. When is the best time to reach you?</h5>

                <p>One of representative from DollarDollar's partner will go through the different quotes from different
                    insurers that is most suitable to your needs. I consent that this assigned representative can
                    contact me via the various communication (Voice Call, SMS and Email)</p>

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
                    <input class="form-control" type="text" id="other-value" name="other_value" data-target="time-5"
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
                            @if ($errors->has('country_code'))
                                <span class="text-danger">
                                                    <strong>{{ $errors->first('country_code') }}</strong>
                                                    </span>
                            @endif
                            <a href="{{ route('account-information.edit', ['id'    =>  AUTH::user()->id, 'location'  =>  'life-insurance-enquiry']) }}">Edit
                                Info</a>
                        </div>

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
        $(document).ready(function () {

            inputs_checked();
            /*var inputs = $("input[name='other_value'], input[name='full_name'], input[name='email'], input[name='country_code'], input[name='telephone']");
             inputs.prop("disabled", true);
             $("input[name='coverage'], input[name='level'], input[name='time[]']").on("change", function() {
             inputs_checked();
             });*/

            if ($("#level-1").is(":checked")) {
                $("input[name='experience_detail']").parent("div").removeClass("hide");
            }
            if ($("#goal-4").is(":checked")) {
                $("#goal-other-value").parent("div").removeClass("hide");
            }
        });
        function inputs_checked() {
            $(" input[name='full_name'], input[name='email'], input[name='country_code'], input[name='telephone']").prop("readonly", true);
        }

        $("input[name='experience']").on("change", function () {
            if ($(this).val() == '<?php echo YES; ?>') {
                $("input[name='experience_detail']").parent("div").removeClass("hide");
            }
            else {
                $("input[name='experience_detail']").parent("div").addClass("hide");
                $('#experience-detail-error').html("");
            }
        });
        $(".risk-radio").change(function () {

            var checked = $(this).is(':checked');

            $(".risk-radio").prop('checked', false);

            if (checked) {

                $(this).prop('checked', true);

            }

        });

        $("#goal-4").on("change", function () {
            if ($(this).is(":checked")) {
                $("#goal-other-value").parent("div").removeClass("hide");
            }
            else {
                $("#goal-other-value").parent("div").addClass("hide");
                $('#goal-other-value-error').html("");
                $('#goal-other-value').val("");
            }
        });
    </script>
@endsection
