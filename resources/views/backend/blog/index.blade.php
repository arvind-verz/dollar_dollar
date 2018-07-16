@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( BLOG_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{BLOG_MODULE}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-book"></i>

                        <h3 class="box-title">{{BLOG_MODULE_SINGLE.'s'}}</h3>

                        
                        <a href="{{ route("blog.create") }}" class="">
                            @if($CheckLayoutPermission[0]->create==1)

                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.BLOG_MODULE_SINGLE}}
                                </button>
                            @endif

                        </a>
                        <select name="filter_category" class="form-control" style="width: 10em;float: right;margin-right: 10px;">
                            <option value="">-- Select --</option>
                            <option value="all">All</option>
                            @if($menus->count())
                                @foreach($menus as $singleMenu)
                                    <option value="{{ $singleMenu->id }}">{{ $singleMenu->title }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="pages" class="table ">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Category</th>
                                                <th>Slug</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($pages->count())
                                                @foreach($pages as $page)
                                                    <tr>
                                                        <td>
                                                            {{ $page->name }}
                                                        </td>
                                                        <td>
                                                            {{ $page->menu_title }}
                                                        </td>
                                                        <td>
                                                            {{ $page->slug }}
                                                        </td>
                                                        <td>
                                                            @if ($page->created_at == null)
                                                                {{$page->created_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($page->created_at))   !!}

                                                        </td>
                                                        <td>@if ($page->updated_at == null)
                                                                {{$page->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($page->updated_at))   !!}

                                                        </td>

                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Page"
                                                                   href="{{ route("blog.edit",["id"=>$page->id]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete @if(($page->is_index == 1 || $page->is_dynamic == 1)) disabled @endif"
                                                                   title="Delete Page"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("blog-destroy",["id"=>$page->id]) }}">
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
    </section>
    <!-- /.content -->
    <script type="text/javascript">
        $("select[name='filter_category']").on("change", function() {
            var value = $(this).val();
            window.location.href = "{{ url('admin/filter-category') }}/"+value;
        });
    </script>

@endsection
