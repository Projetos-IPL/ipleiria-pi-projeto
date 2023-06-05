<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Bilhete;
use App\Services\Payment;
use App\Models\Configuracao;
use Illuminate\Http\Request;

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

        // add item to cart, but allow multiple items to be in the user cart
        // associate the cart array with the authenticated user
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
        // get cart from session that has user attribute equal to the authenticated user
        $cart = session()->get('cart', []);

        // convert the array into a collection
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

        // get quantity of bilhetes in the cart
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

        // get user in request
        $user = $request->user();

        $validPayment = false;
        switch ($user->cliente->tipo_pagamento) {
            case 'MBWAY':
                $validPayment = Payment::payWithMBway($request->numero_telemovel);
                break;
            case 'VISA':
                $validPayment = Payment::payWithVisa($request->numero_cartao, $request->cvc);
                break;
            case 'PAYPAL':
                $validPayment = Payment::payWithPaypal($user->email);
                break;
        }

        if (!$validPayment) {
            return redirect()->back()->with('error', 'Pagamento inválido, por favor verifique os dados de pagamento!');
        }

        // create a new bilhete for each item in the cart
        foreach ($cart as $item) {
            $sessao = $item['sessao_id'];
            $sala = $item['sala_id'];
            $lugares = $item['lugares'];

            dd($item);

            foreach ($lugares as $lugar) {
                $bilhete = new Bilhete();
                $bilhete->sessao_id = $sessao;
                $bilhete->sala_id = $sala;
                $bilhete->lugar_id = $lugar[0];
                $bilhete->save();
            }
        }

        // create a new recibo for the user
        $recibo = $user->recibos()->create([
            'valor' => $request->valor_total,
            'data' => now(),
        ]);

        // associate the bilhetes with the recibo
        foreach ($recibo->bilhetes as $bilhete) {
            $bilhete->recibo_id = $recibo->id;
            $bilhete->save();
        }

        // clear the cart
        session()->forget('cart');

        return redirect()->route('carrinho.showCart')->with('success', 'Compra efetuada com sucesso!');
    }
}
