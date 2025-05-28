@extends('layouts.admin')

@section('content')

<div class="page-wrapper" style="min-height: 399px;">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Profile</h4>
                <h6>Admin Profile</h6>
            </div>
        </div>
        <!-- /product list -->
        <div class="card">
            @if(session("error"))
            <div class="alert alert-danger">{{ session("error") }}</div>
            @endif
            @if(session("success"))
            <div class="alert alert-success">{{ session("success") }}</div>
            @endif
            <div class="card-body">
                <form class="row" method="POST" action="{{ route('admin.update_profile') }}">
                    @csrf
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label class="form-label"> Name</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" name="name" required>
                        </div>
                    </div>
                 
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" name="email" required>
                        </div>
                    </div>
                  
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label class="form-label"> Old Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" name="old_password">
                                {{-- <span class="fas toggle-password fa-eye-slash"></span> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="input-blocks mb-3">
                            <label class="form-label">New Password</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control" name="password">
                                {{-- <span class="fas toggle-password fa-eye-slash"></span> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-submit me-2">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /product list -->
    </div>
</div>

@endsection