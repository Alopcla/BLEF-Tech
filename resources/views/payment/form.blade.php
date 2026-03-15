<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pasarela de Pago - Park Zoo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap">
    <link rel="stylesheet" href="{{ asset('estilos/estilo.css') }}">
</head>

<body>
    @php
    $manana = date('Y-m-d', strtotime('+1 day'));
    $limite = date('Y-m-d', strtotime('+30 days'));
    @endphp

    <header>
        <a href="/"><img src="{{ asset('recursos/favicon.ico') }}" alt="Zoologic"></a>
    </header>

    <div class="payment-box">
        <h2>Pasarela de Pago</h2>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show custom-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show custom-alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ route('payment.process') }}" method="POST" id="purchaseForm">
            @csrf

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Día de visita</label>
                    <input type="date" name="dia" class="form-control" min="{{ $manana }}" max="{{ $limite }}" value="{{ old('dia', $manana) }}" required>
                    <div id="disponibilidad-feedback" class="mt-2 fw-bold" style="font-size: 0.85rem;"></div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo de tarjeta</label>
                    <select name="metod" class="form-select" required>
                        <option value="Visa" {{ old('metod') == 'Visa' ? 'selected' : '' }}>Visa</option>
                        <option value="Mastercard" {{ old('metod') == 'Mastercard' ? 'selected' : '' }}>Mastercard</option>
                        <option value="JCB" {{ old('metod') == 'JCB' ? 'selected' : '' }}>JCB</option>
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label">Número de tarjeta</label>
                    <input type="text" name="tarjeta" class="form-control" value="{{ old('tarjeta') }}" placeholder="0000 0000 0000 0000" pattern="[0-9]{13,19}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Mes</label>
                    <select name="mes" class="form-select" required>
                        @for ($i = 1; $i <= 12; $i++)
                            @php $m=sprintf('%02d', $i); @endphp
                            <option value="{{ $m }}" {{ old('mes') == $m ? 'selected' : '' }}>{{ $m }}</option>
                            @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Año</label>
                    <select name="anio" class="form-select" required>
                        @php $currentYear = (int)date("Y"); @endphp
                        @for ($i = 0; $i <= 15; $i++)
                            @php $y=$currentYear + $i; @endphp
                            <option value="{{ $y }}" {{ old('anio') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                    </select>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label">CVV</label>
                    <input type="text" name="cvv" class="form-control" placeholder="000" pattern="[0-9]{3,4}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cantidad de entradas</label>
                    <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', 1) }}" min="1" max="10" required>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <label class="form-label text-white-50">Correo Electrónico para recibir las entradas</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="usuario@ejemplo.com" required>
                </div>
            </div>

            <h5 class="border-bottom pb-2 mb-3">Información de Facturación</h5>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Nombre" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" placeholder="Apellidos" required>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-8">
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" placeholder="Dirección de facturación" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="cp" class="form-control" value="{{ old('cp') }}" placeholder="C.P." required>
                </div>
            </div>

            @auth
            <div id="guardaInfo" class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="save" id="save" {{ old('save') ? 'checked' : '' }}>
                <label class="form-check-label text-white-50" for="save" style="font-size: 0.9rem;">
                    Guardar información para la próxima vez
                </label>
            </div>
            @endauth

            <button type="submit" class="btn-pagar shadow" id="btnSubmit">Realizar Pago</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const form = document.getElementById('purchaseForm');
        const inputFecha = document.querySelector('input[name="dia"]');
        const inputCantidad = document.querySelector('input[name="cantidad"]');
        const btnSubmit = document.getElementById('btnSubmit');
        const feedback = document.getElementById('disponibilidad-feedback');

        // Función para actualizar el texto de ayuda
        function revisarCupo() {
            const fecha = inputFecha.value;
            if (!fecha) return;

            feedback.innerHTML = '<span class="text-white-50">Consultando disponibilidad...</span>';

            fetch(`{{ route('check.availability') }}?date=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    actualizarInterfaz(data.available);
                })
                .catch(error => console.error('Error:', error));
        }

        function actualizarInterfaz(disponibles) {
            if (disponibles <= 0) {
                feedback.innerHTML = '<span class="text-danger">✘ No hay entradas para este día</span>';
                btnSubmit.disabled = true;
                btnSubmit.style.opacity = '0.5';
            } else {
                feedback.innerHTML = `<span class="text-success">✔ Quedan ${disponibles} disponibles</span>`;
                btnSubmit.disabled = false;
                btnSubmit.style.opacity = '1';
                inputCantidad.max = disponibles;
                if (parseInt(inputCantidad.value) > disponibles) {
                    inputCantidad.value = disponibles;
                }
            }
        }

        // --- VALIDACIÓN DE ÚLTIMO SEGUNDO ---
        form.addEventListener('submit', async function(e) {
            e.preventDefault(); // Detenemos el envío

            const fecha = inputFecha.value;
            const cantidadSolicitada = parseInt(inputCantidad.value);

            // Bloqueamos botón para evitar doble clic
            btnSubmit.disabled = true;
            btnSubmit.innerText = 'Verificando cupo final...';

            try {
                const response = await fetch(`{{ route('check.availability') }}?date=${fecha}`);
                const data = await response.json();
                const disponiblesAhora = data.available;

                if (disponiblesAhora <= 0) {
                    alert('Lo sentimos mucho pero se han vendido todas las entradas para este día justo ahora.');
                    location.reload(); // Refrescamos para mostrar el estado real
                } else if (cantidadSolicitada > disponiblesAhora) {
                    alert(`¡Atención! Justo ahora alguien ha comprado entradas y solo quedan ${disponiblesAhora} disponibles. Por favor, ajusta tu cantidad.`);
                    actualizarInterfaz(disponiblesAhora);
                    btnSubmit.innerText = 'Realizar Pago';
                } else {
                    // Si todo sigue bien, enviamos el formulario
                    btnSubmit.innerText = 'Procesando pago...';
                    form.submit();
                }
            } catch (error) {
                console.error('Error en la verificación final:', error);
                btnSubmit.disabled = false;
                btnSubmit.innerText = 'Realizar Pago';
            }
        });

        inputFecha.addEventListener('change', revisarCupo);
        document.addEventListener('DOMContentLoaded', revisarCupo);
    </script>
</body>

</html>