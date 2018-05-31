<div class="modal fade" id="model-product-name">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> {{PRODUCT_NAME_MODULE_SINGLE.' '.ADD_ACTION}}</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-info ">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <!-- form start -->
                                {!! Form::open(['class' => 'form-horizontal','url' => 'admin/add-product-name', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <div class="box-body">
                                    <div class="form-group">
                                        {{Form::label('product_name', 'Name',['class'=>'col-sm-2 control-label'])}}
                                        <div class="col-sm-10">
                                            {{Form::text('product_name', old('product_name'), ['class' => 'form-control', 'placeholder' => '' ])}}
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