<?php
$systemSetting = \Helper::getSystemSetting();
if (!$systemSetting) {
    return back()->with('error', OPPS_ALERT);
}

?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('description')
    @yield('keywords')
    @yield('author')
    <meta name="dcterms.rightsHolder" content="dollardollar.sg– DollarDollar"/>
    <linkrel="shortcut icon" href="https://dollardollar.sg/favicon.ico"/>
    <linkrel="icon" type="image/gif" href="https://dollardollar.sg/animated_favicon1.gif"/>
    <link href=" {{ asset('apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('favicon.png') }}" rel="icon">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700%7COpen+Sans:300,400,600,700"
          rel="stylesheet">
    <link href="{{ asset('frontend/css/plugin.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link href="{{ asset('frontend/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <script defer src="{{ asset('frontend/js/ls.unveilhooks.min.js') }}"></script>
    <script defer src="{{ asset('frontend/js/lazysizes.min.js') }}"></script>
    <!--HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--WARNING: Respond.js doesn't work if you view the page via file://-->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127066821-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'UA-127066821-1');
    </script>
    <script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/d0c9d1a35fc9a0bd73890de51/5fb5604a48423d0ba92bb0c8a.js");</script>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/plugin.js') }}"></script>
    {{--<script src="{{ asset('frontend/js/modernizr.js') }}"></script>--}}
    <script defer type="text/javascript">

        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        var APP_URL = {!! json_encode(url('/')) !!}
    </script>
    <script>
        window.onload = function() {
            owlCarousel($('.owl-slider'));
        };
    </script>
    <style defer type="text/css">
        .ps-form--filter .active {
            background-color: #0d6ec9;
            color: #fff;
        }

        .ps-table--product tbody tr.highlight {
            background-color: orange;
        }

        .selected_img {
            border: 1px solid #000;
        }

        /*.ps-slider--feature-product.owl-slider.nav-outside .owl-next, .ps-slider--feature-product.owl-slider.nav-outside .owl-prev{
            margin: 0;
            background: rgba(255,255,255,0.5);
        }
        .ps-slider--feature-product.owl-slider.nav-outside .owl-next:hover, .ps-slider--feature-product.owl-slider.nav-outside .owl-prev:hover{
            background: #FDB515;
        }*/
        .ps-home--partners .owl-nav .owl-next{
            margin-right: -55px !important;
        }
        /*.ps-block__header .owl-nav .owl-prev{
            left: -20px;
            background: rgba(255,255,255,0.5);
        }*/
        .for1{
            display: none;
        }
        
            .ps-home-blog .ps-section__left{
                height: 412px;
                padding: 5px 20px;
            }
        .ps-home-fixed-deposit .ps-tab-list li a{
            background: #41494C;
        }
        .ps-home-fixed-deposit .ps-slider--feature-product .ps-block--short-product{
            width: 100%;
        }
        .slider-content {
            background: #ffffff;
            height: auto;
            position: relative;
            display: table;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .wrapper-circle {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
            width: 100%;
            height: auto;
        }
        .ps-slider--home .owl-item img{
            margin: auto;
            max-width: 1000px;
        }
        @media (min-width: 1200px){
            .ads img{
                max-height: initial;
            }
        }
        @media (max-width: 1200px){
            .ps-page--deposit .owl-nav.show{
                width: 100% !important;
            }
            .product-col-00 .ps-slider--feature-product .owl-prev{
                margin: 0;
            }
            .ps-home-blog .ps-section__right{
                margin-left: 0;
                padding-left: 27px;
            }
        }
        @media (max-width: 990px){
            .owl-slider{
                overflow: hidden !important;
            }
            .ps-slider--home .owl-item img{
                max-width: 900px;
            }
        }

        @media (max-width: 768px){
            .ps-col-tiny .col-xs-12:nth-child(2), .ps-col-tiny .col-xs-12{
                width: 100%;
            }
            .foreign1{
                width: 70% !important;
            }
            .foreign2{
                width: 30% !important;
            }
            .for1{
                display: block;
                width: 20% !important;
            }
            .for2{
                display: none;
            }
            .for{
                width: 80% !important;
            }
            .ps-loan .refresh{
                margin-left: 0 !important;
            }
            .ps-slider--home .owl-item img{
                max-width: 768px;
            }
        }
        @media (max-width: 450px){
            .foreign1, .foreign2{
                width: 100% !important;
            }
            .ps-slider--home .owl-item img{
                max-width: 450px;
            }
        }

    </style>
    
</head>
<body style="@if(isset($page) && $page->slug==HOME_SLUG) background-color: #f3f8fb !important; @endif">
{{--<div class="se-pre-con"></div>--}}
<div id="fb-root"></div>
<script defer >(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v3.1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@include('frontend.includes.menu')
        <!-- Content Containers start -->
@yield('content')
        <!-- Content Containers END -->
<!-- Footer -->
@include('frontend.includes.footer')
        <!-- Footer END -->
<div class="totop">
    <div id="totop"><span>Back to Top<i class="fa fa-arrow-right"></i></span></div>
    <a class="profile" href="{{ url(PROFILEDASHBOARD) }}"><span>Profile Page<i class="fa fa-arrow-right"></i></span></a><!--
      <a class="placement" href="javascript:void(0)"><span>placement amount<i class="fa fa-arrow-right"></i></span></a> -->
</div>

<script defer type="text/javascript">
    
    $(document).ready(function () {
        //Date picker
        $('.datepicker').datepicker({
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
    });

    $('a.placement').click(function () {
        $("input[name='search_value']").focus();
    });
</script>
<script defer type="text/javascript">
    $(document).ready(function () {
        $('#datatable').DataTable();
    });
</script>
<script src="{{ asset('frontend/js/jquery.numeric.js') }}"></script>
<script src="{{ asset('frontend/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5afe3db1c821ae18"></script>
</body>
</html>