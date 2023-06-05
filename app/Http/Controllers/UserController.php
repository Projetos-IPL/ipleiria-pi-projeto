<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    private $resultsPerPage = 20;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::query();

        $filterByPesquisa = $request->query('pesquisa') ?? '';
        $filterByTipo = $request->query('tipo') ?? '';
        $filterByBloqueado = $request->query('bloqueado') ?? '';

        if ($filterByTipo !== '') {
            $users->where('tipo', $filterByTipo);
        }

        if ($filterByPesquisa !== '') {
            $users->where('name', 'like', "%{$filterByPesquisa}%")
                ->orWhere('email', 'like', "%{$filterByPesquisa}%");
        }

        if ($filterByBloqueado !== '') {
            $users->where('bloqueado', true);
        }

        $users = $users->paginate($this->resultsPerPage);

        return view(
            'admin::users.index',
            compact('users', 'filterByPesquisa', 'filterByTipo', 'filterByBloqueado')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tipo' => 'required|in:A,F',
            'bloqueado' => 'boolean',
        ]);

        if ($validation) {
            $user = User::create($request->except('foto_url', 'password_confirmation'));
        } else {
            return redirect()->back()->withErrors($validation);
        }

        if ($request->hasFile('foto_url')) {
            $fotoUrl = $request->file('foto_url');

            $fotoUrlName = $user->id . '_' . time() . '.' . $fotoUrl->getClientOriginalExtension();

            $fotoUrl->move(storage_path('app/public/fotos'), $fotoUrlName);
            $user->foto_url = $fotoUrlName;
            $user->save();
        }

        event(new Registered($user));

        return redirect()->route('utilizadores.index')->with('success', 'Utilizador criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->tipo == 'C') {
            $bilhetes = $user->cliente->bilhete()
                ->with('lugar')
                ->orderBy('estado')
                ->orderBy('sessao_id', 'DESC')
                ->paginate(10);

            return view('admin::users.show', compact('user', 'bilhetes'));
        }

        return view('admin::users.show', compact('user'));
    }

    public function showAdminProfile()
    {
        $user = auth()->user();

        return view('admin::users.profile', compact('user'));
    }

    public function showPublicProfile()
    {
        $user = auth()->user();

        return view('public::users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->user()->id) {
            return redirect()->route('utilizadores.index')->with('error', 'Não pode editar o seu próprio perfil!');
        }

        return view('admin::users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // validate user field
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'tipo' => 'required|in:A,C,F',
            'bloqueado' => 'boolean',
        ]);

        if ($validation) {
            $user->update($request->except('foto_url'));
        } else {
            return redirect()->back()->withErrors($validation);
        }

        if ($request->hasFile('foto_url')) {
            $fotoUrl = $request->file('foto_url');

            $fotoUrlName = $user->id . '_' . time() . '.' . $fotoUrl->getClientOriginalExtension();

            $fotoUrl->move(storage_path('app/public/fotos'), $fotoUrlName);
            $user->foto_url = $fotoUrlName;
            $user->save();
        }

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('utilizadores.index')->with('success', 'Utilizador eliminado com sucesso!');
    }

    public function updatePublicProfile(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // validate user field
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'tipo_pagamento' => 'required|in:MBWAY,PAYPAL,VISA',
            'nif' => 'required|string|max:9',
        ]);

        // validate new password and update user
        if ($request->filled('password')) {
            $validation = $request->validate([
                'password' => 'required|string|min:3|confirmed',
            ]);

            if ($validation) {
                $user->update($request->except('foto_url'));
            } else {
                return redirect()->back()->withErrors($validation);
            }
        } else {
            $user->update($request->except('foto_url', 'password', 'tipo_pagamento', 'ref_pagamento', 'nif'));
        }

        if ($validation) {
            $user->update($request->except('foto_url', 'password', 'tipo_pagamento', 'ref_pagamento', 'nif'));
            $user->cliente->update($request->only('tipo_pagamento', 'ref_pagamento', 'nif'));
        } else {
            return redirect()->back()->withErrors($validation);
        }

        if ($request->hasFile('foto_url')) {
            $fotoUrl = $request->file('foto_url');

            $fotoUrlName = $user->id . '_' . time() . '.' . $fotoUrl->getClientOriginalExtension();

            $fotoUrl->move(storage_path('app/public/fotos'), $fotoUrlName);
            $user->foto_url = $fotoUrlName;
            $user->save();
        }

        return redirect()->back()->with('success', 'Perfil atualizado com sucesso!');
    }
}
