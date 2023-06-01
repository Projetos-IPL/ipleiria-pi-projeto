<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
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
        $salas = Sala::query()->where('deleted_at', null)->with('lugares')->orderBy('nome');

        $filterByPesquisa = $request->query('pesquisa') ?? '';

        if ($filterByPesquisa !== '') {
            $salas->where('nome', 'like', "%{$filterByPesquisa}%");
        }

        $salas = $salas->paginate($this->resultsPerPage);

        return view('admin::salas.index', compact('salas', 'filterByPesquisa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::salas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'nome' => 'required|string|max:50',
            'filas' => 'required|integer|min:1|max:26',
            'lugaresPorFila' => 'required|integer|min:1|max:25',
        ]);

        if ($validation) {
            $sala = new Sala();
            $sala->nome = $request->nome;
            $sala->save();

            $filas = $request->filas ?? 0;
            $lugaresPerFila = $request->lugaresPorFila ?? 0;

            for ($i = 1; $i <= $filas; $i++) {
                $filaLetter = chr(64 + $i);

                for ($j = 1; $j <= $lugaresPerFila; $j++) {
                    Lugar::query()->create([
                        'sala_id' => $sala->id,
                        'fila' => $filaLetter,
                        'posicao' => $j,
                    ]);
                }
            }
        } else {
            return redirect()->back()->withErrors($validation);
        }

        return redirect()->route('salas.index')->with('success', 'Sala criada com sucesso!');
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

        Lugar::query()->where('sala_id', $id)->delete();

        return redirect()->route('salas.index')->with('success', 'Sala removido com sucesso!');
    }
}
