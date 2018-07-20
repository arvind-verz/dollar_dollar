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

                        <h3 class="box-title">{{'Edit Promotion Formula'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {!! Form::open(['route' => ['promotion-formula-update', $formula->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title" class="control-label">Promotion Type</label>
                                <select class="form-control" name="promotion_type">
                                    <option value="">None</option>
                                    @if($promotion_types->count())
                                        @foreach($promotion_types as $value)
                                            <option value="{{$value->id}}"  @if( $value->id == $formula->id) selected="selected" @endif>{{$value->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title" class="control-label">Formula Name/Title</label>
                                <input type="text" name="formula_name" class="form-control" placeholder="Enter Formula Name/Title" value="{{ $formula->name }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="title" class="control-label">Formula</label>
                                <input type="text" name="formula" class="form-control" placeholder="Enter Formula" value="{{ $formula->formula }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <br/>
                            <button type="submit" class="btn btn-success">Save</button>
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

@endsection
