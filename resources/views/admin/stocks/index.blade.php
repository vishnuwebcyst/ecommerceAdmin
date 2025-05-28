@extends('layouts.admin')

@section('content')

    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product Stocks</h4>
                        {{-- <h6>View/Search product Category</h6> --}}
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                        @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                @endif

                <div class="card">
                  
                    <div class="card-body">
                        <div class="table-top">
                            <div class="search-set">
                                <div class="search-path">
                                    <a class="btn btn-filter" id="filter_search">
                                        <img src="{{ asset('admin/images/filter.svg') }}" alt="img">
                                        <span><img src="{{ asset('admin/images/closes.svg') }}" alt="img"></span>
                                    </a>
                                </div>
                                <div class="search-input">
                                    <a class="btn btn-searchset"><img src="{{ asset('admin/images/search-white.svg') }}"
                                            alt="img"></a>
                                </div>
                            </div>
                            {{-- <div class="wordset">
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
                            </div> --}}
                        </div>


                        <div class="table-responsive">
                            <table class="table  datanew">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Product Category</th>
                                        <th> Quantity</th>
                                        <th> Action</th>
                                    </tr>
                                </thead>
                                @if (!empty($stocks))
                                    <tbody>
                                        @foreach ($stocks as $key => $item)
                                            <tr>
                                                <td>{{ $stocks->firstItem() + $key }}</td>
                                                <td>{{ $item->product->name ?? ""}}</td>
                                                <td>{{ $item->product->category_name ?? "" }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td class="action-table-data">
                                                    <div class="edit-delete-action">
                                                        <a class="me-2 p-2" href="#" data-bs-toggle="modal"
                                                            data-bs-target="#edit-units_{{ $item->id }}">
                                                            <i data-feather="edit" class="feather-edit"></i>
                                                        </a>
                                                    </div>

                                                    <div class="modal fade " id="edit-units_{{ $item->id }}"
                                                        aria-modal="false" role="dialog">
                                                        <div class="modal-dialog modal-dialog-centered stock-adjust-modal">
                                                            <div class="modal-content">
                                                                <div class="page-wrapper-new p-0">
                                                                    <div class="content">
                                                                        <div
                                                                            class="modal-header border-0 custom-modal-header">
                                                                            <div class="page-title">
                                                                                <h4>Edit Stock</h4>
                                                                            </div>
                                                                            <button type="button" class="close"
                                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">×</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body custom-modal-body">
                                                                            <form action="{{ route('product.update_stocks',$item->id) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <div class="modal-body-table">
                                                                                            <div class="table-responsive">
                                                                                                <div 
                                                                                                    class=" table-responsive">
                                                                                                    <table
                                                                                                        class="table "
                                                                                                      >
                                                                                                        <thead>
                                                                                                            <tr>
                                                                                                                <th class="sorting sorting_asc"
                                                                                                                    tabindex="0"
                                                                                                                    aria-controls="DataTables_Table_1"
                                                                                                                    rowspan="1"
                                                                                                                    colspan="1"
                                                                                                                    aria-sort="ascending"
                                                                                                                    aria-label="Product: activate to sort column descending"
                                                                                                                    style="width: 0px;">
                                                                                                                    Product
                                                                                                                </th>
                                                                                                                <th class="sorting"
                                                                                                                    tabindex="0"
                                                                                                                    aria-controls="DataTables_Table_1"
                                                                                                                    rowspan="1"
                                                                                                                    colspan="1"
                                                                                                                    aria-label="Category: activate to sort column ascending"
                                                                                                                    style="width: 0px;">
                                                                                                                    Category
                                                                                                                </th>
                                                                                                                <th class="sorting"
                                                                                                                    tabindex="0"
                                                                                                                    aria-controls="DataTables_Table_1"
                                                                                                                    rowspan="1"
                                                                                                                    colspan="1"
                                                                                                                    aria-label="Qty: activate to sort column ascending"
                                                                                                                    style="width: 0px;">
                                                                                                                    Qty</th>
                                                                                                            </tr>
                                                                                                        </thead>
                                                                                                        <tr>
                                                                                                            <td>{{ $item->product->name ?? ""}}</td>
                                                                                                          <td>{{ $item->product->category_name ?? ""}}</td>
                                                                                                            <td>
                                                                                                                <div class="product-quantity">
                                                                                                                    <span class="quantity-btn">-<i data-feather="minus-circle" class="feather-search"></i></span>
                                                                                                                    <input type="text" class="quntity-input" value="{{ $item->quantity }}" name="quantity">
                                                                                                                    <span class="quantity-btn">+<i data-feather="plus-circle" class="plus-circle"></i></span>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                        </tr>
                                                                                                        <tbody>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer-btn mt-5">
                                                                                    <button type="submit"
                                                                                        class="btn btn-submit">Save
                                                                                        Changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                            
                            {{ $stocks->links() }}
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <script>
        function deleteCategory(id) {
            if (confirm('Are you sure want to delete')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }


          //Increment Decrement Numberes
	$(".quantity-btn").on("click", function () {

var $button = $(this);
var oldValue = $button.closest('.product-quantity').find("input.quntity-input").val();
if ($button.text() == "+") {
    var newVal = parseFloat(oldValue) + 1;
} else {
    if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
    } else {
        newVal = 0;
    }
}
$button.closest('.product-quantity').find("input.quntity-input").val(newVal);
});
    </script>
@endsection
