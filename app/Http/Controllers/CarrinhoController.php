<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Bilhete;
use App\Services\Payment;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use App\Mail\SendReciboEmail;
use App\Mail\SendBilheteEmail;
use Illuminate\Support\Facades\Mail;

class CarrinhoController extends Controller
{
    public function addItem(Request $request)
    {
        $sessao = $request->sessao_id;
        $sala = $request->sala_id;
        $lugares = json_decode($request->lugares_selecionados);

        if ($lugares === null) {
            return redirect()->back()->with('error', 'Selecione o(s) lugar(es) na sala!');
        }

        // get a list of lugares ids from the fila and posicao and sala_id
        foreach ($lugares as $lugar) {
            $lugar = Lugar::where('fila', $lugar->fila)
                ->where('posicao', $lugar->posicao)
                ->where('sala_id', $sala)
                ->first();

            if ($lugar === null) {
                return redirect()->back()->with('error', 'Lugar(es) selecionado(s) não existe(m)!');
            }

            $lugaresIds[] = [$lugar->id, $lugar->fila, $lugar->posicao];
        }

        $cart = session()->get('cart', []);
        $cart[] = [
            'sessao_id' => $sessao,
            'sala_id' => $sala,
            'lugares' => $lugaresIds,
        ];
        session()->put('cart', $cart);

        return redirect()->route('carrinho.showCart')->with('success', 'Item adicionado ao carrinho!');
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);

        $cart = collect($cart);

        return view('public::carrinho.index', compact('cart'));
    }

    public function showCheckout()
    {
        if (auth()->user()->tipo === 'A' || auth()->user()->tipo === 'F') {
            return redirect()->back()->with('error', 'Como Administrador, não pode aceder a esta página.');
        }

        $cart = session()->get('cart', []);
        $cart = collect($cart);

        $quantidadeBilhetes = $cart->sum(function ($item) {
            return count($item['lugares']);
        });

        $c = Configuracao::first();

        return view('public::carrinho.checkout', compact('cart'))->with([
            'valorIva' => $c->percentagem_iva,
            'valorBilhete' => $c->preco_bilhete_sem_iva,
            'quantidadeBilhetes' => $quantidadeBilhetes,
            'valorTotal' => $quantidadeBilhetes * $c->preco_bilhete_sem_iva * (1 + $c->percentagem_iva / 100),
        ]);
    }

    public function removeItem(int $sessaoId)
    {
        $cart = session()->get('cart', []);

        $cart = collect($cart);

        $cart = $cart->reject(function ($item) use ($sessaoId) {
            return $item['sessao_id'] == $sessaoId;
        });

        $cart = $cart->toArray();

        session()->put('cart', $cart);

        return redirect()->route('carrinho.showCart')->with('success', 'Item removido do carrinho!');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        $cart = collect($cart);

        $user = $request->user();

        $ref_pagamento = null;
        switch ($user->cliente->tipo_pagamento) {
            case 'VISA':
            case 'MBWAY':
                $ref_pagamento = $user->cliente->ref_pagamento;
                break;
            case 'PAYPAL':
                $ref_pagamento = $user->email;
                break;
            default:
                $ref_pagamento = $user->cliente->ref_pagamento;
                break;
        }

        $validPayment = false;
        switch ($user->cliente->tipo_pagamento) {
            case 'MBWAY':
                $validPayment = Payment::payWithMBway($ref_pagamento);
                break;
            case 'VISA':
                $validPayment = Payment::payWithVisa($ref_pagamento, $request->cvc);
                break;
            case 'PAYPAL':
                $validPayment = Payment::payWithPaypal($user->email);
                break;
        }

        if (!$validPayment) {
            return redirect()->back()->with('error', 'Pagamento inválido, por favor verifique os dados de pagamento!');
        }

        $recibo = $user->cliente->recibo()->create([
            'cliente_id' => $user->cliente->id,
            'data' => now()->toDateString(),
            'preco_total_sem_iva' => $request->preco_total_sem_iva,
            'iva' => $request->percentagem_iva,
            'preco_total_com_iva' => $request->preco_total_com_iva,
            'nif' => $user->cliente->nif ?? null,
            'nome_cliente' => $user->name,
            'tipo_pagamento' => $user->cliente->tipo_pagamento,
            'ref_pagamento' => $ref_pagamento,
            'recibo_pdf_url' => '#'
        ]);

        $precoBilhete = Configuracao::first()->preco_bilhete_sem_iva;
        $bilhetes = [];

        foreach ($cart as $item) {
            $sessao = $item['sessao_id'];
            $lugares = $item['lugares'];

            foreach ($lugares as $lugar) {
                $bilhete = new Bilhete();
                $bilhete->sessao_id = $sessao;
                $bilhete->lugar_id = $lugar[0];
                $bilhete->recibo_id = $recibo->id;
                $bilhete->cliente_id = $user->cliente->id;
                $bilhete->preco_sem_iva = $precoBilhete;
                $bilhete->save();

                $bilhetes[] = $bilhete;
            }
        }

        Mail::to($user->email)->send(new SendBilheteEmail($bilhetes));

        ReciboController::createPDF($recibo->id);

        Mail::to($user->email)->send(new SendReciboEmail($recibo->id));

        session()->forget('cart');

        return redirect()->route('carrinho.showCart')->with('success', 'Compra efetuada com sucesso!');
    }
}
