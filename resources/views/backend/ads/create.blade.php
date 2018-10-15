@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( ADS_MANAGEMENT )}}
            <small>{{ADS_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('ads.index', ['type'=>$type]) }}">{{ucfirst($type)}}</a></li>
            <li class="active">{{ADS_MODULE_SINGLE.' '.ADD_ACTION}}</li>
        </ol>
    </section>
    @php if($type=='index') {$type='account';} @endphp

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-info ">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>
    
                        <h3 class="box-title">{{ ucfirst($type) . ' ' .ADS_MODULE_SINGLE.' '.ADD_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => ['admin/ads/store', $type], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="col-md-12">
                                <input type="hidden" name="page" value="{{ $type }}">
                                @if($type=='product')
                                <div class="form-group">
                                    <label>Product Page</label>
                                    <select class="form-control" name="page_type">
                                        <option value="">Select</option>
                                        <option value="fixed-deposit-mode">Fixed Deposit</option>
                                        <option value="saving-deposit-mode">Saving Deposit</option>
                                        <option value="privilege-deposit-mode">Privilege Deposit</option>
                                        <option value="foreign-currency-deposit-mode">Foreign Currency Deposit</option>
                                        <option value="all-in-one-deposit-mode">All in One Deposit</option>
                                    </select>
                                </div>
                                @endif
                                @if($type=='blog')
                                <div class="form-group">
                                    <label>Blog Page</label>
                                    <select class="form-control" name="page_type">
                                        <option value="">Select</option>
                                        {{--<option value="blog">Blog</option>--}}
                                        <option value="blog-inner">Blog Inner</option>
                                    </select>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter title">
                                </div>
                                <div class="form-group">
                                    <label>@if($type=='account'||$type=='blog')Vertical Ad Banner @else Ad Image @endif </label>
                                    <input type="file" name="ad_image" class="form-control">
                                    <p class="text-muted"><strong>Note:</strong> Image
                                        size should be @if($type=='account'||$type=='blog')160*600 @else 160*600 @endif for better display
                                    </p>
                                </div>                                
                                <div class="form-group">
                                    <label>@if($type=='account'||$type=='blog')Vertical Ad Banner Link @else Ad Link @endif</label>
                                    <input type="text" name="ad_link" class="form-control" placeholder="Enter Ad link (example: https://www.google.com)">
                                </div>
                                @if($type=='account' || $type=='blog')
                                <div class="form-group">
                                    <label>@if($type=='account')Horizontal Ad Banner @else Horizontal Banner @endif</label>
                                    <input type="file" name="horizontal_banner_ad_image" class="form-control">
                                    <p class="text-muted"><strong>Note:</strong> Image
                                        size should be @if($type=='account'||$type=='blog')970*250 @else 970*250 @endif for better display
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>@if($type=='account')Horizontal Ad Banner Link @else Horizontal Banner Link @endif</label>
                                    <input type="text" name="horizontal_banner_ad_link" class="form-control" placeholder="Enter Ad link (example: https://www.google.com)">
                                </div>
                                @endif
                                <div class="form-group">
                                    <label>@if($type=='account'||$type=='blog')Paid Vertical Ad  @else Paid Ad Image @endif</label>
                                    <input type="file" name="paid_ad_image" class="form-control">
                                    <p class="text-muted"><strong>Note:</strong> Image
                                        size should be @if($type=='account'||$type=='blog')160*600 @else 160*600 @endif for better display
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>@if($type=='account'||$type=='blog')Paid Vertical Ad Link  @else Paid Ad Link @endif</label>
                                    <input type="text" name="paid_ad_link" class="form-control" placeholder="Enter Ad link (example: https://www.google.com)">
                                </div>
                                @if($type=='account'||$type=='blog')
                                <div class="form-group">
                                    <label>Paid Horizontal Ad</label>
                                    <input type="file" name="horizontal_paid_ad_image" class="form-control">
                                    <p class="text-muted"><strong>Note:</strong> Image
                                        size should be @if($type=='account'||$type=='blog')970*250 @else 970*250 @endif for better display
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label>Paid Horizontal Ad Link</label>
                                    <input type="text" name="horizontal_paid_ad_link" class="form-control" placeholder="Enter Ad link (example: https://www.google.com)">
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="">Ad Range Date</label>
                                    <input type="text" name="ad_range_date" class="form-control date_range" value="" autocomplete="off">
                                </div>
                                
                                <div class="form-group">
                                    <label>Display?</label>
                                    <select class="form-control" name="display">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="box-footer">
                                <a href="{{ route('ads.index', ['type'=>$type]) }}"
                                   class="btn btn-default"><i class="fa fa-close">
                                    </i> Cancel</a>

                                <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i> Add
                                </button>

                            </div>



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
