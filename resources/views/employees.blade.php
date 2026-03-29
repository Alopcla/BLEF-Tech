<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | Zoo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen font-sans text-slate-800">

    <header class="bg-gradient-to-r from-blue-900 to-indigo-800 shadow-lg text-white sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-3">
                <i class="fa-solid fa-paw text-2xl text-blue-300"></i>
                <h1 class="text-2xl font-black tracking-tight">Zoo<span class="text-blue-300">Admin</span></h1>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:block text-sm font-medium bg-blue-800/50 px-4 py-2 rounded-full border border-blue-700/50">
                    <i class="fa-solid fa-circle text-emerald-400 text-[10px] mr-1"></i> Sistema Operativo
                </div>

                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="text-sm font-bold bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition-colors shadow-md flex items-center gap-2">
                        <i class="fa-solid fa-right-from-bracket"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </header>

    <nav class="bg-white border-b border-slate-200 shadow-sm sticky top-[72px] z-30">
        <div class="max-w-7xl mx-auto px-6 py-3 flex items-center gap-4 overflow-x-auto whitespace-nowrap">
            <span class="text-xs font-extrabold text-slate-400 uppercase tracking-wider mr-2">
                <i class="fa-solid fa-diamond-turn-right mr-1"></i> Ir a panel de:
            </span>

            <a href="/panel-medico" class="px-4 py-1.5 rounded-full text-sm font-bold bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 transition">
                <i class="fa-solid fa-user-doctor mr-1"></i> Médico
            </a>
            <a href="/panel-cuidador" class="px-4 py-1.5 rounded-full text-sm font-bold bg-amber-50 text-amber-700 hover:bg-amber-100 border border-amber-200 transition">
                <i class="fa-solid fa-leaf mr-1"></i> Cuidador
            </a>
            <a href="/panel-mantenimiento" class="px-4 py-1.5 rounded-full text-sm font-bold bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-300 transition">
                <i class="fa-solid fa-screwdriver-wrench mr-1"></i> Mantenimiento
            </a>
            <a href="/panel-guia" class="px-4 py-1.5 rounded-full text-sm font-bold bg-sky-50 text-sky-700 hover:bg-sky-100 border border-sky-200 transition">
                <i class="fa-solid fa-map-location-dot mr-1"></i> Guía
            </a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 mt-6">
        @if (session('success'))
            <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-lg shadow-md animate-pulse" role="alert">
                <p class="font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i> ¡Operación exitosa!
                </p>
                <p class="text-sm mt-1 ml-7">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-lg shadow-md" role="alert">
                <p class="font-bold flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-red-600 text-lg"></i> Revisa los siguientes errores:
                </p>
                <ul class="list-disc list-inside text-sm mt-2 space-y-1 ml-7">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 xl:grid-cols-12 gap-10">

        <aside class="xl:col-span-4">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden sticky top-36">
                <div class="bg-slate-800 px-6 py-4">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-blue-400"></i> Alta de Nuevo Empleado
                    </h2>
                    <p class="text-slate-300 text-xs mt-1">Rellena los datos para generar su ficha y acceso.</p>
                </div>

                <form action="{{ route('employees.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">DNI / Pasaporte</label>
                        <input type="text" name="dni" value="{{ old('dni') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" required placeholder="Ej: 12345678A">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Nombre</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition-shadow" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Apellidos</label>
                            <input type="text" name="surname" value="{{ old('surname') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition-shadow" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Correo Electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition-shadow" required placeholder="correo@zoo.com">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Fecha de Nacimiento</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition-shadow text-slate-600" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Dirección Completa</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition-shadow" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Provincia</label>
                            <input type="text" name="province" value="{{ old('province') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition-shadow" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Teléfono Principal</label>
                            <input type="text" name="number" value="{{ old('number') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition-shadow" required>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mt-2">
                        <div class="mb-3">
                            <label class="block text-xs font-bold text-blue-800 uppercase tracking-wider mb-1">Puesto de Trabajo</label>
                            <select name="position" class="w-full border border-blue-200 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="" disabled {{ old('position') ? '' : 'selected' }}>Selecciona un rol...</option>
                                <option value="Administrador" {{ old('position') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                <option value="Guía" {{ old('position') == 'Guía' ? 'selected' : '' }}>Guía</option>
                                <option value="Mantenimiento" {{ old('position') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                <option value="Cuidador" {{ old('position') == 'Cuidador' ? 'selected' : '' }}>Cuidador</option>
                                <option value="Médico" {{ old('position') == 'Médico' ? 'selected' : '' }}>Médico</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-blue-800 uppercase tracking-wider mb-1">Zona Asignada</label>
                            <select name="zone_id" class="w-full border border-blue-200 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="" disabled {{ old('zone_id') ? '' : 'selected' }}>Asignar a una zona...</option>
                                @foreach($zones as $zone)
                                    <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>{{ $zone->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex justify-center items-center gap-2 mt-4">
                        <i class="fa-solid fa-floppy-disk"></i> Registrar Empleado
                    </button>
                </form>
            </div>
        </aside>

        <section class="xl:col-span-8">
            <div class="flex justify-between items-end mb-6 border-b border-slate-200 pb-4">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-800">Directorio de Plantilla</h2>
                    <p class="text-slate-500 text-sm mt-1">Gestiona los permisos, datos y roles de los trabajadores activos.</p>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-indigo-100 text-indigo-800 font-bold px-3 py-1 rounded-full text-sm">
                        <i class="fa-solid fa-users mr-1"></i> Total: {{ $employees->count() }}
                    </span>
                </div>
            </div>

            <div class="bg-white p-3 rounded-xl shadow-sm border border-slate-100 mb-6 flex flex-wrap items-center gap-4 text-xs font-semibold text-slate-600">
                <span class="uppercase tracking-wider text-slate-400 mr-2">
                    <i class="fa-solid fa-circle-info mr-1"></i> Leyenda:
                </span>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-fuchsia-500 shadow-sm"></span> Administrador</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-emerald-500 shadow-sm"></span> Médico</div>
                <div class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-500 shadow-sm"></span> Cuidador</div>
                <div class="flex items
