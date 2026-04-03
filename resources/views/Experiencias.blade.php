@extends('layouts.app')

@section('title', 'Experiencias')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endpush

@section('content')

    {{-- Hero --}}
    <section class="text-center mt-32 px-6">
        <span class="text-[#D9C8A1] uppercase tracking-[4px] text-xs font-bold">Descubre lo inolvidable</span>
        <h1 class="text-4xl md:text-5xl font-parkzoo font-bold mt-2 text-white fuenteZoo">Experiencias <span class="text-[#D9C8A1]">Park Zoo</span></h1>
        <div class="w-16 h-[2px] bg-[#D9C8A1] mx-auto mt-4"></div>
        <p class="text-gray-400 max-w-xl mx-auto mt-6 italic">
            Vive momentos únicos y conecta con la esencia de la vida silvestre.
        </p>
    </section>

    <main class="max-w-7xl mx-auto mt-16 px-6 mb-20">
        
        {{-- 1. LA POPULAR (Formato Ancho con Stats de 3 Columnas) --}}
        @php $popular = $experiencias->first(); @endphp
        @if($popular)
            <div class="mb-16">
                <div class="group relative bg-[#1A2E1A]/40 backdrop-blur-md rounded-[2rem] border border-white/5 p-3 md:p-4 transition-all duration-500 hover:bg-[#1A2E1A]/80 hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                    
                    <div class="absolute -top-3 -right-3 z-20 bg-gradient-to-r from-orange-500 to-yellow-500 text-white text-[10px] font-black px-4 py-1.5 rounded-full shadow-xl rotate-12 uppercase tracking-tighter">
                        Popular 🔥
                    </div>

                    <div class="flex flex-col md:flex-row gap-6 md:gap-10">
                        {{-- Imagen --}}
                        <div class="relative h-72 md:h-[400px] md:w-2/5 overflow-hidden rounded-[1.5rem] shrink-0">
                            <img src="{{ $popular->image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $popular->name }}">
                            <div class="absolute top-4 left-4 backdrop-blur-md bg-white/10 border border-white/20 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl uppercase tracking-widest">
                                {{ $popular->type ?? 'Safari' }}
                            </div>
                        </div>

                        {{-- Contenido --}}
                        <div class="flex-grow flex flex-col justify-center px-4 py-2 md:py-6 md:pr-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-[#D9C8A1] animate-pulse"></div>
                                    <h3 class="text-3xl md:text-5xl font-parkzoo font-bold text-white leading-tight fuenteZoo">{{ $popular->name }}</h3>
                                </div>
                                <div class="bg-[#D9C8A1] text-[#1A2E1A] px-5 py-2 rounded-xl font-black text-xl shadow-2xl shrink-0">
                                    {{ $popular->price }}€
                                </div>
                            </div>

                            <p class="text-gray-400 text-base md:text-lg mb-8 font-medium italic">"{{ $popular->description }}"</p>

                            {{-- STATS POPULAR (Igual que el de abajo) --}}
                            <div class="grid grid-cols-3 gap-4 py-6 border-y border-white/10 mb-8">
                                <div class="text-center border-r border-white/5">
                                    <span class="block text-[10px] uppercase text-white/30 font-bold tracking-widest mb-1">Tiempo</span>
                                    <span class="text-white text-sm md:text-base font-bold">{{ $popular->duration_min }}'</span>
                                </div>
                                
                                <div class="text-center border-r border-white/5">
                                    <span class="block text-[10px] uppercase text-white/30 font-bold tracking-widest mb-1">Disponibles</span>
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $popular->available_spots < 3 ? 'bg-orange-400' : 'bg-green-400' }} opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 {{ $popular->available_spots < 3 ? 'bg-orange-500' : 'bg-green-500' }}"></span>
                                        </span>
                                        <span class="{{ $popular->available_spots < 3 ? 'text-orange-400' : 'text-[#D9C8A1]' }} text-sm md:text-base font-black">{{ $popular->available_spots }}</span>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <span class="block text-[10px] uppercase text-white/30 font-bold tracking-widest mb-1">Capacidad</span>
                                    <span class="text-white text-sm md:text-base font-bold">{{ $popular->capacity }} <i class="fa-solid fa-users text-[#D9C8A1] ml-1"></i></span>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <form action="{{ route('payment.process') }}" method="POST" class="flex-[4]">
                                    @csrf
                                    <input type="hidden" name="amount" value="{{ $popular->price }}">
                                    <input type="hidden" name="concepto" value="Reserva: {{ $popular->name }}">
                                    <input type="hidden" name="tipo" value="experiencia">
                                    <input type="hidden" name="meta[experiencia_id]" value="{{ $popular->id }}">
                                    <input type="hidden" name="meta[nombre]" value="{{ $popular->name }}">
                                    <input type="hidden" name="meta[fecha]" value="{{ now()->format('Y-m-d') }}">
                                    <button type="submit" class="w-full bg-[#D9C8A1] text-[#1A2E1A] py-5 rounded-2xl font-black text-sm uppercase tracking-[2px] shadow-xl hover:bg-white transition-all">
                                        Reservar Ahora
                                    </button>
                                </form>
                                <a href="{{ route('experienciasInfo', $popular->slug) }}" class="flex-1 border border-[#D9C8A1]/30 rounded-2xl flex items-center justify-center text-[#D9C8A1] hover:bg-[#D9C8A1]/10 transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- 2. GRID PARA EL RESTO --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($experiencias->skip(1) as $exp)
            <div class="group relative bg-[#1A2E1A]/40 backdrop-blur-md rounded-[2rem] border border-white/5 p-3 pb-6 transition-all duration-500 hover:bg-[#1A2E1A]/80 hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)] hover:-translate-y-2">
                
                @if($exp->available_spots <= 0)
                    <div class="absolute -top-3 -right-3 z-20 bg-red-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full shadow-xl rotate-12 uppercase tracking-tighter">Sold Out</div>
                @endif

                <div class="relative h-64 w-full overflow-hidden rounded-[1.5rem] mb-6">
                    <img src="{{ $exp->image }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt="{{ $exp->name }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#1A2E1A] via-transparent to-transparent opacity-80"></div>
                    <div class="absolute top-4 left-4 backdrop-blur-md bg-white/10 border border-white/20 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl uppercase tracking-widest">{{ $exp->type ?? 'Safari' }}</div>
                    <div class="absolute bottom-4 right-4 bg-[#D9C8A1] text-[#1A2E1A] px-4 py-1 rounded-lg font-black text-lg shadow-2xl">{{ $exp->price }}€</div>
                </div>

                <div class="px-4">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 rounded-full bg-[#D9C8A1] animate-pulse"></div>
                        <h3 class="text-2xl font-parkzoo font-bold text-white leading-tight fuenteZoo">{{ $exp->name }}</h3>
                    </div>
                    <p class="text-gray-400 text-sm line-clamp-2 mb-6 font-medium leading-relaxed">{{ $exp->description }}</p>

                    {{-- STATS GRID --}}
                    <div class="grid grid-cols-3 gap-2 py-4 border-t border-white/10 mb-6">
                        <div class="text-center border-r border-white/5">
                            <span class="block text-[8px] uppercase text-white/30 font-bold mb-1">Tiempo</span>
                            <span class="text-white text-[11px] font-bold">{{ $exp->duration_min }}'</span>
                        </div>
                        
                        <div class="text-center border-r border-white/5">
                            <span class="block text-[8px] uppercase text-white/30 font-bold mb-1">Libres</span>
                            <div class="flex items-center justify-center gap-1.5">
                                <span class="relative flex h-1.5 w-1.5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $exp->available_spots < 3 ? 'bg-orange-400' : 'bg-green-400' }} opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-1.5 w-1.5 {{ $exp->available_spots < 3 ? 'bg-orange-500' : 'bg-green-500' }}"></span>
                                </span>
                                <span class="{{ $exp->available_spots < 3 ? 'text-orange-400' : 'text-[#D9C8A1]' }} text-[11px] font-black">{{ $exp->available_spots }}</span>
                            </div>
                        </div>

                        <div class="text-center">
                            <span class="block text-[8px] uppercase text-white/30 font-bold mb-1">Máximo</span>
                            <span class="text-white text-[11px] font-bold">{{ $exp->capacity }} <i class="fa-solid fa-users text-[9px] text-[#D9C8A1]"></i></span>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        @if($exp->available_spots > 0)
                            <form action="{{ route('payment.process') }}" method="POST" class="flex-[3]">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $exp->price }}">
                                <input type="hidden" name="concepto" value="Reserva: {{ $exp->name }}">
                                <input type="hidden" name="tipo" value="experiencia">
                                <input type="hidden" name="meta[experiencia_id]" value="{{ $exp->id }}">
                                <input type="hidden" name="meta[nombre]" value="{{ $exp->name }}">
                                <input type="hidden" name="meta[fecha]" value="{{ now()->format('Y-m-d') }}">
                                <button type="submit" class="w-full bg-[#D9C8A1] text-[#1A2E1A] py-4 rounded-2xl font-black text-xs uppercase tracking-[1px] hover:bg-white transition-all">
                                    Reservar
                                </button>
                            </form>
                        @else
                            <button disabled class="flex-[3] bg-gray-500/20 text-gray-500 py-4 rounded-2xl font-black text-xs uppercase cursor-not-allowed">
                                Sold Out
                            </button>
                        @endif
                        
                        <a href="{{ route('experienciasInfo', $exp->slug) }}" class="flex-1 border border-[#D9C8A1]/30 rounded-2xl flex items-center justify-center text-[#D9C8A1] hover:bg-[#D9C8A1]/10 transition-all">
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>

@endsection