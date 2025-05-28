<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobLocationType;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobLocationTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the jobLocationType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the jobLocationType can view the model.
     */
    public function view(User $user, JobLocationType $model): bool
    {
        return true;
    }

    /**
     * Determine whether the jobLocationType can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the jobLocationType can update the model.
     */
    public function update(User $user, JobLocationType $model): bool
    {
        return true;
    }

    /**
     * Determine whether the jobLocationType can delete the model.
     */
    public function delete(User $user, JobLocationType $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the jobLocationType can restore the model.
     */
    public function restore(User $user, JobLocationType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the jobLocationType can permanently delete the model.
     */
    public function forceDelete(User $user, JobLocationType $model): bool
    {
        return false;
    }
}
