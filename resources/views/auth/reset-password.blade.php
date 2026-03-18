<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - BLR Zoo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row h-100">
            <div class="col-md-5 izq-column">
                <div class="form-container">
                    <img src="{{ asset('LOGO.PNG') }}" class="logo" alt="Logo BLR Zoo">

                    <h3>Nueva Contraseña</h3>
                    <p class="description">
                        Introduce tu nueva contraseña. Debe tener al menos 8 caracteres.
                    </p>

                    <!-- POST a 'password.store' → NewPasswordController@store -->
                    <!-- Valida el token y actualiza la columna 'password' en la tabla users -->
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Token oculto que Laravel usa para validar que el enlace del email es válido -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <div class="mb-3">
                            <!-- name="email" → identifica al usuario en la tabla users -->
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email', request()->email) }}"
                                placeholder="correo@ejemplo.com"
                                autocomplete="email"
                                required
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <!-- name="password" → nueva contraseña que se hasheará y guardará en users -->
                            <label for="password" class="form-label">Nueva contraseña</label>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Mínimo 8 caracteres"
                                autocomplete="new-password"
                                required
                            >
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <!-- name="password_confirmation" → Laravel valida que coincide con password -->
                            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Repite la contraseña"
                                autocomplete="new-password"
                                required
                            >
                        </div>

                        <button type="submit">Guardar Contraseña</button>
                    </form>

                    <div class="back-link mt-3">
                        <!-- Ruta 'login' → vuelve a loginv2.blade.php -->
                        <a href="{{ route('login') }}">← Volver al inicio de sesión</a>
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
                                <img src="{{ asset('fondo.jpg') }}" class="d-block w-100" alt="Imagen 1">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('fondo2.jpg') }}" class="d-block w-100" alt="Imagen 2">
                            </div>
                            <div class="carousel-item">
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