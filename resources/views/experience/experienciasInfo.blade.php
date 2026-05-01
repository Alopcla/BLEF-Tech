@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush


@section('content')
<div class="h-24 lg:h-32"></div>

<main class="max-w-6xl mx-auto px-4 lg:px-6 mb-10 lg:mb-20">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch">
        
        {{-- COLUMNA IMAGEN --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4 lg:gap-6">
            <div class="relative h-[300px] lg:h-auto lg:flex-grow">
                <img src="{{ $experiencias->image }}"
                     class="absolute inset-0 w-full h-full object-cover rounded-[2rem] shadow-2xl"
                     alt="{{ $experiencias->name }}">

                <div class="absolute bottom-6 left-6 bg-black/60 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10">
                    <span class="text-[#D9C8A1] font-bold text-2xl">
                        {{ $experiencias->price }}€
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 h-24">
                @php $badges = [
                    ['icon' => 'clock', 'label' => $experiencias->duration_min . ' min', 'color' => 'text-white'],
                    ['icon' => 'users', 'label' => $experiencias->capacity . ' plazas', 'color' => 'text-white'],
                    ['icon' => 'ticket', 'label' => $experiencias->available_spots . ' libres', 'color' => $experiencias->available_spots < 3 ? 'text-orange-400' : 'text-white']
                ]; @endphp
                
                @foreach($badges as $badge)
                    <div class="bg-[#1A2E1A] rounded-[1.5rem] border border-white/5 flex flex-col lg:flex-row items-center justify-center gap-2 p-1">
                        <i class="fa-solid fa-{{ $badge['icon'] }} text-[#D9C8A1]"></i>
                        <span class="{{ $badge['color'] }} font-bold text-[10px] lg:text-base text-center">
                            {{ $badge['label'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- COLUMNA INFO --}}
        <div class="w-full lg:w-1/2 bg-[#1A2E1A] rounded-[2rem] p-6 lg:p-10 border border-white/10 flex flex-col shadow-2xl">
            <div class="mb-auto">
                <div class="inline-block px-3 py-1 rounded-full bg-[#D9C8A1]/10 text-[#D9C8A1] text-[11px] font-black uppercase mb-6 tracking-widest border border-[#D9C8A1]/20">
                    Experiencia Destacada
                </div>

                <h1 class="text-4xl lg:text-5xl font-black text-white mb-6 leading-tight font-parkzoo fuenteZoo">
                    {{ $experiencias->name }}
                </h1>

                <p class="text-[#D9C8A1] text-lg italic opacity-90 mb-8 font-parkzoo fuenteZoo">
                    "{{ $experiencias->description }}"
                </p>

                <p class="text-gray-300 text-sm lg:text-lg leading-relaxed">
                    {{ $experiencias->details }}
                </p>
            </div>

            {{-- BLOQUE REACT --}}
            <div class="mt-12 pt-8 border-t border-white/5">
                <div id="reserva-root"
                     data-auth="{{ auth()->check() ? 'true' : 'false' }}"
                     data-email="{{ auth()->user()->email ?? '' }}"
                     data-exp-id="{{ $experiencias->id }}"
                     data-exp-name="{{ $experiencias->name }}"
                     data-available="{{ $experiencias->available_spots }}">
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endpush