@extends('layouts.app')

@section('title', 'Experiencias')

@section('video', 'false')

@push('styles')

<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<style>
    body {
        background: #141A14 url("/img/zoo_fondo.png") no-repeat fixed center !important;
        background-size: cover !important;
    }
    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: -1;
        pointer-events: none;
    }
</style>
@endpush

@section('content')
    <div id="experiencias-root"
         data-auth="{{ Auth::check() ? 'true' : 'false' }}"
         data-email="{{ Auth::user()->email ?? '' }}">
    </div>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endpush