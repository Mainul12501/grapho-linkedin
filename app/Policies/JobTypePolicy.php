<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobType;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobTypePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the jobType can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the jobType can view the model.
     */
    public function view(User $user, JobType $model): bool
    {
        return true;
    }

    /**
     * Determine whether the jobType can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the jobType can update the model.
     */
    public function update(User $user, JobType $model): bool
    {
        return true;
    }

    /**
     * Determine whether the jobType can delete the model.
     */
    public function delete(User $user, JobType $model): bool
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
     * Determine whether the jobType can restore the model.
     */
    public function restore(User $user, JobType $model): bool
    {
        return false;
    }

    /**
     * Determine whether the jobType can permanently delete the model.
     */
    public function forceDelete(User $user, JobType $model): bool
    {
        return false;
    }
}
