<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Experiencias - Zoológico</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'parkzoo': ['Park zoo', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @font-face {
            font-family: 'Park zoo';
            src: url('/fonts/Parkzoo-Regular.woff2') format('woff2'),
                 url('/fonts/Parkzoo-Regular.woff') format('woff');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="font-sans text-white flex flex-col min-h-screen">

<video autoplay muted loop class="fixed w-full h-full object-cover -z-10">
  <source src="{{ asset('video.mp4') }}" type="video/mp4">
</video>
<div class="fixed inset-0 bg-black/50 -z-10"></div>

<header class="flex justify-center pt-8 px-6">
  <div class="flex items-center gap-8 bg-black/40 backdrop-blur-md px-6 py-3 rounded-full shadow-lg border border-white/20">
    <img src="{{ asset('logo.png') }}" class="w-12">
    <nav class="hidden md:flex gap-5 text-lg font-parkzoo items-center">
      <a href="/" class="hover:text-amber-300 transition">Inicio</a>
      <a href="#" class="hover:text-amber-300 transition">Tickets</a>
      <a href="/experiencias" class="hover:text-amber-300 transition">Experiencias</a>
      <a href="#" class="hover:text-amber-300 transition">Animales</a>
      <a href="#" class="hover:text-amber-300 transition">Tienda</a>
      <a href="#" class="hover:text-amber-300 transition">Contacto</a>
      <button class="bg-amber-300 text-green-900 px-4 py-1 rounded-full hover:bg-amber-200 transition font-sans font-bold text-sm uppercase tracking-wider">Login</button>
    </nav>
  </div>
</header>

<main class="flex-grow">
    <section class="text-center mt-20 px-6">
      <h1 class="text-6xl font-parkzoo mb-2 drop-shadow-lg">Experiencias del Zoológico</h1>
      <p class="text-gray-300 max-w-xl mx-auto italic">
        Vive momentos únicos y divertidos con nuestros animales.
      </p>
    </section>

    <section class="max-w-6xl mx-auto mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-6 px-6 mb-20">
      @foreach($experiencias as $exp)
      <div class="bg-black/60 p-4 rounded-xl border border-white/20 shadow-lg hover:scale-105 transition-transform duration-300 backdrop-blur-sm">
        <div class="relative">
          <img src="{{ $exp->image }}" class="w-full h-48 object-cover rounded-lg mb-2">
          <span class="absolute top-2 left-2 bg-amber-300 text-green-900 text-xs font-bold px-2 py-1 rounded-full shadow">
            {{ $exp->type ?? 'General' }}
          </span>
        </div>
        <h3 class="text-xl font-parkzoo text-amber-300">{{ $exp->name }}</h3>
        <p class="text-gray-300 text-sm mt-1 line-clamp-2">{{ $exp->description }}</p>
        <div class="flex items-center mt-2">
          @for ($i = 0; $i < 5; $i++)
            <i class="{{ $i < ($exp->rating ?? 0) ? 'fa-solid' : 'fa-regular' }} fa-star text-amber-300 text-xs mr-1"></i>
          @endfor
        </div>
        <div class="flex justify-between text-gray-400 text-xs mt-3 uppercase tracking-widest font-semibold">
          <span><i class="fa-solid fa-clock mr-1"></i>{{ $exp->duration }} min</span>
          <span><i class="fa-solid fa-user-group mr-1"></i>{{ $exp->ability }} pax</span>
        </div>
        <div class="flex justify-between items-center mt-4 pt-3 border-t border-white/10">
          <span class="text-white font-bold text-xl">{{ $exp->price }} €</span>
          <div class="flex gap-2">
            <button class="px-4 py-1.5 rounded-full bg-amber-300 text-green-900 font-bold text-sm hover:bg-amber-200 transition-all shadow-lg">Reservar</button>
            <a href="{{route('experienciasInfo', $exp->slug)}}" 
            class="px-3 py-1.5 rounded-full border border-amber-300/50 text-amber-300 text-sm hover:bg-amber-300/10 transition-all font-semibold">
            Info</a>
          </div>
        </div>
      </div>
      @endforeach
    </section>
</main>

<footer class="bg-black/80 backdrop-blur-xl border-t border-white/10 py-6 mt-auto">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
        
        <div class="text-gray-400 text-sm order-3 md:order-1">
            © {{ date('Y') }} <span class="text-gray-200 font-semibold">Zoológico Aventura</span>. Todos los derechos reservados.
        </div>

        <div class="text-amber-300 font-parkzoo text-3xl order-1 md:order-2">
            Park Zoo
        </div>

        <div class="flex gap-6 text-xl order-2 md:order-3">
            <a href="#" class="text-gray-400 hover:text-amber-300 transition-colors"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-gray-400 hover:text-amber-300 transition-colors"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-gray-400 hover:text-amber-300 transition-colors"><i class="fab fa-x-twitter"></i></a>
            <a href="#" class="text-gray-400 hover:text-amber-300 transition-colors"><i class="fab fa-youtube"></i></a>
        </div>

    </div>
</footer>

</body>

</html>
