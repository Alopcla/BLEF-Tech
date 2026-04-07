@extends('layouts.app')

@section('title', 'Animales')

{{-- PASO 1: Desactivamos el video del layout principal --}}
@section('video', 'false')

@push('styles')
    {{-- 1. El Pase VIP para cargar la fuente de inmediato --}}
    <link rel="preload" href="{{ asset('fonts/Parkzoo-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>

    {{-- 2. El CSS global --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
    /* 1. Tu fondo de musgo */
    body {
        background: #141A14 url("/img/zoo_fondo.png") no-repeat fixed center !important;
        background-size: cover !important;
        position: relative;
    }

    /* 2. CREAMOS EL FILTRO OSCURO (Copia exacta de lo que hace tu amigo) */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Esto es el bg-black/50 */
        z-index: -1; /* Se queda justo encima del fondo pero debajo de las letras */
        pointer-events: none;
    }

    /* 3. Transparencia para los contenedores */
    #app, main, .main-content {
        background: transparent !important;
    }
</style>
@endpush

@section('content')
    <div id="pagina-animales-root" style="min-height: 100vh;"></div>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endpush
