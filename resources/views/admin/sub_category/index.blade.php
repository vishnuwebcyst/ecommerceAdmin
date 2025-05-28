@extends('layouts.admin')
@section('content')
    <div class="main-wrapper">



        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product Sub Category list</h4>
                        <h6>View/Search product Category</h6>
                    </div>
                    <div class="page-btn">
                        <a href="{{route('sub_category.create')}}" class="btn btn-added"><img src="{{asset('admin/images/plus.svg')}}"
                                class="me-2" alt="img"> Add Sub Category</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-top">
                            <div class="search-set">
                                <div class="search-path">
                                    <a class="btn btn-filter" id="filter_search">
                                        <img src="{{asset('admin/images/filter.svg')}}" alt="img">
                                        <span><img src=" assets/img/icons/closes.svg" alt="img"></span>
                                    </a>
                                </div>
                                <div class="search-input">
                                    <a class="btn btn-searchset"><img src={{asset('admin/images/search-white.svg')}}
                                            alt="img"></a>
                                </div>
                            </div>
                            <div class="wordset">
                                <ul>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img
                                                src="{{asset('admin/images/pdf.svg')}}" alt="img"></a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img
                                                src="{{asset('admin/images/excel.svg')}}" alt="img"></a>
                                    </li>
                                    <li>
                                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img
                                                src="{{asset('admin/images/printer.svg')}}" alt="img"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card" id="filter_inputs">
                            <div class="card-body pb-0">
                                <div class="row">
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <select class="select">
                                                <option>Choose Category</option>
                                                <option>Computers</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Sub Category</label>
                                            <select class="select">
                                                <option>Choose Sub Category</option>
                                                <option>Fruits</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Category Code</label>
                                            <select class="select">
                                                <option>CT001</option>
                                                <option>CT002</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 col-sm-6 col-12 ms-auto">
                                        <div class="form-group">
                                            <label>&nbsp;</label>
                                            <a class="btn btn-filters ms-auto"><img
                                                    src=" assets/img/icons/search-whites.svg" alt="img"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table  datanew">
                                <thead>
                                    <tr>
                                        <th>
                                            <label class="checkboxs">
                                                <input type="checkbox" id="select-all">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </th>
                                        <th>Category</th>
                                        <th>Parent category</th>
                                        <th>Category Code</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                @if(!empty($category))
                                <tbody >
                                    @foreach ($category as $key=>$item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->category->name ?? '' }}</td>
                                        <td>{{ $item->slug }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <div class="d-flex gap-3 align-items-center">
                                                {{-- <a class="me-3" href=" product-details.html">
                                                    <img src="{{asset('admin/images/eye.svg')}}" alt="img">
                                                </a> --}}
                                                <a href="{{route('sub_category.edit',$item->id)}}">
                                                    <img src="{{asset('admin/images/edit.svg')}}" alt="img">
                                                </a>
                                                {{-- <a class="confirm-text" href="javascript:;" onclick="deleteCategory()">
                                                    <img src="{{ asset('admin/images/delete.svg') }}" alt="img">
                                                </a> --}}
                                                <form action="{{ route('sub_category.destroy',$item->id) }}" method="POST" onsubmit="return confirm('Are You Sure?\nDo You Want to Delete {{$item->name}} sub-category?')">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn confirm-text p-0" type="submit"><img src="{{ asset('admin/images/delete.svg') }}" alt="img"></button>
                                                </form>
                                            </div>
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
@endsection
