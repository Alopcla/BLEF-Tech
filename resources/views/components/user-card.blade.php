<div class="bg-white border-l-4 border-blue-500 p-5 rounded-lg shadow-lg">
    <div class="flex justify-between items-start">
        <div>
            <h2 class="text-xl font-bold">{{ $employee->name }} {{ $employee->surname }}</h2>
            <p class="text-xs text-gray-800 uppercase tracking-wider">DNI: {{ $employee->DNI }}</p>
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
                    <span class="font-mono font-bold text-gray-900">{{ $tel->number }}</span>
                </li>
            @empty
                <li class="test-red-400 text-xs italic">Sin telefono</li>
            @endforelse
        </ul>
    </div>
</div>
