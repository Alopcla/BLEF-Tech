@extends('layouts.app')

@section('title', 'Animales')

@push('styles')
    {{-- 1. El Pase VIP para cargar la fuente de inmediato (¡Cambia el nombre del archivo!) --}}
    <link rel="preload" href="{{ asset('fonts/Parkzoo-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>

    {{-- 2. El CSS global --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

@section('content')
    <div id="pagina-animales-root" style="min-height: 100vh;"></div>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endpush
