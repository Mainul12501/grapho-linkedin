<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the job can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the job can view the model.
     */
    public function view(User $user, Job $model): bool
    {
        return true;
    }

    /**
     * Determine whether the job can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the job can update the model.
     */
    public function update(User $user, Job $model): bool
    {
        return true;
    }

    /**
     * Determine whether the job can delete the model.
     */
    public function delete(User $user, Job $model): bool
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
     * Determine whether the job can restore the model.
     */
    public function restore(User $user, Job $model): bool
    {
        return false;
    }

    /**
     * Determine whether the job can permanently delete the model.
     */
    public function forceDelete(User $user, Job $model): bool
    {
        return false;
    }
}
