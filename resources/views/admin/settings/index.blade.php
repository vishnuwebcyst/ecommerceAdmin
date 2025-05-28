@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Settings</h4>
                        <h6>Manage Website Settings</h6>
                    </div>
                </div>
                <div id="csrf-token" data-content="{{ csrf_token() }}" style="display: none"></div>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif  
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="form-group position-relative">
                                <label for="deal-of-week" class="form-label">Select Logo</label>
                                <!-- <input type="file" class="form-control" id="deal-of-week" name="logo" value=""> -->
                                <div class="image-upload {{ $setting->value != '' ?'pb-5':''}}">
                                        <input type="file" name="logo" onchange="updateImage()" id="file-input">
                                        @if($setting->value != "")
                                        <div class="image-uploads">
                                           
                                            <img src="{{ asset($setting->value) }}" alt="img" width="100">
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
                            <button type="submit" class="btn btn-primary">Save</button>
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
