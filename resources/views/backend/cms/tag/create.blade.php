@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( TAG_MODULE )}}
            <small>{{TAG_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
                <li><a href="{{ route('tag.index') }}">{{TAG_MODULE}}</a></li>
                @if(isset($parent))
                    <?php
                    $breadcums = Helper::getBreadCumsCategoryByMenus($parent);
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
                    <li class="active">{{TAG_MODULE_SINGLE.' '.ADD_ACTION}}</li>
                @endif
            </ol>
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

                        <h3 class="box-title">{{TAG_MODULE_SINGLE.' '.ADD_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => 'admin/tag', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                {{Form::label('tag', 'Title',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('tag', old('tag'), ['class' => 'form-control', 'placeholder' => '','data-role'=>'tagsinput'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Status</label>

                                <div class="col-sm-10">

                                    <select class="form-control select2"
                                            data-placeholder="" name="status"
                                            style="width: 100%;">
                                        <option value="1">Active</option>
                                        <option value="0">Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("tag.index")}}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i> Add
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
