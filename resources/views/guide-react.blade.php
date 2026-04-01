<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Guía | ZooPro</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
</head>
<body class="bg-slate-50">

    <div id="guide-dashboard-root">
        <h1 style="text-align:center; padding: 50px; font-family: sans-serif; color: #64748b;">
            <i class="fa-solid fa-spinner fa-spin"></i> Cargando Panel del Guía...
        </h1>
    </div>

</body>
</html>
