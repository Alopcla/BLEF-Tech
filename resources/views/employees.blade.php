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
        <h1 class="text-3xl font-bold mb-8 text-gray-800">Gestion de Empleados</h1>

        <div class="bg-white p-6 rounded-lg shadow-md mb-10 border-t-4 border-green-500">
            <h2 class="text-xl font-bold mb-4">Registrar nuevo empleado</h2>

            <form action="{{ route('employees.store') }}" method="POST" class="flex gap-4">
                @csrf
                <div class="flex-1">
                    <input type="text" name="DNI" placeholder="DNI" class="border p-2 rounded" required>
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
