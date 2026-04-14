<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Contraseña - BLR Zoo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="auth-wrapper">
        
        {{-- Columna Izquierda (Seguridad) --}}
        <div class="auth-column-left">
            
            {{-- Botón Volver --}}
            <a href="{{ url('/') }}" class="back-home-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al inicio
            </a>

            <div class="w-full max-w-sm px-4">
                {{-- Logo --}}
                <div class="logo-container">
                    <img src="{{ asset('LOGO.PNG') }}" alt="Logo BLR Zoo">
                </div>

                <h1 class="auth-title">Área Segura</h1>
                <p class="auth-subtitle">Esta es una zona protegida. Por favor, confirma tu contraseña antes de continuar.</p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password" 
                               class="form-input @error('password') is-invalid @enderror" 
                               placeholder="••••••••" required autocomplete="current-password" autofocus>
                        
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit mt-4">
                        Confirmar acceso
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-xs text-stone-400 italic">
                        Si no recuerdas tu contraseña, contacta con administración.
                    </p>
                </div>
            </div>
        </div>

        {{-- Columna Derecha --}}
        <div class="auth-column-right">
            <img src="{{ asset('fondo.jpg') }}" class="auth-image" alt="Seguridad BLR Zoo">
            <div class="auth-overlay"></div>
            <div class="auth-caption">
                <h2 class="text-3xl font-bold font-playfair mb-2 tracking-tight">Acceso Restringido</h2>
                <p class="text-white/80 font-light italic">"La seguridad de nuestros datos es tan importante como la de nuestras especies."</p>
            </div>
        </div>
    </div>
</body>
</html>