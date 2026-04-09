@extends('layouts.app')

@section('title', 'Tienda')

@section('video', 'false')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        {{-- CSS propio de la tienda (fondo + navbar) --}}
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">
@endpush

@section('content')

    <div id="tienda-root" data-user-email="{{ auth()->user()?->email ?? '' }}"></div>

@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/tienda.jsx'])
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.12.74/build/spline-viewer.js"></script>
@endpush



