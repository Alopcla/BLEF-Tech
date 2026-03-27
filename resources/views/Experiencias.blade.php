<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Experiencias - Zoológico</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="font-sans text-white">

<!-- VIDEO DE FONDO -->
<video autoplay muted loop class="fixed w-full h-full object-cover -z-10">
  <source src="{{ asset('video.mp4') }}" type="video/mp4">
</video>
<div class="fixed inset-0 bg-black/50 -z-10"></div>

<!-- HEADER -->
<header class="flex justify-center pt-8 px-6">
  <div class="flex items-center gap-8 bg-black/40 backdrop-blur-md px-6 py-3 rounded-full shadow-lg border border-white/20">
    <img src="{{ asset('logo.png') }}" class="w-12">
    <nav class="hidden md:flex gap-5 text-lg">
      <a href="/" class="hover:text-amber-300 transition">Inicio</a>
      <a href="{{ route('payment.show') }}" class="hover:text-amber-300 transition">Tickets</a>
      <a href="/experiencias" class="hover:text-amber-300 transition">Experiencias</a>
      <a href="{{ route('animales') }}" class="hover:text-amber-300 transition">Animales</a>
      <a href="{{ route('tienda') }}" class="hover:text-amber-300 transition">Tienda</a>
      <a href="#" class="hover:text-amber-300 transition">Contacto</a>
      <button class="bg-amber-300 text-green-900 px-4 py-1 rounded-full hover:bg-amber-200 transition">Login</button>
    </nav>
  </div>
</header>

<!-- TITULO -->
<section class="text-center mt-20 px-6">
  <h1 class="text-4xl font-bold mb-2">Experiencias del Zoológico</h1>
  <p class="text-gray-300 max-w-xl mx-auto">
    Vive momentos únicos y divertidos con nuestros animales.
  </p>
</section>

<!-- EXPERIENCIAS -->
<section class="max-w-6xl mx-auto mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-6 px-6">
  @foreach($experiencias as $exp)
  <div class="bg-black/60 p-4 rounded-xl border border-white/20 shadow-lg  hover:scale-105 transition-transform duration-300">

    <!-- IMAGEN CON BADGE -->
    <div class="relative">
      <img src="{{ $exp->image }}" class="w-full h-48 object-cover rounded-lg mb-2">
      <span class="absolute top-2 left-2 bg-amber-300 text-green-900 text-xs font-semibold px-2 py-1 rounded-full shadow">
        {{ $exp->type ?? 'General' }}
      </span>
    </div>

    <!-- NOMBRE Y DESCRIPCIÓN -->
    <h3 class="text-xl font-semibold">{{ $exp->name }}</h3>
    <p class="text-gray-300 text-sm mt-1">{{ $exp->description }}</p>

    <!-- ESTRELLAS DE RATING -->
    <div class="flex items-center mt-1">
      @for ($i = 0; $i < 5; $i++)
        @if($i < ($exp->rating ?? 0))
          <i class="fa-solid fa-star text-amber-300 mr-1"></i>
        @else
          <i class="fa-regular fa-star text-gray-400 mr-1"></i>
        @endif
      @endfor
    </div>

    <!-- DURACIÓN Y CAPACIDAD -->
    <div class="flex justify-between text-gray-300 text-sm mt-2">
      <span><i class="fa-solid fa-clock mr-1"></i>{{ $exp->duration }} min</span>
      <span><i class="fa-solid fa-user-group mr-1"></i>{{ $exp->ability }} personas</span>
    </div>

    <!-- PRECIO Y BOTONES -->
    <div class="flex justify-between items-center mt-2">
      <span class="text-amber-300 font-semibold text-lg">{{ $exp->price }} €</span>
      <div class="flex gap-2">
        <button class="px-3 py-1 rounded-full bg-gradient-to-r from-amber-300 to-amber-400 text-green-900 font-semibold shadow-md hover:scale-105 transition-all">
          Reservar
        </button>
        <a href="{{route('experienciasInfo', $exp->slug)}}">
          <button class="px-3 py-1 rounded-full border border-amber-300 text-amber-300 font-semibold hover:bg-amber-300 hover:text-green-900 transition-all">
            Más info
          </button>
        </a>
      </div>
    </div>

  </div>
  @endforeach
</section>

<!-- FOOTER -->
<footer class="mt-10 bg-black/70 py-6 text-center text-gray-400">
  <div class="flex justify-center gap-4 text-xl mb-2">
    <a href="#" class="hover:text-amber-300"><i class="fab fa-facebook"></i></a>
    <a href="#" class="hover:text-amber-300"><i class="fab fa-instagram"></i></a>
    <a href="#" class="hover:text-amber-300"><i class="fab fa-twitter"></i></a>
    <a href="#" class="hover:text-amber-300"><i class="fab fa-youtube"></i></a>
  </div>
  <p>© {{ date('Y') }} Zoológico. Todos los derechos reservados.</p>
</footer>

</body>
</html>
