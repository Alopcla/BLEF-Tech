@extends('layouts.app')

@section('content')
<div class="h-24 lg:h-32"></div>

<main class="max-w-6xl mx-auto px-4 lg:px-6 mb-10 lg:mb-20">
    <div class="flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch">
        
        {{-- COLUMNA IMAGEN --}}
        <div class="w-full lg:w-1/2 flex flex-col gap-4 lg:gap-6">
            <div class="relative h-[300px] lg:h-auto lg:flex-grow">
                <img src="{{ $experiencias->image }}" class="absolute inset-0 w-full h-full object-cover rounded-[2rem] shadow-2xl" alt="{{ $experiencias->name }}">
                <div class="absolute bottom-6 left-6 bg-black/60 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10">
                    <span class="text-[#D9C8A1] font-bold text-2xl">{{ $experiencias->price }}€</span>
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
                    <span class="{{ $badge['color'] }} font-bold text-[10px] lg:text-base text-center">{{ $badge['label'] }}</span>
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
                <h1 class="text-4xl lg:text-5xl font-black text-white mb-6 leading-tight">{{ $experiencias->name }}</h1>
                <p class="text-[#D9C8A1] text-lg italic opacity-90 mb-8">"{{ $experiencias->description }}"</p>
                <p class="text-gray-300 text-sm lg:text-lg leading-relaxed">{{ $experiencias->details }}</p>
            </div>

            {{-- Bloque de Reserva --}}
            <div class="mt-12 pt-8 border-t border-white/5">
                @if($experiencias->available_spots > 0)
                    <button onclick="toggleModal(true)" class="group relative w-full flex items-center justify-center gap-3 bg-gradient-to-r from-[#F2C94C] via-[#D9C8A1] to-[#F2994A] text-[#1A2E1A] px-10 py-5 rounded-2xl font-black uppercase text-xs tracking-[2px] shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                        <div class="absolute inset-0 w-full h-full bg-white/30 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 skew-x-12"></div>
                        <span class="relative z-10">Confirmar Reserva</span>
                        <i class="fa-solid fa-arrow-right relative z-10 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                @else
                    <button disabled class="w-full flex items-center justify-center gap-3 bg-white/5 text-white/20 border border-white/5 px-10 py-5 rounded-2xl font-black uppercase text-xs cursor-not-allowed">
                        <i class="fa-solid fa-ban"></i><span>Sold Out</span>
                    </button>
                @endif
            </div>
        </div>
    </div>
</main>

