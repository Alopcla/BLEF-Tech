@extends('layouts.app')

@section('title', 'Inicio | Blef-Tech')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;700&display=swap"
        rel="stylesheet">
@endpush

@section('content')

    {{-- Barra de temperatura --}}
    <div class="barra-tiempo" id="temperatura"></div>

    {{-- ESCUDO ANTI-MENÚ: Empuja todo hacia abajo para que el navbar de tu compañero no lo tape --}}
    <div class="h-32 md:h-40 w-full shrink-0"></div>

    {{-- CONTENEDOR PRINCIPAL --}}
    <div class="px-4 sm:px-6 max-w-7xl mx-auto pb-24 space-y-16">

        <div class="bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-12 lg:p-16 shadow-2xl">
            <div class="max-w-3xl mb-12">
                <h1 style="font-family: 'Bebas Neue', sans-serif;"
                    class="text-6xl md:text-8xl text-white tracking-wide mb-6 leading-none">
                    El instinto de <br>
                    <span class="bg-gradient-to-r from-emerald-400 to-amber-300 bg-clip-text text-transparent">proteger la
                        vida.</span>
                </h1>
                <p style="font-family: 'Outfit', sans-serif;"
                    class="text-lg md:text-xl text-white/80 font-light leading-relaxed">
                    BLR-Zoo es mucho más que un zoológico, es un centro de rescate, conservación e investigación biológica.
                    Un refugio inmersivo donde el
                    bienestar animal es la única prioridad, alejándonos del concepto tradicional de exhibición.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 border-t border-white/10 pt-12">
                <div>
                    <i class="fa-solid fa-earth-americas text-3xl text-emerald-400 mb-4 block drop-shadow-md"></i>
                    <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-2xl text-amber-400 tracking-wider mb-2">
                        Conservación Activa</h3>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 text-sm font-light leading-relaxed">
                        Destinamos el 20% de nuestros ingresos a programas internacionales de reintroducción de especies y
                        protección contra la caza furtiva.
                    </p>
                </div>
                <div>
                    <i class="fa-solid fa-leaf text-3xl text-emerald-400 mb-4 block drop-shadow-md"></i>
                    <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-2xl text-amber-400 tracking-wider mb-2">
                        Hábitats Naturalizados</h3>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 text-sm font-light leading-relaxed">
                        Cada recinto recrea con precisión el bioma original de la especie, garantizando que puedan
                        desarrollar sus instintos naturales en paz.
                    </p>
                </div>
                <div>
                    <i class="fa-solid fa-graduation-cap text-3xl text-emerald-400 mb-4 block drop-shadow-md"></i>
                    <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-2xl text-amber-400 tracking-wider mb-2">
                        Educación Global</h3>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 text-sm font-light leading-relaxed">
                        Creemos que solo se protege lo que se ama. Concienciamos a las anteriores y nuevas generaciones
                        mediante el
                        respeto absoluto por la fauna.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-12 lg:p-16 shadow-2xl">
            <div class="mb-10 flex flex-col md:flex-row md:justify-between md:items-end gap-6">
                <div>
                    <h2 style="font-family: 'Bebas Neue', sans-serif;"
                        class="text-4xl md:text-5xl text-emerald-400 tracking-wide mb-2 drop-shadow-md">
                        Nuestros Ecosistemas
                    </h2>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 font-light text-lg">Explora 50
                        hectáreas de naturaleza viva, dividida en zonas bioclimáticas.</p>
                </div>
                <div style="font-family: 'Outfit', sans-serif;"
                    class="text-amber-400 font-bold tracking-widest text-sm uppercase">
                    Más de 50 especies
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="relative h-60 rounded-2xl overflow-hidden border border-emerald-500/20">
                    <img src="https://images.unsplash.com/photo-1535940360221-641a69c43bac?q=80&w=1166&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="absolute inset-0 w-full h-full object-cover opacity-70" alt="La Sabana">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 pr-4">
                        <span style="font-family: 'Outfit', sans-serif;"
                            class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest mb-1 block">•
                            África</span>
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-white tracking-wider mb-1">
                            La Sabana</h3>
                        <p style="font-family: 'Outfit', sans-serif;" class="text-xs text-white/80 font-light">Gran planicie
                            seca para grandes felinos y herbívoros.</p>
                    </div>
                </div>
                <div class="relative h-60 rounded-2xl overflow-hidden border border-emerald-500/20">
                    <img src="https://images.unsplash.com/photo-1730785943425-b1411494bb05?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="absolute inset-0 w-full h-full object-cover opacity-70" alt="Humedal">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 pr-4">
                        <span style="font-family: 'Outfit', sans-serif;"
                            class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest mb-1 block">•
                            Acuático</span>
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-white tracking-wider mb-1">
                            Humedales</h3>
                        <p style="font-family: 'Outfit', sans-serif;" class="text-xs text-white/80 font-light">Charca
                            principal de la sabana para especies anfibias.</p>
                    </div>
                </div>
                <div class="relative h-60 rounded-2xl overflow-hidden border border-amber-500/20">
                    <img src="https://images.unsplash.com/photo-1556648011-e01aca870a81?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="absolute inset-0 w-full h-full object-cover opacity-70" alt="Selva">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 pr-4">
                        <span style="font-family: 'Outfit', sans-serif;"
                            class="text-[10px] text-amber-400 font-bold uppercase tracking-widest mb-1 block">•
                            Jungla</span>
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-white tracking-wider mb-1">
                            Selva Virgen</h3>
                        <p style="font-family: 'Outfit', sans-serif;" class="text-xs text-white/80 font-light">Densa
                            vegetación para primates y especies trepadoras.</p>
                    </div>
                </div>
                <div class="relative h-60 rounded-2xl overflow-hidden border border-blue-500/20">
                    <img src="https://images.unsplash.com/photo-1768346614632-b8f96326be82?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="absolute inset-0 w-full h-full object-cover opacity-70" alt="Aviario">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 pr-4">
                        <span style="font-family: 'Outfit', sans-serif;"
                            class="text-[10px] text-blue-400 font-bold uppercase tracking-widest mb-1 block">• Cúpula</span>
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-white tracking-wider mb-1">
                            El Aviario</h3>
                        <p style="font-family: 'Outfit', sans-serif;" class="text-xs text-white/80 font-light">Cúpula
                            cerrada de vuelo libre para aves exóticas.</p>
                    </div>
                </div>
                <div class="relative h-60 rounded-2xl overflow-hidden border border-orange-500/20">
                    <img src="https://images.unsplash.com/photo-1632089068945-7812c9d0381c?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        class="absolute inset-0 w-full h-full object-cover opacity-70" alt="Reptilario">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 pr-4">
                        <span style="font-family: 'Outfit', sans-serif;"
                            class="text-[10px] text-orange-400 font-bold uppercase tracking-widest mb-1 block">•
                            Terrarios</span>
                        <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-white tracking-wider mb-1">
                            Reptilario</h3>
                        <p style="font-family: 'Outfit', sans-serif;" class="text-xs text-white/80 font-light">Ecosistemas
                            controlados y climatizados al milímetro.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-12 lg:p-16 shadow-2xl">
            <h2 style="font-family: 'Bebas Neue', sans-serif;"
                class="text-4xl md:text-5xl text-amber-400 tracking-wide mb-8 drop-shadow-md">
                El Equipo Blef-Tech
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <div class="border-l-2 border-emerald-400 pl-4 bg-white/5 p-4 rounded-r-xl">
                    <h4 style="font-family: 'Outfit', sans-serif;" class="text-white font-bold mb-2"><i
                            class="fa-solid fa-stethoscope text-emerald-400 mr-2"></i> Médicos Veterinarios</h4>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 text-sm font-light">Disponibles 24/7
                        en nuestro hospital clínico, monitorizando dietas, embarazos y tratamientos preventivos.</p>
                </div>
                <div class="border-l-2 border-amber-400 pl-4 bg-white/5 p-4 rounded-r-xl">
                    <h4 style="font-family: 'Outfit', sans-serif;" class="text-white font-bold mb-2"><i
                            class="fa-solid fa-paw text-amber-400 mr-2"></i> Cuidadores</h4>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 text-sm font-light">Asignados a
                        ecosistemas específicos. Garantizan el enriquecimiento ambiental y la limpieza de los hábitats.</p>
                </div>
                <div class="border-l-2 border-blue-400 pl-4 bg-white/5 p-4 rounded-r-xl">
                    <h4 style="font-family: 'Outfit', sans-serif;" class="text-white font-bold mb-2"><i
                            class="fa-solid fa-map text-blue-400 mr-2"></i> Guías Expertos</h4>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 text-sm font-light">Biólogos y
                        especialistas que dirigen las rutas para asegurar una experiencia educativa sin estresar a la fauna.
                    </p>
                </div>
            </div>

            <div class="bg-emerald-950/40 border border-emerald-500/30 rounded-2xl p-8">
                <h3 style="font-family: 'Bebas Neue', sans-serif;" class="text-3xl text-emerald-400 tracking-wide mb-3">
                    Programa de Experiencias</h3>
                <p style="font-family: 'Outfit', sans-serif;" class="text-white/80 font-light leading-relaxed text-sm">
                    Apostamos por un modelo de visita donde el respeto es lo primero. Nuestros programas inmersivos te
                    permiten acompañar a los guías y cuidadores en su rutina diaria de forma segura. El acceso a estas
                    actividades está estrictamente limitado a grupos reducidos para garantizar la tranquilidad de las
                    especies residentes en todo momento. Consulta disponibilidad tanto en taquilla como en el apartado web
                    de Tickets y Experiencias en nuestra web.
                </p>
            </div>
        </div>

        <div class="bg-black/30 backdrop-blur-md border border-white/10 rounded-[2rem] p-8 md:p-12 lg:p-16 shadow-2xl">
            <h2 style="font-family: 'Bebas Neue', sans-serif;"
                class="text-4xl md:text-5xl text-emerald-400 tracking-wide mb-10 drop-shadow-md">
                Prepara tu Visita
            </h2>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div>
                    <h3 style="font-family: 'Outfit', sans-serif;"
                        class="text-xl font-bold text-amber-400 mb-6 uppercase tracking-wider">Horarios de Apertura</h3>
                    <ul style="font-family: 'Outfit', sans-serif;" class="space-y-4 mb-8">
                        <li class="flex justify-between text-white/80 border-b border-white/10 pb-2">
                            <span class="font-light">Temporada Alta (Abr - Oct)</span>
                            <span class="font-bold">09:00 - 20:00</span>
                        </li>
                        <li class="flex justify-between text-white/80 border-b border-white/10 pb-2">
                            <span class="font-light">Temporada Baja (Nov - Mar)</span>
                            <span class="font-bold">10:00 - 18:00</span>
                        </li>

                    </ul>
                    <p style="font-family: 'Outfit', sans-serif;" class="text-white/70 text-sm font-light">
                        <i class="fa-solid fa-location-dot text-emerald-400 mr-2"></i> Autovía de la Naturaleza, Km 45.
                        Amplio parking gratuito disponible para visitantes.
                    </p>
                </div>

                <div>
                    <h3 style="font-family: 'Outfit', sans-serif;"
                        class="text-xl font-bold text-amber-400 mb-6 uppercase tracking-wider">Preguntas Frecuentes</h3>
                    <div style="font-family: 'Outfit', sans-serif;" class="space-y-6">
                        <div>
                            <h4 class="text-white font-bold text-md mb-1"><i
                                    class="fa-solid fa-hand-holding-heart text-emerald-400 mr-2"></i> ¿Se puede tocar a los
                                animales?</h4>
                            <p class="text-white/60 text-sm font-light">No. Por motivos de bioseguridad y bienestar animal,
                                mantenemos una política de "Cero Contacto Directo", salvo en emergencias veterinarias o
                                experiencias guiadas específicas.</p>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-md mb-1"><i
                                    class="fa-regular fa-clock text-amber-400 mr-2"></i> ¿Cuánto dura la visita completa?
                            </h4>
                            <p class="text-white/60 text-sm font-light">Recomendamos reservar entre 4 y 5 horas para poder
                                recorrer todos los ecosistemas a un ritmo pausado y asistir a las charlas educativas.</p>
                        </div>
                        <div>
                            <h4 class="text-white font-bold text-md mb-1">
                                <i class="fa-solid fa-utensils text-emerald-400 mr-2"></i> ¿Hay opciones de restauración?
                            </h4>
                            <p class="text-white/60 text-sm font-light">
                                Sí. Para proteger los hábitats y garantizar la máxima limpieza, la zona de restauración se
                                encuentra exclusivamente en el Edificio Principal (junto a la entrada). Te recomendamos
                                abastecerte antes de iniciar tu recorrido. Por favor, ayúdanos a cuidar de nuestras especies
                                utilizando siempre los puntos de reciclaje y no dejando ningún residuo en el parque.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
@viteReactRefresh
@vite(['resources/js/app.jsx'])
<script src="{{ asset('js/main.js') }}" defer></script>
@endpush
