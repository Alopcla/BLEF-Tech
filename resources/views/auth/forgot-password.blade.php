<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - BLR Zoo</title>
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

            <div class="w-full max-w-sm px-4">
                {{-- Logo --}}
                <div class="logo-container">
                    <img src="{{ asset('LOGO.PNG') }}" alt="Logo BLR Zoo">
                </div>

                <h1 class="auth-title">¿Contraseña olvidada?</h1>
                <p class="auth-subtitle">No te preocupes. Introduce tu email y te enviaremos un enlace para recuperarla.</p>

                {{-- Mensaje de éxito (Status) --}}
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Se ha enviado el enlace de recuperación a tu correo.</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" id="email" name="email" 
                               class="form-input @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" 
                               placeholder="correo@ejemplo.com" required autofocus>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit mt-2">
                        Enviar instrucciones
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-stone-500 font-medium hover:text-emerald-700 transition-colors inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        Volver al inicio de sesión
                    </a>
                </div>
            </div>
        </div>

        {{-- Columna Derecha --}}
        <div class="auth-column-right">
            <img src="{{ asset('fondo3.jpg') }}" class="auth-image" alt="Naturaleza BLR Zoo">
            <div class="auth-overlay"></div>
            <div class="auth-caption">
                <h2 class="text-3xl font-bold font-playfair mb-2">Seguridad ante todo</h2>
                <p class="text-white/80 font-light">Protegemos tu acceso para que solo te preocupes de disfrutar del zoo.</p>
            </div>
        </div>
    </div>
</body>
</html>