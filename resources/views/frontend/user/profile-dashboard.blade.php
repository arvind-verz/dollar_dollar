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
            <div class="row c-profile">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                    <div class="ps-sidebar">
                        <ul class="ps-list--sidebar">
                            <li class="current"><a href="{{ url('profile-dashboard') }}">Profile Dashboard</a></li>
                            <li><a href="{{ url('account-information') }}">Profile Information</a></li>
                            <li><a href="{{ url('product-management') }}">Product Management</a></li>
                        </ul>
                        @include('frontend.includes.vertical-ads-profile')
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>My Profile Dashboard</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            <p>Hello, <strong>  {{ AUTH::user()->first_name . ' ' . AUTH::user()->last_name }}</strong></p>

                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/user.png" alt="">Account Information</h5>
                                </div>
                                <div class="ps-block__content">
                                    <h5>Contact Information</h5>

                                    <p><strong>  Name: </strong> {{ AUTH::user()->first_name . ' ' . AUTH::user()->last_name }}</p>
                                    <p><strong>  Contact Number: </strong> {{ AUTH::user()->country_code . ' ' . AUTH::user()->tel_phone }}</p>
                                    <p><strong> Email: </strong>{{ AUTH::user()->email }}</p>
                                    <p><strong> Newsletter: </strong>@if(AUTH::user()->email_notification==1) Yes @else No @endif</p>
                                    <p><strong> Consent to marketing information: </strong>@if(AUTH::user()->adviser==1) Yes @else No @endif</p>
                                </div>
                            </div>
                            @if(count($products))
                                <div class="ps-block--box info recommended-product">
                                    <div class="ps-block__header">
                                        <h5><img src="img/icons/file.png" alt="">Featured products</h5>
                                        <!-- <a href="#">View all</a> -->
                                    </div>
                                    <div class="ps-block__content">
                                        <div class="c-list ps-slider--feature-product saving nav-outside owl-slider"
                                             data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000"
                                             data-owl-gap="0" data-owl-nav="true" data-owl-dots="false"
                                             data-owl-item="3" data-owl-item-xs="1" data-owl-item-sm="2"
                                             data-owl-item-md="2" data-owl-item-lg="3" data-owl-duration="1000"
                                             data-owl-mousedrag="on"
                                             data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;"
                                             data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                                            @foreach($products as $product)
                                                <div class="ps-block--short-product second"><div class="slider-img"><img
                                                            src="{{ asset($product->brand_logo) }}" alt=""></div>
                                                    <h4><strong>up to   <span class="highlight-slider"> {{ $product->maximum_interest_rate }}
                                                                %</span></strong>
                                                    </h4>

                                                    <div class="ps-block__info">
                                                        <p><span class="slider-font">Rate: </span>{{ $product->maximum_interest_rate }}
                                                            %</p>

                                                        <p><span class="slider-font">Min:</span> SGD
                                                            ${{ Helper::inThousand($product->minimum_placement_amount) }}
                                                        </p>

                                                        <p class="highlight highlight-bg ">
                                                            @if($product->promotion_period==ONGOING)
                                                                 {{ $product->promotion_period }}
                                                            @elseif($product->promotion_type_id!=ALL_IN_ONE_ACCOUNT)
                                                                @if(in_array($product->formula_id,[SAVING_DEPOSIT_F1,FOREIGN_CURRENCY_DEPOSIT_F2,PRIVILEGE_DEPOSIT_F1]))
                                                                    {{ $product->remaining_days }}  <span
                                                                            class="slider-font">{{\Helper::daysOrMonthForSlider(1,  $product->remaining_days)}}</span>
                                                                @else
                                                                    {{$product->promotion_period}} @if($product->tenure_value > 0)
                                                                        <span
                                                                                class="slider-font">{{\Helper::daysOrMonthForSlider(2,  $product->tenure_value)}}</span> @endif
                                                                @endif
                                                            @else
                                                                {{ $product->promotion_period }} Criteria
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <a class="ps-btn"
                                                       href="@if($product->promotion_type_id==1) fixed-deposit-mode @elseif($product->promotion_type_id==2) saving-deposit-mode @elseif($product->promotion_type_id==3) all-in-one-deposit-mode @elseif($product->promotion_type_id==4) privilege-deposit-mode @elseif($product->promotion_type_id==5) foreign-currency-deposit-mode @endif">More
                                                        info</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>.
                            @endif
                            <div class="ps-block--box info no-border" style="padding: 0;">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/file.png" alt="">All my Accounts</h5>
                                    <!-- <a href="#">View all</a> -->
                                </div>
                                <div class="ps-block__content">
                                    <div class="ps-table-wrap">
                                        <table class="ps-table ps-table--product-managerment" id="datatable">
                                            <thead>
                                            <tr>
                                                <th>Bank</th>
                                                <th>Account
                                                    <br> Name
                                                </th>
                                                <th>Amount</th>
                                                <th>Tenure
                                                    <br> (M= months,
                                                    <br> D = Days)
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
                                                                <button type="button" class="ps-btn--action warning">
                                                                    Edit
                                                                </button>
                                                            </a>
                                                            <a onclick="return confirm('Are you sure to delete?')"
                                                               href="{{ route('product-management.delete', ['id'  =>  $value->product_id]) }}">
                                                                <button type="button" class="ps-btn--action success">
                                                                    Delete
                                                                </button>
                                                            </a>
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
            $('#datatable').DataTable({
                "pageLength": 10,
                'ordering': true,
                "aoColumnDefs": [{
                    "aTargets": [8],
                    "bSortable": false,

                }]
            });
        });
    </script>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
