@extends('layouts.admin')

@section('content')
    <div class="main-wrapper">
        <div class="page-wrapper">
            <div class="content">
                <div class="page-header">
                    <div class="page-title">
                        <h4>Deals of The Week</h4>
                        <h6>Highlight special product on Main Website</h6>
                    </div>
                </div>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <datalist class="form-select">
                            <option value="H">Hello</option>
                        </datalist>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
