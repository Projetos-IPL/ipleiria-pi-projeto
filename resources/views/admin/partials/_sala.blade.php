<style>
    .fila {
        background-color: #555;
        border-radius: 5px;
        color: #fff;
        display: inline-block;
        width: 75px;
        text-align: center;
        cursor: pointer;
    }

    .posicao {
        background-color: #000;
        border-radius: 5px;
        color: #fff;
        display: inline-block;
        width: 40px;
        text-align: center;
        cursor: pointer;
    }

    .ecra {
        background-color: lightgray !important;
    }
</style>

@if ($sala->lugares->isEmpty())
<p>Sem lugares associados.</p>
@else
<table class="table">
    <tbody>
        @foreach ($sala->getFilasForSala() as $fila)
        <tr>
            <td>
                <div class="fila p-2">{{ $fila->fila }}</div>
            </td>
            <td class="text-center">
                @foreach ($sala->getPosicoesForFila($fila->fila) as $posicao)
                <div class="posicao p-2" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-title="Lugar {{ $fila->fila }}{{ $posicao->posicao }}">
                    {{ $posicao->posicao }}
                </div>
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td class="fw-bold text-center py-2 ecra">Ecrã</td>
        </tr>
    </tfoot>
</table>
@endif
