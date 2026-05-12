<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro de Reclamaciones - ZooPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 pb-12 relative min-h-screen flex flex-col">

    {{-- TOASTS FLOTANTES --}}
    <div id="toast-container" class="fixed top-24 right-6 z-50 flex flex-col gap-3">
        @if(session('success'))
            <div class="toast bg-white border border-slate-200 p-4 shadow-xl rounded-2xl flex items-center justify-between min-w-[300px] transition-all duration-500">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-50 text-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-slate-700">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 transition ml-4">✕</button>
            </div>
        @endif

        @if(session('error'))
            <div class="toast bg-white border border-slate-200 p-4 shadow-xl rounded-2xl flex items-center justify-between min-w-[300px] transition-all duration-500">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-red-50 text-red-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-slate-700">{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-slate-400 hover:text-slate-600 transition ml-4">✕</button>
            </div>
        @endif
    </div>

    {{-- HEADER ESTILO DASHBOARD --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <h1 class="text-xl font-black tracking-tight text-slate-800">
                    Zoo<span class="text-yellow-600">Pro</span> Centro de Reclamaciones
                </h1>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al Panel
            </a>
        </div>
    </header>

    <main class="max-w-[1200px] mx-auto px-6 mt-8 flex-1 w-full">

        {{-- BUSCADOR --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 mb-8 relative overflow-hidden">
            {{-- Detalle visual amarillo claro --}}
            <div class="absolute top-0 left-0 w-2 h-full bg-yellow-300"></div>

            <h2 class="text-lg font-black mb-6 text-slate-800 flex items-center gap-2 uppercase tracking-widest">
                Buscar Compra de Cliente
            </h2>

            <form action="{{ route('reclamaciones.buscar') }}" method="GET" class="flex flex-col md:flex-row gap-6">
                <div class="flex-1">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Email del cliente</label>
                    <input type="email" name="email" placeholder="ejemplo@correo.com"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-700 px-4 py-3 rounded-xl focus:ring-2 focus:ring-yellow-300 focus:border-yellow-300 outline-none transition-all font-medium"
                           required value="{{ request('email') ?? $email ?? '' }}">
                </div>

                <div class="w-full md:w-64">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Fecha de visita</label>
                    <input type="date" name="fecha"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-700 px-4 py-3 rounded-xl focus:ring-2 focus:ring-yellow-300 focus:border-yellow-300 outline-none transition-all font-medium"
                           required value="{{ request('fecha') ?? $fecha ?? '' }}">
                </div>

                <div class="w-full md:w-auto flex items-end">
                    {{-- Botón con el amarillo claro y letras oscuras idéntico a tu recorte --}}
                    <button type="submit" class="w-full md:w-auto bg-yellow-100 border border-yellow-300 text-yellow-800 px-8 py-3 rounded-xl hover:bg-yellow-200 transition-all font-black shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        BUSCAR TICKETS
                    </button>
                </div>
            </form>
        </div>

        {{-- RESULTADOS --}}
        @if(isset($tickets))
            @forelse($tickets as $sessionId => $group)

                <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-slate-200 mb-8 hover:shadow-md transition-shadow">

                    {{-- CABECERA PEDIDO --}}
                    <div class="p-5 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-1">ID de Sesión (Stripe)</p>
                                <p class="font-mono text-sm font-bold text-slate-700">{{ $sessionId }}</p>
                            </div>
                        </div>

                        @if($group->first()->status !== 'cancelled')
                            <form id="form-{{ $sessionId }}" action="{{ route('reclamaciones.cancelar.pedido') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="session_id" value="{{ $sessionId }}">

                                <button type="button" onclick="openDeleteModal('form-{{ $sessionId }}')" class="w-full sm:w-auto bg-white border border-red-200 text-red-500 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-red-50 hover:border-red-300 transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Cancelar Pedido
                                </button>
                            </form>
                        @else
                            <div class="px-4 py-2 bg-slate-200 text-slate-500 rounded-lg text-xs font-black uppercase tracking-widest flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Reembolsado Total
                            </div>
                        @endif
                    </div>

                    {{-- TABLA TICKETS --}}
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest bg-white">Identificador</th>
                                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest bg-white">Fecha Visita</th>
                                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest bg-white">Importe</th>
                                    <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest bg-white text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="border-t border-slate-100">
                                @foreach($group as $ticket)
                                    <tr class="hover:bg-slate-50 transition-colors {{ $ticket->status === 'cancelled' ? 'opacity-50 bg-slate-50/50' : '' }}">
                                        <td class="px-6 py-4 font-mono text-sm font-bold text-yellow-600 border-b border-slate-50">
                                            #{{ $ticket->id }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-slate-600 border-b border-slate-50">
                                            {{ date('d/m/Y', strtotime($ticket->visit_day)) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-black text-slate-700 border-b border-slate-50">
                                            {{ $ticket->price }}€
                                        </td>
                                        <td class="px-6 py-4 border-b border-slate-50 text-center">
                                            @if($ticket->status === 'cancelled')
                                                <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-100 text-red-600 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    Cancelado
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-100 text-green-600 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">
                                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                                    Activo
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            @empty
                <div class="bg-white p-16 text-center flex flex-col items-center justify-center text-slate-500 rounded-3xl shadow-sm border border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-700 mb-2">No se encontraron tickets</h3>
                    <p class="text-sm text-slate-500 font-medium max-w-md">No hay registros de compras con ese correo electrónico para la fecha especificada. Revisa los datos y vuelve a intentarlo.</p>
                </div>
            @endforelse
        @endif

    </main>

    {{-- MODAL DE CONFIRMACIÓN --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-[100]">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-sm text-center transform transition-all border border-slate-200">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-3">¿Cancelar pedido?</h3>
            <p class="text-slate-500 text-sm mb-8 font-medium">Esta acción es irreversible. Todos los tickets de este identificador pasarán a estado cancelado en la base de datos.</p>

            <div class="flex gap-4">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3.5 border border-slate-200 text-slate-500 font-bold rounded-xl hover:bg-slate-50 transition-all uppercase text-xs tracking-widest">
                    Volver
                </button>
                <button onclick="submitDeleteForm()" class="flex-1 px-4 py-3.5 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 shadow-lg shadow-red-200 transition-all flex items-center justify-center gap-2 uppercase text-xs tracking-widest">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentFormId = null;

        function openDeleteModal(formId) {
            currentFormId = formId;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            currentFormId = null;
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function submitDeleteForm() {
            if (currentFormId) {
                document.getElementById(currentFormId).submit();
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.add('opacity-0', 'translate-x-full');
                    setTimeout(() => toast.remove(), 500);
                }, 4000);
            });
        });
    </script>
</body>
</html>
