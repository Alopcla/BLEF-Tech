@extends('layouts.app')

@php
    $tituloTipo = match($tipo) {
        'shop'        => 'compra',
        'experiencia' => 'experiencia',
        default       => 'entradas',
    };
@endphp

@section('title', 'Confirmación de ' . $tituloTipo)

@section('content')
{{-- Forzamos el fondo oscuro en toda la página --}}
<style>
    body, html {
        background-color: #0A120A !important;
        margin: 0;
        padding: 0;
    }
    
    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fade-in-up 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }
    .animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }

    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.02); }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #D9C8A1; border-radius: 10px; }

    /* PARCHE 1: Estilo para ocultar tickets extras sin romper el diseño */
    .ticket-extra { display: none !important; }
    .ticket-visible { display: flex !important; }
</style>

<div class="min-h-screen relative overflow-hidden flex items-center justify-center py-12 px-4">
    
    {{-- CAPA POSTERIOR: Brillos dinámicos --}}
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-green-900/20 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-[#D9C8A1]/10 blur-[120px] rounded-full"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-green-950/5 blur-[160px] rounded-full"></div>
    </div>

    <div class="max-w-3xl w-full relative z-10 animate-fade-in-up">
        
        {{-- Cabecera de Confirmación --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 bg-gradient-to-tr from-[#D9C8A1] to-[#F2994A] rounded-full mb-6 shadow-[0_0_50px_rgba(217,200,161,0.3)] animate-bounce-slow">
                <i class="fa-solid fa-check text-3xl md:text-4xl text-[#1A2E1A]"></i>
            </div>
            <h1 class="text-3xl md:text-5xl font-black text-white mb-3 tracking-tighter uppercase">
                ¡Pago Completado!
            </h1>
            <p class="text-[#D9C8A1] text-base md:text-lg font-medium opacity-80">
                Confirmación enviada a <span class="font-bold text-white border-b border-[#D9C8A1]/30">{{ $email }}</span>
            </p>
        </div>

        {{-- TARJETA PRINCIPAL (Glassmorphism) --}}
        <div class="bg-[#1A2E1A]/60 backdrop-blur-2xl border border-white/10 rounded-[2rem] md:rounded-[3rem] overflow-hidden shadow-2xl mb-8">
            
            @if($tipo === 'experiencia')
                {{-- VISTA EXPERIENCIA --}}
                <div class="flex flex-col md:flex-row items-stretch">
                    <div class="md:w-2/5 h-56 md:h-auto relative">
                        <img src="{{ $experiencia->image ?? 'https://images.unsplash.com/photo-1534567153574-2b12153a87f0?q=80&w=2070&auto=format&fit=crop' }}" 
                               class="absolute inset-0 w-full h-full object-cover" alt="Experiencia">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#1A2E1A] md:bg-gradient-to-r md:from-transparent md:to-[#1A2E1A]/90"></div>
                    </div>
                    <div class="p-8 md:p-10 md:w-3/5">
                        <div class="inline-block px-3 py-1 rounded-full bg-[#D9C8A1]/10 text-[#D9C8A1] text-[9px] font-black uppercase mb-4 border border-[#D9C8A1]/20 tracking-[2px]">
                            Reserva Confirmada
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-6 leading-tight">
                            {{ $meta['nombre'] ?? 'Tu Experiencia Park Zoo' }}
                        </h2>
                        
                        <div class="space-y-4 mb-8">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-[#D9C8A1]">
                                    <i class="fa-solid fa-calendar-day"></i>
                                </div>
                                <div>
                                    <p class="text-white/40 text-[10px] uppercase font-bold tracking-widest">Fecha de Visita</p>
                                    <p class="text-white font-semibold">
                                        @php
                                            // Intentamos obtener la fecha de 'fecha' (entrada) o de 'reservation_date' (base de datos)
                                            // Si ninguna existe, ponemos la fecha de hoy para que no explote
                                            $fechaFinal = $meta['fecha'] ?? ($reservation->reservation_date ?? now());
                                        @endphp
                                        {{ \Carbon\Carbon::parse($fechaFinal)->translatedFormat('d \d\e F, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-[#D9C8A1]">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <div>
                                    <p class="text-white/40 text-[10px] uppercase font-bold tracking-widest">Total de la Compra</p>
                                    <p class="text-2xl font-black text-[#D9C8A1]">{{ number_format($amount, 2) }}€</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm italic leading-relaxed border-l-2 border-[#D9C8A1]/30 pl-4">
                            "Prepárate para una jornada inolvidable. Presenta tu DNI al llegar."
                        </p>
                    </div>
                </div>

            @elseif($tipo === 'shop')
                {{-- VISTA SHOP --}}
                <div class="p-8 md:p-12">
                    <div class="flex justify-between items-end mb-8">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Tu Pedido</h2>
                            <p class="text-white/40 text-sm">Resumen de los productos comprados</p>
                        </div>
                        <div class="text-right">
                            <span class="text-3xl font-black text-[#D9C8A1]">{{ number_format($amount, 2) }}€</span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        @foreach($orderItems as $item)
                            <div class="relative bg-white/[0.03] border border-white/10 rounded-2xl p-5 flex items-center justify-between hover:bg-white/[0.07] transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    @if($item->image)
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                            class="w-14 h-14 rounded-xl object-contain bg-neutral-900">
                                    @else
                                        <div class="w-14 h-14 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                                            <i class="fa-solid fa-box text-[#D9C8A1] text-xl"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-white font-bold text-base">{{ $item->name }}</p>
                                        <p class="text-white/40 text-xs mt-0.5">
                                            {{ $item->quantity }} × {{ number_format($item->unit_price, 2) }}€
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[#D9C8A1] font-black text-lg">
                                        {{ number_format($item->unit_price * $item->quantity, 2) }}€
                                    </p>
                                    <p class="text-green-400 text-xs font-bold mt-0.5">Pagado</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total --}}
                    <div class="mt-6 pt-6 border-t border-white/10 flex justify-between items-center">
                        <span class="text-white/60 text-sm uppercase tracking-widest font-bold">Total</span>
                        <span class="text-2xl font-black text-[#D9C8A1]">{{ number_format($amount, 2) }}€</span>
                    </div>
                </div>

            @else
                {{-- VISTA TICKETS --}}
                <div class="p-8 md:p-12">
                    <div class="flex justify-between items-end mb-8">
                        <div>
                            <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">Tus Entradas</h2>
                            <p class="text-white/40 text-sm">Presenta estos códigos en la entrada</p>
                        </div>
                        <div class="text-right">
                            <span class="text-3xl font-black text-[#D9C8A1]">{{ number_format($amount, 2) }}€</span>
                        </div>
                    </div>

                    <div class="space-y-3" id="tickets-container">
                        @foreach($tickets as $index => $ticket)
                            {{-- PARCHE 2: Clase condicional para ocultar a partir del 3 --}}
                            <div class="relative bg-white/[0.03] border border-white/10 rounded-2xl p-5 flex items-center justify-between group hover:bg-white/[0.07] transition-all duration-300 {{ $index >= 3 ? 'ticket-extra' : 'ticket-visible' }}">
                                {{-- Muescas de ticket --}}
                                <div class="absolute -left-[9px] top-1/2 -translate-y-1/2 w-4 h-8 bg-[#0A120A] rounded-full border border-white/10"></div>
                                <div class="absolute -right-[9px] top-1/2 -translate-y-1/2 w-4 h-8 bg-[#0A120A] rounded-full border border-white/10"></div>
                                
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#D9C8A1]/20 to-transparent flex items-center justify-center border border-[#D9C8A1]/20">
                                        <i class="fa-solid fa-qrcode text-[#D9C8A1] text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-white font-bold tracking-wide text-lg">Entrada General</p>
                                        <p class="text-[#D9C8A1] font-mono text-sm font-bold tracking-[2px] uppercase">{{ $ticket['cod'] }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-white/60 text-xs font-medium">{{ $ticket['day_used'] }}</p>
                                    <p class="text-[#D9C8A1] font-bold">Pagado</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Botón Ver Más --}}
                    @if(count($tickets) > 3)
                        <div class="mt-6 text-center">
                            <button id="btn-ver-mas" onclick="revelarTickets()" class="text-[#D9C8A1] text-[10px] font-black uppercase tracking-[3px] border border-[#D9C8A1]/30 px-6 py-2 rounded-full hover:bg-[#D9C8A1] hover:text-[#1A2E1A] transition-all">
                                Ver {{ count($tickets) - 3 }} más
                            </button>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- ACCIONES --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="/" class="group relative flex items-center justify-center gap-3 bg-[#D9C8A1] text-[#1A2E1A] py-5 rounded-2xl font-black uppercase text-xs tracking-[2px] shadow-2xl hover:bg-white transition-all duration-300">
                <i class="fa-solid fa-house group-hover:-translate-y-1 transition-transform"></i>
                <span>Volver al Inicio</span>
            </a>
            @php
                $explorarRuta  = match($tipo) {
                    'shop'        => route('tienda'),
                    'experiencia' => route('VistaExperiencias'),
                    default       => route('tickets.show'),
                };
                $explorarIcono = match($tipo) {
                    'shop'        => 'fa-bag-shopping',
                    'experiencia' => 'fa-leaf',
                    default       => 'fa-ticket',
                };
                $explorarTexto = match($tipo) {
                    'shop'        => 'Ver tienda',
                    'experiencia' => 'Ver experiencias',
                    default       => 'Ver tickets',
                };
            @endphp

            <a href="{{ $explorarRuta }}" class="flex items-center justify-center gap-3 bg-white/5 border border-white/10 text-white py-5 rounded-2xl font-black uppercase text-xs tracking-[2px] hover:bg-white/10 transition-all">
                <i class="fa-solid {{ $explorarIcono }}"></i>
                <span>{{ $explorarTexto }}</span>
            </a>
        </div>

        <div class="mt-12 text-center">
            <p class="text-white/20 text-[10px] uppercase font-black tracking-[6px]">
                Park Zoo Luxury Experiences • 2026
            </p>
        </div>
    </div>
</div>

{{-- Script para la lógica de visualización --}}
<script>
    function revelarTickets() {
        const extras = document.querySelectorAll('.ticket-extra');
        extras.forEach(t => {
            // Cambiamos a la clase visible para asegurar que herede el flex
            t.classList.remove('ticket-extra');
            t.classList.add('ticket-visible', 'animate-fade-in-up');
        });
        document.getElementById('btn-ver-mas').style.display = 'none';
    }
</script>
@endsection