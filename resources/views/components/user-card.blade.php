@props(['employee'])

@php
    // Definimos el diccionario de colores según el puesto
    $roleStyles = [
        'Administrador' => ['border' => 'border-fuchsia-500', 'badge' => 'bg-fuchsia-100 text-fuchsia-800', 'icon' => '👑'],
        'Médico'        => ['border' => 'border-emerald-500', 'badge' => 'bg-emerald-100 text-emerald-800', 'icon' => '🩺'],
        'Cuidador'      => ['border' => 'border-amber-500',   'badge' => 'bg-amber-100 text-amber-800',     'icon' => '🦁'],
        'Guía'          => ['border' => 'border-sky-500',     'badge' => 'bg-sky-100 text-sky-800',         'icon' => '🗺️'],
        'Mantenimiento' => ['border' => 'border-slate-500',   'badge' => 'bg-slate-100 text-slate-800',     'icon' => '🔧'],
    ];

    // Si por algún motivo el puesto no está en la lista, le damos un estilo gris por defecto
    $style = $roleStyles[$employee->position] ?? ['border' => 'border-gray-500', 'badge' => 'bg-gray-100 text-gray-800', 'icon' => '👤'];
@endphp

<div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border-t-4 {{ $style['border'] }} flex flex-col h-full">

    <div class="p-6 flex-grow">
        <div class="flex justify-between items-start mb-4">
            <div>
                <h3 class="text-xl font-bold text-slate-800 leading-tight">{{ $employee->name }} {{ $employee->surname }}</h3>
                <p class="text-xs text-slate-400 mt-1 font-mono">DNI: {{ $employee->dni }}</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 shadow-sm {{ $style['badge'] }}">
                {{ $style['icon'] }} {{ $employee->position }}
            </span>
        </div>

        <div class="space-y-2 mt-4 text-sm">
            <p class="flex items-center gap-2 text-slate-600">
                <span class="w-5 text-center">📍</span> {{ $employee->address }}, {{ $employee->province }}
            </p>
            <p class="flex items-center gap-2 text-slate-600">
                <span class="w-5 text-center">🗺️</span> Zona: <strong class="text-slate-800">{{ $employee->zone->nombre ?? 'Sin zona asignada' }}</strong>
            </p>
            <p class="flex items-center gap-2 text-slate-600">
                <span class="w-5 text-center">🎂</span> Nace: {{ \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') }}
            </p>
            <p class="flex items-center gap-2 text-slate-600 truncate" title="{{ $employee->email }}">
                <span class="w-5 text-center">✉️</span> {{ $employee->email }}
            </p>
        </div>

        <div class="mt-5 pt-4 border-t border-slate-100">
            <p class="text-xs font-bold tracking-wider text-slate-400 uppercase mb-2">📞 Contacto</p>
            <ul class="space-y-1">
                @forelse($employee->telephones as $telephone)
                    <li class="text-sm font-medium text-slate-700 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        {{ $telephone->telephone }}
                    </li>
                @empty
                    <li class="text-red-400 text-xs italic">⚠️ Sin teléfono registrado</li>
                @endforelse
            </ul>
        </div>
    </div>

    <div class="bg-slate-50 p-4 border-t border-slate-100 flex justify-end gap-3 mt-auto">
        <a href="{{ route('employees.edit', encrypt($employee->dni)) }}" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-700 rounded-md hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 transition text-sm font-semibold flex items-center shadow-sm">
            ✏️ Editar
        </a>

        <button type="button" onclick="document.getElementById('modal-delete-{{ $employee->dni }}').classList.remove('hidden')" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-700 rounded-md hover:bg-red-50 hover:text-red-700 hover:border-red-300 transition text-sm font-semibold shadow-sm">
            🗑️ Borrar
        </button>
    </div>
</div>

<div id="modal-delete-{{ $employee->dni }}" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm overflow-y-auto h-full w-full flex items-center justify-center z-50 transition-all">
    <div class="bg-white p-6 rounded-2xl shadow-2xl max-w-sm w-full mx-4 transform scale-100">
        <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl mx-auto mb-4">⚠️</div>
        <h2 class="text-xl font-bold text-slate-800 mb-2 text-center">¿Despedir a {{ $employee->name }}?</h2>
        <p class="text-slate-500 mb-6 text-sm text-center">Se borrará su ficha, sus teléfonos y su acceso al sistema de forma permanente.</p>

        <div class="flex justify-center gap-3">
            <button type="button" onclick="document.getElementById('modal-delete-{{ $employee->dni }}').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition text-sm font-semibold">
                Cancelar
            </button>
            <form action="{{ route('employees.destroy', encrypt($employee->dni)) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-bold shadow-md">
                    Sí, eliminar
                </button>
            </form>
        </div>
    </div>
</div>
