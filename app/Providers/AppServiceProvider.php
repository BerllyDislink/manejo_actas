<?php

namespace App\Providers;

use App\Models\acta;
use App\Models\OrdenSesion;
use App\Models\Session;
use App\Policies\ActaPolicy;
use App\Policies\OrdenSesionPolicy;
use App\Policies\SessionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Session::class, SessionPolicy::class);
        Gate::policy(OrdenSesion::class, OrdenSesionPolicy::class);
        Gate::policy(acta::class, ActaPolicy::class);
    }
}
