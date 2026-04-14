<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - BLR Zoo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="auth-wrapper">
        
        {{-- Columna Izquierda (Formulario) --}}
        <div class="auth-column-left">
            
            <div class="w-full max-w-sm px-4">
                {{-- Logo --}}
                <div class="logo-container">
                    <img src="{{ asset('LOGO.PNG') }}" alt="Logo BLR Zoo">
                </div>

                <h1 class="auth-title">Nueva Contraseña</h1>
                <p class="auth-subtitle">Establece una contraseña segura para volver a disfrutar de BLR Zoo.</p>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    {{-- Email (A menudo viene precargado desde el enlace) --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Confirmar Correo</label>
                        <input type="email" id="email" name="email" 
                               class="form-input @error('email') is-invalid @enderror" 
                               value="{{ old('email', $request->email) }}" 
                               required autocomplete="email">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nueva Password --}}
                    <div class="form-group">
                        <label for="password" class="form-label">Nueva contraseña</label>
                        <input type="password" id="password" name="password" 
                               class="form-input @error('password') is-invalid @enderror" 
                               placeholder="Mínimo 8 caracteres" required autocomplete="new-password" autofocus>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar Password --}}
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="form-input" placeholder="Repite la contraseña" required autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn-submit mt-4">
                        Actualizar contraseña
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-stone-500 font-medium hover:text-emerald-700 transition-colors">
                        ¿Recordaste tu clave? Inicia sesión
                    </a>
                </div>
            </div>
        </div>

        {{-- Columna Derecha --}}
        <div class="auth-column-right">
            <img src="{{ asset('fondo2.jpg') }}" class="auth-image" alt="Renovación BLR Zoo">
            <div class="auth-overlay"></div>
            <div class="auth-caption">
                <h2 class="text-3xl font-bold font-playfair mb-2">Renueva tu energía</h2>
                <p class="text-white/80 font-light italic">"Un nuevo comienzo para seguir explorando el mundo salvaje."</p>
            </div>
        </div>
    </div>
</body>
</html>