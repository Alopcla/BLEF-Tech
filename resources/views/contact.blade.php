@extends('layouts.app')

@section('title', 'Contacto | Blef-Tech')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
@endpush

@section('content')

{{-- ESCUDO ANTI-MENÚ --}}
<div class="h-32 md:h-40 w-full shrink-0"></div>

<div class="px-4 sm:px-6 max-w-7xl mx-auto pb-24 space-y-16">

    {{-- TÍTULO DE LA SECCIÓN --}}
    <div class="text-center">
        <h1 style="font-family: 'Bebas Neue', sans-serif;" class="text-6xl md:text-8xl text-white tracking-wide leading-none">
            Ponte en <span class="text-emerald-400">Contacto</span>
        </h1>
        <p style="font-family: 'Outfit', sans-serif;" class="text-white/60 font-light mt-6 text-lg max-w-2xl mx-auto">
            Estamos aquí para resolver tus dudas sobre conservación, visitas y programas educativos. Elige el canal que prefieras.
        </p>
    </div>

    {{-- GRID DE TARJETAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Tarjeta 1: Visítanos --}}
        <div class="group relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 transition-all duration-500 hover:border-emerald-500/50 hover:-translate-y-2 shadow-2xl">
            <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-[2.5rem]"></div>

            <div class="w-16 h-16 bg-emerald-400/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-solid fa-location-dot text-3xl text-emerald-400"></i>
            </div>

            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-amber-400 tracking-wider mb-3">Visítanos</h3>
            <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light leading-relaxed mb-6">
                Autovía de la Naturaleza, Km 45.<br>
                Sevilla, España.
            </p>
            <a href="#" class="text-emerald-400 text-sm font-medium hover:underline inline-flex items-center gap-2">
                Ver en Google Maps <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        {{-- Tarjeta 2: Llámanos --}}
        <div class="group relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 transition-all duration-500 hover:border-emerald-500/50 hover:-translate-y-2 shadow-2xl">
            <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-[2.5rem]"></div>

            <div class="w-16 h-16 bg-emerald-400/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-solid fa-phone text-3xl text-emerald-400"></i>
            </div>

            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-amber-400 tracking-wider mb-3">Llámanos</h3>
            <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light leading-relaxed">
                Atención al visitante:<br>
                <span class="text-white font-bold text-xl">900 123 456</span>
            </p>
        </div>

        {{-- Tarjeta 3: WhatsApp --}}
        <div class="group relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 transition-all duration-500 hover:border-emerald-500/50 hover:-translate-y-2 shadow-2xl">
            <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-[2.5rem]"></div>

            <div class="w-16 h-16 bg-emerald-400/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-brands fa-whatsapp text-3xl text-emerald-400"></i>
            </div>

            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-amber-400 tracking-wider mb-3">WhatsApp</h3>
            <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light leading-relaxed mb-6">
                Resolución rápida:<br>
                <span class="text-white font-bold text-xl">+34 666 666 666</span>
            </p>
            <span class="px-3 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] uppercase tracking-widest rounded-full border border-emerald-500/30">Online</span>
        </div>

        {{-- Tarjeta 4: Email --}}
        <div class="group relative bg-black/40 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 transition-all duration-500 hover:border-emerald-500/50 hover:-translate-y-2 shadow-2xl">
            <div class="absolute inset-0 bg-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity rounded-[2.5rem]"></div>

            <div class="w-16 h-16 bg-emerald-400/10 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-500">
                <i class="fa-solid fa-envelope text-3xl text-emerald-400"></i>
            </div>

            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-amber-400 tracking-wider mb-3">Escríbenos</h3>
            <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light leading-relaxed">
                Consultas generales:<br>
                <span class="text-white font-bold text-lg">info@blr-zoo.com</span>
            </p>
        </div>

    </div>

    {{-- BLOQUE INFERIOR MEJORADO --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-black/40 to-emerald-900/10 backdrop-blur-md border border-white/10 rounded-[2.5rem] p-10 md:p-16 shadow-2xl text-center">
        {{-- Adorno visual de fondo --}}
        <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>

        <div class="relative z-10">
            <h2 style="font-family: 'Bebas Neue', sans-serif;" class="text-4xl md:text-5xl text-emerald-400 mb-4 tracking-wide">Compromiso de Respuesta</h2>
            <div class="w-20 h-1 bg-emerald-500 mx-auto mb-8 rounded-full"></div>
            <p style="font-family: 'Outfit', sans-serif;" class="max-w-2xl mx-auto text-white/80 font-light text-lg leading-relaxed italic">
                "Nuestro equipo de expertos en biodiversidad está disponible para atenderte. Garantizamos una respuesta humana y detallada en menos de 24 horas."
            </p>
        </div>
    </div>

</div>
@endsection

@push('scripts')
@viteReactRefresh
@vite(['resources/js/app.jsx'])
@endpush