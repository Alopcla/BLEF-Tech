@extends('layouts.app')

@section('content')
{{-- Espaciado adaptativo --}}
<div class="h-24 lg:h-32"></div>

<main class="max-w-6xl mx-auto px-4 lg:px-6 mb-10 lg:mb-20">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch">
        
        {{-- COLUMNA IMAGEN --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4 lg:gap-6">
            <div class="relative h-[300px] lg:h-auto lg:flex-grow">
                <img src="{{ $experiencias->image }}" 
                     class="absolute inset-0 w-full h-full object-cover rounded-[1.5rem] lg:rounded-[2rem] shadow-2xl border border-white/10" 
                     alt="{{ $experiencias->name }}">
                
                <div class="absolute bottom-4 left-4 lg:bottom-6 lg:left-6 bg-black/60 backdrop-blur-md px-4 py-2 rounded-xl lg:rounded-2xl border border-white/10">
                    <span class="text-[#D9C8A1] font-bold text-xl lg:text-2xl">{{ $experiencias->price }}€</span>
                </div>
            </div>

            {{-- Stats: 3 Columnas --}}
            <div class="grid grid-cols-3 gap-2 lg:gap-4 h-20 lg:h-24">
                <div class="bg-[#1A2E1A] rounded-[1.2rem] lg:rounded-[1.5rem] border border-white/5 flex flex-col lg:flex-row items-center justify-center gap-1 lg:gap-3 p-1">
                    <i class="fa-solid fa-clock text-[#D9C8A1] text-xs lg:text-base"></i>
                    <span class="text-white font-bold text-[10px] md:text-sm lg:text-base text-center">{{ $experiencias->duration_min }} min</span>
                </div>

                <div class="bg-[#1A2E1A] rounded-[1.2rem] lg:rounded-[1.5rem] border border-white/5 flex flex-col lg:flex-row items-center justify-center gap-1 lg:gap-3 p-1">
                    <i class="fa-solid fa-users text-[#D9C8A1] text-xs lg:text-base"></i>
                    <span class="text-white font-bold text-[10px] md:text-sm lg:text-base text-center">{{ $experiencias->capacity }} plazas</span>
                </div>

                {{-- Columna 3: Espacios Libres Reales --}}
                <div class="bg-[#1A2E1A] rounded-[1.2rem] lg:rounded-[1.5rem] border border-white/5 flex flex-col lg:flex-row items-center justify-center gap-1 lg:gap-3 p-1">
                    <i class="fa-solid fa-ticket text-[#D9C8A1] text-xs lg:text-base"></i>
                    <span class="{{ $experiencias->available_spots < 3 ? 'text-orange-400' : 'text-white' }} font-bold text-[10px] md:text-sm lg:text-base text-center">
                        {{ $experiencias->available_spots }} libres
                    </span>
                </div>
            </div>
        </div>

        {{-- COLUMNA INFO --}}
        <div class="w-full lg:w-1/2 bg-[#1A2E1A] rounded-[1.5rem] lg:rounded-[2rem] p-6 lg:p-10 border border-white/10 flex flex-col shadow-2xl">
            
            <div class="mb-auto">
                <div class="inline-block px-3 py-1 rounded-full bg-[#D9C8A1]/10 text-[#D9C8A1] text-[9px] lg:text-[11px] font-black uppercase mb-4 lg:mb-8 border border-[#D9C8A1]/20 tracking-widest">
                    Experiencia Destacada
                </div>

                <h1 class="text-3xl lg:text-5xl font-black text-white mb-4 lg:mb-6 tracking-tighter leading-tight">
                    {{ $experiencias->name }}
                </h1>

                <p class="text-[#D9C8A1] text-base lg:text-lg font-medium leading-relaxed mb-6 lg:mb-8 italic opacity-90">
                    "{{ $experiencias->description }}"
                </p>

                <div class="space-y-4 text-gray-300 text-sm lg:text-lg leading-relaxed">
                    <p>{{ $experiencias->details }}</p>
                </div>
            </div>

            {{-- Bloque de Reserva --}}
            <div class="mt-8 lg:mt-12 pt-6 lg:pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-6">
                
                <div class="flex flex-col items-center sm:items-start order-2 sm:order-1">
                    <p class="text-white/40 text-[10px] lg:text-[11px] uppercase font-black tracking-[3px] mb-2">Transacción Segura</p>
                    <div class="flex gap-4 opacity-50 text-xl lg:text-2xl text-white">
                        <i class="fa-brands fa-cc-visa"></i>
                        <i class="fa-brands fa-cc-mastercard"></i>
                    </div>
                </div>

                @if($experiencias->available_spots > 0)
                    <form action="{{ route('payment.process') }}" method="POST" class="w-full sm:w-auto order-1 sm:order-2">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $experiencias->price }}">
                        <input type="hidden" name="concepto" value="Reserva: {{ $experiencias->name }}">
                        <input type="hidden" name="tipo" value="experiencia">
                        <input type="hidden" name="meta[experiencia_id]" value="{{ $experiencias->id }}">
                        <input type="hidden" name="meta[nombre]" value="{{ $experiencias->name }}">
                        <input type="hidden" name="meta[fecha]" value="{{ now()->format('Y-m-d') }}">

                        {{-- SOLO si NO está logeado --}}
                        @guest
                            <div class="relative w-full mb-4 group/input">
                                {{-- Icono flotante --}}
                                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#D9C8A1]/50 group-focus-within/input:text-[#D9C8A1] transition-colors">
                                    <i class="fa-solid fa-envelope text-xs"></i>
                                </div>

                                <input type="email" 
                                    name="email" 
                                    placeholder="Introduce tu email"
                                    required
                                    class="w-full pl-11 pr-4 py-4 rounded-2xl bg-white/5 border border-white/10 text-white text-sm placeholder:text-white/20 focus:outline-none focus:ring-2 focus:ring-[#D9C8A1]/30 focus:border-[#D9C8A1]/50 transition-all backdrop-blur-md shadow-inner"
                                >
                                
                                {{-- Etiqueta flotante pequeña --}}
                                <span class="absolute -top-2 left-4 bg-[#1A2E1A] px-2 text-[10px] text-[#D9C8A1] font-black uppercase tracking-widest border border-white/5 rounded-md">
                                    Email del cliente
                                </span>
                            </div>
                        @endguest

                        <button type="submit" class="group relative w-full sm:w-auto flex items-center justify-center gap-3 bg-gradient-to-r from-[#F2C94C] via-[#D9C8A1] to-[#F2994A] text-[#1A2E1A] px-10 py-5 rounded-2xl font-black uppercase text-xs tracking-[2px] shadow-[0_10px_30px_rgba(242,201,76,0.3)] hover:shadow-[0_15px_40px_rgba(242,201,76,0.5)] hover:-translate-y-1 active:scale-95 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 w-full h-full bg-white/30 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 skew-x-12"></div>
                            <span class="relative z-10">Confirmar Reserva</span>
                            <i class="fa-solid fa-arrow-right relative z-10 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                @else
                    <div class="w-full sm:w-auto order-1 sm:order-2">
                        <button disabled class="w-full sm:w-auto flex items-center justify-center gap-3 bg-white/5 text-white/20 border border-white/5 px-10 py-5 rounded-2xl font-black uppercase text-xs tracking-[2px] cursor-not-allowed">
                            <i class="fa-solid fa-ban"></i>
                            <span>Sold Out</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection