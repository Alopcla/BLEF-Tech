<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zoologico - Mapa Interactivo</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="main.js" defer></script>

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    <style>
        body {
            background-color: #1a2622;
            /* Verde bosque muy oscuro */
            background-image: radial-gradient(circle at center, #23332e 0%, #1a2622 100%);
            margin: 0;
            color: white;
        }

        img {
            user-select: none;
            -webkit-user-drag: none;
        }

        /* Personalización del scroll para el popup del mapa */
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #16a34a;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #15803d;
        }

        /* --- NUEVAS REGLAS PARA EL AUTOSCROLL --- */
        @keyframes autoScrollPopup {
            0% {
                transform: translateY(0);
            }

            15% {
                transform: translateY(0);
            }

            /* Ajusta el 250px si ves que el final se corta o sobra mucho espacio */
            85% {
                transform: translateY(calc(-100% + 250px));
            }

            100% {
                transform: translateY(calc(-100% + 250px));
            }
        }

        .animate-scroll {
            display: block;
            /* IMPORTANTE: La animación se aplica al div que envuelve los animales */
            animation: autoScrollPopup 10s linear infinite alternate;
        }

        /* Clase para asegurar que el contenedor padre corte lo que sobresale */
        .overflow-hidden-container {
            overflow: hidden !important;
            position: relative;
        }
    </style>
</head>

<body style="background-color: #1a1a1a;">
    <header>
        <div class="barra-tiempo" id="temperatura"></div>
        <div class="barra-navegacion">
            <img src="{{ asset('LOGO.PNG') }}" alt="Logo_del_zoologico">
            <button class="abrir-menu" id="abrir"><i class="bi bi-list"></i></button>
            <nav id="nav">
                <button class="cerrar-menu" id="cerrar"><i class="bi bi-x-lg"></i></button>
                <div class="navegacion-flex">
                    <a href="/">Inicio</a>
                    <a href="{{route('payment.show')}}">Tickets</a>
                    <a href="{{ route('VistaExperiencias') }}">Experiencias</a>
                    <a href="{{ route('animales') }}">Animales</a>
                    <a href="{{ route('tienda') }}">Tienda</a>
                    <a href="#">Contacto</a>
                    <a href="{{ route('login') }}">
                        <button name="iniciar-sesion" class="iniciar-sesion">Iniciar Sesion</button>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <main style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div id="react-mapa"></div>
    </main>

    <footer>
        <div class="redes-sociales">
            <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
    </footer>
</body>

</html>