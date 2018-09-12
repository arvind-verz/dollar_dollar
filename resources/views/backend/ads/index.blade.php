@extends('backend.layouts.app')
@section('content')
@php if($type=='index') {$type='account';} @endphp
    <section class="content-header">

        <h1>
            {{strtoupper( ADS_MANAGEMENT )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('ads.index', ['type'=>$type]) }}">{{ADS_MANAGEMENT}}</a></li>
            <li class="active">{{ ucfirst($type) }}</li>
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
                        <a class="btn btn-app delete bulk_remove hide" title="Delete Ads"><i class="fa fa-trash"></i> <span class="badge"></span>Delete</a>
                        <div class="form-group col-md-2 bulk_status hide">
                          <span class="badge"></span>
                          <select class="form-control" name="select_type">
                            <option value="">-- Select --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                          </select>
                        </div> 
                        <input type="hidden" name="bulk_remove_type" value="bulk_ads_remove">
                        <input type="hidden" name="bulk_update_type" value="bulk_ads_status_update">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="banners" class="table ">
                                            <thead>
                                            <tr>
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort"> Delete/Update</th>
                                                @if($type=='product')
                                                <th>Product Page</th>
                                                @elseif($type=='blog')
                                                <th>Blog Page</th>
                                                @endif
                                                <th>Title</th>
                                                <th>Ad Image</th>
                                                @if($type=='account')
                                                <th>Banner Image</th>
                                                @endif
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
                                                            <input type="checkbox" name="bluk_remove[]" value="{{ $ad->id }}">
                                                        </td>
                                                        @if($type=='product' || $type=='blog')
                                                            <td>
                                                                {{  $ad->page_type  }}
                                                            </td>
                                                        @endif
                                                        <td>
                                                            {{  $ad->title  }}
                                                        </td>
                                                        <td>
                                                            @if(!empty($ad->ad_image))
                                                            <img src="{{ asset($ad->ad_image) }}" alt="" width="100px">
                                                            @else
                                                            Not available
                                                            @endif
                                                        </td>
                                                        @if($type=='account')
                                                        <td>
                                                            @if(!empty($ad->horizontal_banner_ad_image))
                                                            <img src="{{ asset($ad->horizontal_banner_ad_image) }}" alt="" width="100px">
                                                            @else
                                                            Not available
                                                            @endif
                                                        </td>
                                                        @endif
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
                                                                   href="{{ route("ads.edit",["id"=>$ad->id, 'type'=>$type]) }}">
                                                                    <i class="fa fa-edit"></i> Edit
                                                                </a>
                                                            @endif

                                                            @if($CheckLayoutPermission[0]->delete==1)
                                                                    <a class="btn btn-app delete" title="Delete Banner"
                                                                       onclick="return confirm('Are you sure to delete this?')"
                                                                       href="{{ route("ads.destroy",["id"=>$ad->id, "type"=>$type]) }}">
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
