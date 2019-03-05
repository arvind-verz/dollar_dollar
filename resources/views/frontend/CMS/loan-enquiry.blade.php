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
                <div class="ps-block--image">
                    <div class="ps-block__content">
                        <h3 class="ps-heading"><span> <i class="fa fa-area-chart"></i> Home </span> Loan</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br/><br/>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. <a href="">LEARN MORE<i class="fa fa-angle-right"></i></a></p>
                    </div>
                    <div class="ps-block__content right" ><img src="{{asset('/uploads/uploads/images/loan.jpg')}}" alt=""></div>
                </div>
                <div class="ps-loan-from">
                    <label>FULL NAME<input class="full-name" type="text"></label>
                    <label>EMAIL<input class="email" type="text"></label>
                    <label class="ps-loan-mobile">MOBILE<span><input type="text" value="+65"><input type="text"></span></label>
                    <label>Property Type<select><option>Property Type</option></select></label>
                    <label>Loan Amnount<input type="text"></label>
                    <label>Loan Type<select><option>Loan Type</option></select></label>
                    <button>SUBMIT</button>
                </div>
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
    $(document).ready(function() {
        inputs_checked();
        /*var inputs = $("input[name='other_value'], input[name='full_name'], input[name='email'], input[name='country_code'], input[name='telephone']");
        inputs.prop("disabled", true);
        $("input[name='components[]'], input[name='gender'], input[name='smoke'], input[name='time[]']").on("change", function() {
            inputs_checked();
        });*/

        function inputs_checked() {
            $(" input[name='full_name'], input[name='email'], input[name='country_code'], input[name='telephone']").prop("readonly", true);
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
