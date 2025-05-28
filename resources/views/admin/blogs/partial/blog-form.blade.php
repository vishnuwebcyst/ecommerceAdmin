<div class="card">
    <div class="card-body">
        <form class="row" action="{{ !empty($blog ?? '') ? route('blog.update', $blog->id) : route('blog.store') }}" method="POST"
            enctype="multipart/form-data" id="form">
            @if (!empty($blog ?? '')) {{ method_field('PUT') }} @endif
            @csrf
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" value="{{ old('title', $blog->title ?? '') }}" class="@error('title') is-invalid @enderror">
                    @error('title')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" value="{{ old('author', $blog->author ?? '') }}">
                </div>
            </div>

            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea type="text" name="description" class="@error('description') is-invalid @enderror">{{ old('description', $blog->description ?? '') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-lg-12">
                <div class="form-group">
                    <label>Content</label>
                    <textarea class="form-control editor" name="content" id="blogContent">{{ old('content', $blog->content ?? '') }}</textarea>
                    @error('content')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Image</label>
                    <div class="image-upload">
                        <a href="javascript:;"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger pt-2 z-3"
                            style="height: 30px;width:30px;font-size:15px;" id="remove-image">&times;</a>
                        <input type="file" name="image" accept="image/*" id="file-input" onchange="updateImage()">
                        <div class="image-uploads">
                            <img src="{{ asset('admin/images/upload.svg') }}" alt="img"
                                id="selected-image">
                            <h4 id="drag">Drag and drop a file to upload</h4>
                        </div>
                    </div>
                    @error('image')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-lg-12">
                <button type="submit" class="btn btn-submit me-2">Submit</a>
                <button type="reset" class="btn btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        // configure ckeditor
        CKEDITOR.replace('blogContent', {
            // filebrowserUploadUrl: "{{-- route('product.store', ['_token' => csrf_token() ]) --}}",
            filebrowserUploadMethod: 'form'
        });
        // submit ckeditor data with form
        $('form').submit(function() {
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
        });

    });
</script>
