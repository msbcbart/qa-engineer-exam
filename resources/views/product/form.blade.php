@extends('layouts.app', [
    'bodyClass' => 'hold-transition sidebar-mini layout-fixed'
])

@push('metas')
<meta name="access-token" content="{{ $token }}">
@endpush

@section('content')
<section class="content pt-3">
    <div class="container-fluid">
        <div class="row">
            <div id="app" class="col col-md-8 mx-auto">
                <product-form-component :product="{{ $product }}" :category-enum="{{ $categories }}" />
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    @vite(['resources/js/app.js'])
@endpush