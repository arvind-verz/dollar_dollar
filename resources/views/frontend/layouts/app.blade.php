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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <link href="{{ asset('frontend/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
    <style type="text/css">
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
    </style>

</head>
<body>
    <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
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
      <div id="totop"><span>backtotop<i class="fa fa-arrow-right"></i></span></div>
      <a class="profile" href="{{ url(PROFILEDASHBOARD) }}"><span>profile page<i class="fa fa-arrow-right"></i></span></a><!-- 
      <a class="placement" href="javascript:void(0)"><span>placement amount<i class="fa fa-arrow-right"></i></span></a> -->
    </div>

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
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd"
        });
    });
    
    $('a.placement').click(function() {
        $("input[name='search_value']").focus();
    });    
</script>
<script type="text/javascript">
        $(document).ready( function () {
            $('#datatable').DataTable();
        } );
    </script>

<script src="{{ asset('frontend/js/plugin.js') }}"></script>
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