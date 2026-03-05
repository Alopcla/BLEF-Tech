<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiencias - Zoológico</title>

    <!-- Tailwind CDN (modo principiante) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            padding-bottom: 100px;
        }
    </style>
</head>

<body class="relative font-sans">

    <!-- VIDEO FONDO -->
    <video autoplay muted loop class="fixed top-0 left-0 w-full h-full object-cover -z-10">
        <source src="{{ asset('Video.mp4') }}" type="video/mp4">
    </video>

    <!-- HEADER -->
    <header class="flex justify-center items-center mt-10 px-6">
        <div class="flex items-center gap-10 bg-black/40 backdrop-blur-md px-6 py-4 rounded-2xl shadow-lg">

            <img src="{{ asset('LOGO.PNG') }}" class="w-14 h-14">

            <nav class="hidden md:flex gap-8 text-[#D9C8A1] text-xl">
                <a href="/" class="hover:bg-[#D9C8A1] hover:text-[#3A6B35] px-4 py-2 rounded-full transition">Inicio</a>
                <a href="#"
                    class="hover:bg-[#D9C8A1] hover:text-[#3A6B35] px-4 py-2 rounded-full transition">Tickets</a>
                <a href="{{route('VistaExperiencias')}}"
                    class="hover:bg-[#D9C8A1] hover:text-[#3A6B35] px-4 py-2 rounded-full transition">Experiencias</a>
                <a href="#seccion-animales"
                    class="hover:bg-[#D9C8A1] hover:text-[#3A6B35] px-4 py-2 rounded-full transition">Animales</a>
                <a href="#" class="hover:bg-[#D9C8A1] hover:text-[#3A6B35] px-4 py-2 rounded-full transition">Tienda</a>
                <a href="#"
                    class="hover:bg-[#D9C8A1] hover:text-[#3A6B35] px-4 py-2 rounded-full transition">Contacto</a>
                <a href="{{ route('login') }}">
                    <button class="bg-[#D9C8A1] text-[#3A6B35] px-5 py-2 rounded-full hover:bg-[#3A6B35] hover:text-[#D9C8A1] transition">
                        Iniciar Sesión
                    </button>
                </a>
            </nav>


        </div>
    </header>

    <!-- HERO -->
    <section class="text-center mt-32 px-5">
        <h1 class="text-5xl md:text-6xl text-[#D9C8A1] font-bold drop-shadow-lg mb-5">
            Experiencias Únicas
        </h1>
        <p class="text-xl text-[#D9C8A1] drop-shadow-md">
            Vive momentos inolvidables con nuestros animales
        </p>
    </section>

    <!-- GRID EXPERIENCIAS -->
    <section class="max-w-6xl mx-auto mt-16 px-5 grid md:grid-cols-2 lg:grid-cols-3 gap-8">

        @foreach($experiencias as $exp)

            <div
                class="bg-black/70 backdrop-blur-md rounded-2xl overflow-hidden shadow-lg border border-[#D9C8A1]/30 hover:-translate-y-2 hover:shadow-2xl transition duration-300">

                <!-- Imagen -->
                <img src="{{ $exp->imagen }}" class="w-full h-60 object-cover">

                <!-- Contenido -->
                <div class="p-6">

                    <h3 class="text-2xl text-[#D9C8A1] mb-3">
                        {{ $exp->titulo }}
                    </h3>

                    <p class="text-[#D9C8A1] text-sm mb-4">
                        {{ $exp->descripcion }}
                    </p>

                    <div class="flex flex-wrap gap-4 text-sm mb-4 text-[#D9C8A1]">
                        <span><i class="bi bi-clock"></i> {{ $exp->duracion }}</span>
                        <span><i class="bi bi-people"></i> {{ $exp->personas }}</span>
                    </div>

                    <p class="text-[#3A6B35] text-xl mb-4 font-semibold">
                        {{ $exp->precio }} € por persona
                    </p>

                    <button
                        class="w-full bg-[#D9C8A1] text-[#3A6B35] py-2 rounded-full hover:bg-[#3A6B35] hover:text-[#D9C8A1] transition">
                        Reservar
                    </button>

                </div>
            </div>

        @endforeach

    </section>

    <!-- FOOTER -->
    <footer class="fixed bottom-0 w-full bg-[#D9C8A1] py-4">
        <div class="flex justify-center gap-6 text-[#3A6B35] text-xl">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
    </footer>

</body>

</html>
