@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Blog List</h4>
                        <h6>Manage your blogs</h6>
                    </div>
                    <div class="page-btn">
                        <a href=" {{ route('blog.create') }}" class="btn btn-added"><img
                                src="{{ asset('admin/images/plus.svg') }}" alt="img" class="me-1">Add New Blog</a>
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
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Image</th>
                                        <th>Author</th>
                                        <th>Added On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if (!empty($blogs))
                                    <tbody>
                                        @foreach ($blogs as $key => $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td class="text-truncate">{{ $item->description }}</td>
                                                <td><img src="{{ $item->image_link }}" style="width: 100px;"></td>
                                                <td>{{ $item->author ?? 'No Author' }}</td>
                                                <td>{{ $item->created_at->format('d/m/Y h:i A') }}</td>
                                                {{-- <td>{{ $item->created_at }}</td> --}}
                                                <td>
                                                    <a class="me-3" href="{{ route('blog.edit', $item->id) }}">
                                                        <img src="{{ asset('admin/images/edit.svg') }}" alt="img">
                                                    </a>
                                                    {{-- <a class="confirm-text" href="javascript:;" onclick="deleteBlog()">
                                                        <img src="{{ asset('admin/images/delete.svg') }}" alt="img">
                                                    </a> --}}
                                                    <form id="delete-form" action="{{ route('blog.destroy', $item->id) }}"
                                                        method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?\nDo want to delete this blog?\n{{$item->title}}')">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="confirm-text" style="border: none; background: none;">
                                                            <img src="{{ asset('admin/images/delete.svg') }}" alt="img">
                                                        </button>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                            <div class="mt-4">{{ $blogs->links() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
