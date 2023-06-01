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
        $sessoes = Sessao::orderBy('data', 'asc')->orderBy('horario_inicio', 'asc')->with('filme', 'sala')->get();

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

        $filmes = Filme::all()->sortBy('titulo')->whereNull('deleted_at');
        $salas = Sala::all()->whereNull('deleted_at');

        // check if sessoes query is empty
        if ($sessoes->isEmpty()) {
            return view('admin::sessoes.index', compact('sessoes', 'filmes', 'salas', 'filterByFilme', 'filterBySala'));
        }

        $sessoes = $sessoes->toQuery()->paginate($this->resultsPerPage);

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
        $filmes = Filme::all()->sortBy('titulo')->whereNull('deleted_at');
        $salas = Sala::all()->whereNull('deleted_at');

        return view('admin::sessoes.create', compact('filmes', 'salas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'filme_id' => 'required|exists:filmes,id',
            'sala_id' => 'required|exists:salas,id',
            'data' => 'required|date',
            'horario_inicio' => 'required|date_format:H:i',
        ]);

        if ($validation) {
            $sessao = new Sessao();
            $sessao->filme_id = $request->filme_id;
            $sessao->sala_id = $request->sala_id;
            $sessao->data = $request->data;
            $sessao->horario_inicio = $request->horario_inicio;
            $sessao->save();

            return redirect()->route('sessoes.index')->with('success', 'Sessão criada com sucesso!');
        } else {
            return redirect()->back()->withErrors($validation);
        }

        return redirect()->back()->with('error', 'Ocorreu um erro ao criar a sessão!');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $sessao = Sessao::findOrFail($id);

        if ($sessao->bilhetes->count() > 0) {
            return redirect()->back()->with('error', 'Não é possível remover uma sessão com bilhetes associados!');
        }

        $filmes = Filme::all()->sortBy('titulo')->whereNull('deleted_at');
        $salas = Sala::all()->whereNull('deleted_at');

        return view('admin::sessoes.edit', compact('sessao', 'filmes', 'salas'));
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
    public function destroy(int $id)
    {
        $sessao = Sessao::findOrFail($id);

        if ($sessao->bilhetes->count() > 0) {
            return redirect()->back()->with('error', 'Não é possível remover uma sessão com bilhetes associados!');
        }

        if ($sessao) {
            $sessao->delete();
            return redirect()->route('sessoes.index')->with('success', 'Sessão removida com sucesso!');
        }

        return redirect()->back()->with('error', 'Ocorreu um erro ao remover a sessão!');
    }
}
