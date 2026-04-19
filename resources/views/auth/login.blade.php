<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite(['resources/css/app.css'])
</head>

<body>

    <div class="auth-wrapper">
        {{-- Columna Izquierda --}}
        <div class="auth-column-left">

            <a href="{{ url('/') }}" class="back-home-btn">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
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