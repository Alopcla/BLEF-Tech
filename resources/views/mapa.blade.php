@extends('layouts.app')

@section('title', 'Mapa Interactivo')

@section('video', 'false')

@push('styles')
<style>
    body {
        background-color: #1a2622;
        background-image: radial-gradient(circle at center, #23332e 0%, #1a2622 100%);
    }

    img {
        user-select: none;
        -webkit-user-drag: none;
    }

    .custom-scrollbar::-webkit-scrollbar { width: 5px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #16a34a; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #15803d; }

    @keyframes autoScrollPopup {
        0%   { transform: translateY(0); }
        15%  { transform: translateY(0); }
        85%  { transform: translateY(calc(-100% + 250px)); }
        100% { transform: translateY(calc(-100% + 250px)); }
    }

    .animate-scroll {
        display: block;
        animation: autoScrollPopup 10s linear infinite alternate;
    }

    .overflow-hidden-container {
        overflow: hidden !important;
        position: relative;
    }
</style>
@endpush

@section('content')
    <main style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
        <div id="react-mapa"></div>
    </main>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endpush