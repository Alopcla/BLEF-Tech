<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago - Park Zoo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">

    {{-- asset() busca dentro de la carpeta 'public' --}}
    <link rel="stylesheet" href="{{ asset('estilos/estilo.css') }}">
</head>

<body>
    <header>
        <img src="{{ asset('recursos/favicon.ico') }}" alt="Zoologic">
    </header>

    <div class="payment-box">
        <h2>Pasarela de Pago</h2>

        {{-- Mostrar mensaje de éxito --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show custom-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Mostrar mensaje de error (si algo falla en el controlador) --}}
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show custom-alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Errores de validación de los campos --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- El action usa route() para apuntar al nombre que pusimos en web.php --}}
        <form action="{{ route('payment.process') }}" method="POST" id="purchaseForm">
            {{-- EL TOKEN CSRF ES OBLIGATORIO EN LARAVEL PARA FORMULARIOS --}}
            @csrf

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Día de visita</label>
                    <select name="dia" class="form-select" required>
                        @foreach(['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'] as $dia)
                        <option value="{{ $dia }}">{{ ucfirst($dia) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de tarjeta</label>
                    <select name="metod" class="form-select" required>
                        <option value="Visa">Visa</option>
                        <option value="Mastercard">Mastercard</option>
                        <option value="JCB">JCB</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Número de tarjeta</label>
                    <input type="text" name="tarjeta" class="form-control" placeholder="0000 0000 0000 0000" pattern="[0-9]{13,19}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Mes</label>
                    <select name="mes" class="form-select" required>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                            @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Año</label>
                    <select name="anio" class="form-select" required>
                        @php $currentYear = (int)date("Y"); @endphp
                        @for ($i = 0; $i <= 15; $i++)
                            <option value="{{ $currentYear + $i }}">{{ $currentYear + $i }}</option>
                            @endfor
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">CVV</label>
                    <input type="text" name="cvv" class="form-control" placeholder="000" pattern="[0-9]{3,4}" required>
                </div>
            </div>

            <h5 class="border-bottom pb-2 mb-3">Información de Facturación</h5>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="apellidos" class="form-control" placeholder="Apellidos" required>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <input type="text" name="direccion" class="form-control" placeholder="Dirección de facturación" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="cp" class="form-control" placeholder="Código Postal" required>
                </div>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="save" id="save">
                <label class="form-check-label text-white-50" for="save" style="font-size: 0.9rem;">
                    Guardar información para la próxima vez
                </label>
            </div>

            <button type="submit" class="btn-pagar shadow">Realizar Pago</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>