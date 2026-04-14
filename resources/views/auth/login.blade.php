<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<div class="auth-wrapper">
    {{-- Columna Izquierda --}}
    <div class="auth-column-left">
        
        <a href="{{ url('/') }}" class="back-home-btn">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Volver al inicio
        </a>

        <div class="w-full max-w-sm">
            <div class="logo-container">
                <img src="{{ asset('LOGO.PNG') }}" alt="Logo BLR Zoo">
            </div>

            <h1 class="auth-title">Inicia sesión</h1>
            <p class="auth-subtitle">Accede a tu cuenta de BLR Zoo</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-input" placeholder="correo@ejemplo.com" required autofocus>
                </div>

                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="accent-green-700"> Recordarme
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-green-700 hover:underline">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn-submit">Entrar</button>
            </form>

            <p class="mt-8 text-center text-sm text-gray-500">
                ¿Aún no eres parte? <a href="{{ route('register') }}" class="text-green-700 font-semibold hover:underline">Regístrate</a>
            </p>
        </div>
    </div>

    {{-- Columna Derecha --}}
    <div class="auth-column-right">
        <img src="{{ asset('fondo.jpg') }}" class="auth-image" alt="BLR Zoo">
        <div class="auth-overlay"></div>
        <div class="auth-caption">
            <h2 class="text-3xl font-bold font-playfair mb-2">BLR Zoo</h2>
            <p class="text-white/80 font-light">Descubre la vida salvaje como nunca antes.</p>
        </div>
    </div>
</div>

</body>
</html>