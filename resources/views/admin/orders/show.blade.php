@extends('layouts.admin')

@section('content')
<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Order</h4>
                    <h6>Order Details</h6>
                </div>
            </div>

            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeStatusModal">Change Order Status</button>
                    </div>
                    <table class="table">
                        <tr>
                            <th>Order ID</th>
                            <td>{{$order->order_id}}</td>
                            <th>Order Date</th>
                            <td>{{$order->created_at->format('d-M-Y hh:mm:i a')}}</td>
                        </tr>
                        <tr>
                            <th>User Name</th>
                            <td>{{$order->user->name}}</td>
                            <th>User Email</th>
                            <td>{{$order->user->email}}</td>
                        </tr>
                        <tr>
                            <th>Total Price</th>
                            <td>{{$order->total_price}}</td>
                            <th>Total Quantity</th>
                            <td>{{$order->total_quantity}}</td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td>{{$order->payment_type}}</td>
                            <th>Payment Status</th>
                            <td>{{$order->payment_status}}</td>
                        </tr>
                        <tr>
                            <th>Order Status</th>
                            <td> <span
                                    style="color: {{ $order->status === 'Pending' ? '#BF9824' : '#188B28' }}">
                                    {{ $order->status }}
                                </span></td>
                            <th>User Address</th>
                            <td>
                                @isset($order->address)
                                <span>{{$order->address->address_line1}}, {{$order->address->address_line2}} {{$order->address->city}}<br>{{$order->address->state}}, {{$order->address->zip}} <span>
                                        @endisset
                            </td>
                        </tr>
                        <tr>
                            <th>Remarks</th>
                            <td>
                                @isset($order->remarks)
                                <span>{{$order->remarks}} </span>
                                @endisset
                            </td>
                            <th>User Phone</th>
                            <td>
                                @isset($order->address)
                                <span>{{$order->address->phone}} </span>
                                @endisset
                            </td>
                        </tr>
                    </table>
                    <div class="fs-2 mt-5 mb-2">Order Products</div>
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Discount Amount</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $subTotal = 0;
                                @endphp
                                @if (count($order->orderProducts) > 0)
                                @foreach ($order->orderProducts as $key => $product)
                                @php

                                $subTotal += $product->total;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->discount }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->total - $product->discount }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                                    <td><strong>{{ $subTotal }}</strong></td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="5">
                                        <div class="fs-4 text-center">No Data Found</div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="changeStatusModalLabel">Change Order Status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('orders.update', ['order' => $order->id]) }}">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label>Status</label>
                        <select class="select form-select" name="status" id="order_status">
                            <option value="">Choose Status</option>
                            <option value="Pending" @if($order->status === 'Pending') selected @endif>Pending</option>
                            <option value="Processing" @if($order->status === 'Processing') selected @endif>Processing</option>
                            <option value="Confirmed" @if($order->status === 'Confirmed') selected @endif>Confirmed</option>
                            <option value="Dispatched" @if($order->status === 'Dispatched') selected @endif>Dispatched</option>
                            <option value="Out For Delivery" @if($order->status === 'Out For Delivery') selected @endif>Out For Delivery</option>
                            <option value="Delivered" @if($order->status === 'Delivered') selected @endif>Delivered</option>
                            <option value="Cancelled" @if($order->status === 'Cancelled') selected @endif>Cancelled</option>
                            <option value="Rejected" @if($order->status === 'Rejected') selected @endif>Rejected</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Payment Status</label>
                        <select class="select form-select" name="payment_status" id="payment_status">
                            <option value="">Choose Status</option>
                            <option value="Pending" @if($order->payment_status === 'Pending') selected @endif>Pending</option>
                            <option value="Completed" @if($order->payment_status === 'Completed') selected @endif>Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Remarks</label>
                        <textarea name="remarks" id="" rows="3" class="form-control" required>{{$order->remarks}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var modal = document.getElementById('changeStatusModal');
    modal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var orderId = button.getAttribute('data-order-id');
        document.querySelector('#order_id').value = orderId;
        document.querySelector('#order_status').value = '';
    });
</script>
@endsection