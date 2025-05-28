 @extends('layouts.admin')
 @section('content')
     <div class="main-wrapper">



         <div class="page-wrapper">
             <div class="content">
                 <div class="page-header">
                     <div class="page-title">
                         <h4>Product Add</h4>
                         <h6>Create new product</h6>
                     </div>
                 </div>

                 @if (session('error'))
                     <div class="alert alert-danger">{{ session('error') }}</div>
                 @endif
                 <div class="card">
                     <div class="card-body">
                         <form class="row" action="{{ route('product.store') }}" method="POST"
                             enctype="multipart/form-data" id="form">
                             @csrf
                             <div class="col-lg-3 col-sm-6 col-12">
                                 <div class="form-group">
                                     <label>Product Name</label>
                                     <input type="text" name="name" value="{{ old('name') }}">
                                     @error('name')
                                         <div class="text-danger">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>
                             <div class="col-lg-3 col-sm-6 col-12">
                                 <div class="form-group">
                                     <label>Category</label>
                                     <select class="select form-select" name="category" onchange="getCategory(this.value)">
                                         <option value="">Choose Category</option>
                                         @if (!empty($category))
                                             @foreach ($category as $cat)
                                                 <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                             @endforeach
                                         @endif
                                     </select>
                                     @error('category')
                                         <div class="text-danger">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>
                             <div class="col-lg-3 col-sm-6 col-12">
                                 <div class="form-group">
                                     <label>Sub Category</label>
                                     <select class="select form-select" name="sub_category" id="sub_category">
                                         <option value="">Choose Sub Category</option>
                                     </select>
                                     @error('sub_category')
                                         <div class="text-danger">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>
                             {{-- <div class="col-lg-3 col-sm-6 col-12">
                             <div class="form-group">
                                 <label>Sub Category</label>
                                 <select class="select form-select">
                                     <option>Choose Sub Category</option>
                                     <option>Fruits</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col-lg-3 col-sm-6 col-12">
                             <div class="form-group">
                                 <label>Brand</label>
                                 <select class="select form-select">
                                     <option>Choose Brand</option>
                                     <option>Brand</option>
                                 </select>
                             </div>
                         </div> --}}
                             {{-- <div class="col-lg-3 col-sm-6 col-12">
                             <div class="form-group">
                                 <label>Unit</label>
                                 <input type="text" name="unit" placeholder="example 1-100">
                                 @error('unit')
                                 <div class="text-danger">{{ $message }}</div>
                                  @enderror
                             </div>
                         </div>
                         <div class="col-lg-3 col-sm-6 col-12">
                             <div class="form-group">
                                 <label>Unit</label>
                                 <select class="select  form-select" name="unit_type">
                                     <option value="">Choose Unit Type</option>
                                     @if (!empty($units))
                                     @foreach ($units as $unit)
                                     <option value="{{$unit->id}}">{{ $unit->name }}</option>
                                     @endforeach
                                     @endif
                                 </select>
                                 @error('unit_type')
                                 <div class="text-danger">{{ $message }}</div>
                                  @enderror
                             </div>
                         </div> --}}
                             <div class="col-lg-3 col-sm-6 col-12">
                                 <div class="form-group">
                                     <label>SKU</label>
                                     <input type="text" name="sku" value="{{ old('sku') }}">
                                 </div>
                             </div>
                             {{-- <div class="col-lg-3 col-sm-6 col-12">
                             <div class="form-group">
                                 <label>Minimum Qty</label>
                                 <input type="text">
                             </div>
                         </div> --}}

                             {{-- <div class="col-lg-3 col-sm-6 col-12">
                             <div class="form-group">
                                 <label>Tax</label>
                                 <select class="select  form-select">
                                     <option>Choose Tax</option>
                                     <option>2%</option>
                                 </select>
                             </div>
                         </div> --}}
                         <div class="col-lg-4 col-sm-6 col-12">
                                 <div class="form-group">
                                     <label>Discount Amount</label>
                                     <input type="number" class="form-control" id="discount" name="discount" value="">
                                     <div id="error-message" style="color: red; display: none;">Discount cannot be greater than the price!</div>

                                 </div>
                             </div>  
                              <!-- <div class="col-lg-3 col-sm-6 col-12">
                                 <div class="form-group">
                                     <label>Discount Type</label>
                                     <select class="select  form-select" name="discount">
                                         <option>Percentage</option>
                                         <option value="10">10%</option>
                                         <option value="20">20%</option>
                                     </select>
 
                                 </div>
                             </div> -->
                             {{-- <div class="col-lg-3 col-sm-6 col-12">
                                 <div class="form-group">
                                     <label> Status</label>
                                     <select class="select  form-select" name="status">
                                         <option value="Open">Open</option>
                                         <option value="Closed">Closed</option>
                                     </select>
                                     @error('status')
                                         <div class="text-danger">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div> --}}


                             {{-- <div class="input-group m-3">
                            <input type="text" class="form-control m-input">
                        </div> --}}

                             <div id="newinput" class="col-md-12 row">
                                 <div class="col-lg-2 col-sm-6 col-12">
                                     <div class="form-group">
                                         <label>Unit</label>
                                         <input type="number" name="unit[]" placeholder="example 1-100"
                                             class="form-control">
                                         @error('unit')
                                             <div class="text-danger">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>
                                 <div class="col-lg-3 col-sm-6 col-12">
                                     <div class="form-group">
                                         <label>Unit</label>
                                         <select class="select  form-select m-input" name="unit_type[]">
                                             <option value="">Choose Unit Type</option>
                                             @if (!empty($units))
                                                 @foreach ($units as $unit)
                                                     <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                                                 @endforeach
                                             @endif
                                         </select>
                                         @error('unit_type')
                                             <div class="text-danger">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>

                                 <div class="col-lg-2 col-sm-6 col-12">
                                     <div class="form-group">
                                         <label>Price</label>
                                         <input type="text" name="price[]" id="price"  class="form-control">
                                         @error('price')
                                             <div class="text-danger">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-sm-6 col-12">
                                     <div class="form-group">
                                         <label>Quantity</label>
                                         <input type="text" name="quantity[]">
                                         @error('quantity')
                                             <div class="text-danger">{{ $message }}</div>
                                         @enderror
                                     </div>
                                 </div>

                             </div>
                             <button id="rowAdder" type="button" class="btn btn-dark col-md-2 mb-4">
                                 <span class="bi bi-plus-square-dotted">
                                 </span> ADD
                             </button>


                             <div class="col-lg-12">
                                 <div class="form-group">
                                     <label>Description</label>
                                     <textarea class="form-control editor" name="description" id="groupContent">{{ old('description') }}</textarea>
                                     @error('description')
                                         <div class="text-danger">{{ $message }}</div>
                                     @enderror
                                 </div>
                             </div>
                             <div class="col-lg-12">
                                 <div class="form-group">
                                     <label> Product Image</label>
                                     <div class="image-upload">
                                         <a href="javascript:;"
                                             class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger pt-2"
                                             style="height: 30px;width:30px;font-size:15px;" id="remove-image">
                                             X</a>
                                         <input type="file" name="image[]" id="file-input" onchange="updateImage()"
                                             multiple>
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
                                 <button type="submit" class="btn btn-submit me-2"
                                     onclick="handleButtonClick(this)" id="submit-btn">Submit</a>

                                     <button type="reset" class="btn btn-cancel">Cancel</button>
                             </div>
                         </form>
                     </div>
                 </div>

             </div>
         </div>
     </div>

     <script>
        $(document).ready(function() {
    // Trigger when discount or price fields are changed
    $('#discount, #price').on('input', function() {
        // Get the values of discount and price inputs
        var discount = parseFloat($('#discount').val());
        var price = parseFloat($('#price').val());

        // Check if discount is greater than the price
        if (discount > price) {
            // Show error message if discount is greater than price
            $('#error-message').show();

            // Optionally, you can highlight the input fields to show an error
            $('#discount').css('border-color', 'red');
            $('#price').css('border-color', 'red');

            // Show alert
            alert("Discount cannot be greater than the price!");

            // Hide the submit button
            $('#submit-btn').hide();
        } else {
            // Hide error message if discount is less than or equal to the price
            $('#error-message').hide();

            // Reset the border color when the validation is passed
            $('#discount').css('border-color', '');
            $('#price').css('border-color', '');

            // Show the submit button again
            $('#submit-btn').show();
        }
    });
});
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

     <script>
         $(document).ready(function() {



             $("#rowAdder").click(async function() {
                 var data = await fetch("{{ route('get_units') }}");
                 var units = await data.json();

                 newRowAdd =
                     '<div id="row" class="row">' +
                     '<div class="col-lg-2 col-sm-6 col-12"><div class="form-group">' +
                     '<input type="number" class="form-control m-input" placeholder="example 1-100" name="unit[]"> </div></div>' +
                     '<div class="col-lg-3 col-sm-6 col-12"><div class="form-group">' +
                     ' <select class="select  form-select m-input" name="unit_type[]"><option value="">Choose Unit Type</option>';

                 units.forEach(datas => {
                     newRowAdd += '<option value="' + datas.name + '">' + datas.name +
                         '</option>'
                 });

                 newRowAdd += '</select></div></div>' +
                     '<div class="col-lg-2 col-sm-6 col-12">' +
                     '<div class="form-group">' +
                     '<input type="text" name="price[]" id="price"  class="form-control">' +
                     '</div>' +
                     '</div>' +
                     '<div class="col-lg-2 col-sm-6 col-12">' +
                     '<div class="form-group">' +
                     '<input type="text" name="quantity[]" >' +
                     '</div>' +
                     '</div>' +
                     '<div class="col-2">' +
                     '<button class="btn btn-danger" id="DeleteRow" type="button">' +
                     '<i class="bi bi-trash"></i> Delete</button> </div></div>';

                 $('#newinput').append(newRowAdd);
             });
             $("body").on("click", "#DeleteRow", function() {
                 $(this).parents("#row").remove();
             });



         });

         async function getCategory(e) {
             $("#sub_category").html("<option value=''>Select Sub Category</option>");
             var value = e;
             var data = await fetch("/get_category/" + value, {
                 method: "GET",
             });
             var res = await data.json();
             res.forEach((item) => {
                 $("#sub_category").append(
                     "<option value='" + item.id + "'>" + item.name + "</option>"
                 );
             });
         }

         function handleButtonClick(button) {
             // Disable the button
             button.disabled = true;
             $("#form").submit();

             // Enable the button after 2 seconds (2000 milliseconds)
             setTimeout(function() {
                 button.disabled = false;
             }, 1000);
         }
     </script>


 @endsection
