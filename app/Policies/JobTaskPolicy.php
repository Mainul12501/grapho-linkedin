<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobTask;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobTaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the jobTask can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the jobTask can view the model.
     */
    public function view(User $user, JobTask $model): bool
    {
        return true;
    }

    /**
     * Determine whether the jobTask can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the jobTask can update the model.
     */
    public function update(User $user, JobTask $model): bool
    {
        return true;
    }

    /**
     * Determine whether the jobTask can delete the model.
     */
    public function delete(User $user, JobTask $model): bool
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
     * Determine whether the jobTask can restore the model.
     */
    public function restore(User $user, JobTask $model): bool
    {
        return false;
    }

    /**
     * Determine whether the jobTask can permanently delete the model.
     */
    public function forceDelete(User $user, JobTask $model): bool
    {
        return false;
    }
}
