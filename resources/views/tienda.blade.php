<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda — BLR Zoo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    {{-- CSS propio de la tienda (fondo + navbar) --}}
    <link rel="stylesheet" href="{{ asset('css/tienda.css') }}">

    {{-- Iconos --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Vite: Tailwind + React --}}
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/tienda.jsx'])
</head>
<body>

    <header>
        <div class="barra-navegacion">
            <a href="/"><img src="{{ asset('LOGO.PNG') }}" alt="Logo BLR Zoo"></a>
            <button class="abrir-menu" id="abrir"><i class="bi bi-list"></i></button>
            <nav id="nav">
                <button class="cerrar-menu" id="cerrar"><i class="bi bi-x-lg"></i></button>
                <div class="navegacion-flex">
                    <a href="/">Inicio</a>
                    <a href="{{ route('payment.show') }}">Tickets</a>
                    <a href="{{ route('VistaExperiencias') }}">Experiencias</a>
                    <a href="/#seccion-animales">Animales</a>
                    <a href="{{ route('tienda') }}" class="activo">Tienda</a>
                    <a href="#">Contacto</a>
                    <a href="{{ route('login') }}">
                        <button class="iniciar-sesion">Iniciar Sesión</button>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    {{-- React monta aquí --}}
    <div id="tienda-root"></div>

    <footer>
        <div class="redes-sociales">
            <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
    </footer>

    {{-- Script del menú hamburguesa --}}
    <script>
        const abrir = document.getElementById('abrir');
        const cerrar = document.getElementById('cerrar');
        const nav = document.getElementById('nav');

        abrir?.addEventListener('click', () => nav.classList.add('visible'));
        cerrar?.addEventListener('click', () => nav.classList.remove('visible'));
    </script>

</body>
</html>