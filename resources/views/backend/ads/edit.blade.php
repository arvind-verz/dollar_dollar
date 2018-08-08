@extends('backend.layouts.app')
@section('content')
    <section class="content-header">
        <h1>
            {{strtoupper( ADS_MANAGEMENT )}}
            <small>{{ADS_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('banner.index', ['type'=>$type]) }}">{{ADS_MANAGEMENT}}</a></li>
            <li class="active">{{ADS_MODULE_SINGLE.' '.ADD_ACTION}}</li>
        </ol>
    </section>
    @php if($type=='index') {$type='account';} @endphp

    <!-- Main content -->
    <section class="content">
        <div class="row">
            @include('backend.inc.messages')
            <div class="col-xs-12">
                <div class="box box-warning ">
                    <div class="box-header with-border">
                        <i class="fa fa-edit"></i>

                        <h3 class="box-title">{{ ucfirst($type) . ' ' .ADS_MODULE_SINGLE.' '.EDIT_ACTION}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- form start -->
                        {!! Form::open(['class' => 'form-horizontal','url' => ['admin/ads/update', $ads->id, $type], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="col-md-12">
                                <input type="hidden" name="page" value="{{ $type }}">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter title" value="{{ $ads->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Ad Image</label>
                                    <input type="file" name="ad_image" class="form-control">
                                    @if(isset($ads->ad_image) && ($ads->ad_image != ''))
                                        <div class="col-sm-2">                                        
                                            <div class="attachment-block clearfix">
                                                <a href="javascript:void(0)" class="text-danger" title="close" onclick="removeImage(this, '{{ $ads->id }}');"><i class="fas fa-times fa-lg"></i></a>
                                                <img class="attachment-img" src="{!! asset($ads->ad_image) !!}"
                                                     alt="Banner Image">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Ad Link</label>
                                    <input type="text" name="ad_link" class="form-control" placeholder="Enter Ad link (example: https://www.google.com)" value="{{ $ads->ad_link }}">
                                </div>
                                <div class="form-group">
                                    <label>Display?</label>
                                    <select class="form-control" name="display">
                                        <option value="1" @if($ads->display==1) selected @endif>Yes</option>
                                        <option value="0" @if($ads->display==0) selected @endif>No</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <a href="{{route("ads.index", ["type"=>$type])}}"
                               class="btn btn-default"><i class="fa fa-close">
                                </i> Cancel</a>

                            <button type="submit" class="btn btn-warning pull-right"><i class="fa  fa-check"></i> Update
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
    <script>
            function removeImage(ref, id) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('remove-image') }}",
                    data: "type=ads&id="+id,
                    cache: false,
                    success: function(data) {
                        if(data.trim()=='success') {
                            $(ref).parents(".col-sm-2").remove();
                        }
                    }
                });
            }
    </script>
@endsection
