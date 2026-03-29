<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reclamaciones - ZooLogic</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-10 bg-gray-100 font-[Poppins]">
    <div class="max-w-6xl mx-auto">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">🎫 Centro de Reclamaciones</h1>
                <p class="text-gray-600">Busca tickets por cliente para reenviar o cancelar.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded shadow hover:bg-gray-600 transition">
                ← Volver al Panel
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-8 border-t-4 border-yellow-500">
            <h2 class="text-xl font-bold mb-4 text-gray-700">Buscar Compra</h2>

            <form action="{{ route('reclamaciones.buscar') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[250px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email del cliente</label>
                    <input type="email" name="email" placeholder="usuario@ejemplo.com"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-400 outline-none"
                        required value="{{ request('email') ?? $email ?? '' }}">
                </div>
                <div class="w-full md:w-auto">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de visita</label>
                    <input type="date" name="fecha"
                        class="w-full border p-2 rounded focus:ring-2 focus:ring-yellow-400 outline-none"
                        required value="{{ request('fecha') ?? $fecha ?? '' }}">
                </div>
                <div class="w-full md:w-auto flex items-end">
                    <button type="submit" class="w-full bg-yellow-600 text-white px-6 py-2 rounded hover:bg-yellow-700 transition font-bold shadow">
                        🔍 Buscar Tickets
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm">
            {{ session('error') }}
        </div>
        @endif

        @if(isset($tickets))
        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="p-4 font-semibold text-gray-600">ID Ticket</th>
                        <th class="p-4 font-semibold text-gray-600">Fecha Visita</th>
                        <th class="p-4 font-semibold text-gray-600">Precio</th>
                        <th class="p-4 font-semibold text-gray-600">Método Pago</th>
                        <th class="p-4 font-semibold text-gray-600 text-center">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-4 font-mono text-blue-600">#{{ $ticket->id }}</td>
                        <td class="p-4">{{ date('d/m/Y', strtotime($ticket->day_used)) }}</td>
                        <td class="p-4 font-bold">{{ $ticket->price }}€</td>
                        <td class="p-4"><span class="px-2 py-1 bg-gray-200 rounded text-xs uppercase">{{ $ticket->type }}</span></td>
                        <td class="p-4 text-center">
                            <span class="text-green-600 text-sm font-medium">● Activo</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-500">
                            ❌ No se encontraron tickets para <strong>{{ request('email') ?? $email }}</strong> en la fecha seleccionada.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if(count($tickets) > 0)
            <div class="p-6 bg-gray-50 flex flex-wrap gap-4 border-t items-center justify-between">
                <p class="text-sm text-gray-600 italic">Se han encontrado {{ count($tickets) }} tickets asociados.</p>

                <div class="flex gap-3">
                    <form action="{{ route('reclamaciones.reenviar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition flex items-center gap-2">
                            📧 Reenviar al Cliente
                        </button>
                    </form>

                    <form action="{{ route('reclamaciones.cancelar', ['fecha' => $fecha, 'email' => $email]) }}" method="POST"
                        onsubmit="return confirm('¿Estás seguro? Esta acción eliminará los tickets y liberará el cupo para otros visitantes.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition flex items-center gap-2">
                            🗑️ Cancelar Todo
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</body>

</html>