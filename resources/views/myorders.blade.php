@extends('layouts.app')

@section('title', 'Mis Compras')

@section('video', 'false')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<style>
    body {
        /* Fondo con un degradado radial para centrar la atención */
        background: radial-gradient(circle at center, rgba(20, 26, 20, 0.8) 0%, rgba(10, 15, 10, 1) 100%), 
                    url("/img/zoo_fondo.png") no-repeat fixed center !important;
        background-size: cover !important;
    }

    /* Animación suave para la entrada de la página */
    .fade-in-down {
        animation: fadeInDown 0.8s ease-out;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }


    input {
    outline: none;
    box-shadow: none;
    }

    /* Chrome autofill feo (esto es lo que ves en tu captura) */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active {
    -webkit-box-shadow: 0 0 0 1000px #1A2E1A inset !important;
    -webkit-text-fill-color: white !important;
    caret-color: white;
    border-radius: 1rem;
    }

    /* quita borde azul de focus */
    input:focus {
    outline: none !important;
    box-shadow: none !important;
    }
</style>
@endpush

@section('content')
{{-- Espaciador --}}
<div class="h-24 lg:h-40"></div>

<div class="max-w-6xl mx-auto px-6 pb-20">
    {{-- Header con estilo refinado --}}
    <header class="mb-16 text-center lg:text-left fade-in-down">
        <div class="inline-block py-1 px-3 rounded-full bg-[#D9C8A1]/10 border border-[#D9C8A1]/20 mb-4">
            <span class="text-[#D9C8A1] uppercase tracking-[4px] text-[9px] font-black">
                Portal del Explorador
            </span>
        </div>

        <h1 class="font-parkzoo text-5xl lg:text-7xl text-white mt-2 leading-none">
            Mi <span class="text-[#D9C8A1] drop-shadow-[0_0_15px_rgba(217,200,161,0.3)]">Historial</span>
        </h1>

        <div class="flex flex-col lg:flex-row lg:items-center gap-4 mt-6">
            <p class="text-white/40 text-sm max-w-md italic">
                "Consulta tus expediciones pasadas, tickets de acceso y adquisiciones de la tienda oficial."
            </p>
            <div class="h-[1px] flex-grow bg-gradient-to-r from-[#D9C8A1]/30 to-transparent hidden lg:block"></div>
        </div>
    </header>

    {{-- Contenedor React --}}
    {{-- He añadido una min-height para que no salte el layout al cargar React --}}
    <div id="myorders-root"
         class="min-h-[400px]"
         data-auth="{{ Auth::check() ? 'true' : 'false' }}"
         data-email="{{ Auth::user()->email ?? '' }}">
         {{-- Loader opcional mientras carga React --}}
         <div class="flex justify-center items-center h-64">
             <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-[#D9C8A1]"></div>
         </div>
    </div>
</div>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endpush