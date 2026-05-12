<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alertas - ZooPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Importamos la fuente Poppins --}}
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
    </div>

    {{-- HEADER ESTILO DASHBOARD --}}
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
        <div class="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-100 border border-indigo-200 text-indigo-600 w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-sm">
                    {{-- NUEVO ICONO: MEGÁFONO --}}
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
                <h1 class="text-xl font-black tracking-tight text-slate-800">
                    Zoo<span class="text-indigo-600">Pro</span> Alertas del Mapa
                </h1>
            </div>
            <a href="{{ route('employees.index') }}" class="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Volver al Panel
            </a>
        </div>
    </header>

    <main class="max-w-[1200px] mx-auto px-6 mt-8 flex-1 w-full">

        {{-- FORMULARIO CREAR ALERTA --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 mb-8 relative overflow-hidden">
            {{-- Detalle visual índigo --}}
            <div class="absolute top-0 left-0 w-2 h-full bg-indigo-500"></div>

            <h2 class="text-lg font-black mb-6 text-slate-800 flex items-center gap-2 uppercase tracking-widest">
                Crear Nueva Alerta
            </h2>

            <form action="{{ route('alerts.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Zona del Zoo</label>
                        <select name="zone_type" class="w-full bg-slate-50 border border-slate-200 text-slate-700 px-4 py-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium appearance-none" required>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->type }}">{{ $zone->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nivel de Importancia</label>
                        <select name="level" class="w-full bg-slate-50 border border-slate-200 text-slate-700 px-4 py-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium appearance-none" required>
                            <option value="aviso">Aviso (Verde)</option>
                            <option value="alerta">Alerta (Amarillo)</option>
                            <option value="peligro">Peligro (Rojo)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Título corto</label>
                    <input type="text" name="title" placeholder="Ej: Zona en obras temporalmente"
                           class="w-full bg-slate-50 border border-slate-200 text-slate-700 px-4 py-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Mensaje detallado</label>
                    <textarea name="message" rows="3" placeholder="Describe lo que ocurre para informar a los visitantes..."
                              class="w-full bg-slate-50 border border-slate-200 text-slate-700 px-4 py-3 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all font-medium resize-none" required></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="w-full md:w-auto bg-indigo-600 text-white px-8 py-3.5 rounded-xl hover:bg-indigo-700 transition-all font-black shadow-lg shadow-indigo-200 flex items-center justify-center gap-2 uppercase text-xs tracking-widest">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Publicar Alerta
                    </button>
                </div>
            </form>
        </div>

        {{-- LISTADO DE ALERTAS --}}
        <div class="bg-white rounded-3xl shadow-sm overflow-hidden border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
                <div class="w-8 h-8 bg-white border border-slate-200 rounded-lg flex items-center justify-center text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </div>
                <h3 class="text-sm font-black text-slate-700 uppercase tracking-widest">Alertas Activas</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest bg-white">Zona</th>
                            <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest bg-white">Detalles de la Alerta</th>
                            <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest bg-white">Gravedad</th>
                            <th class="px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest bg-white text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="border-t border-slate-100">
                        @forelse($alerts as $alert)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-5 border-b border-slate-50">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase tracking-wider border border-slate-200">
                                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $alert->zone_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 border-b border-slate-50">
                                    <p class="text-sm font-bold text-slate-800 mb-1">{{ $alert->title }}</p>
                                    <p class="text-xs text-slate-500 font-medium max-w-md line-clamp-2">{{ $alert->message }}</p>
                                </td>
                                <td class="px-6 py-5 border-b border-slate-50">
                                    @if($alert->level == 'peligro')
                                        <span class="inline-flex items-center gap-1.5 bg-red-50 border border-red-100 text-red-600 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">
                                            <span class="w-2 h-2 rounded-full bg-red-500"></span> Peligro
                                        </span>
                                    @elseif($alert->level == 'alerta')
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 border border-amber-100 text-amber-600 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span> Alerta
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-green-50 border border-green-100 text-green-600 px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Aviso
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-5 border-b border-slate-50 text-right">
                                    <form id="form-{{ $alert->id }}" action="{{ route('alerts.destroy', $alert->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="openDeleteModal('form-{{ $alert->id }}')"
                                                class="w-10 h-10 inline-flex items-center justify-center rounded-xl bg-slate-100 text-slate-400 hover:bg-red-50 hover:text-red-500 transition-all opacity-0 group-hover:opacity-100 focus:opacity-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-sm font-bold uppercase tracking-widest">No hay alertas activas</p>
                                        <p class="text-xs mt-1 font-medium">El mapa funciona con normalidad en todas las zonas.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- MODAL DE CONFIRMACIÓN --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-[100]">
        <div class="bg-white rounded-3xl shadow-2xl p-8 w-full max-w-sm text-center transform transition-all border border-slate-200">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-800 mb-3">¿Eliminar alerta?</h3>
            <p class="text-slate-500 text-sm mb-8 font-medium">La alerta desaparecerá inmediatamente del mapa de los visitantes. Esta acción no se puede deshacer.</p>

            <div class="flex gap-4">
                <button onclick="closeDeleteModal()" class="flex-1 px-4 py-3.5 border border-slate-200 text-slate-500 font-bold rounded-xl hover:bg-slate-50 transition-all uppercase text-xs tracking-widest">
                    Cancelar
                </button>
                <button onclick="submitDeleteForm()" class="flex-1 px-4 py-3.5 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 shadow-lg shadow-red-200 transition-all flex items-center justify-center gap-2 uppercase text-xs tracking-widest">
                    Eliminar
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPTS (Modal y Toasts) --}}
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
