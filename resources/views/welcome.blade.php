@extends('layouts.app')

@section('title', 'Inicio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
@endpush

@section('content')

    {{-- Barra de temperatura --}}
    <div class="barra-tiempo" id="temperatura"></div>

    {{-- Sección animales (React) --}}
    <div id="pagina-animales-root" style="display: none; min-height: 500px; padding: 50px;"></div>

@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
    <script src="{{ asset('js/main.js') }}" defer></script>
@endpush
