<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keeper Panel - Zoo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-10 bg-blue-50">
    <div class="max-w-6xl mx-auto">

        <!-- Botón de Cerrar Sesión -->
        <div class="flex justify-end mb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition font-bold">
                    🚪 Sign Out
                </button>
            </form>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md border-t-4 border-blue-500">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">🩺 Panel de Guía</h1>
            <p class="text-gray-600 mb-6">Bienvenido, Cuidador. Aquí gestionaremos las diferentes dietas y cuidados de nuestros queridos animales.</p>

            <div class="p-4 bg-yellow-100 text-yellow-800 rounded">
                <p>🚧 Módulo en construcción.</p>
            </div>
        </div>

    </div>
</body>
</html>
