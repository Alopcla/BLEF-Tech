@extends('layouts.app')

@section('title', 'Animales')

@section('video', 'false')

@push('styles')
    {{-- Fuente de letras --}}
    <link rel="preload" href="{{ asset('fonts/Parkzoo-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>

    {{-- CSS global --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
    /* Fondo de imagen */
    body {
        background: #141A14 url("/img/zoo_fondo.png") no-repeat fixed center !important;
        background-size: cover !important;
        position: relative;
    }

    /* FILTRO OSCURO DE FONDO */
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

    /* Transparencia para los contenedores */
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
