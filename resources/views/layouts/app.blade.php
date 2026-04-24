<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.12.74/build/spline-viewer.js"></script>

    <title>@yield('title', 'Park Zoo')</title>

    @vite(['resources/css/app.css'])
    @stack('styles')
</head>
<body class="font-sans antialiased text-white flex flex-col min-h-screen">

    @if(trim($__env->yieldContent('video')) !== 'false')
        <video autoplay muted loop playsinline class="fixed w-full h-full object-cover -z-10">
            <source src="{{ asset('video.mp4') }}" type="video/mp4">
        </video>
        <div class="fixed inset-0 bg-black/50 -z-10"></div>
    @endif

    @include('layouts.partials.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @stack('scripts')

</body>
</html>