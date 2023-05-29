<?php

namespace App\Http\Controllers;

use App\Models\Sala;
use App\Models\Filme;
use App\Models\Sessao;
use Illuminate\Http\Request;

class SessaoController extends Controller
{
    private $resultsPerPage = 10;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sessoes = Sessao::orderBy('data', 'asc')->orderBy('horario_inicio', 'asc')->get();

        $sessoes = $sessoes->filter(function ($sessao) {
            $sessaoDate = $sessao->data . ' ' . $sessao->horario_inicio;
            $now = now();
            return $sessaoDate > $now;
        });

        $filterByFilme = $request->query('filme') ?? '';
        $filterBySala = $request->query('sala') ?? '';

        if ($filterByFilme !== '') {
            $sessoes = $sessoes->where('filme_id', $filterByFilme);
        }

        if ($filterBySala !== '') {
            $sessoes = $sessoes->where('sala_id', $filterBySala);
        }

        $sessoes = $sessoes->toQuery()->paginate($this->resultsPerPage);

        $filmes = Filme::all()->sortBy('titulo')->whereNull('deleted_at');
        $salas = Sala::all()->whereNull('deleted_at');

        return view(
            'admin::sessoes.index',
            compact('sessoes', 'filterByFilme', 'filterBySala', 'filmes', 'salas')
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
    public function show(Sessao $sessao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sessao $sessao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sessao $sessao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sessao $sessao)
    {
        //
    }
}
