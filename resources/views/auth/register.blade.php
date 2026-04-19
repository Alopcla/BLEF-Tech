<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - BLR Zoo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite(['resources/css/app.css'])
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
                    
                        {{-- Separador --}}
                    <div class="flex items-center my-4">
                        <hr class="flex-grow border-neutral-700">
                        <span class="mx-3 text-neutral-500 text-xs uppercase">o continúa con</span>
                        <hr class="flex-grow border-neutral-700">
                    </div>

                    {{-- Botón Google --}}
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 w-full py-2.5 px-4 rounded-xl border border-neutral-700 bg-neutral-800 hover:bg-neutral-700 text-white text-sm font-medium transition-colors duration-200">
                        <svg width="18" height="18" viewBox="0 0 48 48">
                            <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                            <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                            <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                            <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            <path fill="none" d="M0 0h48v48H0z" />
                        </svg>
                        Continuar con Google
                    </a>
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