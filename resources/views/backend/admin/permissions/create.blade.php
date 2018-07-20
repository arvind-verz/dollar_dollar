@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( PERMISSION_MODULE )}}
            <small>{{PERMISSION_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('admins.index') }}">{{USER_MODULE}}</a></li>
            <li class="active">{{PERMISSION_MODULE_SINGLE.' '.ADD_ACTION}}</li>
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

                        <h3 class="box-title">{{PERMISSION_MODULE_SINGLE.' '.ADD_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','route'=>['permissionsStore'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="form-group">
                                {{Form::label('name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    {{Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => ''])}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{Form::label('modules', 'Modules',['class'=>'col-sm-2 control-label'])}}
                                <div class="col-sm-10">
                                    @foreach($Modules as $modules)
                                        <table class="table row border">
                                            <tr  >
                                                <th  colspan="2" style="border:0;">{{$modules->label}}</th></tr>

                                            <tr>
                                                <td>View
                                                </td>
                                                <td>
                                                    <input type="radio" name="module[{{$modules->id}}]['view'][]" value="1" checked>Yes
                                                    <input type="radio" name="module[{{$modules->id}}]['view'][]" value="0">No
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Create</td>
                                                <td>

                                                    <input type="radio" name="module[{{$modules->id}}]['create'][]" value="1" checked>Yes
                                                    <input type="radio" name="module[{{$modules->id}}]['create'][]" value="0">No
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Edit</td>
                                                <td>
                                                    <input type="radio" name="module[{{$modules->id}}]['edit'][]" value="1" checked>Yes
                                                    <input type="radio" name="module[{{$modules->id}}]['edit'][]" value="0">No
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Delete
                                                </td>
                                                <td>
                                                    <input type="radio" name="module[{{$modules->id}}]['delete'][]" value="1" checked>Yes
                                                    <input type="radio" name="module[{{$modules->id}}]['delete'][]" value="0">No
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Import
                                                </td>
                                                <td>
                                                    <input type="radio" name="module[{{$modules->id}}]['import'][]" value="1" checked>Yes
                                                    <input type="radio" name="module[{{$modules->id}}]['import'][]" value="0">No
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Export
                                                </td>
                                                <td>
                                                    <input type="radio" name="module[{{$modules->id}}]['export'][]" value="1" checked>Yes
                                                    <input type="radio" name="module[{{$modules->id}}]['export'][]" value="0">No
                                                </td>
                                            </tr>

                                        </table>
                                    @endforeach
                                </div>
                            </div>


                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("admins.index")}}"
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
