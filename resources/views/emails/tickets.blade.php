<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #4a3f35;
            /* Marrón oscuro para mejor lectura */
            line-height: 1.6;
            background-color: #fdfaf6;
            /* Fondo muy suave */
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #dcd3c1;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            /* Degradado sutil similar al atardecer de la imagen */
            background-color: #d3c4a2;
            background: linear-gradient(135deg, #d3c4a2 0%, #c5b591 100%);
            color: #3e2723;
            padding: 30px 20px;
            text-align: center;
        }

        .logo-container {
            margin-bottom: 10px;
        }

        /* Simulación del icono del zoo */
        .logo-icon {
            width: 50px;
            height: 50px;
            margin-bottom: 5px;
        }

        h1 {
            margin: 0;
            font-size: 1.8em;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .content {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            background-color: #fffcf7;
        }

        th {
            background-color: #e9e2d3;
            color: #5d4037;
            border-bottom: 2px solid #dcd3c1;
            text-align: left;
            padding: 15px;
            font-size: 0.85em;
            text-transform: uppercase;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee5d8;
            font-size: 0.95em;
        }

        .fecha-destacada {
            color: #5c7c34;
            /* Verde similar al logo del zoo */
            font-weight: bold;
        }

        .footer {
            background-color: #f9f7f2;
            padding: 20px;
            font-size: 0.8em;
            color: #8d7d6f;
            text-align: center;
            border-top: 1px solid #eee5d8;
        }

        .important-note {
            background-color: #fdf3e7;
            border-left: 4px solid #d3c4a2;
            padding: 10px 15px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Tus Entradas</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.8;">ZooLogic - Naturaleza a tu alcance</p>
        </div>

        <div class="content">
            <p>Hola,</p>
            <div class="important-note">
                Confirmamos la compra de tus entradas. <strong>Recuerda presentar estos tickets (digitales o impresos) en el control de acceso.</strong>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID Ticket</th>
                        <th>Día Visita</th>
                        <th>Compra</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td style="font-weight: bold;">#{{ $ticket['id'] }}</td>
                        <td class="fecha-destacada">{{ $ticket['day_used'] }}</td>
                        <td>{{ $ticket['date'] }}</td>
                        <td>{{ number_format($ticket['price'], 2) }} €</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p><strong>Información:</strong> Las entradas son válidas exclusivamente para la fecha seleccionada.</p>
            <p>© 2026 ZooLogic. Este es un correo automático.</p>
        </div>
    </div>
</body>

</html>