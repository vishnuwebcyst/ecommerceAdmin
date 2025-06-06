@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Product Add Unit Type</h4>
                        <h6>Create new product Unit Type</h6>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form class="row" method="post" action="{{ route('unit.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-lg-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label>Unit Name</label>
                                    <input type="text"  name="name">
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

   
@endsection
