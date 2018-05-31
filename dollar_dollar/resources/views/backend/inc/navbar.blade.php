
    <!-- Logo -->
    <a href="{{ url('/admin') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"> <img src="{{ asset('favicon.png') }}" style="height: 25px; width: 25px;" class="img-circle" alt="User Image"></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><i ><img src="{{ asset('favicon.png') }}" style="height: 25px; width: 25px;" class="img-circle" alt="User Image"></i>&nbsp;{{ config('app.name') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-right" id="navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <span> &nbsp;{{ strtoupper( Auth::user()->first_name.' '.Auth::user()->last_name) }}</span> <span class="caret"></span></a>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="{{ route('edit-profile',['id'=>Auth::user()->id]) }}">Update Profile</a></li>
                        <li class="divider"></li>
                        {{-- <li><a href="#">Change Password</a></li>
                         <li class="divider"></li>--}}
                        <li><a href="{{ route('admin.logout') }}" >Logout</a></li>

                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>

    </nav>