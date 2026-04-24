@extends('layouts.app')

@section('title', 'Legal Notice | Blef-Tech')

@push('styles')
    @vite(['resources/css/legal.css'])
@endpush

@section('content')

{{-- Clase 'legal-page' para el fondo oscuro --}}
<div class="legal-page">
    
    {{-- Espaciador para el menú --}}
    <div class="h-32 md:h-40 w-full"></div>

    <div class="px-4 sm:px-6 max-w-5xl mx-auto pb-24 relative z-10">
        
        {{-- Cabecera --}}
        <div class="mb-12 text-center">
            <h1 class="font-bebas text-5xl md:text-7xl text-white mb-4">
                Aviso <span class="gradient-text">Legal</span>
            </h1>
            <p class="font-outfit text-white/50 uppercase tracking-[0.2em] text-sm">
                Información del Proyecto Académico (TFG)
            </p>
        </div>

        {{-- Contenido Legal --}}
        <div class="glass-card p-8 md:p-16 shadow-2xl">
            <div class="legal-content">
                <p class="text-lg">
                    En cumplimiento con el deber de información, se hace constar que este sitio web constituye un <strong>entorno de simulación tecnológica</strong> desarrollado para un Trabajo de Fin de Grado.
                </p>

                <h3>1. Identidad del Titular</h3>
                <p>
                    El titular del desarrollo y responsable de los contenidos de este proyecto es el alumno de Grado [Tu Nombre/Estudiante]. La plataforma <strong>Blef-Tech Zoo</strong> es una creación intelectual con fines puramente educativos y de demostración técnica.
                </p>

                <h3>2. Propiedad Intelectual y Uso</h3>
                <p>
                    El código fuente, diseño de la interfaz (E-commerce, pasarela de tickets y sistema de reserva de experiencias) y logotipos han sido desarrollados como parte de la formación académica del autor.
                </p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Catálogo de Animales:</strong> Las imágenes y descripciones de las especies se utilizan bajo licencias Creative Commons para fines ilustrativos.</li>
                    <li><strong>Marcas:</strong> La marca "Blef-Tech" es ficticia y cualquier parecido con empresas reales es pura coincidencia.</li>
                </ul>

                <h3>3. Exclusión de Responsabilidad</h3>
                <p>
                    Dado que se trata de un prototipo para un TFG:
                </p>
                <ul class="list-disc pl-6">
                    <li>No se garantiza la disponibilidad ininterrumpida de los servicios de compra.</li>
                    <li>Los precios mostrados en la tienda y tickets son <strong>simulados</strong> y no dan derecho a productos o acceso real a instalaciones físicas.</li>
                    <li>No se procesan pagos reales ni se requiere información bancaria auténtica.</li>
                </ul>

                <h3>4. Ley Aplicable</h3>
                <p>
                    Este sitio se rige por la normativa vigente en España relativa a la protección de propiedad intelectual dentro del marco de la formación universitaria.
                </p>
            </div>
        </div>

        {{-- Botón Volver usando la clase del CSS --}}
        <div class="mt-12 text-center">
            <a href="{{ url('/') }}" class="btn-blef-outline font-bebas text-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Volver al Inicio
            </a>
        </div>
    </div>
</div>

@endsection