@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Orders List</h4>
                        <h6>All Orders</h6>
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card card-header mb-2 fw-bold">
                    Total Orders : {{  count($orders) }}
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>User</th>
                                        <th>User Email</th>
                                        <th>Total Price</th>
                                        <th>Total Quantity</th>
                                        <th>Order Status</th>
                                        <th>Date / Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if (!empty($orders))
                                    <tbody>
                                        @foreach ($orders as $key => $item)
                                            <tr>
                                                <td>{{ $orders->firstItem()+$key }}</td>
                                                <td>{{ $item->order_id }}</td>
                                                <td>{{ $item->user->name }}</td>
                                                <td>{{ $item->user->email }}</td>
                                                <td>{{ $item->total_price }}</td>
                                                <td>{{ $item->total_quantity }}</td>
                                                <td>{{ $item->status }}</td>
                                                <td>{{ $item->created_at->format('d-m-Y h:i a') }}</td>
                                                <td>
                                                    <a class="me-3" href="#changeStatusModal" data-bs-toggle="modal" data-order-id="{{ $item->id }}">
                                                        Change Status
                                                    </a>
                                                    <a class="me-3" href="{{ route('orders.show', ['order' => $item->id]) }}">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        <ul class="pagination mt-3">
                            {{ $orders->links() }}
                        </ul>
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
                    <form method="POST" action="{{ route('update_order') }}">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label>Status</label>
                            <select class="select form-select" name="status" id="order_status">
                                <option value="">Choose Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Dispatched">Dispatched</option>
                                <option value="Out For Delivery">Out For Delivery</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Cancelled">Cancelled</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Payment Status</label>
                            <select class="select form-select" name="payment_status" id="payment_status">
                                <option value="" disabled>Choose Status</option>
                                <option value="Pending" selected>Pending</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Remarks</label>
                            <textarea name="remarks" id="" rows="3" class="form-control" required></textarea>
                        </div>
                        <input type="hidden" name="order_id" id="order_id">
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
