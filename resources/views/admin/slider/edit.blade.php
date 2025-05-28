@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Slider Image Update  </h4>
                        <h6>Update  slide image</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form class="row" method="post" action="{{ route('admin.update_slider',$data->id) }}" enctype="multipart/form-data">
                            @csrf
                         
                           
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Slider Image</label>
                                    <div class="image-upload {{ $data->image != "" ?'pb-5':''}}">
                                        <input type="file" name="image" onchange="updateImage()" id="file-input">
                                        @if($data->image != "")
                                        <div class="image-uploads">
                                            <a href="{{route('cat_file.delete',$data->id)}}" class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger pt-2" style="height: 30px;width:30px;font-size:15px;">
                                                X</a>
                                            <img src="{{ asset($data->image) }}" alt="img" width="100">
                                        </div>
                                        @else
                                        <div class="image-uploads">
                                            <a href="javascript:;" class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger pt-2" style="height: 30px;width:30px;font-size:15px;" id="remove-image">
                                                X</a>
                                            <img src="{{ asset('admin/images/upload.svg') }}" alt="img" id="selected-image">
                                            <h4 id="drag">Drag and drop a file to upload</h4>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-submit me-2">Submit</button>
                                <button type="reset" class="btn btn-cancel">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function updateImage() {
            var file_input = document.getElementById('file-input');
            var product_image = document.getElementById('selected-image');
            var fileupload = document.querySelector('.image-uploads h4');
    
            if (file_input.files.length > 0) {
                var file = file_input.files[0];
                var fileReader = new FileReader();
    
                fileReader.onload = function(e) {
                    product_image.src = e.target.result;
                    fileupload.textContent = '';
                    product_image.style.width = '50px';
                };
    
                fileReader.readAsDataURL(file);
                document.getElementById('remove-image').style.display = 'block';
                
    
            }
        }
    
            document.getElementById('remove-image').style.display = 'none';
            document.getElementById('remove-image').addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('selected-image').src = "{{ asset('admin/images/upload.svg') }}";
                document.getElementById('file-input').value = "";
                document.getElementById('remove-image').style.display = 'none';
                document.getElementById('drag').innerHTML = 'Drag and drop a file to upload';
                document.getElementById('selected-image').style.height = "50px";
    
            });
        
    </script>

   
@endsection
