<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use App\Models\Genero;
use Illuminate\Http\Request;

class FilmeController extends Controller
{
    private $resultsPerPage = 20;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Filme $filme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filme $filme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filme $filme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filme $filme)
    {
        //
    }
}
