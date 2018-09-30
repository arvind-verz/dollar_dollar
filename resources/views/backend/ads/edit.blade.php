@extends('backend.layouts.app')
@section('content')
    @php if($type=='index') {$type='account';} @endphp
    <section class="content-header">
        <h1>
            {{strtoupper( ADS_MANAGEMENT )}}
            <small>{{ADS_MODULE_SINGLE.' '.ADD_ACTION}}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
            <li><a href="{{ route('ads.index', ['type'=>$type]) }}">{{ucfirst($type)}}</a></li>
            <li class="active">{{ADS_MODULE_SINGLE.' '.EDIT_ACTION}}</li>
        </ol>
    </section>

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
                                @if($type=='product')
                                    <div class="form-group">
                                        <label>Product Page</label>
                                        <select class="form-control" name="page_type">
                                            <option value="">Select</option>
                                            <option value="fixed-deposit-mode"
                                                    @if($ads->page_type=='fixed-deposit-mode') selected @endif>Fixed
                                                Deposit
                                            </option>
                                            <option value="saving-deposit-mode"
                                                    @if($ads->page_type=='saving-deposit-mode') selected @endif>Saving
                                                Deposit
                                            </option>
                                            <option value="privilege-deposit-mode"
                                                    @if($ads->page_type=='privilege-deposit-mode') selected @endif>
                                                Privilege Deposit
                                            </option>
                                            <option value="foreign-currency-deposit-mode"
                                                    @if($ads->page_type=='foreign-currency-deposit-mode') selected @endif>
                                                Foreign Currency Deposit
                                            </option>
                                            <option value="all-in-one-deposit-mode"
                                                    @if($ads->page_type=='all-in-one-deposit-mode') selected @endif>All
                                                in One Deposit
                                            </option>
                                        </select>
                                    </div>
                                @elseif($type=='blog')
                                    <div class="form-group">
                                        <label>Blog Page</label>
                                        <select class="form-control" name="page_type">
                                            <option value="">Select</option>
                                            <option value="blog" @if($ads->page_type=='blog') selected @endif>Blog
                                            </option>
                                            <option value="blog-inner"
                                                    @if($ads->page_type=='blog-inner') selected @endif>Blog Inner
                                            </option>
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="Enter title"
                                           value="{{ $ads->title }}">
                                </div>
                                <div class="form-group">
                                    <label>@if($type=='account')Vertical Ad Banner @else Ad
                                        Image @endif </label>
                                    <input type="file" name="ad_image" class="form-control">
                                    @if(isset($ads->ad_image) && ($ads->ad_image != ''))
                                        <div class="col-sm-2">
                                            <div class="attachment-block clearfix">
                                                <a href="javascript:void(0)" class="text-danger" title="close"
                                                   onclick="removeImage(this, '{{ $ads->id }}', 'normal');"><i
                                                            class="fas fa-times fa-lg"></i></a>
                                                <img class="attachment-img" src="{!! asset($ads->ad_image) !!}"
                                                     alt="Banner Image">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>@if($type=='account')Vertical Ad Banner Link @else Ad
                                        Link @endif</label>
                                    <input type="text" name="ad_link" class="form-control"
                                           placeholder="Enter Ad link (example: https://www.google.com)"
                                           value="{{ $ads->ad_link }}">
                                </div>
                                    <div class="form-group horizonal_banner">
                                        <label>@if($type=='account')Horizontal Ad Banner @else
                                                Horizontal Banner @endif</label>
                                        <input type="file" name="horizontal_banner_ad_image" class="form-control">
                                        @if(isset($ads->horizontal_banner_ad_image) && ($ads->horizontal_banner_ad_image != ''))
                                            <div class="col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="javascript:void(0)" class="text-danger" title="close"
                                                       onclick="removeImage(this, '{{ $ads->id }}', 'horizontal');"><i
                                                                class="fas fa-times fa-lg"></i></a>
                                                    <img class="attachment-img"
                                                         src="{!! asset($ads->horizontal_banner_ad_image) !!}"
                                                         alt="Banner Image">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group horizonal_banner">
                                        <label>@if($type=='account')Horizontal Ad Banner Link @else
                                                Horizontal Banner Link @endif</label>
                                        <input type="text" name="horizontal_banner_ad_link" class="form-control"
                                               placeholder="Enter Ad link (example: https://www.google.com)"
                                               value="{{ $ads->horizontal_banner_ad_link }}">
                                    </div>
                                <div class="form-group">
                                    <label>@if($type=='account')Paid Vertical Ad  @else Paid Ad
                                        Image @endif</label>
                                    <input type="file" name="paid_ad_image" class="form-control">
                                    @if(isset($ads->paid_ad_image) && ($ads->paid_ad_image != ''))
                                        <div class="col-sm-2">
                                            <div class="attachment-block clearfix">
                                                <a href="javascript:void(0)" class="text-danger" title="close"
                                                   onclick="removeImage(this, '{{ $ads->id }}', 'paid');"><i
                                                            class="fas fa-times fa-lg"></i></a>
                                                <img class="attachment-img" src="{!! asset($ads->paid_ad_image) !!}"
                                                     alt="Banner Image">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>@if($type=='account')Paid Vertical Ad Link  @else Paid Ad
                                        Link @endif</label>
                                    <input type="text" name="paid_ad_link" class="form-control"
                                           placeholder="Enter Ad link (example: https://www.google.com)"
                                           value="{{ $ads->paid_ad_link }}">
                                </div>
                                @if($type=='account')
                                    <div class="form-group">
                                        <label>Paid Horizontal Ad</label>
                                        <input type="file" name="horizontal_paid_ad_image" class="form-control">
                                        @if(isset($ads->horizontal_paid_ad_image) && ($ads->horizontal_paid_ad_image != ''))
                                            <div class="col-sm-2">
                                                <div class="attachment-block clearfix">
                                                    <a href="javascript:void(0)" class="text-danger" title="close"
                                                       onclick="removeImage(this, '{{ $ads->id }}', 'paid');"><i
                                                                class="fas fa-times fa-lg"></i></a>
                                                    <img class="attachment-img" src="{!! asset($ads->horizontal_paid_ad_image) !!}"
                                                         alt="Banner Image">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label>Paid Horizontal Ad Link</label>
                                        <input type="text" name="horizontal_paid_ad_link" class="form-control"
                                               placeholder="Enter Ad link (example: https://www.google.com)"
                                               value="{{ $ads->horizontal_paid_ad_link }}">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="">Ad Range Date </label>
                                    <input type="text" name="ad_range_date" class="form-control date_range"
                                           value="@if(empty($ads->ad_start_date) || empty($ads->ad_end_date))  @else {{ date('Y/m/d', strtotime($ads->ad_start_date)) .' - '. date('Y/m/d', strtotime($ads->ad_end_date)) }} @endif"
                                           autocomplete="off">
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
                            <a href="{{ route('ads.index', ['type'=>$type]) }}"
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
        function removeImage(ref, id, place) {
            $.ajax({
                method: "POST",
                url: "{{ route('remove-image') }}",
                data: "type=ads&id=" + id + "&place=" + place,
                cache: false,
                success: function (data) {
                    if (data.trim() == 'success') {
                        $(ref).parents(".col-sm-2").remove();
                    }
                }
            });
        }

        $(document).ready(function () {
            showhide();
        });

        $("select[name='page_type']").on("change", function () {
            showhide();
        });

        function showhide() {
            var name = $("select[name='page_type']").val();
            /*if (name == 'blog') {
                $(".horizonal_banner").addClass("hide");
            }
            else {
                $(".horizonal_banner").removeClass("hide");
            }*/
        }
    </script>
@endsection
