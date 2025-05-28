@extends('layouts.admin')
@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product Add Sub Category</h4>
                        <h6>Create new product subcategory</h6>
                    </div>
                </div>

                <form class="card" method="post" action="{{ route('sub_category.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6 col-12" data-select2-id="6">
                                <div class="form-group" data-select2-id="5">
                                    <label>Parent Category</label>
                                    <select class="form-select form-control" name="category_id" required>
                                        <option value="" selected disabled>Choose Category</option>
                                        @if (!empty($category))
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Sub Category Name</label>
                                    <input type="text" oninput="createSlug(this.value)" name="name" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Sub Category Code</label>
                                    <input type="text" id="slug" name="slug" required>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Categorey Image</label>
                                    <div class="image-upload">
                                        <input name="image" type="file">
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
