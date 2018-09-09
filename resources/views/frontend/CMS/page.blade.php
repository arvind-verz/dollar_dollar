@extends('frontend.layouts.app')
@section('title', $page->title)
@section('content')



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
    <?php
    //$pageName = strtok($page->name, " ");;
    $pageName = explode(' ', trim($page->name));
    $pageHeading = $pageName[0];
    // $a =  array_shift($arr);
    unset($pageName[0]);
    $redirect_url = 'javascript:void(0)';
    if($page->slug=='health-insurance') {
        $redirect_url = 'health-insurance-enquiry';
    }
    elseif($page->slug=='life-insurance') {
        $redirect_url = 'life-insurance-enquiry';
    }
    elseif($page->slug=='investment') {
        $redirect_url = 'investment-enquiry';
    }
    $auth_check = Auth::check();
    ?>
    {{--Page content start--}}
    @if($page->slug!=THANK_SLUG)
        <main class="ps-main">
            <div class="container">
                <h3 class="ps-heading mb-35 pl-15">
                    <span>@if(!empty($page->icon))<i class="{{ $page->icon }}"></i>@endif {{$pageHeading}} {{implode(' ',$pageName)}} </span>
                </h3>



                {!!  $page->contents !!}

            </div>
        </main>
    @else
        {!!  $page->contents !!}
    @endif
    {{--Page content end--}}
    {{--contact us or what we offer section start--}}
    @if(isset($page->contact_or_offer) && isset($systemSetting->{$page->contact_or_offer}))
        {!! $systemSetting->{$page->contact_or_offer} !!}
    @endif


    {{--contact us or what we offer section end--}}
<!-- Modal -->
<script>
    $(document).ready(function() {
        var auth_check = '{{ $auth_check }}';
        var redirect_url = '{{ url("$redirect_url") }}';
        if(auth_check==1) {
            $(".ps-block--highlight button").remove();
            $(".ps-block--highlight h4").after('<a class="ps-btn" href="'+redirect_url+'">Get quotes</a>');
        }
    });
</script>
<div id="myModalInsurance" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <p>You have to Login/Register to submit a Quote</p>
            </div>
            <div class="col-lg-3">
                <a class="ps-btn" href="{{ url($redirect_url) }}">Login</a>
            </div>
            <div class="col-lg-3">
                <a class="ps-btn ps-btn--outline" href="@if(!empty($redirect_url)) {{ url('registration_page', ['redirect_url' => $redirect_url]) }} @else {{ url('registration') }} @endif">Signup</a>
            </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
