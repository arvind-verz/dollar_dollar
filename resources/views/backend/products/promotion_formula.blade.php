@extends('backend.layouts.app')
@section('content')
    <section class="content-header">

        <h1>
            {{strtoupper( PRODUCT_MODULE )}}
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>{{DASHBOARD}}</a></li>
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

                        <h3 class="box-title">{{'Promotion Formula'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['route' => 'promotion-formula-db', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title" class="control-label">Promotion Type</label>
                                <select class="form-control" name="promotion_type">
                                    <option value="">None</option>
                                    @if($promotion_types->count())
                                        @foreach($promotion_types as $value)
                                            <option value="{{$value->id}}"  @if( $value->id == old('promotion_type')) selected="selected" @endif>{{$value->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title" class="control-label">Formula Name/Title</label>
                                <input type="text" name="formula_name" class="form-control" placeholder="Enter Formula Name/Title" value="{{ old('formula_name') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title" class="control-label">Formula</label>
                                <input type="text" name="formula" class="form-control" placeholder="Enter Formula" value="{{ old('formula') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <br/>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                         {!! Form::close() !!}
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Promotion Type</th>
                                    <th>Formula Name/Title</th>
                                    <th>Formula</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; ?>
                                @if($formulas->count())
                                    @foreach($formulas as $formula)
                                        <?php 
                                        // dd($sel_query);
                                        $promotion = $promotion_types->where('id', '=', $formula->promotion_id)->all();
                                       if(count($promotion)) {
                                            $promotion = array_values($promotion);
                                       }
                                        ?>
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>@if(count($promotion)) {{ $promotion[0]->name }} @endif</td>
                                            <td>{{ $formula->name }}</td>
                                            <td>{{ $formula->formula }}</td>
                                            <td>{{ date("d-m-Y", strtotime($formula->created_at)) }}</td>
                                            <td>
                                                @if($CheckLayoutPermission[0]->edit==1)
                                                    <a class="btn btn-app edit" title="Edit Formula"
                                                       href="{{ route("promotion-formula-edit",["id"=>$formula->id]) }}">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                @endif

                                                @if($CheckLayoutPermission[0]->delete==1)
                                                    <a class="btn btn-app delete" title="Delete Formula"
                                                       onclick="return confirm('Are you sure to delete this?')"
                                                       href="{{ route("promotion-formula-remove",["id"=>$formula->id]) }}">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    <?php $i++; ?>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">No data found.</td>
                                    </tr>
                                @endif
                            </tbody>
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
