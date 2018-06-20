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
                            <!-- <div class="ps-block--box recommended-product">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/file.png" alt="">recommended products</h5><a href="#">View all</a>
                                </div>
                                <div class="ps-block__content">
                                    <div class="ps-block--short-product second"><img src="img/logo/1.png" alt="">
                                        <h4>up to <strong> 1.3%</strong></h4>
                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>1.3%</p>
                                            <p><strong>Min:</strong> SGD $20,000</p>
                                            <p class="highlight">12 Months</p>
                                        </div><a class="ps-btn" href="#">More info</a>
                                    </div>
                                    <div class="ps-block--short-product second"><img src="img/logo/1.png" alt="">
                                        <h4>up to <strong> 1.3%</strong></h4>
                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>1.3%</p>
                                            <p><strong>Min:</strong> SGD $20,000</p>
                                            <p class="highlight">12 Months</p>
                                        </div><a class="ps-btn" href="#">More info</a>
                                    </div>
                                    <div class="ps-block--short-product second"><img src="img/logo/1.png" alt="">
                                        <h4>up to <strong> 1.3%</strong></h4>
                                        <div class="ps-block__info">
                                            <p><strong> rate: </strong>1.3%</p>
                                            <p><strong>Min:</strong> SGD $20,000</p>
                                            <p class="highlight">12 Months</p>
                                        </div><a class="ps-btn" href="#">More info</a>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-block--box no-border">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/file.png" alt="">Recently Added Products</h5><a href="#">View all</a>
                                </div>
                                <div class="ps-block__content">
                                    <div class="ps-table-wrap">
                                        <table class="ps-table ps-table--product-managerment">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Amount</th>
                                                    <th>Tenor (Months)</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Interested Earned</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>DBS</td>
                                                    <td>$6,000</td>
                                                    <td>24</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xxx.xx</td>
                                                    <td>InActive</td>
                                                    <td>
                                                        <button class="ps-btn--action warning">Edit</button>
                                                        <button class="ps-btn--action success">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>OCBC</td>
                                                    <td>$1,500</td>
                                                    <td>12</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xxx.xx</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button class="ps-btn--action warning">Edit</button>
                                                        <button class="ps-btn--action success">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>UOB</td>
                                                    <td>$3,000</td>
                                                    <td>36</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xxx.xx</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button class="ps-btn--action warning">Edit</button>
                                                        <button class="ps-btn--action success">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="ps-block--box no-border">
                                <div class="ps-block__header">
                                    <h5><img src="img/icons/file.png" alt="">Promotion Ending Products</h5><a href="#">View all</a>
                                </div>
                                <div class="ps-block__content">
                                    <div class="ps-table-wrap">
                                        <table class="ps-table ps-table--product-managerment">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Amount</th>
                                                    <th>Tenor (Months)</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Interested Earned</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>DBS</td>
                                                    <td>$6,000</td>
                                                    <td>24</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xxx.xx</td>
                                                    <td>InActive</td>
                                                    <td>
                                                        <button class="ps-btn--action warning">Edit</button>
                                                        <button class="ps-btn--action success">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>OCBC</td>
                                                    <td>$1,500</td>
                                                    <td>12</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xxx.xx</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button class="ps-btn--action warning">Edit</button>
                                                        <button class="ps-btn--action success">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>UOB</td>
                                                    <td>$3,000</td>
                                                    <td>36</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xx-xx-xxxx</td>
                                                    <td>xxx.xx</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button class="ps-btn--action warning">Edit</button>
                                                        <button class="ps-btn--action success">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif
    {{--contact us or what we offer section end--}}

@endsection
