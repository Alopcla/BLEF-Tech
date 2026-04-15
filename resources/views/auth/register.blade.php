<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - BLR Zoo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="auth-wrapper">
        
        {{-- Columna Izquierda (Formulario) --}}
        <div class="auth-column-left">
            
            {{-- Botón Volver --}}
            <a href="{{ url('/') }}" class="back-home-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al inicio
            </a>

            <div class="w-full max-w-md px-4">
                {{-- Logo --}}
                <div class="logo-container">
                    <img src="{{ asset('LOGO.PNG') }}" alt="Logo BLR Zoo">
                </div>

                <h1 class="auth-title">Crear cuenta</h1>
                <p class="auth-subtitle">Únete a la comunidad de BLR Zoo y ayuda a la conservación.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nombre --}}
                    <div class="form-group">
                        <label for="name" class="form-label">Nombre completo</label>
                        <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="Tu nombre" required autofocus>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="correo@ejemplo.com" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Grid para Contraseñas (Dos columnas en pantallas grandes) --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-group mb-0">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror" 
                                   placeholder="••••••••" required>
                        </div>
                        <div class="form-group mb-0">
                            <label for="password_confirmation" class="form-label">Confirmar</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" 
                                   placeholder="••••••••" required>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mb-4">{{ $message }}</p>
                    @enderror

                    <button type="submit" class="btn-submit mt-2">Crear mi cuenta</button>
                </form>

                <p class="mt-8 text-center text-sm text-gray-500">
                    ¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="text-green-700 font-semibold hover:underline">Inicia sesión</a>
                </p>
            </div>
        </div>

        {{-- Columna Derecha (Imagen/Carrusel) --}}
        <div class="auth-column-right">
            {{-- Usamos una sola imagen para mantener la limpieza, o puedes reinsertar el carrusel aquí --}}
            <img src="{{ asset('fondo2.jpg') }}" class="auth-image" alt="BLR Zoo">
            <div class="auth-overlay"></div>
            <div class="auth-caption">
                <h2 class="text-3xl font-bold font-playfair mb-2 italic">"La naturaleza no es un lugar que visitar, es el hogar."</h2>
                <p class="text-white/80 font-light">Sé parte del cambio en BLR Zoo.</p>
            </div>
        </div>
    </div>
</body>
</html>