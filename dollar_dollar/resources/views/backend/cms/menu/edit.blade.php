@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( MENU_MODULE )}}
            <small>{{MENU_MODULE_SINGLE.' '.EDIT_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            @if(isset($id))
                <li class=""><a href="{{ route('menu.index') }}">{{MENU_MODULE}}</a></li>
                <?php
                $breadcums = Helper::getBackendBreadCumsCategoryByMenus($id);
                $breadCumsCount = count($breadcums) - 1;
                ?>
                @for($i=0; $i<=$breadCumsCount;$i++)
                    <li><a
                                href="{{ route("getSubMenus",["id"=>$breadcums[$i]['id']]) }}"> {{$breadcums[$i]['title']}}</a>
                    </li>
                @endfor
            @else
                <li class="active">{{MENU_MODULE}}</li>
            @endif
            <li class="active">{{MENU_MODULE_SINGLE.'  '.EDIT_ACTION}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>

                        <h3 class="box-title">{{MENU_MODULE_SINGLE.' '.EDIT_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => ['admin/menu', $menu->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                {{Form::label('title', 'Title',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('title', $menu->title, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Parent Menu</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="Select Sub menu of" name="parent"
                                            style="width: 100%;">
                                        <option value="0">Main menu</option>
                                        @if($menus->count())
                                            @foreach($menus as $singleMenu)
                                                <option value="{{ $singleMenu->id }}"
                                                        @if($singleMenu->id == $menu->parent) selected @endif>{{ $singleMenu->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                {{Form::label('view_order', 'View Order',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::number('view_order', $menu->view_order, ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        {{Form::hidden('_method','PUT')}}
                        <div class="box-footer">
                            <a href="{{route("menu.index")}}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-warning pull-right"><i class="fa  fa-check"></i>
                                Update
                            </button>

                        </div>
                        <!-- /.box-footer -->
                        {!! Form::close() !!}
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
