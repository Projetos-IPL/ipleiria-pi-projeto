<?php

namespace App\Http\Controllers;

use App\Models\Genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    private $resultsPerPage = 20;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $generos = Genero::query()->where('deleted_at', null);

        $filterByPesquisa = $request->query('pesquisa') ?? '';

        if ($filterByPesquisa !== '') {
            $generos->where('nome', 'like', "%{$filterByPesquisa}%")
                ->orWhere('code', 'like', "%{$filterByPesquisa}%");
        }

        $generos = $generos->paginate($this->resultsPerPage);

        return view('admin::generos.index', compact('generos', 'filterByPesquisa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::generos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'code' => 'required|alpha|max:20',
            'nome' => 'required|alpha|max:50',
        ]);

        if ($validation) {
            $genero = new Genero();
            $genero->code = $request->code;
            $genero->nome = $request->nome;
            $genero->save();
        } else {
            return redirect()->back()->withErrors($validation);
        }

        return redirect()->route('generos.index')->with('success', 'Género criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $genero = Genero::query()->where('code', $id)->firstOrFail();
        $filmes = $genero->filmes()->get();

        return view('admin::generos.show', compact('genero', 'filmes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $genero = Genero::query()->where('code', $id)->firstOrFail();

        return view('admin::generos.edit', compact('genero'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $genero = Genero::query()->where('code', $id)->firstOrFail();

        $validation = $request->validate([
            'code' => 'required|alpha|max:20',
            'nome' => 'required|alpha|max:50',
        ]);

        if ($validation) {
            $genero->code = $request->code;
            $genero->nome = $request->nome;
            $genero->save();
        } else {
            return redirect()->back()->withErrors($validation);
        }

        return redirect()->route('generos.index')->with('success', 'Género atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $genero = Genero::query()->where('code', $id)->firstOrFail();
        $genero->delete();

        return redirect()->route('generos.index')->with('success', 'Género removido com sucesso!');
    }
}
