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
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 ">
                    <div class="ps-sidebar">
                        <h3 class="ps-heading"><span> My </span> Account</h3>
                        <ul class="ps-list--sidebar">
                            <li class="current"><a href="{{ url('profile-dashboard') }}">My Profile Dashboard</a></li>
                            <li><a href="{{ url('account-information') }}">Account Information</a></li>
                            <li><a href="{{ url('product-management') }}">Product Management</a></li>
                        </ul>
                        <div class="pt-2">
                            <a href="{{ isset($ads->ad_link) ? asset($ads[0]->ad_link) : '#' }}" target="_blank"><img src="{{ asset($ads[0]->ad_image) }}" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 ">
                    <div class="ps-dashboard">
                        <div class="ps-dashboard__header">
                            <h3>My Profile Dashboard</h3>
                        </div>
                        <div class="ps-dashboard__content">
                            <p>Hello, <strong> {{ AUTH::user()->first_name }}</strong></p>
                            <div class="ps-block--box info">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/user.png" alt="">Account Information</h5>
                                </div>
                                <div class="ps-block__content">
                                    <h5>Contact Information</h5>
                                    <p><strong> Name: </strong> {{ AUTH::user()->first_name }}</p>
                                    <p><strong> Email: </strong><a href="#">{{ AUTH::user()->email }}</a></p>
                                </div>
                            </div>
                            @if(count($user_products))
                            <div class="ps-block--box recommended-product">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/file.png" alt="">recommended products</h5><!-- <a href="#">View all</a> -->
                                </div>
                                <div class="ps-block__content">
                                    <div class="c-list ps-slider--feature-product saving nav-outside owl-slider" data-owl-auto="true" data-owl-loop="true" data-owl-speed="5000" data-owl-gap="0" data-owl-nav="true" data-owl-dots="false" data-owl-item="3" data-owl-item-xs="1" data-owl-item-sm="1" data-owl-item-md="2" data-owl-item-lg="3" data-owl-duration="1000" data-owl-mousedrag="on" data-owl-nav-left="&lt;i class='fa fa-caret-left'&gt;&lt;/i&gt;" data-owl-nav-right="&lt;i class='fa fa-caret-right'&gt;&lt;/i&gt;">
                                        @foreach($user_products as $promotion_product)
                                        <div class="ps-block--short-product second"><img src="img/logo/1.png" alt="">
                                            <h4>up to <strong> 1.3%</strong></h4>
                                            <div class="ps-block__info">
                                                <p><strong> rate: </strong>1.3%</p>
                                                <p><strong>Min:</strong> SGD $20,000</p>
                                                <p class="highlight">12 Months</p>
                                            </div><a class="ps-btn" href="#">More info</a>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>.
                            @endif
                            <div class="ps-block--box no-border">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/file.png" alt="">Recently Added Products</h5><!-- <a href="#">View all</a> -->
                                </div>
                                <div class="ps-block__content">
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
                                                        <td>{{ $value->interest_earned }}</td>
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
            </div>
        </div>
    </main>
    <script type="text/javascript">
        $(document).ready( function () {
            $('#datatable, #datatable1').DataTable();
        } );
    </script>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
