@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( ADS_MANAGEMENT )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{ADS_MANAGEMENT}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-pie-chart"></i>
                        @php if($type=='index') {$type='account';} @endphp
                        <h3 class="box-title">{{ ucfirst($type) . ' ' . ADS_MODULE_SINGLE}}</h3>
                        @if($CheckLayoutPermission[0]->create==1)
                            <a href="{{ route("ads.create", ['type'=>$type]) }}" class="">
                                <button type="submit" class="btn btn-info pull-right"><i
                                            class="fa  fa-plus"></i> {{ADD_ACTION.' '.ADS_MODULE_SINGLE}}
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

                                        <table id="banners" class="table ">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Ad Image</th>
                                                <th>Created on</th>
                                                <th>Updated on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($ads->count())
                                                @foreach($ads as $ad)
                                                    <tr>
                                                        <td>
                                                            {{  $ad->title  }}
                                                        </td>
                                                        <td>
                                                            {{ $ad->ad_image }}
                                                        </td>
                                                        <td>
                                                            @if ($ad->created_at == null)
                                                                {{$ad->created_at}}
                                                            @endif
                                                                {!!  date("Y-m-d h:i A", strtotime($ad->created_at))   !!}

                                                        </td>
                                                        <td>@if ($ad->updated_at == null)
                                                                {{$ad->updated_at}}
                                                            @endif
                                                            {!!  date("Y-m-d h:i A", strtotime($ad->updated_at))   !!}

                                                        </td>
                                                        <td class="text-center">

                                                            @if($CheckLayoutPermission[0]->edit==1)
                                                                <a class="btn btn-app edit" title="Edit Banner"
                                                                   href="{{ route("banner.edit",["id"=>$ad->id, 'type'=>$type]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                    <a class="btn btn-app delete" title="Delete Banner"
                                                                       onclick="return confirm('Are you sure to delete this?')"
                                                                       href="{{ route("banner-destroy",["id"=>$ad->id]) }}">
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

@endsection
