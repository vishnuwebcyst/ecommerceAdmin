@extends('layouts.admin')
@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product Update Sub Category</h4>
                        <h6>update product subcategory</h6>
                    </div>
                </div>

                <form class="card" method="post" enctype="multipart/form-data"
                    action="{{ route('sub_category.update', ['sub_category' => $sub_category->id]) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12" data-select2-id="6">
                                <div class="form-group" data-select2-id="5">
                                    <label>Parent Category</label>
                                    <select class="form-select form-control" name="category_id" required>
                                        <option value="" selected disabled>Choose Category</option>
                                        @if (!empty($categories))
                                            @foreach ($categories as $item)
                                                <option value="{{ $item->id }}"
                                                    selected={{ $item->id == $sub_category->category_id }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Sub Category Name</label>
                                    <input type="text" oninput="createSlug(this.value)" name="name"
                                        value="{{ $sub_category->name }}" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Sub Category Code</label>
                                    <input type="text" id="slug" name="slug" value="{{ $sub_category->slug }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description">{{ $sub_category->description }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Product Image</label>
                                    <div class="image-upload">
                                        <input type="file" name="image">
                                        <div class="image-uploads">
                                            <img src="https://dreamspos.dreamguystech.com/html/template/assets/img/icons/upload.svg"
                                                alt="img">
                                            <h4>Drag and drop a file to upload</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <button type="reset" class="btn btn-cancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
