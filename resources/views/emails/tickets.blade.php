<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 90%;
            margin: 0 auto;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
        }

        .header {
            background-color: #2e7d32;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            text-align: left;
            padding: 12px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }

        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>¡Gracias por tu visita!</h1>
        </div>

        <p>Hola,</p>
        <p>Confirmamos la compra de tus entradas para <strong>Park Zoo</strong>. A continuación verás el detalle de tus tickets generados:</p>

        <table>
            <thead>
                <tr>
                    <th>ID Ticket</th>
                    <th>Fecha de Compra</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                {{-- $tickets es la variable que definimos como public en el Mailable --}}
                @foreach($tickets as $ticket)
                <tr>
                    <td>#{{ $ticket['id'] }}</td>
                    <td>{{ $ticket['date'] }}</td>
                    <td>{{ number_format($ticket['price'], 2) }} €</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p>Zoologic - Naturaleza a tu alcance.</p>
        </div>
    </div>
</body>

</html>