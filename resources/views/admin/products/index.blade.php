@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product List</h4>
                        <h6>Manage your products</h6>
                    </div>
                    <div class="page-btn">
                        <a href=" {{ route('product.create') }}" class="btn btn-added"><img
                                src="{{ asset('admin/images/plus.svg') }}" alt="img" class="me-1">Add New Product</a>
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
                        <div class="table-top">
                            <div class="search-set">
                                <div class="search-path">
                                    <a class="btn btn-filter" id="filter_search">
                                        <img src="{{ asset('admin/images/filter.svg') }}" alt="img">
                                        <span><img src=" assets/img/icons/closes.svg" alt="img"></span>
                                    </a>
                                </div>
                                <div class="search-input">
                                    <a class="btn btn-searchset"><img src="{{ asset('admin/images/search-white.svg') }}"
                                            alt="img"></a>
                                </div>
                            </div>
                            <div class="wordset">
                                <ul>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                                src="{{ asset('admin/images/pdf.svg') }}" alt="img"></a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                                src="{{ asset('admin/images/excel.svg') }}" alt="img"></a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                                src="{{ asset('admin/images/printer.svg') }}" alt="img"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Category </th>
                                        <th>Sub Category </th>
                                        <th>Price</th>
                                        <th>Discount Amount </th>
                                        <th>Discount Price </th>
                                        <th>Qty</th>
                                        {{-- <th>Created By</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if (!empty($products))
                                    <tbody>
                                        @foreach ($products as $key => $item)
                                            <tr>
                                                <td>{{ $products->firstItem() + $key }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->category->name ?? ""}}</td>
                                                <td>{{ $item->sub_category->name ?? ""}}</td>
                                                <td>{{ isset($item->product_units[0]) ? $item->product_units[0]->price : '' }}</td>
                                                <td>{{ $item->discount }}</td>
                                                <td>{{ isset($item->product_units[0]) ? $item->product_units[0]->price - $item->discount  : '' }}</td>
                                                <td>{{ isset($item->product_units[0]) ? $item->product_units[0]->quantity: '' }}</td>
                                                {{-- <td>{{ $item->created_at }}</td> --}}
                                                <td>
                                                    <a class="me-3" href="{{ route('product.edit', $item->id) }}">
                                                        <img src="{{ asset('admin/images/edit.svg') }}" alt="img">
                                                    </a>
                                                    <a class="confirm-text" href="javascript:;" onclick="deleteProduct({{$item->id}})">
                                                        <img src="{{ asset('admin/images/delete.svg') }}" alt="img">
                                                    </a>
                                                    <form id="delete-form-{{$item->id}}" action="{{ route('product.destroy',$item->id) }}" method="POST"
                                                        class="d-none">
                                                        @csrf
                                                        @method('delete')
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        <ul class="pagination">
                            {{ $products->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    function deleteProduct(id){
        if(confirm('Are you sure want to delete')){
            document.getElementById(`delete-form-${id}`).submit();
        }
    }
</script>


@endsection
