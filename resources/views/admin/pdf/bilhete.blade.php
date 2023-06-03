<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bilhete</title>

    <style>
        body {
            margin: 0;
        }

        table,
        th,
        td {
            border: 1px solid #000;
            border-collapse: collapse;
        }

        td {
            padding: 20px;
        }

        span {
            font-size: 4em;
            font-weight: bold;
        }

        h1 {
            font-size: 3em;
        }

        p {
            font-size: 1.5em;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>CineMagic</h1>

    <table>
        <tr>
            <td>
                Fila<br>
                <span>{{ $bilhete->lugar->fila }}</span>
            </td>
            <td>
                Lugar<br>
                <span>{{ $bilhete->lugar->posicao }}</span>
            </td>
            <td rowspan="2">
                Sala<br>
                <span>{{ $bilhete->lugar->sala->nome }}</span>
            </td>
            <td rowspan="2">
                Cliente<br>
                @if ($bilhete->cliente != null)
                <img src="{{ 'https://cinemagic.test:8443/' . $bilhete->cliente->user->getAvatarPath() }}"
                    style="max-width: 100px; margin-top: 10px">
                <p>{{ $bilhete->cliente->user->name }}</p>
                @else
                <span>Cliente removido</span>
                @endif
            </td>
            <td rowspan="2">
                <img src="data:image/png;base64,{{ base64_encode($qrCodeImage) }}" alt="QR Code">
            </td>
        </tr>
        <tr>
            <td>
                Hora<br>
                <span>{{ \Carbon\Carbon::parse($bilhete->sessao->horario_inicio)->format('H:i') }}</span>
            </td>
            <td>
                Data<br>
                <span>{{ \Carbon\Carbon::parse($bilhete->sessao->data)->format('d/m/Y') }}</span>
            </td>
        </tr>
    </table>
</body>

</html>
