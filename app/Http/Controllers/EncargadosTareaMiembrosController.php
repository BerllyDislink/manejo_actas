<?php
namespace App\Http\Controllers;

use App\Models\AsistenciaInvitado;
use App\Models\AsistenciaMiembro;
use App\Models\Sesion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class EncargadosTareaMiembrosController extends Controller
{
    public function getMemberInvitedToSesion($IDSESION)
    {
        Gate::authorize('view', AsistenciaMiembro::class);

        $memberInviteToSesion = QueryBuilder::for(User::class)
            ->select('users.id as user_id', 'miembros.IDMIEMBRO as miembro_id', 'miembros.NOMBRE as nombre', 'users.email', 'miembros.CARGO as cargo',
                'asistencia_miembros.ESTADO_ASISTENCIA as asistencia', 'roles.name as rol')
            ->join('miembros', 'users.id', '=', 'miembros.user_id')
            ->join('asistencia_miembros', 'miembros.IDMIEMBRO', '=', 'asistencia_miembros.MIEMBRO_IDMIEMBRO')
            ->join('sesion', 'asistencia_miembros.SESSION_IDSESION', '=', 'sesion.IDSESION')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('sesion.IDSESION', '=', $IDSESION)
            ->get();

        return response()->json(['data' => $memberInviteToSesion]);
    }

    public function getGuestInvitedToSesion($IDSESION)
    {
        Gate::authorize('view', AsistenciaInvitado::class);

        $guestInviteToSesion = QueryBuilder::for(User::class)
            ->select('users.id as user_id', 'invitados.IDINVITADOS as invitado_id', 'invitados.NOMBRE as nombre', 'users.email', 'invitados.CARGO as cargo',
                'asistencia_invitado.ESTADO_ASISTENCIA as asistencia', 'roles.name as rol')
            ->join('invitados', 'users.id', '=', 'invitados.user_id')
            ->join('asistencia_invitado', 'invitados.IDINVITADOS', '=', 'asistencia_invitado.INIVITADO_IDINVITADO')
            ->join('sesion', 'asistencia_invitado.SESION_IDSESION', '=', 'sesion.IDSESION')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('sesion.IDSESION', '=', $IDSESION)
            ->get();

        return response()->json(['data' => $guestInviteToSesion]);
    }

    public function show($IDSESION)
    {
        Gate::authorize('view', [AsistenciaMiembro::class, AsistenciaInvitado::class]);

        $memberInviteToSesion = QueryBuilder::for(User::class)
            ->select('users.id as user_id', 'miembros.IDMIEMBRO as miembro_id', 'miembros.NOMBRE as nombre', 'miembros.CARGO as cargo',
                'asistencia_miembros.ESTADO_ASISTENCIA as asistencia', 'roles.name as rol')
            ->join('miembros', 'users.id', '=', 'miembros.user_id')
            ->join('asistencia_miembros', 'miembros.IDMIEMBRO', '=', 'asistencia_miembros.MIEMBRO_IDMIEMBRO')
            ->join('sesion', 'asistencia_miembros.SESSION_IDSESION', '=', 'sesion.IDSESION')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('sesion.IDSESION', '=', $IDSESION)
            ->get();

        $guestInviteToSesion = QueryBuilder::for(User::class)
            ->select('users.id as user_id', 'invitados.IDINVITADOS as invitado_id', 'invitados.NOMBRE as nombre', 'invitados.CARGO as cargo',
                'asistencia_invitado.ESTADO_ASISTENCIA as asistencia', 'roles.name as rol')
            ->join('invitados', 'users.id', '=', 'invitados.user_id')
            ->join('asistencia_invitado', 'invitados.IDINVITADOS', '=', 'asistencia_invitado.INIVITADO_IDINVITADO')
            ->join('sesion', 'asistencia_invitado.SESION_IDSESION', '=', 'sesion.IDSESION')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->where('sesion.IDSESION', '=', $IDSESION)
            ->get();

        $registro = User::with('miembros.asistencia_miembros.sesion', 'invitados.asistencia_invitados.sesion', 'roles')->get();

        $spati = QueryBuilder::for(Sesion::class)
            ->allowedFields([
                'sesion.IDSESION',
                'sesion.asistencia_miembros.ESTADO_ASISTENCIA',
                'sesion.asistencia_miembros.miembro.IDMIEMBRO',
                'sesion.asistencia_miembros.miembro.users.id',
                'asistencia_miembros.miembro.users.roles.id',
                'asistencia_invitados.ESTADO_ASISTENCIA',
                'asistencia_invitados.invitado.IDINVITADOS',
                'asistencia_invitados.invitado.users.id',
                'asistencia_invitados.invitado.users.roles.id'
            ])
            ->allowedIncludes([
                'asistencia_miembros.miembro.users.roles',
                'asistencia_invitados.invitado.users.roles'
            ])
            ->allowedFilters(AllowedFilter::exact('IDSESION'))
            ->get();

        $listInvitedToSession = compact('memberInviteToSesion', 'guestInviteToSesion');
        return response()->json($listInvitedToSession);
    }
}
