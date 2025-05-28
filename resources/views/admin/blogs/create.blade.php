@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Add New Blog</h4>
                        <h6>Post a new Blog</h6>
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @include('admin.blogs.partial.blog-form')

            </div>
        </div>
    </div>
@endsection
