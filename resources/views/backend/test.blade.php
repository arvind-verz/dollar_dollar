@extends('backend.layouts.app')
@section('content')
    <div class="panel panel-primary details-container">
        <div class="panel-heading clearfix">
            <h4 class="panel-title pull-left" style="padding-top: 7.5px;">Edit Order </h4>
        </div>
    </div>
    <div class="row panel">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders') }}">Order Module</a></li>
            <li class="breadcrumb-item">Edit Order</li>
        </ol>
    </div>
    <div class="">
        {!! Form::open(['route' => ['orderUpdate', $orderDetail->order_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('customer_ref_no', 'Order No :')}}
            {{Form::text('customer_ref_no', $orderDetail->customer_ref_no, ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
        </div>
        <div class="form-group">
            {{Form::label('contact_person', 'Customer :')}}
            {{Form::text('contact_person', $orderDetail->contact_person, ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
        </div>
        <div class="form-group">
            {{Form::label('company', 'Company :')}}
            {{Form::text('company', $orderDetail->company, ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
        </div>
        <div class="form-group">
            {{Form::label('tel_phone', 'Contact Number :')}}
            {{Form::text('tel_phone', $orderDetail->tel_phone, ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
        </div>
        <div class="form-group">
            {{Form::label('email', 'Email :')}}
            {{Form::text('email', $orderDetail->email, ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
        </div>
        <div class="form-group">
            {{Form::label('description', 'Product Title :')}}
            {{Form::text('description',   implode(',  ', $orderDetail->product_title), ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
        </div>
        <div class="form-group">
            {{Form::label('order_price', 'Total Amount :')}}
            {{Form::text('order_price', $orderDetail->total_amount, ['class' => 'form-control', 'placeholder' => '','readonly'=>'readonly'])}}
        </div>

        <div class="form-group">
            {{Form::label('remark', 'Remark :')}}
            {{Form::textarea('remark', $orderDetail->remark, ['id' => 'remark', 'class' => 'form-control ', 'placeholder' => ''])}}
        </div>
        <div class="form-group">
            <label>Order Status </label>
            <select class="form-control " name="order_status" id="">

                <option value="{{ PROCESSING }}" @if(PROCESSING == $orderDetail->order_status)selected @endif >Order is
                    being processed
                </option>
                <option value="{{ AWAITING_PAYMENT }}"
                        @if(AWAITING_PAYMENT == $orderDetail->order_status)selected @endif>Order acknowledgment sent and
                    awaiting payment
                </option>
                <option value="{{ PAID }}" @if(PAID == $orderDetail->order_status)selected @endif}>Payment received
                </option>
                <option value="{{ SHIPPED }}" @if(SHIPPED == $orderDetail->order_status)selected @endif>Order shipped
                </option>

            </select>
        </div>
        {{Form::hidden('_method','PUT')}}
        <div class="form-group">
            {{Form::submit('Submit', ['class'=>'btn btn-fw btn-primary'])}}
            <a href="{{route("orders")}}"
               class="btn btn-fw btn-default "><i class="fa fa-">
                </i> Cancel</a>
        </div>
        {!! Form::close() !!}
    </div>
    <script>
        document.getElementById("remark").readOnly = true;
    </script>
@endsection