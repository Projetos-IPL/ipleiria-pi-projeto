<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recibo</title>

    <style>
        body {
            text-align: center;
        }

        html {
            margin: 10px 20px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .bilhetes-table {
            border-collapse: collapse;
            width: 100%;
        }

        .bilhetes-table thead>tr {
            border-bottom: 1px solid #000;
        }

        .bilhetes-table tbody>tr>td {
            border-bottom: 1px dotted #aaa;
            padding: 12px 0;
        }

        .totais-table {
            border-collapse: collapse;
            margin-top: 20px;
        }

        .totais-table tbody>tr>td {
            padding: 12px 0;
        }

        span {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>CineMagic</h1>

    <h3>Recibo #{{ $recibo->id }}</h3>

    <h5>{{ \Carbon\Carbon::parse($recibo->data)->format('d/m/Y') }}</h5>
    <hr style="margin-bottom: 20px">

    <div style="text-align: left;">
        <p><span>Cliente:</span> {{ $recibo->cliente?->user?->name }}</p>
        <p><span>NIF:</span> {{ $recibo->cliente?->nif ?? 'n/ disponível' }}</p>

        <table style="margin-top: 30px" class="bilhetes-table">
            <thead>
                <tr>
                    <th>Sessão</th>
                    <th>Lugar</th>
                    <th>Bilhete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bilhetes as $b)
                <tr>
                    <td>
                        <span>{{ $b->sessao->filme->titulo }}</span><br>
                        {{ \Carbon\Carbon::parse($b->sessao->data)->format('d/m/Y') }} -
                        {{ \Carbon\Carbon::parse($b->sessao->horario_inicio)->format('H:i') }} <br>
                        <small>Sala: {{ $b->sessao->sala->nome }} [{{ $b->sessao->sala->id }}]</small>
                    </td>
                    <td class="text-center">
                        {{ $b->lugar->getPrettyLugar() }}
                    </td>
                    <td class="text-center">
                        #{{ $b->id }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="float: right; width: auto;">
        <table class="totais-table">
            <tbody>
                <tr>
                    <td><span>Total s/ IVA:</span></td>
                    <td class="text-right">{{ number_format($recibo->preco_total_sem_iva, 2, ',', '.') }} €</td>
                </tr>
                <tr>
                    <td><span>IVA:</span></td>
                    <td class="text-right">{{ number_format($recibo->iva, 2, ',', '.') }} €</td>
                </tr>
                <tr>
                    <td><span>Total:</span></td>
                    <td class="text-right">{{ number_format($recibo->preco_total_com_iva, 2, ',', '.') }} €</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 32px">
        <p><span>Método de Pagamento:</span> {{ $recibo->tipo_pagamento }}</p>
        <p><span>Ref. de Pagamento:</span> {{ $recibo->ref_pagamento ?? $recibo->cliente->user->email }}</p>
    </div>

    <div class="text-center" style="margin-top: 60px;">
        <p><span>Obrigado pela preferência!</span></p>
        <small>{{ now() }}</small>
    </div>
</body>

</html>