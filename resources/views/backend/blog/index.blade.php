@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( BLOG_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{BLOG_MODULE}}</li>
        </ol>
    </section>
    <?php if (!isset($filterCategory)) {
        $filterCategory = 'all';
    } ?>
            <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-book"></i>

                        <h3 class="box-title">{{BLOG_MODULE_SINGLE.'s'}}</h3>


                        <a href="{{ route("blog-add",['category'=>$filterCategory]) }}" class="">
                            @if($CheckLayoutPermission[0]->create==1)

                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.BLOG_MODULE_SINGLE}}
                                </button>
                            @endif

                        </a>

                        <select name="filter_category" class="form-control"
                                style="width: 10em;float: right;margin-right: 10px;">
                            <option value="">-- Select --</option>
                            <option value="all" @if(isset($filterCategory) && ($filterCategory=="all")) selected @endif>
                                All
                            </option>
                            @if($menus->count())
                                @foreach($menus as $singleMenu)
                                    <option value="{{ $singleMenu->id }}"
                                            @if(isset($filterCategory) && ($filterCategory==$singleMenu->id)) selected @endif>{{ $singleMenu->title }}</option>
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

                                        <table id="blogs" class="table ">
                                            <thead>
                                            <tr>
                                                <th>Action</th>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Ads Status</th>
                                                <th>Category</th>
                                                <th>Posted By</th>
                                                <th>Slug</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($pages->count())
                                                @foreach($pages as $page)
                                                    <tr>
                                                        <td class="text-center">
                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Page"
                                                                   href="{{ route("blog.edit",["id"=>$page->id,'filter_category'=>$filterCategory]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                <a class="btn btn-app delete @if(($page->is_index == 1 || $page->is_dynamic == 1)) disabled @endif"
                                                                   title="Delete Page"
                                                                   onclick="return confirm('Are you sure to delete this?')"
                                                                   href="{{ route("blog-destroy",["id"=>$page->id,'filter_category'=>$filterCategory]) }}">
                                                                    <i class="fa fa-trash"></i> Delete
                                                                </a>
                                                            @endif


                                                        </td>
                                                        <td>
                                                            {{ $page->name }}
                                                        </td>
                                                        <td>
                                                            @if($page->status==1)
                                                                Active
                                                            @else
                                                                Deactivate
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($page->disable_ads==1)
                                                                Disabled
                                                            @else
                                                                Enable
                                                            @endif

                                                        </td>
                                                        <td>
                                                            {{ $page->menu_title }}
                                                        </td>
                                                        <td>
                                                            {{ $page->posted_by }}
                                                        </td>
                                                        <td>
                                                            {{ $page->slug }}
                                                        </td>
                                                        <td>
                                                            @if ($page->created_at == null)
                                                                {{$page->created_at}}
                                                            @endif
                                                            {!!  date("Y-m-d H:i", strtotime($page->created_at))   !!}

                                                        </td>
                                                        <td>@if ($page->updated_at == null)
                                                                {{$page->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d H:i", strtotime($page->updated_at))   !!}

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
        $("select[name='filter_category']").on("change", function () {
            var value = $(this).val();
            window.location.href = "{{ url('admin/filter-category') }}/" + value;
        });
    </script>

@endsection
