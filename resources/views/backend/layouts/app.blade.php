<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

@include('backend.inc.head')

<body class="hold-transition skin-blue sidebar-mini">
{{--<div class="se-pre-con"></div>--}}
<div class="wrapper" id="">
    <header class="main-header">
        @include('backend.inc.navbar')
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        @include('backend.inc.sidebar')
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
        </div>
        <script type="text/javascript">document.write(new Date().getFullYear());</script>
        <strong> Dollar Dollar.</strong> All rights reserved.
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        @include('backend.inc.control-sidebar')
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
@include('backend.inc.footer')
</body>
</html>
