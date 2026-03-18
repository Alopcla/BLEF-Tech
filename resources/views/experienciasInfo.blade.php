<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $experiencias->name }} - Zoológico</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="font-sans text-white bg-black">

<video autoplay muted loop class="fixed w-full h-full object-cover -z-10">
    <source src="{{ asset('video.mp4') }}" type="video/mp4">
</video>
<div class="fixed inset-0 bg-black/60 -z-10"></div>

<header class="flex justify-center pt-8 px-6">
    <div class="flex items-center gap-8 bg-black/40 backdrop-blur-md px-6 py-3 rounded-full border border-white/20">
        <img src="{{ asset('logo.png') }}" class="w-10">
        <nav class="flex gap-5">
            <a href="/" class="hover:text-amber-300">Inicio</a>
            <a href="/experienciass" class="text-amber-300">experiencias</a>
            <a href="#" class="hover:text-amber-300">Contacto</a>
        </nav>
    </div>
</header>

<main class="max-w-6xl mx-auto mt-12 px-6">
    
    <div class="grid lg:grid-cols-2 gap-10">
        
        <div>
            <img src="{{ $experiencias->image }}" class="w-full h-[400px] object-cover rounded-2xl border border-white/20 shadow-xl">
            
            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-black/40 p-4 rounded-xl border border-white/10 text-center">
                    <p class="text-gray-400 text-sm">Duración</p>
                    <p class="text-xl font-bold">{{ $experiencias->duration_min }} min</p>
                </div>
                <div class="bg-black/40 p-4 rounded-xl border border-white/10 text-center">
                    <p class="text-gray-400 text-sm">Capacidad</p>
                    <p class="text-xl font-bold">{{ $experiencias->ability }} pers.</p>
                </div>
            </div>
        </div>

        <div class="bg-black/40 p-8 rounded-2xl border border-white/10">
            <h1 class="text-4xl font-bold mb-4">{{ $experiencias->name }}</h1>
            
            <p class="text-amber-300 text-lg font-medium mb-6">
                {{ $experiencias->description }}
            </p>

            <div class="text-gray-200 space-y-4 leading-relaxed">
                <h3 class="text-xl font-semibold text-white">Descripción detallada</h3>
                <p>{{ $experiencias->details }}</p>
            </div>

            <div class="mt-10 flex items-center justify-between bg-white/5 p-6 rounded-xl">
                <div>
                    <p class="text-gray-400 text-sm">Precio total</p>
                    <p class="text-3xl font-bold text-amber-300">{{ $experiencias->price }} €</p>
                </div>
                <button class="bg-amber-300 text-green-900 px-8 py-3 rounded-full font-bold hover:bg-amber-200 transition">
                    Reservar
                </button>
            </div>
        </div>

    </div>
</main>

<footer class="mt-20 py-10 text-center text-gray-500">
    <p>© {{ date('Y') }} Zoológico. Todos los derechos reservados.</p>
</footer>

</body>
</html>