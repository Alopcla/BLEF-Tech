<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Alertas - Zoologic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-10 bg-gray-100">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">📢 Alertas del Mapa</h1>
            <a href="{{ route('employees.index') }}" class="text-indigo-600 font-bold hover:underline">← Volver al Panel</a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white p-6 rounded-xl shadow-md border-t-4 border-indigo-600 mb-10">
            <h2 class="text-xl font-bold mb-4 text-gray-700">Crear Nueva Alerta</h2>
            <form action="{{ route('alerts.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-1">Zona del Zoo</label>
                        <select name="zone_type" class="w-full border p-2 rounded-lg" required>
                            @foreach($zones as $zone)
                            <option value="{{ $zone->type }}">{{ $zone->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-1">Nivel de Importancia</label>
                        <select name="level" class="w-full border p-2 rounded-lg" required>
                            <option value="aviso">Aviso (Verde)</option>
                            <option value="alerta">Alerta (Amarillo)</option>
                            <option value="peligro">Peligro (Rojo)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-1">Título corto</label>
                    <input type="text" name="title" placeholder="Ej: Zona en obras" class="w-full border p-2 rounded-lg" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-600 mb-1">Mensaje detallado</label>
                    <textarea name="message" rows="3" placeholder="Describe lo que ocurre..." class="w-full border p-2 rounded-lg" required></textarea>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 rounded-lg hover:bg-indigo-700 transition">
                    Publicar Alerta en el Mapa
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 text-sm font-bold text-gray-600">Zona</th>
                        <th class="p-4 text-sm font-bold text-gray-600">Alerta</th>
                        <th class="p-4 text-sm font-bold text-gray-600">Nivel</th>
                        <th class="p-4 text-sm font-bold text-gray-600 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($alerts as $alert)
                    <tr>
                        <td class="p-4 font-bold text-gray-700">{{ $alert->zone_type }}</td>
                        <td class="p-4">
                            <p class="text-sm font-bold">{{ $alert->title }}</p>
                            <p class="text-xs text-gray-500">{{ $alert->message }}</p>
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase
                                    {{ $alert->level == 'peligro' ? 'bg-red-100 text-red-700' : ($alert->level == 'alerta' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                {{ $alert->level }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <form action="{{ route('alerts.destroy', $alert->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta alerta?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 font-bold text-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>