@extends('layouts.app', [
    'bodyClass' => 'hold-transition login-page'
])

@section('content')
<div class="container error-container">
    <h1 class="display-4">404 - Page Not Found</h1>
    <p class="lead">Sorry, the page you are looking for could not be found.</p>
    <p class="text-muted"><a href="{{ route('login') }}">Return</a>.</p>
</div>
@endsection