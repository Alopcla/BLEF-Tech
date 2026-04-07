@extends('layouts.app')

@section('title', 'Inicio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
@endpush

@section('content')
    {{-- Cascarón para la página principal de React --}}
    <div id="index-root"></div>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endpush