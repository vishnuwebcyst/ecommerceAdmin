@extends('layouts.admin')

@section('content')

    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Customer List</h4>
                        {{-- <h6>View/Search product Category</h6> --}}
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
                                        <span><img src="{{ asset('admin/images/closes.svg')}}" alt="img"></span>
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
                                        {{-- <th>
                                                <label class="checkboxs">
                                                    <input type="checkbox" id="select-all">
                                                    <span class="checkmarks"></span>
                                                </label>
                                            </th> --}}
                                        <th>#</th>
                                        <th>Customer Name</th>
                                        <th>Customer Email</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if (!empty($customers))
                                    <tbody>
                                        @foreach ($customers as $key => $item)
                                            <tr>
                                                <td>{{ $customers->firstItem() + $key }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td><a href="{{ route('orders.index',["user_id"=>$item->id]) }}" >View Orders</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                            {{ $customers->links() }}
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
    </script>
@endsection
