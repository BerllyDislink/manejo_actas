<?php

namespace App\Policies;

use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Auth\Access\Response;


class SolicitudPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read_petition');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Solicitud $solicitud): bool
    {
        return $user->can('read_petition');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_petition');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Solicitud $solicitud): bool
    {
        return $user->can('update_petition');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Solicitud $solicitud): bool
    {
        return $user->can('delete_petition');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Solicitud $solicitud): bool
    {
        return false;
    }


    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Solicitud $solicitud): bool
    {
        return false;
    }
}
