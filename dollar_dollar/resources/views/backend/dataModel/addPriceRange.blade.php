<div class="modal fade" id="model-price-range">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> {{PLACEMENT_RANGE_MODULE_SINGLE.' '.ADD_ACTION}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info ">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <!-- form start -->
                                {!! Form::open(['class' => 'form-horizontal','url' => 'admin/add-price-range', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="product_name">
                                                <option value="">None</option>
                                                @if($product_names->count())
                                                    @foreach($product_names as $product_name)
                                                        <option value="{{$product_name->id}}"
                                                                @if(old('product_name')==$product_name->id) selected="selected" @endif>{{$product_name->product_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Min Placement</label>

                                        <div class="col-sm-10">
                                            <input type="number" name="min_placement" class="form-control"
                                                   placeholder=""
                                                   value="{{ old('min_placement') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Max Placement</label>

                                        <div class="col-sm-10">
                                            <input type="number" name="max_placement" class="form-control"
                                                   placeholder=""
                                                   value="{{ old('max_placement') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-info pull-right"><i class="fa  fa-check"></i> Add
                </button>
            </div>
            {!! Form::close() !!}
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

        