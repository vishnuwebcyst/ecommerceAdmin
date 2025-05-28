@extends('layouts.admin')

@section('content')

<div class="main-wrapper">
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Slider list</h4>
                    <h6>View/Search Slider</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.add_slider') }}" class="btn btn-added">
                        <img src="{{ asset('admin/images/plus.svg') }}" class="me-1" alt="img">Add Slider
                    </a>
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
                                    <span><img src=" admin/images/closes.svg" alt="img"></span>
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
                        <table class="table  datanew">
                            <thead>
                                <tr>

                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Date</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            @if (!empty($data))
                            <tbody>
                                @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $data->firstItem() + $key }}</td>
                                    <td> <img src="{{ asset($item->image) }}" alt="img" width="100">
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>

                                        <a class="me-3" href="{{ route('admin.edit_slider', $item->id) }}">
                                            <img src="{{ asset('admin/images/edit.svg') }}" alt="img">
                                        </a>
                                        <a class="confirm-text" href="javascript:;"
                                            onclick="deleteCategory('{{ $item->id }}')">
                                            <img src="{{ asset('admin/images/delete.svg') }}" alt="img">
                                        </a>
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('admin.delete_slider', $item->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            @endif
                        </table>
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