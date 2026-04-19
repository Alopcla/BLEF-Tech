<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Email - BLR Zoo</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite(['resources/css/app.css'])
</head>

<body>
    <div class="auth-wrapper">
        
        {{-- Columna Izquierda (Mensaje) --}}
        <div class="auth-column-left">
            
            <div class="w-full max-w-md px-4">
                {{-- Logo --}}
                <div class="logo-container">
                    <img src="{{ asset('LOGO.PNG') }}" alt="Logo BLR Zoo">
                </div>

                <h1 class="auth-title">Introduce el código</h1>
                <p class="auth-subtitle">Te hemos enviado un código de 6 dígitos a tu correo. Introdúcelo para continuar.</p>

                {{-- Mensaje de reenvío exitoso --}}
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 text-sm flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span>Se ha enviado un nuevo enlace de verificación a tu correo.</span>
                    </div>
                @endif

                <div class="space-y-4">
                    {{-- Errores --}}
                    @if ($errors->any())
                        <p class="text-red-500 text-sm text-center">{{ $errors->first() }}</p>
                    @endif

                    {{-- Formulario código --}}
                    <form method="POST" action="{{ route('verification.code') }}">
                        @csrf
                        <input type="text" name="code" maxlength="6"
                            class="form-input text-center text-2xl tracking-[1rem] font-bold mb-4"
                            placeholder="······" autofocus required>
                        <button type="submit" class="btn-submit">Verificar</button>
                    </form>

                    {{-- Reenviar --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="text-sm text-stone-400 hover:text-emerald-400 transition-colors underline underline-offset-4">
                            Reenviar código
                        </button>
                    </form>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-sm text-stone-400 hover:text-red-600 transition-colors underline underline-offset-4">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Columna Derecha --}}
        <div class="auth-column-right">
            <img src="{{ asset('fondo3.jpg') }}" class="auth-image" alt="Naturaleza BLR Zoo">
            <div class="auth-overlay"></div>
            <div class="auth-caption">
                <h2 class="text-3xl font-bold font-playfair mb-2 tracking-tight">Casi hemos terminado</h2>
                <p class="text-white/80 font-light italic">"Un último paso para sumergirte en la experiencia BLR Zoo."</p>
            </div>
        </div>
    </div>
</body>
</html>