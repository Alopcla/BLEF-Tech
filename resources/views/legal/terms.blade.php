@extends('layouts.app')

@section('title', 'Terms & Conditions | Blef-Tech')

@push('styles')
    {{-- Mantenemos la consistencia con tu CSS de legales --}}
    @vite(['resources/css/legal.css'])
@endpush

@section('content')

<div class="legal-page">
    
    <div class="h-32 md:h-40 w-full"></div>

    <div class="px-4 sm:px-6 max-w-5xl mx-auto pb-24 relative z-10">
        
        <div class="mb-12 text-center">
            <h1 class="font-bebas text-5xl md:text-7xl text-white mb-4">
                Términos y <span class="gradient-text">Condiciones</span>
            </h1>
            <p class="font-outfit text-white/50 uppercase tracking-[0.2em] text-sm">
                Acuerdo de Uso y Contratación Digital
            </p>
        </div>

        <div class="glass-card p-8 md:p-16 shadow-2xl">
            <div class="legal-content">
                <p class="text-lg">
                    Bienvenido a <strong>Blef-Tech Zoo</strong>. Al acceder a nuestra web y utilizar nuestros servicios de compra, aceptas los presentes términos. Este documento regula la relación entre el usuario y nuestra plataforma de gestión biotecnológica.
                </p>

                <h3>1. Compra de Tickets y Acceso</h3>
                <p>
                    Los tickets adquiridos a través de la web son nominativos y contienen un código QR único.
                </p>
                <ul class="list-disc pl-6 space-y-2 font-outfit">
                    <li>La entrada es válida únicamente para la fecha seleccionada en el calendario.</li>
                    <li>No se admiten devoluciones de tickets una vez generada la transacción, salvo por causas de fuerza mayor o cierre del parque.</li>
                    <li>Es obligatorio presentar el DNI junto al ticket digital en los tornos de acceso.</li>
                </ul>

                <h3>2. Tienda Online (E-commerce)</h3>
                <p>
                    Al comprar productos en la <strong>Tienda Blef-Tech</strong>:
                </p>
                <ul class="list-disc pl-6 space-y-2 font-outfit">
                    <li>Los precios incluyen los impuestos aplicables según la normativa vigente (simulada).</li>
                    <li>El envío de productos físicos se gestionará en un plazo de 3 a 5 días hábiles.</li>
                    <li>Dispones de 14 días naturales para solicitar una devolución si el producto no cumple con tus expectativas.</li>
                </ul>

                <h3>3. Reserva de Experiencias Inmersivas</h3>
                <p>
                    Nuestras experiencias con animales están sujetas a disponibilidad y condiciones meteorológicas. 
                </p>
                <ul class="list-disc pl-6 space-y-2 font-outfit">
                    <li>Es requisito indispensable poseer un ticket de entrada general para el mismo día de la experiencia.</li>
                    <li>Blef-Tech se reserva el derecho de cancelar o reprogramar experiencias por motivos de bienestar animal sin previo aviso.</li>
                </ul>

                <h3>4. Uso de la Plataforma</h3>
                <p>
                    Queda prohibido cualquier intento de vulnerar el sistema de tickets, realizar ataques de denegación de servicio o intentar suplantar la identidad de otros usuarios en el panel de experiencias.
                </p>

                <div class="tfg-note tfg-note-emerald mt-12">
                    <p class="text-sm m-0">
                        <i class="fa-solid fa-gavel mr-2"></i> 
                        <strong>Aviso Académico:</strong> Este documento es una simulación para demostrar la capacidad de implementación de un sistema de términos de uso en una aplicación web. No tiene validez legal fuera del entorno académico.
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