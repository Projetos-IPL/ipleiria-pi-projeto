<?php

namespace App\Policies;

use App\Models\User;

class UserTypePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function restrictUserTypeAdministrator(User $user)
    {
        return $user->tipo === 'A';
    }

    public function restrictUserTypeFuncionario(User $user)
    {
        return $user->tipo === 'F';
    }
}
