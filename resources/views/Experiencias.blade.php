@extends('layouts.app')

@section('title', 'Experiencias')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

@section('content')

    {{-- Hero: Más limpio y con colores coherentes --}}
    <section class="text-center mt-32 px-6">
        <span class="text-[#D9C8A1] uppercase tracking-[4px] text-xs font-bold">Descubre lo inolvidable</span>
        <h1 class="text-4xl md:text-5xl font-parkzoo font-bold mt-2 text-white fuenteZoo">Experiencias <span class="text-[#D9C8A1]">Park Zoo</span></h1>
        <div class="w-16 h-[2px] bg-[#D9C8A1] mx-auto mt-4"></div>
        <p class="text-gray-400 max-w-xl mx-auto mt-6 italic">
            Vive momentos únicos y conecta con la esencia de la vida silvestre.
        </p>
    </section>

    {{-- Grid de experiencias --}}
<section class="max-w-7xl mx-auto mt-16 grid md:grid-cols-2 lg:grid-cols-3 gap-10 px-6 mb-20">
    @foreach($experiencias as $exp)
    <div class="group relative bg-[#1A2E1A]/40 backdrop-blur-md rounded-[2rem] border border-white/5 p-3 pb-6 transition-all duration-500 hover:bg-[#1A2E1A]/80 hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)] hover:-translate-y-2">
        
        @if($loop->first)
            <div class="absolute -top-3 -right-3 z-20 bg-gradient-to-r from-orange-500 to-yellow-500 text-white text-[10px] font-black px-4 py-1.5 rounded-full shadow-xl rotate-12 uppercase tracking-tighter">
                Popular 🔥
            </div>
        @endif

        {{-- Contenedor de Imagen con forma orgánica --}}
        <div class="relative h-64 w-full overflow-hidden rounded-[1.5rem] mb-6">
            <img src="{{ $exp->image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110 group-hover:rotate-1" alt="{{ $exp->name }}">
            
            <div class="absolute inset-0 bg-gradient-to-t from-[#1A2E1A] via-transparent to-transparent opacity-80"></div>

            <div class="absolute top-4 left-4 backdrop-blur-md bg-white/10 border border-white/20 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl uppercase tracking-widest">
                {{ $exp->type ?? 'Safari' }}
            </div>

            <div class="absolute bottom-4 right-4 bg-[#D9C8A1] text-[#1A2E1A] px-4 py-1 rounded-lg font-black text-lg shadow-2xl">
                {{ $exp->price }}€
            </div>
        </div>

        {{-- Texto y Detalles --}}
        <div class="px-4">
            <div class="flex items-center gap-2 mb-2">
                <div class="w-2 h-2 rounded-full bg-[#D9C8A1] animate-pulse"></div>
                <h3 class="text-2xl font-parkzoo font-bold text-white leading-tight fuenteZoo">{{ $exp->name }}</h3>
            </div>
            
            <p class="text-gray-400 text-sm line-clamp-2 mb-6 font-medium leading-relaxed">
                {{ $exp->description }}
            </p>

            {{-- Info Bar con Iconos Refinados --}}
            <div class="flex justify-between items-center py-4 border-t border-white/10 mb-6">
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase text-[#D9C8A1]/50 tracking-tighter">Duración</span>
                    <span class="text-white text-xs font-bold flex items-center gap-1">
                        <i class="fa-regular fa-clock text-[#D9C8A1]"></i> {{ $exp->duration }}min
                    </span>
                </div>
                <div class="h-8 w-[1px] bg-white/10"></div>
                <div class="flex flex-col items-end">
                    <span class="text-[10px] uppercase text-[#D9C8A1]/50 tracking-tighter">Grupo</span>
                    <span class="text-white text-xs font-bold flex items-center gap-1">
                        {{ $exp->ability }} pers. <i class="fa-solid fa-paw text-[#D9C8A1]"></i>
                    </span>
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex gap-3">
                <button class="flex-[3] bg-[#D9C8A1] text-[#1A2E1A] py-4 rounded-2xl font-black text-xs uppercase tracking-[2px] shadow-[0_10px_20px_rgba(217,200,161,0.2)] hover:bg-white hover:shadow-[#D9C8A1]/40 transition-all duration-300">
                    Reservar Ahora
                </button>
                <a href="{{ route('experienciasInfo', $exp->slug) }}" class="flex-1 border border-[#D9C8A1]/30 rounded-2xl flex items-center justify-center text-[#D9C8A1] hover:bg-[#D9C8A1]/10 transition-colors">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    @endforeach
</section>

@endsection
