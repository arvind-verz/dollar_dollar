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

                        <h3 class="box-title">{{'Product List'}}</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table style="table-layout: fixed; width: 100%;">
                            <tr>
                                <td>
                                    <div style="width: 100%; overflow-x: auto;">

                                        <table id="pages" class="table ">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Promotion Start</th>
                                                <th>Promotion End</th>
                                                <th>Tenure</th>
                                                <th>Created on</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=1; ?>
                                                @if($products->count())
                                                    @foreach($products as $product)
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $product->name; ?></td>
                                                        <td><?php echo $product->promotion_start; ?></td>
                                                        <td><?php echo $product->promotion_end; ?></td>
                                                        <td><?php echo $product->tenure; ?></td>
                                                        <td><?php echo $product->created_at; ?></td>
                                                        <td>Action</td>
                                                    </tr>
                                                    <?php $i++; ?>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td class="text-center">No data found.</td>
                                                </tr>
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
