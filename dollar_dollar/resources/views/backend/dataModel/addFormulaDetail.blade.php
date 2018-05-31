<div class="modal fade" id="model-formula-detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> {{FORMULA_DETAIL_MODULE_SINGLE.' '.ADD_ACTION}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info ">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <!-- form start -->
                                {!! Form::open(['class' => 'form-horizontal','url' => 'admin/add-formula-detail', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Name</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="product_name" id="formula_product_id">
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
                                        <label for="title" class="col-sm-2 control-label">Placement Range</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" name="placement_range">
                                                <option value="">None</option>
                                            </select>
                                            <input type="hidden" id="hidden-placement-range" value="{{ old('placement_range') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Tenure</label>

                                        <div class="col-sm-10">
                                            <input type="number" name="tenure" class="form-control " placeholder=""
                                                   value="{{ old('tenure') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="title" class="col-sm-2 control-label">Bonus Interest</label>

                                        <div class="col-sm-10">
                                            <input type="text" name="bonus_interest" class="form-control only_numeric"
                                                   placeholder="" value="{{ old('bonus_interest') }}">
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