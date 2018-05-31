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
    <meta name="description" content="">
    <meta name="author" content="">
    <link href=" {{ asset('apple-touch-icon.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('favicon.png') }}" rel="icon">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700%7COpen+Sans:300,400,600,700"
          rel="stylesheet">
    <link href="{{ asset('frontend/css/plugin.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
    <!--HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--WARNING: Respond.js doesn't work if you view the page via file://-->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script type="text/javascript">
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        var APP_URL = {!! json_encode(url('/')) !!}
    </script>

</head>
<body>
@include('frontend.includes.menu')
        <!-- Content Containers start -->
@yield('content')
        <!-- Content Containers END -->
<!-- Footer -->
@include('frontend.includes.footer')
        <!-- Footer END -->
<div id="totop"><span>backtotop<i class="fa fa-arrow-right"></i></span></div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".only_numeric").numeric();
        // NUMERIC DIGITS WITH + SPECIAL ONLY
        $("input[name='country_code'], input[name='telephone']").on('keydown', function (e) {
            if((e.keyCode<48 || e.keyCode>57) && e.keyCode!=8 && e.keyCode!=37 && e.keyCode!=39 && e.keyCode!=9 && e.keyCode!=187) {
                e.preventDefault();
            }
        });
    });

    $(document).ready(function () {
        //Date picker
        $('.datepicker').datepicker({
            autoclose: true,
            dateFormat: "yy-mm-dd"
        });
    });
    
</script>
<script src="{{ asset('frontend/js/plugin.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.numeric.js') }}"></script>
<script src="{{ asset('frontend/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('frontend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5afe3db1c821ae18"></script>

</body>
</html>