<?php

namespace App\Policies;

use App\Models\EncargadosTarea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EncargadosTareaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('read_task_mandated');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->can('read_task_mandated');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_task_mandated');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->can('update_task_mandated');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('delete_task_mandated');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EncargadosTarea $encargadosTarea): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EncargadosTarea $encargadosTarea): bool
    {
        return false;
    }
}
