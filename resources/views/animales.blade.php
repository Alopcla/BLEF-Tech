@extends('layouts.app')

@section('title', 'Animales')

@push('styles')
    {{-- 1. El Pase VIP para cargar la fuente de inmediato --}}
    <link rel="preload" href="{{ asset('fonts/Parkzoo-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>

    {{-- 2. El CSS global --}}
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <style>
    /* 1. Forzamos la desaparición del vídeo y de cualquier fondo previo */
    video, .video-background, #video-container {
        display: none !important;
        opacity: 0 !important;
        visibility: hidden !important;
    }

    /* 2. Aplicamos el fondo con una ruta relativa simple */
    body {
        background: #141A14 url("img/zoo_fondo.png") no-repeat fixed center !important;
        background-size: cover !important;
    }

    /* 3. Por si el layout de tu amigo tiene capas encima (muy importante) */
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
