@extends('layouts.app')

@section('title', 'Animales')

@section('content')
    <div id="pagina-animales-root" style="min-height: 100vh;"></div>
@endsection

@push('scripts')
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
@endpush