{{-- MODAL ÚNICO DE RESERVA --}}
<div id="modalReserva" class="fixed inset-0 z-[100] hidden items-center justify-center px-4">
    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" onclick="toggleModal(false)"></div>
    <div class="relative bg-[#1A2E1A] border border-white/10 w-full max-w-md rounded-[2.5rem] p-8">
        
        <button onclick="toggleModal(false)" class="absolute top-6 right-6 text-white/40 hover:text-white transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <form action="{{ route('payment.process') }}" method="POST" id="formReserva">
            @csrf
            <input type="hidden" name="concepto" value="Reserva: {{ $experiencias->name }}">
            <input type="hidden" name="tipo" value="experiencia">
            <input type="hidden" name="meta[experiencia_id]" value="{{ $experiencias->id }}">
            <input type="hidden" name="meta[fecha]" id="hiddenFecha">
            <input type="hidden" name="meta[ticket_id]" id="hiddenTicketId">
            <input type="hidden" name="email" id="hiddenEmail" value="{{ auth()->user()->email ?? '' }}">

            {{-- PASO 1: Email (Solo si no está logueado y no hay tickets cargados) --}}
            <div id="stepEmail" class="{{ auth()->check() || $misTickets->count() > 0 ? 'hidden' : '' }}">
                <h2 class="text-2xl font-parkzoo text-white mb-2 text-center fuenteZoo">¿Tienes entrada?</h2>
                <p class="text-white/30 text-[10px] text-center mb-6 uppercase tracking-widest">Introduce tu email para verificar</p>
                <input type="email" id="guestEmailInput" placeholder="tu@email.com" class="w-full p-4 rounded-2xl bg-white/5 border border-white/10 text-white mb-4 focus:ring-1 focus:ring-[#D9C8A1]">
                <p id="emailError" class="hidden text-red-400 text-xs text-center mb-4"></p>
                <button type="button" onclick="verificarEmail()" class="w-full bg-[#D9C8A1] text-[#1A2E1A] py-4 rounded-xl font-black uppercase hover:bg-white transition-all">Verificar Entradas</button>
            </div>

            {{-- PASO 2: Selección de Ticket --}}
            <div id="stepTickets" class="{{ auth()->check() || $misTickets->count() > 0 ? '' : 'hidden' }}">
                <h2 class="text-2xl font-parkzoo text-white mb-2 text-center fuenteZoo">Selecciona tu entrada</h2>
                <p class="text-white/30 text-[10px] text-center mb-6 uppercase tracking-widest">Se reservará para la fecha del ticket</p>
                
                <div id="listaTickets" class="space-y-3 max-h-60 overflow-y-auto pr-1">
                    @forelse($misTickets as $ticket)
                        <label onclick="selectTicket('{{ $ticket->id }}', '{{ $ticket->visit_day->format('Y-m-d') }}')" class="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-2xl cursor-pointer hover:bg-[#D9C8A1]/10 transition-all">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="ticket_radio" class="accent-[#D9C8A1]">
                                <div>
                                    <span class="text-white font-bold block text-sm">{{ $ticket->visit_day->format('d/m/Y') }}</span>
                                    <span class="text-white/40 text-xs font-mono">{{ $ticket->cod_ticket }}</span>
                                </div>
                            </div>
                            <span class="text-[#D9C8A1] text-xs font-bold px-3 py-1 bg-[#D9C8A1]/10 rounded-lg">{{ $ticket->visit_day->format('D') }}</span>
                        </label>
                    @empty
                        @auth
                        <div class="text-center py-4">
                            <p class="text-white/40 text-sm mb-4">No tienes entradas disponibles.</p>
                            <a href="{{ route('payment.show') }}" class="inline-block bg-[#D9C8A1] text-[#1A2E1A] px-6 py-2 rounded-xl font-black text-xs uppercase">Comprar ahora</a>
                        </div>
                        @endauth
                    @endforelse
                </div>

                <button type="submit" id="btnSubmit" disabled class="w-full mt-6 bg-[#D9C8A1] text-[#1A2E1A] py-4 rounded-xl font-black uppercase opacity-50 cursor-not-allowed transition-all">
                    Confirmar Reserva
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleModal(show) {
        const modal = document.getElementById('modalReserva');
        modal.classList.toggle('hidden', !show);
        modal.classList.toggle('flex', show);
    }

    function selectTicket(id, fecha) {
        document.getElementById('hiddenTicketId').value = id;
        document.getElementById('hiddenFecha').value = fecha;
        const btn = document.getElementById('btnSubmit');
        btn.disabled = false;
        btn.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    async function verificarEmail() {
        const email = document.getElementById('guestEmailInput').value.trim();
        const errorEl = document.getElementById('emailError');
        if (!email) return;

        try {
            const res = await fetch(`/api/tickets-by-email?email=${encodeURIComponent(email)}`);
            const data = await res.json();

            if (!data.tickets || data.tickets.length === 0) {
                errorEl.textContent = 'No se encontraron entradas.';
                errorEl.classList.remove('hidden');
                return;
            }

            // Renderizar tickets dinámicamente
            const lista = document.getElementById('listaTickets');
            lista.innerHTML = data.tickets.map(t => `
                <label onclick="selectTicket('${t.id}', '${t.visit_day}')" class="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-2xl cursor-pointer hover:bg-[#D9C8A1]/10 transition-all">
                    <div class="flex items-center gap-3">
                        <input type="radio" name="ticket_radio" class="accent-[#D9C8A1]">
                        <div>
                            <span class="text-white font-bold block text-sm">${t.visit_day_formatted}</span>
                            <span class="text-white/40 text-xs font-mono">${t.cod_ticket}</span>
                        </div>
                    </div>
                </label>
            `).join('');

            document.getElementById('hiddenEmail').value = email;
            document.getElementById('stepEmail').classList.add('hidden');
            document.getElementById('stepTickets').classList.remove('hidden');
        } catch (e) {
            errorEl.textContent = 'Error al conectar.';
            errorEl.classList.remove('hidden');
        }
    }
</script>
@endpush