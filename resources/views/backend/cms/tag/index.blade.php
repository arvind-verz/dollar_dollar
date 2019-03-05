@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( TAG_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            @if(isset($id))
                <li class=""><a href="{{ route('tag.index') }}">{{TAG_MODULE}}</a></li>
                <?php
                $breadcums = Helper::getBreadCumsCategoryByMenus($id);
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
                <li class="active">{{TAG_MODULE}}</li>
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

                        <h3 class="box-title">{{TAG_MODULE_SINGLE.'s'}}</h3>
                        @if($CheckLayoutPermission[0]->create==1)
                            <a href=" {{ route("tag.create") }}" class="">
                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.TAG_MODULE_SINGLE}}
                                </button>
                            </a>
                        @endif


                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <a class="btn btn-app delete bulk_remove hide" title="Delete Tags"><i class="fa fa-trash"></i>
                            <span class="badge"></span>Delete</a>

                        <div class="form-group col-md-2 bulk_status hide">
                            <span class="badge"></span>
                            <select class="form-control" name="select_type">
                                <option value="">-- Select --</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <input type="hidden" name="bulk_remove_type" value="bulk_tag_remove">
                        <input type="hidden" name="bulk_update_type" value="bulk_tag_status_update">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="tags" class="table">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort">
                                                </th>
                                                <th>Action</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($tags->count())
                                                @foreach($tags as $tag)
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" name="bluk_remove[]"
                                                                   value="{{ $tag->id }}">
                                                        </td>
                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Tag"
                                                                   href="{{ route("tag.edit",["id"=>$tag->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete @if(($tag->is_blog == 1 || $tag->is_dynamic == 1)) disabled @endif"
                                                                   title="Delete Tag"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("tag-destroy",["id"=>$tag->id]) }}">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $tag->title }}
                                                        </td>
                                                        <td>
                                                            <i class="fa {{ ($tag->status==1) ? "fa-check text-success":"fa-times text-danger" }} inline"></i>
                                                        </td>
                                                        <td>
                                                            @if ($tag->created_at == null)
                                                                {{$tag->created_at}}
                                                            @endif
                                                            {!!  date("Y-m-d H:i", strtotime($tag->created_at))   !!}

                                                        </td>
                                                        <td>@if ($tag->updated_at == null)
                                                                {{$tag->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d H:i", strtotime($tag->updated_at))   !!}
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
