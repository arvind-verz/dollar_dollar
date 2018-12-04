@extends('frontend.layouts.app')
@section('content')
@php
//Register page id is 1
$id=2;
//get banners
//
$banners=Helper::getBanners($id);
//dd($banners);
@endphp
<!-- Banner -->
@if($banners)
@foreach($banners as $banner)
<div class="banner-holder inner-banner">
    <img alt="" src="{{ asset($banner->banner_image) }}"/>
    <div class="bn-caption">
        <div class="container">
            <div class="bn-content">
                <div>
                    {!!  $banner->title!!}
                </div>
            </div>
        </div>
    </div>
    <div class="clear">
    </div>
</div>
@endforeach
@endif
<!-- Banner END -->
<!-- Content Containers -->
<div class="main-container">
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li>
                    <a href="{{ route('index') }}">
                        Home
                    </a>
                </li>
                <li>
                    <strong>
                        About Us
                    </strong>
                </li>
            </ul>
        </div>
    </div>
    <div class="fullcontainer">
        <div class="container">
            <div class="inner-container md pb20">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="row-inner">
                            <div class="image-gallery">
                                <div id="about_big">
                                    <img alt="" class="responsive bdr" src="{{ asset('images/office-2.jpg') }}"/>
                                </div>
                                <ul class="pro-thumb">
                                    <li>
                                        <a href="{{ asset('images/ISO-cert-2017-2018.jpg') }}" rel="enlargeimage::mousedown" rev="about_big">
                                            <img alt="" class="responsive bdr" src="{{ asset('images/ISO-cert-2017-2018.jpg') }}"/>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ asset('images/BizSAFE-Level-4-2015-2018.jpg') }}" rel="enlargeimage::mousedown" rev="about_big">
                                            <img alt="" class="responsive bdr" src="{{ asset('images/BizSAFE-Level-4-2015-2018.jpg') }}"/>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ asset('images/office-2.jpg') }}" rel="enlargeimage::mousedown" rev="about_big">
                                            <img alt="" class="responsive bdr" src="{{ asset('images/office-2.jpg') }}"/>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                        <div class="row-inner">
                            <div class="title3">
                                About Us
                            </div>
                            <p class="lead">
                                Speedo Marine is a major supplier of an extensive range of
industrial equipment and products. Established in 1972, we have since been
providing quality products and top-notch service to our valuable customers,
majority of whom come from the marine, oil and gas, petrochemical,
aerospace, construction, automobile, as well as furniture industries. In the
early 2000’s, Speedo Marine worked hand in hand with its sister company in
Shanghai to venture into the LNG industries in China, providing offshore
supply of insulation materials. In recent years, we have also acquired our
own hose manufacturing line, producing hoses for the marine industry. As a
result of cumulative experience, Speedo Marine today enjoys a reputation of
being the leading supplier committed to providing these industries with the
best services and products in the field.
                            </p>
                            <p class="lead">
                                Embracing our values of reliability, integrity, and efficiency,
we aim to meet our customers’ satisfaction through on-time deliveries, fast
response, and quality service. To provide greater convenience to our
customers, our products are available through our wide network of companies
located in Australia (various cities), Malaysia (Johor Bahru), Indonesia
(Surabaya) and China (Shanghai, for insulation material).
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Content Containers END -->
@endsection
