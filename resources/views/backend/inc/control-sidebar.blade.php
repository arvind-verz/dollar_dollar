        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li><a href="#system-setting" data-toggle="tab"><i class="fa fa-wrench"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="system-setting">
                <ul  class="sidebar-menu">
                    <li class=" ">
                    <a href="{{ route('system-setting.index') }}">
                        <i class="fa fa-cog"></i> <span>{{SYSTEM_SETTING_MODULE_SINGLE}}</span>
                    </a>
                    <a href="{{ route('system-setting-homepage.index') }}">
                        <i class="fa fa-cog"></i> <span>Homepage Setting</span>
                    </a>
                    </li>
                </ul>

            </div>
            <!-- /.tab-pane -->

        </div>