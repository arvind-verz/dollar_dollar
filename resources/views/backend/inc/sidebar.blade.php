        <!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    {{--<!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('backend/dist/img/user2-160x160.png') }}" class="img-circle" alt="User Image"/>
        </div>
        <div class="pull-left info">
            <p> {{ strtoupper( Auth::user()->first_name.' '.Auth::user()->last_name) }}</p>
            --}}{{-- <a href="#"><i class="fa fa-circle text-success"></i> Super Admin</a>--}}{{--
        </div>
    </div>--}}
    <!-- sidebar menu: : style can be found in sidebar.less -->

    <?php
    $menus = \Helper::getBackEndMenu();
    ?>

    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">NAVIGATION</li>
        <li>
            <a href="{{ route('admin.dashboard') }}" onclick="location.href='{{ route('admin.dashboard') }}'">

                <i class="fa fa-home"></i> <span>Dashboard</span>
            </a>
        </li>
        @foreach($menus as $menu)
            <?php $name = $menu->name; ?>

                @if($menu->label == ENQUIRY_MODULE)
                    <li class="treeview ">
                <a href="#" >
                    <i class="{{$menu->icon}}"></i> <span>{{$menu->label}}</span>
                     <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('contact-enquiry.index') }}"><i class="fa fa-tty"></i> Contact Enquiry</a></li>
                            <li><a href="{{ route('health-insurance-enquiry.index') }}"><i class="fa fa-plus"></i> Health Insurance Enquiry</a></li>
                            <li><a href="{{ route('life-insurance-enquiry.index') }}"><i class="fa fa-heart"></i> Life Insurance Enquiry</a></li>
                            <li><a href="{{ route('investment-enquiry.index') }}"><i class="fas fa-money-bill-alt"></i> Investment Enquiry</a></li>
                            <li><a href="{{ route('loan-enquiry.index') }}"><i class="fas fa-home"></i> Loan Enquiry</a></li>
                        </ul>
                    </li>
                    @elseif($menu->label == PRODUCT_MODULE)
                    <li class="treeview ">
                        <a href="#" >
                            <i class="{{$menu->icon}}"></i> <span>{{$menu->label}}</span>
                             <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class=" "><a href="{{ route('promotion-products',["productTypeId"=>FIX_DEPOSIT]) }}"><i class="fa fa-credit-card"></i>{{FIX_DEPOSIT_TITLE}}</a></li>
                            <li class=" "><a href="{{ route('promotion-products',["productTypeId"=>SAVING_DEPOSIT]) }}"><i class="fa fa-cloud"></i>{{SAVING_DEPOSIT_TITLE}}</a></li>
                            <li class=" "><a href="{{ route('promotion-products',["productTypeId"=>ALL_IN_ONE_ACCOUNT]) }}"><i class="fa fa-sign-language "></i>{{ALL_IN_ONE_ACCOUNT_TITLE}}</a></li>
                            <li class=" "><a href="{{ route('promotion-products',["productTypeId"=>PRIVILEGE_DEPOSIT]) }}"><i class="fa fa-bolt"></i>{{PRIVILEGE_DEPOSIT_TITLE}}</a></li>
                            <li class=" "><a href="{{ route('promotion-products',["productTypeId"=>FOREIGN_CURRENCY_DEPOSIT]) }}"><i class="fa fa-dollar-sign"></i>{{FOREIGN_DEPOSIT_TITLE}}</a></li>
                            <li class=" "><a href="{{ route('promotion-products',["productTypeId"=>LOAN]) }}"><i class="fa fa-home"></i>{{LOAN_TITLE}}</a></li>
                        </ul>
                    </li>
                    @elseif($menu->label == BANNER_MODULE)
                    <li class="treeview ">
                        <a href="#" >
                            <i class="{{$menu->icon}}"></i> <span>{{$menu->label}}</span>
                             <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class=" "><a href="{{ route('banner.index', ['type'=>'home-page']) }}"> Home Page</a></li>
                            <li class=" "><a href="{{ route('banner.index', ['type'=>'inner-page']) }}"> Inner Page</a></li>
                        </ul>
                    </li>
                    @elseif($menu->label == ADS_MANAGEMENT)
                    <li class="treeview ">
                        <a href="#" >
                            <i class="{{$menu->icon}}"></i> <span>{{$menu->label}}</span>
                             <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class=" "><a href="{{ route('ads.index', ['type'=>'account']) }}"> My Account</a></li>
                            <li class=" "><a href="{{ route('ads.index', ['type'=>'blog']) }}"> Blog</a></li>
                            <li class=" "><a href="{{ route('ads.index', ['type'=>'product']) }}"> Product</a></li>
                            <li class=" "><a href="{{ route('ads.index', ['type'=>'email']) }}"> Email</a></li>
                        </ul>
                    </li>
                    @elseif($menu->label == REPORT_MODULE)
                    <li class="treeview ">
                        <a href="#" >
                            <i class="{{$menu->icon}}"></i> <span>{{$menu->label}}</span>
                             <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="{{ route('customer-report') }}"><i class="fa fa-plus"></i> Customer</a></li>
                            <li><a href="{{ route('customer-deletion-report') }}"><i class="fa fa-plus"></i> Customer Deactivation </a></li>
                            <li><a href="{{ route('customer-update-detail') }}"><i class="fa fa-plus"></i> Customer Update Detail </a></li>
                        </ul>
                    </li>
                    @else

                    <li>
                    <a href="@if($menu->name=='#') {{ $menu->name }} @else{{ route($name) }} @endif" onclick="location.href='#'">

                        <i class="{{$menu->icon}}"></i> <span>{{$menu->label}}</span>
                    </a>
                    </li>
                    @endif

        @endforeach
    </ul>
</section>
<!-- /.sidebar -->
