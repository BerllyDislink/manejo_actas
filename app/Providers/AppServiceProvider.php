<?php

namespace App\Providers;

use App\Models\acta;
use App\Models\AsistenciaInvitado;
use App\Models\AsistenciaMiembro;
use App\Models\EncargadosTarea;
use App\Models\Miembro;
use App\Models\OrdenSesion;
use App\Models\Proposicione;
use App\Models\Sesion;
use App\Policies\ActaPolicy;
use App\Policies\AsistenciaInvitadoPolicy;
use App\Policies\AsistenciaMiembroPolicy;
use App\Policies\EncargadosTareaPolicy;
use App\Policies\MiembroPolicy;
use App\Policies\OrdenSesionPolicy;
use App\Policies\ProposicionePolicy;
use App\Policies\SessionPolicy;
use Illuminate\Support\Facades\Event;
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
        Gate::policy(Sesion::class, SessionPolicy::class);
        Gate::policy(OrdenSesion::class, OrdenSesionPolicy::class);
        Gate::policy(acta::class, ActaPolicy::class);
        Gate::policy(Miembro::class, MiembroPolicy::class);
        Gate::policy(AsistenciaMiembro::class, AsistenciaMiembroPolicy::class);
        Gate::policy(AsistenciaInvitado::class, AsistenciaInvitadoPolicy::class);
        Gate::policy(Proposicione::class, ProposicionePolicy::class);
        Gate::policy(EncargadosTarea::class, EncargadosTareaPolicy::class);

        

    }
}
