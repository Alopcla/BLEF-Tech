@extends('layouts.app')

@section('content')
{{-- Espaciado adaptativo: menos en móvil, más en escritorio --}}
<div class="h-24 lg:h-32"></div>

<main class="max-w-6xl mx-auto px-4 lg:px-6 mb-10 lg:mb-20">
    {{-- Cambiamos a flex-col por defecto y lg:flex-row para escritorio --}}
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch">
        
        {{-- COLUMNA IMAGEN: En móvil tiene una altura fija para no ocupar toda la pantalla --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4 lg:gap-6">
            <div class="relative h-[300px] lg:h-auto lg:flex-grow">
                <img src="{{ $experiencias->image }}" 
                     class="absolute inset-0 w-full h-full object-cover rounded-[1.5rem] lg:rounded-[2rem] shadow-2xl border border-white/10" 
                     alt="{{ $experiencias->name }}">
                
                <div class="absolute bottom-4 left-4 lg:bottom-6 lg:left-6 bg-black/60 backdrop-blur-md px-4 py-2 rounded-xl lg:rounded-2xl border border-white/10">
                    <span class="text-[#D9C8A1] font-bold text-xl lg:text-2xl">{{ $experiencias->price }}€</span>
                </div>
            </div>

            {{-- Stats: En móvil se ven más compactos --}}
            <div class="grid grid-cols-2 gap-3 lg:gap-4 h-20 lg:h-24">
                <div class="bg-[#1A2E1A] rounded-[1.2rem] lg:rounded-[1.5rem] border border-white/5 flex items-center justify-center gap-2 lg:gap-3">
                    <i class="fa-solid fa-clock text-[#D9C8A1] text-sm lg:text-base"></i>
                    <span class="text-white font-bold text-sm lg:text-base">{{ $experiencias->duration_min }} min</span>
                </div>
                <div class="bg-[#1A2E1A] rounded-[1.2rem] lg:rounded-[1.5rem] border border-white/5 flex items-center justify-center gap-2 lg:gap-3">
                    <i class="fa-solid fa-users text-[#D9C8A1] text-sm lg:text-base"></i>
                    <span class="text-white font-bold text-sm lg:text-base">{{ $experiencias->ability }} plazas</span>
                </div>
            </div>
        </div>

        {{-- COLUMNA INFO: Ajustamos paddings y tamaños de texto --}}
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

            {{-- Bloque de Reserva: En móvil el botón suele ir mejor a ancho completo --}}
            <div class="mt-8 lg:mt-12 pt-6 lg:pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex flex-col items-center sm:items-start">
                    <p class="text-white/40 text-[10px] lg:text-[11px] uppercase font-black tracking-widest">Pago Seguro</p>
                    <div class="flex gap-3 mt-2 opacity-40 text-lg lg:text-xl text-white">
                        <i class="fa-brands fa-cc-visa"></i>
                        <i class="fa-brands fa-cc-mastercard"></i>
                        <i class="fa-brands fa-cc-apple-pay"></i>
                    </div>
                </div>

                <button class="w-full sm:w-auto bg-[#D9C8A1] text-[#1A2E1A] px-8 lg:px-10 py-4 lg:py-5 rounded-xl lg:rounded-2xl font-black uppercase text-xs lg:text-sm hover:scale-105 active:scale-95 transition-all shadow-lg">
                    Reservar Ticket
                </button>
            </div>
        </div>

    </div>
</main>
@endsection