<!-- A pesar de que el archivo 'welcome.blade.php',
 originalmente el codigo que contiene es el index.html que
 realizo Gonzalo Falcon.

 Los distintos cambios a realizar son los que estan comentados, justo abajo
 del comentario. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zoologico</title>
    <!-- En el href, se utiliza la funcion de Laravel (asset), sirve para archivos fisicos(imagenes, CSS, videos).
     Automaticamente buscara en las carpetas correspondientes. En este caso la ruta seria ' public/css/style.css ' -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="main.js" defer></script>
    <!-- Obligatorio estas dos lineas de codigo para trabajar con React.
    Si en otra pagina no habria componentes de React, no es necesario añadir dichas lineas. -->
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
</head>

<body>
    <video class="video-background" autoplay muted loop>
        <!-- Archivo fisico (video.mp4), por lo tanto, funcion asset -->
        <source src="{{ asset('Video.mp4') }}" type="video/mp4">
    </video>
    <header>
        <div class="barra-tiempo" id="temperatura"></div>
        <div class="barra-navegacion">

            <!-- De la misma forma con el logo del zoo. Al ser en la carpeta public,
             no es necesario indicar la ruta, solamente nombrar el archivo -->
            <img src="{{ asset('LOGO.PNG') }}" alt="Logo_del_zoologico">
            <button class="abrir-menu" id="abrir"><i class="bi bi-list"></i></button>
            <nav id="nav">
                <button class="cerrar-menu" id="cerrar"><i class="bi bi-x-lg"></i></button>
                <div class="navegacion-flex">
                    <a href="#">Inicio</a>
                    <a href="#">Tickets</a>
                    <a href="#">Experiencias</a>
                    <a href="#seccion-animales">Animales</a>
                    <a href="#">Tienda</a>
                    <a href="#">Contacto</a>
                    <!-- En cuanto a la redireccion a otra pagina, seria otra funcion distinta.
                    Dicha funcion es... url()
                    Para ello, en el archivo routes/web.php, definiriamos una funcion la cual
                    nos llevaria a dicha pagina -->
                    <a href="{{ route('login') }}">
                        <button name="iniciar-sesion" class="iniciar-sesion">Iniciar Sesion</button>
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <footer>
        <div class="redes-sociales">
            <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com" target="_blank"><i class="fab fa-youtube"></i></a>
        </div>
    </footer>
    <div id="seccion-animales" style="min-height: 500px; padding: 50px;">
    </div>
</body>

</html>
