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
                        @if(count($ads))
                        <div class="pt-2">
                            <a href="{{ isset($ads->ad_link) ? asset($ads[0]->ad_link) : '#' }}" target="_blank"><img src="{{ asset($ads[0]->ad_image) }}" alt=""></a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>Product Management</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            {!! Form::open(['route' => 'product-management.store', 'class'  =>  'ps-form--product-management', 'method' =>  'POST']) !!}
                                <div class="ps-form__header"><a class="ps-btn" href="#">Add Products</a></div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Bank <sup>*</sup></label>
                                            <select class="form-control" name="bank_id" required="required">
                                                <option value="">Please select</option>
                                                @foreach($brands as $bank)
                                                    <option value="{{ $bank->id }}" @if($bank->id==old('bank_id')) selected @endif>{{ $bank->title }}</option>
                                                    
                                                @endforeach
                                                <option value="0">Other</option>
                                            </select>
                                            <input type="text" class="form-control hide" name="bank_id_other" value="" placeholder="Enter bank name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Account Name</label>
                                            <input class="form-control" name="account_name" type="text" placeholder="Enter Account Name" value="{{ old('account_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Amount <sup>*</sup></label>
                                            <input class="form-control prefix_dollar" required="required" name="amount" type="text" placeholder="Enter Amount"  value="{{ (old('amount')) ? old('amount') : '0.000' }}">
                                            <!-- <span class="suffix_k">K</span> -->
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Tenor</label>
                                            <input type="text" class="form-control only_numeric" name="tenure" value="{{ old('tenure') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Reminder</label>
                                            <select class="form-control select2" name="reminder[]" multiple="multiple">
                                                <option value="1 Day">1 Day</option>
                                                <option value="1 Week">1 Week</option>
                                                <option value="2 Week">2 Week</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input class="form-control datepicker" name="start_date" type="text" placeholder="" autocomplete="off" value="{{ old('start_date') }}">
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input class="form-control datepicker" name="end_date" type="text" placeholder="" autocomplete="off" value="{{ old('end_date') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Interested earned</label>
                                            <input class="form-control" name="interest_earned" type="text" placeholder="Enter Interest Earned" value="{{ old('interest_earned') }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                                        <div class="form-group">
                                            <label>Don’t Send Reminders</label>
                                            <input type="checkbox" class="form-control" name="dod_reminder" @if(old('dod_reminder')==1) checked @endif>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group submit">
                                    <p>"<span>*</span>" are mandatory fields.</p>
                                    <button type="submit" class="ps-btn">Submit</button>
                                </div>
                            {{ Form::close() }}
                            <div class="ps-table-wrap">
                                <table class="ps-table ps-table--product-managerment" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>Bank</th>
                                            <th>Account
                                                <br> Name</th>
                                            <th>Amount</th>
                                            <th>Tenor
                                                <br> (M= months,
                                                <br> D = Days)</th>
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
                                                <td><img src="{{ asset($value->brand_logo) }}" width="50"> {{ $value->title }}</td>
                                                <td>{{ $value->account_name }}</td>
                                                <td>{{ $value->amount }}</td>
                                                <td>{{ $value->tenure }}</td>
                                                <td>{{ date("d-m-Y", strtotime($value->start_date)) }}</td>
                                                <td>{{ date("d-m-Y", strtotime($value->end_date)) }}</td>
                                                <td>{{ isset($value->interest_earned) ? $value->interest_earned.'%' : '-' }}</td>
                                                <td>@if($curr_date<=$end_date && $curr_date>=$start_date) Ongoing @else Expired @endif</td>
                                                <td>
                                                    <a href="{{ route('product-management.edit', ['id'  =>  $value->product_id]) }}"><button type="button" class="ps-btn--action warning">Edit</button></a>
                                                    <a onclick="return confirm('Are you sure to delete?')" href="{{ route('product-management.delete', ['id'  =>  $value->product_id]) }}"><button type="button" class="ps-btn--action success">Delete</button></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td class="text-center" colspan="9">No data found.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
