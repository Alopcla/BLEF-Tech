<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - BLR Zoo</title>
    <!--   -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!--   -->
    <link rel="stylesheet" href="{{ asset('style-loginv2.css') }}">
    <script src="https://accounts.google.com/gsi/client" defer></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-5 izq-column">
                <div class="form-container">
                    <!--   -->
                    <img src="{{ asset('LOGO.PNG') }}" class="logo" alt="Logo BLR Zoo">
                    <h3>Iniciar Sesión</h3>
                    <p class="description">
                        Bienvenido de nuevo. Ingresa tus credenciales para acceder a tu cuenta.
                    </p>

                    <form>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario o Correo</label>
                            <input type="text" class="form-control" id="usuario"
                                placeholder="Nombre de usuario o correo" required>
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" placeholder="Tu contraseña"
                                required>
                        </div>

                        <div class="forgot-password">
                            <!-- Se define la url, cuyo nombre saldra al final de la URL.
                            En routes/web.php definiremos la funcion -->
                            <a href="{{ url('/recover-password') }}">¿Has olvidado tu contraseña?</a>
                        </div>

                        <button type="submit">
                            Continuar
                        </button>
                    </form>

                    <div class="separador">
                        <span>o</span>
                    </div>

                    <div class="login-google">
                        <div id="g_id_onload" data-client_id="TU_CLIENT_ID_AQUI"
                            data-callback="handleCredentialResponse"></div>
                        <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                            data-text="signin_with" data-shape="pill"></div>
                    </div>

                    <div class="register-link">
                        <!-- URL para direccionar a la pagina Registro -->
                        <a href="{{ url('/register') }}">¿No tienes cuenta? Crear una</a>
                    </div>
                </div>
            </div>

            <div class="col-md-7 der-column d-none d-md-flex p-0">
                <div class="carousel-container">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"
                        data-bs-interval="4000">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                class="active"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators"
                                data-bs-slide-to="2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <!-- Funcion de Laravel para indicar la ruta de la imagen -->
                                <img src="{{ asset('fondo.jpg') }}" class="d-block w-100" alt="Imagen 1">
                            </div>
                            <div class="carousel-item">
                                <!-- Funcion de Laravel para indicar la ruta de la imagen -->
                                <img src="{{ asset('fondo2.jpg') }}" class="d-block w-100" alt="Imagen 2">
                            </div>
                            <div class="carousel-item">
                                <!-- Funcion de Laravel para indicar la ruta de la imagen -->
                                <img src="{{ asset('fondo3.jpg') }}" class="d-block w-100" alt="Imagen 3">
                            </div>
                        </div>
                        <div class="info-overlay">
                            <h5>BLR Zoo</h5>
                            <p>
                                Conecta con la naturaleza. Descubre especies fascinantes y aprende sobre la conservación
                                de la vida silvestre.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
