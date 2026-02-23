<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - BLR Zoo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('style-registerv2.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-5 izq-column">
                <div class="form-container">
                    <!-- Funcion de Laravel para indicar la ruta de la imagen -->
                    <img src="{{ asset('LOGO.PNG') }}" class="logo" alt="Logo BLR Zoo">
                    <h3>Registrarse</h3>
                    <p class="description">
                        Crea tu cuenta y comienza a disfrutar de todas las ventajas de BLR Zoo.
                    </p>

                    <form>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" placeholder="Tu nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="apellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" placeholder="Tus apellidos"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" id="dni" placeholder="12345678X" required>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" placeholder="600 123 456" required>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="email" placeholder="correo@ejemplo.com"
                                required>
                        </div>

                        <div class="mb-2">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" placeholder="Tu dirección completa"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena"
                                placeholder="Crea una contraseña segura" required>
                        </div>

                        <button type="submit">
                            Continuar
                        </button>
                    </form>

                    <div class="login-link">
                        <!-- Funcion de Laravel para indicar la Vista para el Login -->
                        <a href="{{ url('/login') }}">¿Ya tienes cuenta? Inicia sesión</a>
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
