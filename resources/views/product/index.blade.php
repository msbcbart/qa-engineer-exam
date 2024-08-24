@extends('layouts.app', [
    'bodyClass' => 'hold-transition sidebar-mini layout-fixed'
])

@push('metas')
<meta name="access-token" content="{{ $token }}">
@endpush

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-6">
                <h1 class="m-0 text-dark">Products</h1>
            </div>
            <div class="col-6">
                <a href="{{ route('product.form') }}" class="btn btn-primary btn-round float-right">Create</a>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div id="app" class="col">
                <product-list-component :category-enum="{{ $categories }}" />
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    @vite(['resources/js/app.js'])
@endpush