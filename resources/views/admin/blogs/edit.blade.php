@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Edit Blog</h4>
                        <h6>Make Changes to Blog</h6>
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
