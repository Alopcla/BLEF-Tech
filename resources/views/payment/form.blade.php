@extends('layouts.app')

@section('title', 'Comprar Tickets')

@section('video', 'true')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(0.8) sepia(50%) saturate(500%) hue-rotate(10deg);
        cursor: pointer;
    }
    /* Estilo preventivo para botón deshabilitado */
    button:disabled {
        cursor: not-allowed !important;
        pointer-events: none;
    }
</style>
@endpush

@section('content')

{{-- Espaciador para el header --}}
<div class="h-24 lg:h-32"></div>

<div class="min-h-[80vh] flex items-center justify-center px-4 pb-20">
    {{-- Tarjeta Principal --}}
    <div class="w-full max-w-xl bg-[#1A2E1A] border border-white/10 rounded-[2.5rem] p-8 lg:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.5)] backdrop-blur-xl relative overflow-hidden">
        
        {{-- Adorno visual de fondo --}}
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#D9C8A1]/10 rounded-full blur-3xl"></div>

        <header class="relative z-10 mb-10 text-center">
            <span class="text-[#D9C8A1] uppercase tracking-[5px] text-[10px] font-black">Acceso General</span>
            <h2 class="font-parkzoo text-4xl lg:text-5xl text-white mt-2 fuenteZoo">Reserva tu <span class="text-[#D9C8A1]">Aventura</span></h2>
            <p class="text-white/40 text-xs mt-4 max-w-xs mx-auto">Selecciona la fecha de tu visita y el número de exploradores.</p>
        </header>

        {{-- Alertas de éxito o error --}}
        @if(session('success') || session('error'))
            <div class="relative z-10 mb-8 animate-fade-in">
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-2xl text-sm flex items-center gap-3">
                        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                    </div>
                @else
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-2xl text-sm flex items-center gap-3">
                        <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                    </div>
                @endif
            </div>
        @endif

        <form action="{{ route('payment.process') }}" method="POST" id="purchaseForm" class="relative z-10 space-y-6">
            @csrf
            <input type="hidden" name="tipo" value="ticket">
            <input type="hidden" name="concepto" value="Entradas Park Zoo">

            {{-- Sección Email --}}
            @auth
                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                <div class="bg-white/5 border border-white/10 rounded-2xl px-6 py-4 flex items-center justify-between">
                    <span class="text-white/40 text-xs uppercase font-bold tracking-widest">Visitante</span>
                    <span class="text-[#D9C8A1] text-sm font-bold">{{ auth()->user()->email }}</span>
                </div>
            @else
                <div class="group/input relative">
                    <label class="absolute -top-2 left-4 bg-[#1A2E1A] px-2 text-[10px] text-[#D9C8A1] font-black uppercase tracking-widest z-20">Email de contacto</label>
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-white/20 group-focus-within/input:text-[#D9C8A1] transition-colors">
                        <i class="fa-solid fa-envelope text-xs"></i>
                    </div>
                    <input type="email" name="email" required
                           class="w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white text-sm focus:outline-none focus:border-[#D9C8A1]/50 focus:ring-1 focus:ring-[#D9C8A1]/20 transition-all"
                           placeholder="tu@email.com">
                </div>
            @endauth

            {{-- Sección Fecha y Cantidad --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Fecha --}}
                <div class="group/input relative">
                    <label class="absolute -top-2 left-4 bg-[#1A2E1A] px-2 text-[10px] text-[#D9C8A1] font-black uppercase tracking-widest z-20">Fecha</label>
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-white/20 group-focus-within/input:text-[#D9C8A1] transition-colors">
                        <i class="fa-solid fa-calendar-day text-xs"></i>
                    </div>
                    {{-- Usamos la variable $fecha que viene del controlador --}}
                    <input type="date" name="meta[dia]" id="inputFecha" required
                           min="{{ $fecha }}" value="{{ $fecha }}"
                           class="w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white text-sm focus:outline-none focus:border-[#D9C8A1]/50 transition-all cursor-pointer">
                </div>

                {{-- Cantidad --}}
                <div class="group/input relative">
                    <label class="absolute -top-2 left-4 bg-[#1A2E1A] px-2 text-[10px] text-[#D9C8A1] font-black uppercase tracking-widest z-20">Entradas</label>
                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none text-white/20 group-focus-within/input:text-[#D9C8A1] transition-colors">
                        <i class="fa-solid fa-ticket text-xs"></i>
                    </div>
                    <input type="number" name="meta[cantidad]" id="inputCantidad" required
                           min="1" max="10" value="1"
                           class="w-full bg-white/5 border border-white/10 rounded-2xl pl-12 pr-6 py-4 text-white text-sm focus:outline-none focus:border-[#D9C8A1]/50 transition-all">
                </div>
            </div>

            {{-- Feedback disponibilidad --}}
            <div id="disponibilidad-feedback" class="text-center py-2 transition-all duration-300 min-h-[1.5rem]"></div>

            {{-- Resumen de Pago --}}
            <div class="bg-gradient-to-br from-black/40 to-black/10 rounded-3xl p-6 border border-white/5 shadow-inner">
                <div class="flex justify-between items-center">
                    <div class="space-y-1">
                        <span class="text-white/30 text-[10px] uppercase font-black tracking-widest block">Total a pagar</span>
                        <div class="flex items-center gap-2">
                            <span class="text-white/60 text-xs">Precio unitario:</span>
                            <span class="bg-[#D9C8A1]/10 text-[#D9C8A1] text-[10px] px-2 py-0.5 rounded-full font-bold">15,00 €</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-white font-black text-3xl lg:text-4xl tracking-tighter" id="precioTotal">15,00 €</span>
                    </div>
                </div>
            </div>

            {{-- Botón de Pago --}}
            <div class="pt-4">
                <button type="submit" id="btnSubmit"
                    class="group relative w-full flex items-center justify-center gap-3 bg-gradient-to-r from-[#F2C94C] via-[#D9C8A1] to-[#F2994A] text-[#1A2E1A] py-5 rounded-2xl font-black uppercase text-xs tracking-[3px] shadow-[0_15px_40px_rgba(217,200,161,0.2)] hover:shadow-[0_20px_50px_rgba(217,200,161,0.4)] hover:-translate-y-1 active:scale-95 transition-all duration-300 overflow-hidden">
                    <div class="absolute inset-0 w-full h-full bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 skew-x-12"></div>
                    <span class="relative z-10" id="btnText">Confirmar y Pagar</span>
                    <i class="fa-solid fa-arrow-right relative z-10 group-hover:translate-x-1 transition-transform"></i>
                </button>
                
                <div class="flex items-center justify-center gap-6 mt-8 opacity-30 grayscale hover:grayscale-0 transition-all duration-500">
                    <i class="fa-brands fa-cc-stripe text-3xl text-white"></i>
                    <i class="fa-brands fa-cc-visa text-2xl text-white"></i>
                    <i class="fa-brands fa-cc-mastercard text-2xl text-white"></i>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const inputFecha       = document.getElementById('inputFecha');
    const inputCantidad    = document.getElementById('inputCantidad');
    const btnSubmit        = document.getElementById('btnSubmit');
    const btnText          = document.getElementById('btnText');
    const feedback         = document.getElementById('disponibilidad-feedback');
    const precioTotal      = document.getElementById('precioTotal');
    const precioPorEntrada = 15;

    function actualizarPrecio() {
        const cantidad = parseInt(inputCantidad.value) || 0;
        precioTotal.textContent = (cantidad * precioPorEntrada).toFixed(2).replace('.', ',') + ' €';
    }

    async function revisarCupo() {
        const fecha = inputFecha.value;
        if (!fecha) return;
        
        feedback.innerHTML = '<span class="text-white/20 text-[10px] uppercase font-bold tracking-widest animate-pulse">Verificando cupo...</span>';

        try {
            const r = await fetch(`{{ route('check.availability') }}?date=${fecha}`);
            const data = await r.json();
            actualizarInterfaz(data.available);
        } catch (e) {
            feedback.innerHTML = '';
        }
    }

    function actualizarInterfaz(disponibles) {
        if (disponibles <= 0) {
            feedback.innerHTML = '<div class="inline-flex items-center gap-2 px-3 py-1 bg-red-500/10 border border-red-500/20 rounded-full"><span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-ping"></span><span class="text-red-400 text-[10px] font-black uppercase tracking-widest">Agotado para esta fecha</span></div>';
            
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-50', 'grayscale');
            btnText.textContent = 'Entradas Agotadas';
            
            inputCantidad.value = 0;
            inputCantidad.disabled = true; // <--- Bloqueo para que no confunda al usuario
        } else {
            feedback.innerHTML = `<div class="inline-flex items-center gap-2 px-3 py-1 bg-[#D9C8A1]/10 border border-[#D9C8A1]/20 rounded-full"><span class="text-[#D9C8A1] text-[10px] font-black uppercase tracking-widest">¡Quedan ${disponibles} plazas disponibles!</span></div>`;
            
            btnSubmit.disabled = false;
            btnSubmit.classList.remove('opacity-50', 'grayscale');
            btnText.textContent = 'Confirmar y Pagar';
            
            inputCantidad.disabled = false; // <--- Desbloqueo
            inputCantidad.max = disponibles;

            if (parseInt(inputCantidad.value) <= 0) inputCantidad.value = 1;
            if (parseInt(inputCantidad.value) > disponibles) {
                inputCantidad.value = disponibles;
            }
        }
        actualizarPrecio();
    }

    // El submit lo dejamos así si quieres seguridad máxima:
    document.getElementById('purchaseForm').addEventListener('submit', async function(e) {
        if (btnSubmit.disabled) return e.preventDefault(); // Doble seguro

        btnSubmit.disabled = true;
        btnText.textContent = 'Validando reserva...';
        
        // Esta parte hace que si alguien tarda 10 min en el formulario, 
        // no le deje pagar si las entradas se acabaron mientras escribía.
        const r = await fetch(`{{ route('check.availability') }}?date=${inputFecha.value}`);
        const data = await r.json();
        
        if (data.available < inputCantidad.value) {
            e.preventDefault();
            actualizarInterfaz(data.available);
            alert("Lo sentimos, el aforo acaba de cambiar. Por favor, ajusta tu reserva.");
            return;
        }

        btnText.textContent = 'Abriendo Stripe...';
    });

    inputFecha.addEventListener('change', revisarCupo);
    inputCantidad.addEventListener('input', actualizarPrecio);

    document.addEventListener('DOMContentLoaded', () => {
        revisarCupo();
        actualizarPrecio();
    });
</script>
@endpush