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
                        <a class="btn btn-app delete bulk_remove hide" title="Delete Ads"><i class="fa fa-trash"></i>
                            <span class="badge"></span>Delete</a>

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
                                                <th><input type="checkbox" name="all_bulk_remove" class="no-sort">
                                                    Delete/Update
                                                </th>
                                                @if($type=='product')
                                                    <th>Product Page</th>
                                                @elseif($type=='blog')
                                                    <th>Blog Page</th>
                                                @endif
                                                <th>Title</th>
                                                <th>@if($type=='account' || $type=='blog')Vertical Ad Banner @else Ad Image @endif</th>
                                                <th>@if($type=='account' || $type=='blog')Vertical Ad Banner Link @else Ad
                                                    Link @endif</th>
                                                @if($type=='account' || $type=='blog')
                                                    <th>@if($type=='account' || $type=='blog')Horizontal Ad Banner @else Horizontal
                                                        Banner @endif</th>
                                                    <th>@if($type=='account' || $type=='blog')Horizontal Ad Banner Link @else Horizontal
                                                        Banner Link @endif</th>
                                                @endif
                                                <th>@if($type=='account' || $type=='blog')Paid Vertical Ad  @else Paid Ad
                                                    Image @endif</th>
                                                <th>@if($type=='account' || $type=='blog')Paid Vertical Ad Link  @else Paid Ad
                                                    Link @endif</th>
                                                @if($type=='account' || $type=='blog')
                                                    <th>Paid Horizontal Ad</th>
                                                    <th>Paid Horizontal Ad Link</th>
                                                @endif
                                                <th>Expiry Date</th>
                                                <th>Status</th>
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
                                                            <input type="checkbox" name="bluk_remove[]"
                                                                   value="{{ $ad->id }}">
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
                                                                <img src="{{ asset($ad->ad_image) }}" alt=""
                                                                     width="100px">
                                                            @else
                                                                Not available
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($ad->ad_link))<a href="{{$ad->ad_link}}"
                                                                                        target="_blank">{{$ad->ad_link}}</a>@endif
                                                        </td>
                                                        @if($type=='account' || $type=='blog')
                                                            <td>
                                                                @if(!empty($ad->horizontal_banner_ad_image))
                                                                    <img src="{{ asset($ad->horizontal_banner_ad_image) }}"
                                                                         alt="" width="100px">
                                                                @else
                                                                    Not available
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(!empty($ad->horizontal_banner_ad_link))<a
                                                                        href="{{$ad->horizontal_banner_ad_link}}"
                                                                        target="_blank">{{$ad->horizontal_banner_ad_link}}</a>@endif
                                                            </td>
                                                        @endif
                                                        <td>
                                                            @if(!empty($ad->paid_ad_image))
                                                                <img src="{{ asset($ad->paid_ad_image) }}" alt=""
                                                                     width="100px">
                                                            @else
                                                                Not available
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(!empty($ad->paid_ad_link))<a
                                                                    href="{{$ad->paid_ad_link}}"
                                                                    target="_blank">{{$ad->paid_ad_link}}</a>
                                                            @endif
                                                        </td>
                                                        @if($type=='account' || $type=='blog')
                                                            <td>
                                                                @if(!empty($ad->horizontal_paid_ad_image))
                                                                    <img src="{{ asset($ad->horizontal_paid_ad_image) }}"
                                                                         alt="" width="100px">
                                                                @else
                                                                    Not available
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(!empty($ad->horizontal_paid_ad_link))<a
                                                                        href="{{$ad->horizontal_paid_ad_link}}"
                                                                        target="_blank">{{$ad->horizontal_paid_ad_link}}</a>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        <td>
                                                            @if (!empty($ad->ad_end_date))
                                                                {!!  date("Y-m-d h:i A", strtotime($ad->ad_end_date))   !!}
                                                            @endif
                                                        </td>
                                                        <?php
                                                        $expiryDate = \Helper::convertToCarbonEndDate($ad->ad_end_date);
                                                        $todayDate = \Carbon\Carbon::now();
                                                        ?>
                                                        <td>@if($todayDate>$expiryDate) Expired @else
                                                                Active @endif </td>
                                                        <td>
                                                            @if (!empty($ad->created_at))
                                                                {!!  date("Y-m-d h:i A", strtotime($ad->created_at))   !!}
                                                            @endif
                                                        </td>
                                                        <td>@if (!empty($ad->updated_at))
                                                                {!!  date("Y-m-d h:i A", strtotime($ad->updated_at))   !!}
                                                            @endif
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
