@extends('layouts.app')

@section('title', 'Contacto | Blef-Tech')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
{{-- Mantener las fuentes para que el estilo sea idéntico --}}
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
@endpush

@section('content')

{{-- ESCUDO ANTI-MENÚ --}}
<div class="h-32 md:h-40 w-full shrink-0"></div>

<div class="px-4 sm:px-6 max-w-7xl mx-auto pb-24 space-y-12">

    {{-- TÍTULO DE LA SECCIÓN --}}
    <div class="text-center mb-12">
        <h1 style="font-family: 'Bebas Neue', sans-serif;" class="text-6xl md:text-7xl text-white tracking-wide">
            Ponte en <span class="text-emerald-400">Contacto</span>
        </h1>
        <p style="font-family: 'Outfit', sans-serif;" class="text-white/60 font-light mt-4 text-lg">
            Estamos aquí para resolver tus dudas sobre conservación, visitas y programas educativos.
        </p>
    </div>

    {{-- TARJETAS DE CONTACTO --}}
    {{-- CONTENEDOR DE TARJETAS --}}
    <div class="flex flex-wrap justify-center gap-8">

        {{-- Tarjeta 1 --}}
        <div class="flex-1 min-w-[300px] max-w-[380px] bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 shadow-2xl hover:border-emerald-500/50 transition-colors">
            <i class="fa-solid fa-location-dot text-4xl text-emerald-400 mb-6"></i>
            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-amber-400 tracking-wider mb-3">Visítanos</h3>
            <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light leading-relaxed">
                Autovía de la Naturaleza, Km 45.<br>
                Sevilla, España.
            </p>
        </div>

        {{-- Tarjeta 2 --}}
        <div class="flex-1 min-w-[300px] max-w-[380px] bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 shadow-2xl hover:border-emerald-500/50 transition-colors">
            <i class="fa-solid fa-phone text-4xl text-emerald-400 mb-6"></i>
            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-amber-400 tracking-wider mb-3">Llámanos</h3>
            <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light leading-relaxed">
                Atención al visitante:<br>
                <span class="text-white font-bold">900 123 456</span>
            </p>
        </div>

        {{-- Tarjeta 3 --}}
        <div class="flex-1 min-w-[300px] max-w-[380px] bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 shadow-2xl hover:border-emerald-500/50 transition-colors">
            <i class="fa-brands fa-whatsapp text-4xl text-emerald-400 mb-6"></i>
            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-amber-400 tracking-wider mb-3">WhatsApp</h3>
            <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light leading-relaxed">
                Resolución rápida y personalizada:<br>
                <span class="text-white font-bold">+34 666 666 666</span>
            </p>
        </div>

        {{-- Tarjeta 4 (Esta bajará al centro automáticamente) --}}
        <div class="flex-1 min-w-[300px] max-w-[380px] bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 shadow-2xl hover:border-emerald-500/50 transition-colors">
            <i class="fa-solid fa-envelope text-4xl text-emerald-400 mb-6"></i>
            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-amber-400 tracking-wider mb-3">Escríbenos</h3>
            <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light leading-relaxed">
                Consultas generales:<br>
                <span class="text-white font-bold">info@blr-zoo.com</span>
            </p>
        </div>

    </div>

    {{-- BLOQUE INFERIOR (Opcional: Formulario o Mapa) --}}
    <div class="bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-12 shadow-2xl">
        <h2 style="font-family: 'Bebas Neue', sans-serif;" class="text-4xl text-emerald-400 mb-6 text-center">Horario de Atención Digital</h2>
        <p style="font-family: 'Outfit', sans-serif;" class="text-center text-white/70 font-light">
            Nuestro equipo de soporte responde en un plazo máximo de 24 horas hábiles.
            Para emergencias veterinarias, por favor acuda directamente al Edificio Principal.
        </p>
    </div>

</div>

@endsection

@push('scripts')
@viteReactRefresh
@vite(['resources/js/app.jsx'])
@endpush