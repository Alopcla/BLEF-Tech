<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Componentes de Empleados</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-10 bg-gray-100">
    <div class="max-w-6xl mx-auto">

        <div class="flex justify-end mb-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition font-bold">
                    🚪 Cerrar Sesión
                </button>
            </form>
        </div>

        <h1 class="text-3xl font-bold mb-8 text-gray-800">Gestion de Empleados</h1>
        <!-- Botones de navegación exclusivos del Administrador -->
        <div class="mb-8 flex flex-wrap gap-4">
            <a href="{{ route('medico.dashboard') }}"
                class="bg-teal-600 text-white px-4 py-2 rounded shadow hover:bg-teal-700 transition">
                🩺 Ir a Panel Médico
            </a>
            <a href="{{ route('guia.dashboard') }}"
                class="bg-orange-500 text-white px-4 py-2 rounded shadow hover:bg-orange-600 transition">
                🗺️ Ir a Panel Guía
            </a>
            <a href="{{ route('mantenimiento.dashboard') }}"
                class="bg-gray-600 text-white px-4 py-2 rounded shadow hover:bg-gray-700 transition">
                🛠️ Ir a Panel Mantenimiento
            </a>
            <a href="{{ route('cuidador.dashboard') }}"
                class="bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 transition">
                🥩 Ir a Panel Cuidador
            </a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md mb-10 border-t-4 border-green-500">
            <h2 class="text-xl font-bold mb-4">Registrar nuevo empleado</h2>

            <form action="{{ route('employees.store') }}" method="POST" class="flex gap-4">
                @csrf
                <div class="flex-1">
                    <input type="text" name="dni" placeholder="DNI" class="border p-2 rounded" required>
                    <input type="text" name="name" placeholder="Nombre del empleado" class="border p-2 rounded"
                        required>
                    <input type="text" name="surname" placeholder="Apellidos del empleado" class="border p-2 rounded"
                        required>
                    <input type="email" name="email" placeholder="Correo electronico" class="border p-2 rounded"
                        required>
                    <input type="date" name="birth_date" class="border p-2 rounded" required>
                    <input type="text" name="number" placeholder="Telefono" class="border p-2 rounded" required>
                    <input type="text" name="address" placeholder="Direccion" class="border p-2 rounded" required>
                    <input type="text" name="province" placeholder="Provincia" class="border p-2 rounded" required>
                    <!-- Campo para elegir el puesto de trabajo -->
                    <select name="position" class="border p-2 rounded w-full mt-2" required>
                        <option value="" disabled selected>Selecciona el puesto del empleado...</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Médico">Médico Veterinario</option>
                        <option value="Guía">Guía</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                        <option value="Cuidador">Cuidador</option>
                    </select>

                    <!-- Menu despegable de las zonas traido desde EmployeeController -->
                    <select name="zone_id"
                        class="border-gray-300 focus:border-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                        <option value="" disabled selected>Selecciona la zona asignada...</option>

                        @foreach ($zones as $zone)
                            <option value="{{ $zone->id }}">{{ $zone->type }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Guardar empleado
                </button>
            </form>

            @if(session('success'))
                <p class="mt-3 text-green-600 font-semibold">{{ session('success') }}</p>
            @endif

        </div>

    </div>

    {{-- Formulario para ingresar a empleados --}}



    {{-- Listado de los empleados con sus respectivos telefonos --}}
    <h1 class="text-2xl font-bold mb-5">Mi primer componente:</h1>

    <div class="grid grid-cols-1 md:grid-cols3 gap-4">
        @foreach ($employees as $employee)
            {{-- Esto es un comentario...
            Se usa " : " antes de los atributos para pasar variables de PHP.
            Para que no explote, utilizaremos el operador en caso de que un empleado
            no tenga telefono --}}
            <x-user-card :employee="$employee" />
        @endforeach
    </div>



</body>

</html>
