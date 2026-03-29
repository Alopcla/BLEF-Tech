<div class="bg-white border-l-4 border-blue-500 p-5 rounded-lg shadow-lg">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-bold">{{ $employee->name }} {{ $employee->surname }}</h2>
            <p class="text-xs text-gray-800 uppercase tracking-wider">DNI: {{ $employee->dni }}</p>
        </div>
    </div>


    <div class="mt-4 space-y-2 text-sm text-gray-600">
        <p><strong>Direccion: </strong>{{ $employee->address }}</p>
        <p><strong>Provincia: </strong>{{ $employee->province }}</p>
        <p><strong>Email: </strong>{{ $employee->email }}</p>
        <p><strong>Fecha de nacimiento: </strong>{{ \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') }}</p>
    </div>

    <div class="mt-4 pt-4 border-t border-gray-100">
        <p class="text-xs font-bold text-blue-600 mb-2">TELEFONOS REGISTRADOS:</p>
        <ul class="space-y-3 max-w-xs">
            @forelse($employee->telephones as $tel)
                <li class="flex justify-between bg-gray-200 p-2 rounded text-sm">
                    <span class="text-gray-600 text-xs italic">Nº {{ $tel->order }}</span>
                    <span class="font-mono font-bold text-gray-900">{{ $tel->telephone }}</span>
                </li>
            @empty
                <li class="test-red-400 text-xs italic">Sin telefono</li>
            @endforelse
        </ul>
    </div>
    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('employees.edit', encrypt($employee->dni)) }}"
            class="bg-blue-100 text-blue-700 px-3 py-1.5 rounded-md hover:bg-blue-200 transition text-sm font-semibold flex items-center">
            ✏️ Editar
        </a>

        <button type="button"
            onclick="document.getElementById('modal-delete-{{ $employee->dni }}').classList.remove('hidden')"
            class="bg-red-100 text-red-700 px-3 py-1.5 rounded-md hover:bg-red-200 transition text-sm font-semibold">
            🗑️ Borrar Empleado
        </button>
    </div>


    <div id="modal-delete-{{ $employee->dni }}"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50 transition-opacity">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full mx-4">

            <h2 class="text-xl font-bold text-gray-800 mb-2">¿Eliminar a {{ $employee->name }}?</h2>
            <p class="text-gray-600 mb-6 text-sm">Esta acción borrará definitivamente su ficha de Recursos Humanos y
                eliminará su acceso al sistema. Esta acción no se puede deshacer.</p>

            <div class="flex justify-end gap-3">
                <button type="button"
                    onclick="document.getElementById('modal-delete-{{ $employee->dni }}').classList.add('hidden')"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition text-sm font-semibold">
                    Cancelar
                </button>

                <form action="{{ route('employees.destroy', encrypt($employee->dni)) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition text-sm font-bold shadow-md">
                        Sí, eliminar
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
