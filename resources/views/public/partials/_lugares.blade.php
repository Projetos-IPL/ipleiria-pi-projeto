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

<script>
    var lugaresSelecionados = 0;
    var lugares = [];

    function setLugarAtivo(lugar) {
        var quantidade = document.getElementById("quantidade").value;

        if (lugar.classList.contains("bg-danger")) {
            alert("Este lugar já está ocupado.");
            return;
        }

        if (lugar.classList.contains("bg-success")) {
            lugar.classList.remove("bg-success");

            lugaresSelecionados--;
            lugares = lugares.filter(function (item) {
                return item.fila != lugar.getAttribute("data-fila") || item.posicao != lugar.getAttribute("data-posicao");
            });

            return;
        }

        if (quantidade == lugaresSelecionados) {
            alert("Já selecionou o número máximo de lugares.");
            return;
        }

        var fila = lugar.getAttribute("data-fila");
        var posicao = lugar.getAttribute("data-posicao");

        lugar.classList.toggle("bg-success");

        lugaresSelecionados++;
        lugares.push({
            fila: fila,
            posicao: posicao
        });

        document.getElementById("lugares_selecionados").value = JSON.stringify(lugares);
    }
</script>


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
                @php
                $ocupado = ($ocupados->contains(function ($value, $key) use ($fila, $posicao) {
                return $value->fila == $fila->fila && $value->posicao == $posicao->posicao;
                }));
                @endphp

                <div onclick="setLugarAtivo(this)" data-fila="{{ $fila->fila }}" data-posicao="{{ $posicao->posicao }}"
                    class="posicao p-2 {{ $ocupado ? 'bg-danger' : '' }}">
                    {{ $fila->fila }}{{ $posicao->posicao }}
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

<!-- hidden input that stores the lugares selected -->
<input type="hidden" name="lugares_selecionados" id="lugares_selecionados" value="" />
@endif
