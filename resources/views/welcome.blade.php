@extends('layouts.app')

@section('title', 'Inicio')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
@endpush

@section('content')

    {{-- Barra de temperatura --}}
    <div class="barra-tiempo" id="temperatura"></div>

    <div class="relative z-10 max-w-5xl mx-auto px-6 sm:px-8 mt-12 mb-16">
        <div class="bg-emerald-900/90 backdrop-blur-md rounded-2xl p-6 shadow-xl border border-emerald-500/30 flex flex-col md:flex-row justify-around items-center gap-6">
            <div class="text-center">
                <h4 style="font-family: 'Bebas Neue', sans-serif;" class="text-5xl text-amber-300">350+</h4>
                <p style="font-family: 'Outfit', sans-serif;" class="text-emerald-100 font-bold uppercase text-xs mt-1">Especies Rescatadas</p>
            </div>
            <div class="hidden md:block w-px h-10 bg-emerald-700/50"></div>
            <div class="text-center">
                <h4 style="font-family: 'Bebas Neue', sans-serif;" class="text-5xl text-amber-300">50 ha</h4>
                <p style="font-family: 'Outfit', sans-serif;" class="text-emerald-100 font-bold uppercase text-xs mt-1">Reserva Natural</p>
            </div>
            <div class="hidden md:block w-px h-10 bg-emerald-700/50"></div>
            <div class="text-center">
                <h4 style="font-family: 'Bebas Neue', sans-serif;" class="text-5xl text-amber-300">100%</h4>
                <p style="font-family: 'Outfit', sans-serif;" class="text-emerald-100 font-bold uppercase text-xs mt-1">Bienestar Animal</p>
            </div>
        </div>
    </div>

    <section class="py-16 bg-black/40 backdrop-blur-sm relative">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="flex flex-col lg:flex-row gap-12 items-center">

                <div class="lg:w-1/2">
                    <h2 style="font-family: 'Outfit', sans-serif;" class="text-sm font-black text-amber-400 uppercase mb-2">Proyecto Blef-Tech</h2>
                    <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-6xl text-white leading-none mb-4 tracking-wide">
                        PROTEGEMOS <span class="text-emerald-400">LO SALVAJE.</span>
                    </h3>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-base text-stone-300 mb-6 font-light">
                        No somos una exhibición; somos un centro de rescate y conservación. Frenamos la extinción masiva con hábitats de vanguardia y atención veterinaria 24/7.
                    </p>
                    <a href="#historia" style="font-family: 'Outfit', sans-serif;" class="inline-flex items-center gap-2 font-bold text-amber-400 hover:text-white transition-colors">
                        Nuestra historia <i class="fa-solid fa-arrow-down border border-amber-400 rounded-full p-2 ml-2"></i>
                    </a>
                </div>

                <div class="lg:w-1/2 flex flex-col gap-4 w-full">
                    <div class="bg-white/5 border border-white/10 p-6 rounded-2xl">
                        <h4 style="font-family: 'Outfit', sans-serif;" class="text-lg font-bold text-emerald-400 mb-2"><i class="fa-solid fa-leaf mr-2"></i> Conservación</h4>
                        <p style="font-family: 'Outfit', sans-serif;" class="text-sm text-stone-400">El 20% de cada entrada va directo a reforestar hábitats y combatir la caza furtiva.</p>
                    </div>
                    <div class="bg-white/5 border border-white/10 p-6 rounded-2xl">
                        <h4 style="font-family: 'Outfit', sans-serif;" class="text-lg font-bold text-amber-400 mb-2"><i class="fa-solid fa-stethoscope mr-2"></i> Hospital Clínico</h4>
                        <p style="font-family: 'Outfit', sans-serif;" class="text-sm text-stone-400">Instalaciones médicas de última generación abiertas al público para visibilizar nuestro trabajo.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="historia" class="py-16 bg-stone-950/80 backdrop-blur-md border-t border-white/5">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-5xl text-white mb-10 tracking-wide">De un sueño a refugio global</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="p-6 bg-white/5 rounded-2xl border border-white/10">
                    <span style="font-family: 'Bebas Neue', sans-serif;" class="text-emerald-400 text-3xl">2010</span>
                    <h4 style="font-family: 'Outfit', sans-serif;" class="font-bold text-white mt-2 mb-2">El Inicio</h4>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-stone-400 text-sm">Nacimos como un pequeño centro de recuperación para aves de nuestro entorno local.</p>
                </div>
                <div class="p-6 bg-white/5 rounded-2xl border border-white/10">
                    <span style="font-family: 'Bebas Neue', sans-serif;" class="text-emerald-400 text-3xl">2016</span>
                    <h4 style="font-family: 'Outfit', sans-serif;" class="font-bold text-white mt-2 mb-2">La Gran Reserva</h4>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-stone-400 text-sm">Rescatamos a los primeros felinos de circos ilegales, abriendo la zona de la Sabana.</p>
                </div>
                <div class="p-6 bg-emerald-900/30 rounded-2xl border border-emerald-500/30">
                    <span style="font-family: 'Bebas Neue', sans-serif;" class="text-amber-400 text-3xl">HOY</span>
                    <h4 style="font-family: 'Outfit', sans-serif;" class="font-bold text-white mt-2 mb-2">Ecosistema</h4>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-emerald-100/70 text-sm">4 biomas inmersivos y referencia internacional en bienestar animal.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-black/40 backdrop-blur-sm border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <h2 style="font-family: 'Bebas Neue', sans-serif;" class="text-5xl text-center text-white mb-10 tracking-wide">EXPLORA NUESTROS ECOSISTEMAS</h2>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="/animales" class="group relative h-48 rounded-2xl overflow-hidden border border-white/10">
                    <img src="/img/sabana.jpg" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-white text-2xl tracking-wide">La Sabana</h3>
                    </div>
                </a>
                <a href="/animales" class="group relative h-48 rounded-2xl overflow-hidden border border-white/10">
                    <img src="/img/selva.jpg" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-white text-2xl tracking-wide">Selva Tropical</h3>
                    </div>
                </a>
                <a href="/animales" class="group relative h-48 rounded-2xl overflow-hidden border border-white/10">
                    <img src="/img/acuario.jpg" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-white text-2xl tracking-wide">Océanos</h3>
                    </div>
                </a>
                <a href="/animales" class="group relative h-48 rounded-2xl overflow-hidden border border-white/10">
                    <img src="/img/aviario.jpg" class="w-full h-full object-cover opacity-60 group-hover:opacity-100 group-hover:scale-105 transition-all" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end p-4">
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-white text-2xl tracking-wide">El Aviario</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 bg-emerald-950/80 backdrop-blur-md border-t border-emerald-800/50">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 style="font-family: 'Bebas Neue', sans-serif;" class="text-5xl text-white mb-4 tracking-wide">VIVE LA EXPERIENCIA</h2>
            <p style="font-family: 'Outfit', sans-serif;" class="text-emerald-100/90 text-base mb-8">Da de comer a las jirafas o disfruta de una ruta VIP. Plazas limitadas.</p>
            <a href="/experiencias" style="font-family: 'Outfit', sans-serif;" class="bg-amber-400 hover:bg-amber-300 text-emerald-950 px-8 py-3 rounded-full font-bold transition-transform hover:scale-105 inline-block">
                <i class="fa-solid fa-ticket mr-2"></i> RESERVAR AHORA
            </a>
        </div>
    </section>

@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
    <script src="{{ asset('js/main.js') }}" defer></script>
@endpush
