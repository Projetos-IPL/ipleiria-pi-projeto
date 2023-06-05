<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Policies\UserTypePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('restrict-user-type-administrator', [UserTypePolicy::class, 'restrictUserTypeAdministrator']);
        Gate::define('restrict-user-type-funcionario', [UserTypePolicy::class, 'restrictUserTypeFuncionario']);
    }
}
