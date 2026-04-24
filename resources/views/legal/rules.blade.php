@extends('layouts.app')

@section('title', 'Zoo Rules | Blef-Tech')

@push('styles')
    {{-- Reutilizamos el mismo CSS para mantener la estética --}}
    @vite(['resources/css/legal.css'])
@endpush

@section('content')

<div class="legal-page">
    
    <div class="h-32 md:h-40 w-full"></div>

    <div class="px-4 sm:px-6 max-w-5xl mx-auto pb-24 relative z-10">
        
        <div class="mb-12 text-center">
            <h1 class="font-bebas text-5xl md:text-7xl text-white mb-4">
                Normas del <span class="gradient-text">Zoo</span>
            </h1>
            <p class="font-outfit text-white/50 uppercase tracking-[0.2em] text-sm">
                Compromiso con el Bienestar Animal y la Seguridad
            </p>
        </div>

        <div class="glass-card p-8 md:p-16 shadow-2xl">
            <div class="legal-content">
                <p class="text-lg">
                    Para garantizar una experiencia segura y educativa en <strong>Blef-Tech Zoo</strong>, todos los visitantes deben cumplir con el siguiente código de conducta. El incumplimiento de estas normas puede suponer la anulación de tus <strong>tickets</strong> sin derecho a reembolso.
                </p>

                <h3>1. Respeto a los Animales</h3>
                <p>
                    Nuestros animales viven en ecosistemas diseñados para su bienestar. Queda estrictamente prohibido:
                </p>
                <ul class="list-disc pl-6 space-y-2 font-outfit">
                    <li>Alimentar a los animales (disponemos de dietas controladas por veterinarios).</li>
                    <li>Gritar o golpear los cristales y vallas de seguridad.</li>
                    <li>Utilizar flash al tomar fotografías, ya que puede estresar a las especies sensibles.</li>
                </ul>

                <h3>2. Normas para "Experiencias Blef-Tech"</h3>
                <p>
                    Si has adquirido una <strong>Experiencia</strong> mediante nuestra plataforma digital, recuerda:
                </p>
                <ul class="list-disc pl-6 space-y-2 font-outfit">
                    <li>Es obligatorio presentar el ticket digital con el código QR válido.</li>
                    <li>Debes seguir las instrucciones del cuidador en todo momento.</li>
                    <li>El acceso a zonas restringidas solo está permitido durante el horario reservado en la web.</li>
                </ul>

                <h3>3. Seguridad y Entorno</h3>
                <p>
                    Como zoo tecnológico, contamos con sensores y sistemas de monitorización. Por favor, mantente en los senderos marcados en el <strong>Mapa Interactivo</strong> de nuestra web para evitar zonas en mantenimiento o áreas de manejo técnico.
                </p>

                <h3>4. Objetos Prohibidos</h3>
                <p>
                    No se permite el acceso con drones, punteros láser o cualquier objeto que pueda interferir con el comportamiento natural de los animales o los sistemas de Blef-Tech.
                </p>

                <div class="tfg-note tfg-note-emerald mt-12">
                    <p class="text-sm m-0">
                        <i class="fa-solid fa-shield-dog mr-2"></i> 
                        <strong>Aviso Académico:</strong> Estas normas han sido redactadas para simular la lógica de negocio de un centro de conservación real dentro del proyecto TFG.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <a href="{{ url('/') }}" class="btn-blef-outline font-bebas text-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Volver al Inicio
            </a>
        </div>
    </div>
</div>

@endsection