<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href=" {{ asset('apple-touch-icon.png') }}" rel="apple-touch-icon">
<link href="{{ asset('favicon.png') }}" rel="icon">
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('backend/bower_components/font-awesome/css/font-awesome.min.css') }}">

<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('backend/bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('backend/bower_components/DataTables/datatables.min.css') }}">
<link rel="stylesheet"
      href="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.css') }} ">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="{{ asset('backend/dist/css/skins/_all-skins.min.css' ) }}">
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('backend/bower_components/morris.js/morris.css' ) }}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('backend/bower_components/jvectormap/jquery-jvectormap.css')}}">
<!-- Date Picker -->
<link rel="stylesheet"
      href="{{ asset('backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/all.css')}}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet"
      href="{{ asset('backend/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('backend/plugins/timepicker/bootstrap-timepicker.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('backend/bower_components/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
<link rel="stylesheet" href="{{ asset('backend/bower_components/iconpicker/fontawesome-iconpicker.min.css')}}">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript" src="{{ asset('backend/dist/js/jquery.min.js') }}"></script>
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" id="script"></script>
<script src="{{ asset('js/tinymce/jquery.tinymce.min.js') }}" id="script"></script>
<script src="{{ asset('js/tinymce/plugins/variable/plugin.min.js') }}"></script>
{{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
<script>
    $(window).load(function () {
// Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
</script>--}}
<!-- Google Font -->
<script> var APP_URL = {!! json_encode(url('/')) !!}</script>
<link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
{{--tag css--}}
<link rel="stylesheet" href="{{ asset('backend/dist/bootstrap-tagsinput.css') }}"/>
<style>
    input[type='checkbox'] {
        height: 25px;
        width: 25px;
    }
</style>
<!-- jQuery 3 -->
<script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('backend/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js' ) }}"></script>
<!-- Select2 -->
<script src="{{ asset('backend/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<!-- DataTables -->
<script src="{{ asset('backend/bower_components/DataTables/datatables.min.js' ) }}"></script>
<script src="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/iconpicker/fontawesome-iconpicker.js') }}"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/DataTables/Buttons-1.5.1/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
