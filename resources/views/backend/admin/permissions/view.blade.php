<div class="row">
    @include('backend.inc.messages')
    <div class="col-xs-12">
        <div class="box box-info ">
            <div class="box-header with-border">
                <i class="fa fa-user-secret"></i>

                <h3 class="box-title">{{PERMISSION_MODULE_SINGLE.'s'}}</h3>
                @if($CheckLayoutPermission[0]->create==1)
                    <a href="{{route("permissionsCreate")}}" class="">
                        <button type="submit" class="btn btn-info pull-right"><i
                                    class="fa  fa-plus"></i> {{ADD_ACTION.' '.PERMISSION_MODULE_SINGLE}}
                        </button>
                    </a>
                @endif


            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @if(!empty($role_array))

                    <table style="table-layout: fixed; width: 100%;">
                        <tr>
                            <td>
                                <div style="width: 100%; overflow-x: auto;">

                                    <table id="brands" class="table ">
                                        <thead>
                                        <tr>

                                            <th>Role Name</th>
                                            <th>Modules</th>
                                            <th>Role Access</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($role_array as $key=>$value)
                                            <tr>
                                                <td>
                                                    {!! $key   !!}
                                                </td>

                                                <td>
                                                    <?php echo implode(", ", $role_array[$key]["modules"]);?>
                                                </td>
                                                <td>
                                                    <?php echo implode(", ", $role_array[$key]["Access"]);?>

                                                </td>
                                                <td class="text-center">
                                                    @if($CheckLayoutPermission[0]->edit==1)
                                                        <a class="btn btn-app edit" title="Edit Permission"
                                                           href="{{ route("permissionsEdit",["id"=>$role_array[$key]["id"][0]]) }}">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                    @endif
                                                    @if($CheckLayoutPermission[0]->delete==1)
                                                        <a class="btn btn-app delete" title="Delete Permission"
                                                           onclick="return confirm('Are you sure to delete this?')"
                                                           href="{{ route("permissionsDestroy",["id"=>$role_array[$key]["id"][0]]) }}">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif

                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>


            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
    <!-- /.col -->
</div>
<!-- /.row -->