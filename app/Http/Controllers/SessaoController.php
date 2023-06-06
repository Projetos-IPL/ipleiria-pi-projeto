<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sala;
use App\Models\Filme;
use App\Models\Lugar;
use App\Models\Genero;
use App\Models\Sessao;
use Illuminate\Support\Str;
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
        $sessao = Sessao::findOrFail($id);
        $bilhetes = $sessao->bilhetes()->paginate($this->resultsPerPage);

        return view('admin::sessoes.show', compact('sessao', 'bilhetes'));
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

    public function indexPublic(Request $request)
    {
        $currentDate = Carbon::now()->toDateString();
        $currentHour = Carbon::now()->format('H');

        $sessoes = Sessao::with('filme.genero')->whereDate('data', '>=', $currentDate)
            ->where(function ($query) use ($currentDate, $currentHour) {
                $query->whereDate('data', '>', $currentDate)
                    ->orWhere(function ($query) use ($currentHour) {
                        $query->whereRaw('HOUR(horario_inicio) >= ?', [$currentHour]);
                    });
            })
            ->get();

        $sessoes = $sessoes->filter(function ($sessao) use ($request) {
            $filme = $sessao->filme;
            $genero = $filme->genero;

            $searchQuery = $request->query('search') ?? '';
            $generoQuery = $request->query('genero') ?? '';

            if ($searchQuery !== '') {
                return stripos($filme->titulo, $searchQuery) !== false or stripos($filme->sinopse, $searchQuery) !== false;
            }

            if ($generoQuery !== '') {
                return $genero->code == $generoQuery;
            }

            return true;
        });

        $sessoes = $sessoes->unique('filme_id');

        $generos = $sessoes->map(function ($sessao) {
            return $sessao->filme->genero;
        })->unique('code');

        return view('public::sessoes.index', compact('sessoes', 'generos'));
    }

    public function showPublic(int $id)
    {
        $filme = Filme::findOrFail($id);

        if ($filme->trailer_url == null) {
            $filme->trailer_url = '';
        } else {
            $filme->trailer_url = explode('=', $filme->trailer_url)[1];
        }

        $currentDate = Carbon::now()->toDateString();
        $currentHour = Carbon::now()->format('H');

        $filme->sessoes = Sessao::with('filme.genero')->where('filme_id', '=', $filme->id)->whereDate('data', '>=', $currentDate)
            ->where(function ($query) use ($currentDate, $currentHour) {
                $query->whereDate('data', '>', $currentDate)
                    ->orWhere(function ($query) use ($currentHour) {
                        $query->whereRaw('HOUR(horario_inicio) >= ?', [$currentHour]);
                    });
            })
            ->get();

        return view('public::sessoes.show', ['filme' => $filme]);
    }

    public function buy(int $id)
    {
        $sessao = Sessao::findOrFail($id);
        $filme = $sessao->filme;

        if ($filme->trailer_url == null) {
            $filme->trailer_url = '';
        } else {
            $filme->trailer_url = explode('=', $filme->trailer_url)[1];
        }

        $bilhetes = $sessao->bilhetes;
        $ocupados = [];

        foreach ($bilhetes as $bilhete) {
            $ocupados[] = $bilhete->lugar_id;
        }

        $ocupados = Lugar::whereIn('id', $ocupados)->get();

        return view('public::sessoes.buy', compact('sessao', 'filme', 'ocupados'));
    }

    public function accessControl(Request $request)
    {
        $sessoes = Sessao::with('filme')->whereDate('data', '=', date('Y-m-d'))->get();

        return view('admin::sessoes.access-control', compact('sessoes'));
    }
}
