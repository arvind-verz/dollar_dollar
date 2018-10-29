@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')
    <?php
    $tooltips = \GuzzleHttp\json_decode($page->tooltip);
    $toolTip = null;
    if (count($tooltips)) {
        $toolTip = $tooltips[0];
    }
    ?>
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
                        <ul class="ps-list--sidebar">
                            <li><a href="{{ url('profile-dashboard') }}">Profile Dashboard</a></li>
                            <li><a href="{{ url('account-information') }}">Profile Information</a></li>
                            <li class="current"><a href="{{ url('product-management') }}">Product Management</a></li>
                        </ul>
                        @if(count($ads))
                            @if(($ads[0]->display==1))
                                @php
                                $current_time = strtotime(date('Y-m-d', strtotime('now')));
                                $ad_start_date = strtotime($ads[0]->ad_start_date);
                                $ad_end_date = strtotime($ads[0]->ad_end_date);
                                @endphp

                                @if($current_time>=$ad_start_date && $current_time<=$ad_end_date && !empty($ads[0]->paid_ad_image))
                                    <div class="pt-2">
                                        <a href="{{ isset($ads[0]->paid_ad_link) ? asset($ads[0]->paid_ad_link) : '#' }}"
                                           target="_blank"><img src="{{ asset($ads[0]->paid_ad_image) }}" alt=""></a>
                                    </div>
                                @else
                                    <div class="pt-2">
                                        <a href="{{ isset($ads[0]->ad_link) ? asset($ads[0]->ad_link) : '#' }}"
                                           target="_blank"><img src="{{ asset($ads[0]->ad_image) }}" alt=""></a>
                                    </div>
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>Product Management</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            {!! Form::open(['route' => ['product-management.update', $product_management->id], 'class'  =>  'ps-form--product-management', 'method' =>  'POST']) !!}
                                    <!-- <div class="ps-form__header"><a class="ps-btn" href="#">Add Products</a></div> -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <label>Bank <sup>*</sup></label>
                                        <select class="form-control" name="bank_id" required="required">
                                            <option value="">Please select</option>
                                            @foreach($brands as $bank)
                                                <option value="{{ $bank->id }}"
                                                        @if($bank->id==$product_management->bank_id) selected @endif>{{ $bank->title }}</option>

                                            @endforeach
                                            <option value="0" @if(0==$product_management->bank_id) selected @endif>
                                                Other
                                            </option>
                                        </select>
                                        <input type="text" class="form-control hide" name="bank_id_other"
                                               value="{{ $product_management->other_bank }}"
                                               placeholder="Enter Bank or Financial Institution name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <label>Account Name</label>
                                        <input class="form-control" name="account_name" type="text"
                                               placeholder="Enter Account Name"
                                               value="{{ $product_management->account_name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                            <div class="form-group">
                                                <label>Amount<sup>*</sup></label>
                                                <input class="form-control" required="required" name="amount" type="text"
                                                       placeholder="Enter Amount" value="{{ $product_management->amount }}">
                                                <!-- <span class="suffix_k">K</span> -->
                                            </div>
                                        </div>  
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="input-group form-group">
                                                <label>Tenure</label>
                                                <input type="text" class="form-control " name="tenure"
                                                       value="{{ $product_management->tenure }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                            <div class="input-group-btn" style="width: 50%;">
                                                <select class="form-control mt-30" name="tenure_calender">
                                                    <option value="D"
                                                            @if($product_management->tenure_calender=='D') selected @endif>
                                                        Days
                                                    </option>
                                                    <option value="M"
                                                            @if($product_management->tenure_calender=='M') selected @endif>
                                                        Months
                                                    </option>
                                                    <option value="Y"
                                                            @if($product_management->tenure_calender=='Y') selected @endif>
                                                        Years
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">-->
                                <!--    <div class="form-group">-->
                                <!--        <label>Amount a<sup>*</sup></label>-->
                                <!--        <input class="form-control" required="required" name="amount" type="text"-->
                                <!--               placeholder="Enter Amount" value="{{ $product_management->amount }}">-->
                                        <!-- <span class="suffix_k">K</span> -->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">-->
                                <!--    <div class="input-group form-group">-->
                                <!--        <label>Tenure</label>-->
                                <!--        <input type="text" class="form-control " name="tenure"-->
                                <!--               value="{{ $product_management->tenure }}">-->

                                <!--        <div class="input-group-btn" style="width: 50%;">-->
                                <!--            <select class="form-control mt-30" name="tenure_calender">-->
                                <!--                <option value="D"-->
                                <!--                        @if($product_management->tenure_calender=='D') selected @endif>-->
                                <!--                    Days-->
                                <!--                </option>-->
                                <!--                <option value="M"-->
                                <!--                        @if($product_management->tenure_calender=='M') selected @endif>-->
                                <!--                    Months-->
                                <!--                </option>-->
                                <!--                <option value="Y"-->
                                <!--                        @if($product_management->tenure_calender=='Y') selected @endif>-->
                                <!--                    Years-->
                                <!--                </option>-->
                                <!--            </select>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <?php $product_reminder = json_decode($product_management->product_reminder); dd($product_reminder); if(!$product_reminder)
                                {$product_reminder=[];} ?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <label>Reminder</label>
                                        @if(isset($toolTip->reminder_tooltip))
                                            <a class="ps-tooltip" href="javascript:void(0)"
                                               data-tooltip="{{$toolTip->reminder_tooltip}}"><i
                                                        class="fa fa-exclamation-circle"></i></a>
                                        @endif
                                        <!--<select  class="form-control select2-multiple " id="reminder" disabled="disabled"-->
                                        <!--         name="reminder[]" multiple="multiple"-->
                                        <!--         style="width: 100%;height:45px;">-->
                                        <!--    <option value="1 Day"-->
                                        <!--            @if(in_array('1 Day', $product_reminder)) selected @endif>1 Day-->
                                        <!--    </option>-->
                                        <!--    <option value="1 Week"-->
                                        <!--            @if(in_array('1 Week', $product_reminder)) selected @endif>1 Week-->
                                        <!--    </option>-->
                                        <!--    <option value="2 Week"-->
                                        <!--            @if(in_array('2 Week', $product_reminder)) selected @endif>2 Week-->
                                        <!--    </option>-->
                                        <!--</select>-->
                                            <div class="reminder">
                                                <label><input type="checkbox" name="reminder1" value="1 Day" @if($product_reminder['reminder1']=='1 Day')checked @endif ><span>1 Day</span></label>
                                                <label><input type="checkbox" name="reminder2" value="1 Week" @if($product_reminder['reminder2']=='1 Week')checked @endif><span>1 Week</span></label>
                                                <label><input type="checkbox" name="reminder3" value="2 Week" @if($product_reminder['reminder3']=='2 Week')checked @endif><span>2 Week</span></label>
                                            </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input class="form-control datepicker" name="start_date" type="text"
                                                       placeholder="" autocomplete="off"
                                                       value="@if(!empty($product_management->start_date)) {{ date("Y-m-d", strtotime($product_management->start_date)) }} @endif">
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <input class="form-control datepicker" name="end_date" type="text"
                                                       placeholder="" autocomplete="off"
                                                       value="@if(!empty($product_management->end_date)){{ date("Y-m-d", strtotime($product_management->end_date)) }} @endif">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <div class="form-group">
                                        <label>Interested earned</label>
                                        @if(isset($toolTip->interest_earn_tooltip))
                                            <a class="ps-tooltip" href="javascript:void(0)"
                                               data-tooltip="{{$toolTip->interest_earn_tooltip}}"><i
                                                        class="fa fa-exclamation-circle"></i></a>
                                        @endif
                                        <input class="form-control" name="interest_earned" type="text"
                                               placeholder="Enter Interest Earned"
                                               value="{{ $product_management->interest_earned }}">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                            <div class="form-group submit">
                                                <label>Do not Send Reminders</label>
                                                <input type="checkbox" class="form-control" name="dod_reminder"
                                                       @if(old('dod_reminder')==1) checked @endif>


                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                            <div class="form-group submit">
                                                <p>"<span>*</span>" are mandatory fields.</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                            <div class="form-group submit">
                                                <button type="submit" class="ps-btn">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">


        $("select[name='bank_id']").on("change", function () {
            var value = $(this).val();

            if (value == 0 && value != '') {
                $(this).attr("required", false);
                $("input[name='bank_id_other']").removeClass("hide").attr("required", true);
            }
            else {
                $(this).attr("required", true);
                $("input[name='bank_id_other']").addClass("hide").attr("required", false);
            }
        });
        $("input[name='end_date']").on("change", function () {
            var valueLenght = $(this).val().length;
            if (valueLenght == 0) {
                $("#reminder").attr("disabled", true);
                $("input[name='dod_reminder']").prop('checked', false);
                $("input[name='dod_reminder']").attr("disabled", true);
                $(".select2").select2("val", " ");
            }
            else {
                $("#reminder").attr("disabled", false);
                $("input[name='dod_reminder']").attr("disabled", false);
            }
        });
        var value = $("select[name='bank_id']").val();

        if (value == 0) {
            $("select[name='bank_id']").attr("required", false);
            $("input[name='bank_id_other']").removeClass("hide").attr("required", true);
        }
        else {
            $("select[name='bank_id']").attr("required", true);
            $("input[name='bank_id_other']").addClass("hide").attr("required", false);
        }

        $("input[name='dod_reminder']").on("change", function () {
            if ($(this).is(":checked") !== false) {
                $("select[name='reminder[]']").prop("disabled", true);
                $(".select2").select2("val", " ");
            }
            else {
                $("select[name='reminder[]']").prop("disabled", false);
            }
        });

        if ($("input[name='dod_reminder']").is(":checked") !== false) {
            $("select[name='reminder[]']").prop("disabled", true);
            $(".select2").select2("val", " ");
        }

        /*dod_onoff();
         $("input[name='start_date'], input[name='end_date']").on("change", function() {
         dod_onoff();
         });

         function dod_onoff() {
         var start_date = $("input[name='end_date']").val();
         var end_date = $("input[name='end_date']").val();
         if(start_date=='' || end_date=='') {
         $("input[name='dod_reminder']").attr("disabled", true);
         }
         else {
         $("input[name='dod_reminder']").attr("disabled", false);
         }
         }*/
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2();
            if ($("input[name='end_date']").val().length != 0) {
                $("#reminder").attr("disabled", false);
                $("input[name='dod_reminder']").attr("disabled", false);
            } else {
                $("#reminder").attr("disabled", true);
                $("input[name='dod_reminder']").attr("disabled", true);
            }

        });
    </script>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
