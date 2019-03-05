@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( MENU_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            @if(isset($id))
                <li class=""><a href="{{ route('menu.index') }}">{{MENU_MODULE}}</a></li>
                <?php
                $breadcums = Helper::getBackendBreadCumsCategoryByMenus($id);
                $breadCumsCount = count($breadcums) - 1;
                ?>
                @for($i=0; $i<=$breadCumsCount;$i++)
                    @if($i==$breadCumsCount)
                        <li class="active">{{$breadcums[$i]['title']}}</li>
                    @else
                        <li><a
                                    href="{{ route("getSubMenus",["id"=>$breadcums[$i]['id']]) }}"> {{$breadcums[$i]['title']}}</a>
                        </li>

                    @endif
                @endfor
            @else
                <li class="active">{{MENU_MODULE}}</li>
            @endif
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-bars"></i>

                        <h3 class="box-title">@if(isset($menu)) {{ $menu->title }} @else {{MENU_MODULE_SINGLE.'s'}} @endif</h3>
                        @if($CheckLayoutPermission[0]->create==1)
                            <a href=" {{ route("menu-create",["parent"=>$parent]) }}" class="">
                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.MENU_MODULE_SINGLE}}
                                </button>
                            </a>
                        @endif


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="menus" class="table">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>View Order</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($menus->count())
                                                @foreach($menus as $menu)
                                                    <tr>
                                                        <td>
                                                            {{ $menu->title }}
                                                        </td>
                                                        <td>
                                                            {{ $menu->view_order }}
                                                        </td>
                                                        <td>
                                                            @if ($menu->created_at == null)
                                                                {{$menu->created_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($menu->created_at))   !!}

                                                        </td>
                                                        <td>@if ($menu->updated_at == null)
                                                                {{$menu->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($menu->updated_at))   !!}
                                                        </td>
                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Menu"
                                                                   href="{{ route("menu.edit",["id"=>$menu->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete @if(($menu->is_blog == 1 || $menu->is_dynamic == 1)) disabled @endif"
                                                                   title="Delete Menu"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("menu-destroy",["id"=>$menu->id]) }}">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </a>
                                                            @endif

                                                            <a class="btn btn-app list" title="Menu List"
                                                               href="{{ route("getSubMenus",["id"=>$menu->id]) }}">
                                                                <i class="fa fa-list"></i> List 
                                                                @if(count($countSubMenu))
                                                                    @foreach($countSubMenu as $key => $count)
                                                                        @if($key==$menu->id)
                                                                        <span class="badge">{{ count($count) }}</span>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </a>


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
    </section>
    <!-- /.content -->

@endsection
