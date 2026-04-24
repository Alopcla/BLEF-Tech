@extends('layouts.app')

@section('title', 'Mapa Interactivo | Blef-Tech')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #0a0a0a !important;
        margin: 0;
        overflow-x: hidden;
    }

    /* CONTENEDOR DEL MAPA */
    .map-main-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    #react-mapa {
        width: 100%;
        min-width: 900px;
        /* Previene amontonamiento de pines */
        position: relative;
        z-index: 10;
    }

    /* AJUSTES DEL POPUP (Autoscroll) */
    .overflow-hidden-container {
        position: relative;
        overflow: hidden !important;
        height: 320px !important;
    }

    @keyframes autoScrollPopup {

        0%,
        15% {
            transform: translateY(0);
        }

        85%,
        100% {
            transform: translateY(calc(-100% + 320px));
        }
    }

    .animate-scroll {
        display: block;
        animation: autoScrollPopup 10s linear infinite alternate !important;
    }

    /* RESPONSIVE */
    @media screen and (max-width: 900px) {
        .barra-tiempo {
            position: static;
            backdrop-filter: none;
            box-shadow: none;
            background: none;
            display: flex;
            justify-content: flex-start;
            padding: 0;
            font-size: 20px;
        }

        .map-main-container {
            padding-top: 20px;
            align-items: flex-start;
            justify-content: flex-start;
        }
    }

    /* Scrollbar personalizada para el popup */
    .custom-scrollbar::-webkit-scrollbar {
        width: 5px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #16a34a;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')

{{-- Barra de temperatura --}}
<div class="barra-tiempo" id="temperatura"></div>

<div class="h-32 md:h-40 w-full shrink-0"></div>

{{-- Área del Mapa --}}
<main class="map-main-container">
    <div id="react-mapa"></div>
</main>

@endsection

@push('scripts')
@viteReactRefresh
@vite(['resources/js/app.jsx'])
@endpush