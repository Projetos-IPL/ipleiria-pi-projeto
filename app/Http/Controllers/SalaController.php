<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use Illuminate\Http\Request;

class SalaController extends Controller
{
    private $resultsPerPage = 20;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $salas = Sala::query()->where('deleted_at', null);

        $filterByPesquisa = $request->query('pesquisa') ?? '';

        if ($filterByPesquisa !== '') {
            $salas->where('nome', 'like', "%{$filterByPesquisa}%");
        }

        $salas = $salas->paginate($this->resultsPerPage);

        return view('admin::salas.index', compact('salas', 'filterByPesquisa'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $sala = Sala::query()->findOrFail($id);

        return view('admin::salas.show', compact('sala'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $sala = Sala::query()->findOrFail($id);

        return view('admin::salas.edit', compact('sala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $sala = Sala::query()->findOrFail($id);

        $validation = $request->validate([
            'nome' => 'required|string|max:50',
        ]);

        if ($validation) {
            $sala->nome = $request->nome;
            $sala->save();
        } else {
            return redirect()->back()->withErrors($validation);
        }

        return redirect()->route('salas.index')->with('success', 'Sala atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $sala = Sala::query()->findOrFail($id);
        $sala->delete();

        return redirect()->route('salas.index')->with('success', 'Sala removido com sucesso!');
    }
}
