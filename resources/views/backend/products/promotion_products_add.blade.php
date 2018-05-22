@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( PRODUCT_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>{{DASHBOARD}}</a></li>
            <li class="active">{{PRODUCT_MODULE}}</li>
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

                        <h3 class="box-title">{{'Add New Promotion'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['class' => 'form-horizontal','route' => 'promotion-products-add-db', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Promotion Type</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="promotion_type">
                                    <option value="">None</option>
                                    @if($promotion_types->count())
                                        @foreach($promotion_types as $value)
                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Formula</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="formula_id">
                                    <option value="">None</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Product Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="product_name" class="form-control" placeholder="Enter Product Name" value="{{ old('product_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Min Placement</label>
                            <div class="col-sm-10">
                                <input type="number" name="min_range" class="form-control" placeholder="Enter Min Placement" value="{{ old('min_range') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Max Placement</label>
                            <div class="col-sm-10">
                                <input type="number" name="max_range" class="form-control" placeholder="Enter Max Placement" value="{{ old('max_range') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Promotion Start Date</label>
                            <div class="col-sm-10">
                                <input type="date" name="promotion_start" class="form-control" placeholder="Enter Promotion Start Date" value="{{ old('promotion_start') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Promotion End Date</label>
                            <div class="col-sm-10">
                                <input type="date" name="promotion_end" class="form-control" placeholder="Enter Promotion End Date" value="{{ old('promotion_end') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Tenure</label>
                            <div class="col-sm-10">
                                <input type="number" name="tenure" class="form-control" placeholder="Enter Tenure" value="{{ old('tenure') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Bonus Interest</label>
                            <div class="col-sm-10">
                                <input type="text" name="bonus_interest" class="form-control only_numeric" placeholder="Enter Bonus Interest"  value="{{ old('bonus_interest') }}">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right">Submit</button>
                        </div>
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
    <script type="text/javascript">
        $("select[name='promotion_type']").on("change", function() {
            var promotion_type = $(this).val();
//alert(promotion_type);
            $.ajax({
                method: "GET",
                url: "{{url('/admin/promotion-products/get-formula/')}}"+'/'+promotion_type,
                data: "",
                cache: false,
                success: function(data) {
                    $("select[name='formula_id']").html(data);
                }
            });
        });
    </script>
@endsection
