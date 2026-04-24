@extends('layouts.app')

@section('title', 'Privacy Policy | Blef-Tech')

@push('styles')
    @vite(['resources/css/legal.css'])
@endpush

@section('content')

{{-- Usamos la clase 'legal-page' que definimos en el CSS para el fondo oscuro --}}
<div class="legal-page">
    
    {{-- Espaciador para el menú --}}
    <div class="h-32 md:h-40 w-full"></div>

    <div class="px-4 sm:px-6 max-w-5xl mx-auto pb-24 relative z-10">
        
        {{-- Cabecera --}}
        <div class="mb-12 text-center">
            <h1 class="font-bebas text-5xl md:text-7xl text-white mb-4">
                Política de <span class="gradient-text">Privacidad</span>
            </h1>
            <p class="font-outfit text-white/50 uppercase tracking-[0.2em] text-sm">
                Last updated: {{ date('d/m/Y') }}
            </p>
        </div>

        {{-- Contenido Legal --}}
        <div class="glass-card p-8 md:p-16 shadow-2xl">
            <div class="legal-content">
                <p class="text-lg">
                    En <strong>Blef-Tech Zoo</strong>, la protección de tus datos es tan prioritaria como el bienestar de nuestras especies. Este documento detalla cómo tratamos la información personal que recopilas a través de nuestra plataforma de gestión de entradas, tienda y experiencias.
                </p>

                <h3>1. Responsable del Tratamiento</h3>
                <p>
                    El responsable de los datos recogidos en este sitio web es <strong>Blef-Tech Conservation Group S.A.</strong>, con domicilio social en Autovía de la Naturaleza, Km 45, y correo electrónico de contacto: <strong>privacidad@blr-zoo.com</strong>.
                </p>

                <h3>2. Datos que Recopilamos</h3>
                <p>Recogemos información necesaria para garantizar tu acceso al parque y mejorar tu experiencia:</p>
                <ul class="list-disc pl-6 space-y-2">
                    <li><strong>Identificación:</strong> Nombre, apellidos y DNI (para la validez de las entradas).</li>
                    <li><strong>Contacto:</strong> Correo electrónico para el envío de tickets digitales y confirmaciones de compra en la tienda.</li>
                    <li><strong>Pago:</strong> No almacenamos datos de tarjetas; todas las transacciones se realizan mediante pasarelas de pago cifradas de terceros.</li>
                    <li><strong>Servicios:</strong> Validación de tickets para la compra de experiencias exclusivas.</li>
                </ul>

                <h3>3. Finalidad del Tratamiento</h3>
                <p>Tus datos se utilizan exclusivamente para:</p>
                <ul class="list-disc pl-6">
                    <li>Gestionar la reserva de entradas, compra de productos y acceso a experiencias.</li>
                    <li>Enviar notificaciones críticas sobre cambios de horario o avisos de seguridad.</li>
                    <li>Cumplir con las metas académicas del Trabajo de Fin de Grado (TFG).</li>
                </ul>

                <h3>4. Conservación de Datos</h3>
                <p>
                    Al tratarse de un entorno de <strong>proyecto académico (TFG)</strong>, los datos serán eliminados tras la evaluación del mismo y no se utilizarán para fines comerciales reales.
                </p>

                <h3>5. Tus Derechos</h3>
                <p>
                    Puedes ejercer tus derechos de acceso, rectificación o supresión enviando un correo a nuestro departamento de sistemas ficticio.
                </p>

                {{-- Nota de TFG  --}}
                <div class="tfg-note tfg-note-emerald mt-12">
                    <p class="text-sm m-0">
                        <i class="fa-solid fa-circle-info mr-2"></i> 
                        <strong>Aviso Académico:</strong> Esta página ha sido generada con fines ilustrativos para la defensa del TFG. Blef-Tech no es una entidad comercial real.
                    </p>
                </div>
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