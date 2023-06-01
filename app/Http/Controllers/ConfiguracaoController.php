<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;

class ConfiguracaoController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $configuracao = Configuracao::first();

        $validation = $request->validate([
            'preco_bilhete_sem_iva' => 'required|numeric|min:0',
            'percentagem_iva' => 'required|numeric|max:100|min:0',
        ]);

        if ($validation) {
            $configuracao->update($validation);
        } else {
            return redirect()->back()->withErrors($validation);
        }

        return redirect()->route('configuracoes.edit')->with('success', 'Configurações atualizadas com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $configuracao = Configuracao::first();

        return view('admin::configuracoes.edit', compact('configuracao'));
    }
}
