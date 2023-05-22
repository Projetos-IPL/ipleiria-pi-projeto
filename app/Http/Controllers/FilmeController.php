<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use App\Models\Genero;
use Illuminate\Http\Request;

class FilmeController extends Controller
{
    private $resultsPerPage = 10;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filmes = Filme::query();

        // check if query parameters for filtering are empty
        $filterByGenero = $request->query('genero') ?? '';
        $filterByPesquisa = $request->query('pesquisa') ?? '';
        $filterByAno = $request->query('ano') ?? '';

        // filter based on filter parameters
        if ($filterByGenero !== '') {
            $filmes->where('genero_code', $filterByGenero);
        }

        if ($filterByPesquisa !== '') {
            $filmes->where('titulo', 'like', "%{$filterByPesquisa}%")
                ->orWhere('sumario', 'like', "%{$filterByPesquisa}%");
        }

        if ($filterByAno !== '') {
            $filmes->where('ano', $filterByAno);
        }

        $filmes = $filmes->paginate($this->resultsPerPage);

        // get all generos to show in filter
        $generos = Genero::all();
        $anos = Filme::select('ano')->distinct()->orderBy('ano', 'DESC')->get();

        return view(
            'admin::filmes.index',
            compact('filmes', 'generos', 'anos', 'filterByGenero', 'filterByPesquisa', 'filterByAno')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $generos = Genero::all();

        return view('admin::filmes.create', compact('generos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate fields
        $validation = $request->validate([
            'titulo' => 'required',
            'genero_code' => 'required',
            'ano' => 'required|numeric|digits:4',
        ]);

        if ($validation) {
            $filme = new Filme();
            $filme->titulo = $request->titulo;
            $filme->genero_code = $request->genero_code;
            $filme->ano = $request->ano;
            $filme->sumario = $request->sumario;
            $filme->trailer_url = $request->trailer_url;
            $filme->custom = $request->custom;
            $filme->save();
        } else {
            return redirect()->back()->withErrors($validation);
        }

        if ($request->hasFile('cartaz_url')) {
            $cartazUrl = $request->file('cartaz_url');

            $cartazUrlName = $filme->id . '_' . time() . '.' . $cartazUrl->getClientOriginalExtension();

            $cartazUrl->move(storage_path('app/public/cartazes'), $cartazUrlName);
            $filme->cartaz_url = $cartazUrlName;
            $filme->save();
        }

        return redirect()->route('admin.filmes.index')->with('success', 'Filme criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        $filme = Filme::findOrFail($id);

        return view('admin::filmes.show', compact('filme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $filme = Filme::findOrFail($id);
        $generos = Genero::all();

        return view('admin::filmes.edit', compact('filme', 'generos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $filme = Filme::findOrFail($id);

        // validate fields
        $validation = $request->validate([
            'titulo' => 'required',
            'genero_code' => 'required',
            'ano' => 'required|numeric|digits:4',
        ]);

        if ($validation) {
            $filme->titulo = $request->titulo;
            $filme->genero_code = $request->genero_code;
            $filme->ano = $request->ano;
            $filme->sumario = $request->sumario;
            $filme->trailer_url = $request->trailer_url;
            $filme->custom = $request->custom;
            $filme->save();
        } else {
            return redirect()->back()->withErrors($validation);
        }

        if ($request->hasFile('cartaz_url')) {
            $cartazUrl = $request->file('cartaz_url');

            $cartazUrlName = $filme->id . '_' . time() . '.' . $cartazUrl->getClientOriginalExtension();

            $cartazUrl->move(storage_path('app/public/cartazes'), $cartazUrlName);
            $filme->cartaz_url = $cartazUrlName;
            $filme->save();
        }

        return redirect()->route('admin.filmes.index')->with('success', 'Filme alterado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $filme = Filme::findOrFail($id);
        $filme->delete();

        return redirect()->route('admin.filmes.index')->with('success', 'Filme eliminado com sucesso!');
    }
}
