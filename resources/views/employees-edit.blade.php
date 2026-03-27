<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-10 bg-gray-100">

    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">

        <div class="border-b pb-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">✏️ Editar Ficha de Empleado</h1>
            <p class="text-gray-500">Modificando los datos de: <span
                    class="font-bold text-blue-600">{{ $employee->name }} {{ $employee->surname }}</span> (DNI:
                {{ $employee->dni }})</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                <strong class="font-bold">¡Uy! Hay un problema:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('employees.update', $employee->dni) }}" method="POST">
            @csrf
            @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ $employee->name }}"
                        class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                    <input type="text" name="surname" value="{{ $employee->surname }}"
                        class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <input type="text" name="address" value="{{ $employee->address }}"
                        class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provincia</label>
                    <input type="text" name="province" value="{{ $employee->province }}"
                        class="w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 p-4 bg-blue-50 rounded-lg">
                <div>
                    <label class="block text-sm font-medium text-blue-900 mb-1">Puesto de Trabajo</label>
                    <input type="text" name="position" value="{{ $employee->position }}"
                        class="w-full border-gray-300 rounded-md shadow-sm p-2 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-blue-900 mb-1">Zona Asignada</label>
                    <select name="zone_id" class="w-full border-gray-300 rounded-md shadow-sm p-2 border bg-white"
                        required>
                        @foreach($zones as $zone)
                            <option value="{{ $zone->id }}" {{ $employee->zone_id == $zone->id ? 'selected' : '' }}>
                                {{ $zone->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-8 border border-gray-200 rounded-lg p-5">
                <h3 class="text-lg font-bold text-gray-700 mb-4 flex items-center gap-2">📞 Gestión de Teléfonos</h3>

                <div class="space-y-3">
                    @foreach($employee->telephones as $telephone)
                        <div class="flex items-end gap-2" id="phone-container-{{ $telephone->id }}">
                            <div class="flex-grow">
                                <label class="text-xs text-gray-500 mb-1">Teléfono registrado (ID:
                                    {{ $telephone->id }})</label>
                                <input type="text" name="telephones[{{ $telephone->id }}]"
                                    value="{{ $telephone->telephone }}"
                                    class="w-full border-gray-300 rounded-md shadow-sm p-2 border bg-gray-50" required>
                            </div>

                            <button type="button"
                                onclick="document.getElementById('phone-container-{{ $telephone->id }}').remove()"
                                class="bg-red-100 text-red-600 px-3 py-2.5 rounded-md hover:bg-red-200 transition border border-red-200"
                                title="Eliminar este número">
                                🗑️
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 pt-5 border-t border-gray-200">
                    <label class="block text-sm font-bold text-green-700 mb-1">➕ Añadir nuevo teléfono
                        (Opcional)</label>
                    <input type="text" name="new_telephones[]" placeholder="Escribe un número nuevo aquí..."
                        class="w-full md:w-1/2 border-green-300 rounded-md shadow-sm p-2 border focus:ring-green-500 focus:border-green-500">
                    <p class="text-xs text-gray-400 mt-1">Déjalo en blanco si no quieres añadir ninguno.</p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-6 border-t pt-6">
                <a href="/dashboard"
                    class="px-5 py-2.5 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition font-semibold text-sm">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-bold shadow-md text-sm">
                    💾 Guardar Cambios
                </button>
            </div>

        </form>
    </div>

</body>

</html>
