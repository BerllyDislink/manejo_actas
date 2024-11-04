<?php

namespace App\Policies;

use App\Models\Solicitante;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SolicitantePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read_applicants');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Solicitante $solicitante): bool
    {
        return $user->can('read_applicants');
        
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_applicants');
        
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Solicitante $solicitante): bool
    {
        return $user->can('update_applicants');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Solicitante $solicitante): bool
    {
        return $user->can('delete_applicants');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Solicitante $solicitante): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Solicitante $solicitante): bool
    {
        return false;
    }
}
