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

            <div class="row mt-20">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                    <div class="ps-sidebar">
                        <ul class="ps-list--sidebar">
                            <li><a href="{{ url('profile-dashboard') }}">Profile Dashboard</a></li>
                            <li><a href="{{ url('account-information') }}">Profile Information</a></li>
                            <li class="current"><a href="{{ url('product-management') }}">Product Management</a></li>
                        </ul>
                        @include('frontend.includes.vertical-ads-profile')
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <?php
                        //$pageName = strtok($page->name, " ");;
                        $pageName = explode(' ', trim($page->name));
                        $pageHeading = $pageName[0];
                        $tooltips = \GuzzleHttp\json_decode($page->tooltip);
                        $toolTip = null;
                        if (count($tooltips)) {
                            $toolTip = $tooltips[0];
                        }
                        // $a =  array_shift($arr);
                        unset($pageName[0]);
                        ?>
                        {{--Page content start--}}
                        @if($page->slug!=THANK_SLUG)
                            <h3 class="ps-heading mb-35">
                                <span>@if(!empty($page->icon))<i
                                            class="{{ $page->icon }}"></i>@endif {{$pageHeading}} {{implode(' ',$pageName)}} </span>
                            </h3>

                            {!!  $page->contents !!}
                            @else
                            {!!  $page->contents !!}
                            @endif
                                    <!-- <div class="ps-dashboard__header">
                            <h3>Product Management</h3>
                        </div> -->
                            <div class="ps-dashboard__content">
                                {!! Form::open(['route' => 'product-management.store', 'class'  =>  'ps-form--product-management', 'method' =>  'POST']) !!}
                                        <!-- <div class="ps-form__header"><a class="ps-btn" href="#">Add Products</a></div> -->
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Bank <sup>*</sup></label>
                                            <select class="form-control" name="bank_id" required="required">
                                                <option value="">Please select</option>
                                                @foreach($brands as $bank)
                                                    <option value="{{ $bank->id }}"
                                                            @if($bank->id==old('bank_id')) selected @endif>{{ $bank->title }}</option>

                                                @endforeach
                                                <option value="0">Other</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <input type="text" class="form-control hide orther-hide" name="bank_id_other" value=""
                                                   placeholder="Enter Bank or Financial Institution name">
                                    </div></div>
                                    <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Account Name</label>
                                            <input class="form-control" name="account_name" type="text"
                                                   placeholder="Enter Account Name" value="{{ old('account_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                                <div class="form-group">
                                                    <label>Amount<sup>*</sup></label>
                                                    <input class="form-control prefix_dollar only_numeric" required="required"
                                                           name="amount"
                                                           type="text" placeholder="Enter Amount"
                                                           value="{{ old('amount') }}">
                                                    <!-- <span class="suffix_k">K</span> -->
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <div class="form-group">
                                                    <label>Tenor</label>
                                                    <input type="text" class="form-control only_numeric" name="tenure"
                                                           value="{{ old('tenure') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                                <div class="form-group">
                                                    <select class="form-control mt-30 mt-34" name="tenure_calender">
                                                        <option value="D" selected>Days</option>
                                                        <option value="M">Months</option>
                                                        <option value="Y">Years</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">-->
                                    <!--    <div class="row">-->
                                    <!--        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">-->
                                    <!--            <div class="form-group">-->
                                    <!--                <label>Tenure</label>-->
                                    <!--                <input type="text" class="form-control " name="tenure"-->
                                    <!--                       value="{{ old('tenure') }}">-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">-->
                                    <!--            <div class="form-group">-->
                                    <!--                <select class="form-control mt-30" name="tenure_calender">-->
                                    <!--                    <option value="D" selected>Days</option>-->
                                    <!--                    <option value="M">Months</option>-->
                                    <!--                    <option value="Y">Years</option>-->
                                    <!--                </select>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Reminder
                                            </label>
                                            @if(isset($toolTip->reminder_tooltip))
                                                <a class="ps-tooltip" href="javascript:void(0)"
                                                   data-tooltip="{{$toolTip->reminder_tooltip}}"><i
                                                            class="fa fa-exclamation-circle"></i></a>
                                                @endif

                                                <div class="reminder">
                                                    <label><input type="checkbox" name="reminder1" value="1 Day"><span>1 Day</span></label>
                                                    <label><input type="checkbox" name="reminder2" value="1 Week"><span>1 Week</span></label>
                                                    <label><input type="checkbox" name="reminder3" value="2 Weeks"><span>2 Weeks</span></label>
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
                                                           value="{{ old('start_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input class="form-control datepicker" id="end-date" name="end_date"
                                                           type="text"
                                                           placeholder="" autocomplete="off"
                                                           value="{{ old('end_date') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Interested earned
                                            </label>
                                            @if(isset($toolTip->interest_earn_tooltip))
                                                <a class="ps-tooltip" href="javascript:void(0)"
                                                   data-tooltip="{{$toolTip->interest_earn_tooltip}}"><i
                                                            class="fa fa-exclamation-circle"></i></a>
                                            @endif
                                            <input class="form-control" name="interest_earned" type="text"
                                                   placeholder="Enter Interest Rate &/OR in dollar amount"
                                                   value="{{ old('interest_earned') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                                <div class="form-group submit">
                                                    <label style="margin: 5px 0 5px;">Do not Send Reminders</label>
                                                    <input type="checkbox" class="form-control" checked="checked" disabled="disabled"
                                                           name="dod_reminder"
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
                                                    <button type="submit" class="ps-btn">Add Products</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ Form::close() }}
                                @if(count($user_products))
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                            <div class="ps-table-wrap">
                                                <table class="ps-table ps-table--product-managerment" id="datatable">
                                                    <thead>
                                                    <tr>
                                                        <th>Bank</th>
                                                        <th>Account
                                                            <br> Name
                                                        </th>
                                                        <th>Amount</th>
                                                        <th>Tenor
                                                            <br> (M= months,
                                                            <br> D = Days)
                                                            <br> Y = Years)
                                                        </th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th>Interest Earned</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(count($user_products))
                                                        @foreach($user_products as $value)
                                                            @php
                                                            $curr_date = date("Y-m-d", strtotime('now'));
                                                            $start_date = date("Y-m-d", strtotime($value->start_date));
                                                            $end_date = date("Y-m-d", strtotime($value->end_date));
                                                            @endphp
                                                            <tr>
                                                                <td @if(!empty($value->brand_logo)) style="padding: 0;" @endif>
                                                                    @if(!empty($value->brand_logo))
                                                                        <span style="opacity: 0;position: absolute;"> {{ $value->title }} </span>
                                                                        <img src="{{ asset($value->brand_logo) }}">
                                                                    @elseif($value->other_bank)
                                                                        {{ $value->other_bank }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                                <td>{{ !empty($value->account_name) ? $value->account_name : '-' }}</td>
                                                                <td>{{ !empty($value->amount) ? '$'.$value->amount : '-' }}</td>
                                                                <td>{{ !empty($value->tenure) ? $value->tenure . ' ' . $value->tenure_calender : '-' }}</td>
                                                                <td>{{ !empty($value->start_date) ? date("d-m-Y", strtotime($value->start_date)) : '-' }}</td>
                                                                <td>{{ !empty($value->end_date) ? date("d-m-Y", strtotime($value->end_date)) : '-' }}</td>
                                                                <td>{{ isset($value->interest_earned) ? $value->interest_earned : '-' }}</td>
                                                                <td>@if(($curr_date<=$end_date && $curr_date>=$start_date) || (empty($value->end_date)))
                                                                        Ongoing @else Expired @endif</td>
                                                                <td>
                                                                    <a href="{{ route('product-management.edit', ['id'  =>  $value->product_id]) }}">
                                                                        <button type="button"
                                                                                class="ps-btn--action warning">
                                                                            Edit
                                                                        </button>
                                                                    </a>
                                                                    <a onclick="return confirm('Are you sure to delete?')"
                                                                       href="{{ route('product-management.delete', ['id'  =>  $value->product_id]) }}">
                                                                        <button type="button"
                                                                                class="ps-btn--action success">
                                                                            Delete
                                                                        </button>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                 @include('frontend.includes.vertical-ads-profile')
                                @include('frontend.includes.horizontal-ads')
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(document).ready(function () {
            if ($("input[name='end_date']").val().length != 0) {
                $(".reminder").find('input[type=checkbox]').prop("disabled", false);
                $("input[name='dod_reminder']").attr("disabled", false);
            } else {
                $('.reminder').find('input[type=checkbox]:checked').removeAttr('checked');
                $(".reminder").find('input[type=checkbox]').prop("disabled", true);
                $("input[name='dod_reminder']").attr("disabled", true);
            }

            $('#datatable').DataTable({
                "pageLength": 10,
                'ordering': true,
                "aoColumnDefs": [{
                    "aTargets": [8],
                    "bSortable": false,

                }]
            });
        });
        $("input[name='end_date']").on("change", function () {
            var valueLenght = $(this).val().length;
            if (valueLenght == 0) {
                $('.reminder').find('input[type=checkbox]:checked').removeAttr('checked');
                $(".reminder").find('input[type=checkbox]').prop("disabled", true);
                $("input[name='dod_reminder']").prop('checked', false);
                $("input[name='dod_reminder']").attr("disabled", true);
                $(".select2").select2("val", " ");
            }
            else {
                if ($("input[name='dod_reminder']").is(":checked") !== false) {
                    $('.reminder').find('input[type=checkbox]:checked').removeAttr('checked');
                    $(".reminder").find('input[type=checkbox]').prop("disabled", true);
                    $(".select2").select2("val", " ");
                }else{
                    $(".reminder").find('input[type=checkbox]').prop("disabled", false);
                }
                $("input[name='dod_reminder']").attr("disabled", false);
            }
        });
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

        $("input[name='dod_reminder']").on("change", function () {
            if ($(this).is(":checked") !== false) {
                $('.reminder').find('input[type=checkbox]:checked').removeAttr('checked');
                $(".reminder").find('input[type=checkbox]').prop("disabled", true);
                $(".select2").select2("val", " ");
            }
            else {
                $(".reminder").find('input[type=checkbox]').prop("disabled", false);
            }
        });
        if ($("input[name='dod_reminder']").is(":checked") !== false) {
            $('.reminder').find('input[type=checkbox]:checked').removeAttr('checked');
            $(".reminder").find('input[type=checkbox]').prop("disabled", true);
            $(".select2").select2("val", " ");
        }
        /*dod_onoff();
         $("input[name='start_date'], input[name='end_date']").on("change", function () {
         dod_onoff();
         });

         function dod_onoff() {
         var start_date = $("input[name='start_date']").val();
         var end_date = $("input[name='end_date']").val();
         if (start_date == '' || end_date == '') {
         $("input[name='dod_reminder']").prop('checked', false);
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
        });
    </script>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
