<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Industry;
use Illuminate\Auth\Access\HandlesAuthorization;

class IndustryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the industry can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the industry can view the model.
     */
    public function view(User $user, Industry $model): bool
    {
        return true;
    }

    /**
     * Determine whether the industry can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the industry can update the model.
     */
    public function update(User $user, Industry $model): bool
    {
        return true;
    }

    /**
     * Determine whether the industry can delete the model.
     */
    public function delete(User $user, Industry $model): bool
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
     * Determine whether the industry can restore the model.
     */
    public function restore(User $user, Industry $model): bool
    {
        return false;
    }

    /**
     * Determine whether the industry can permanently delete the model.
     */
    public function forceDelete(User $user, Industry $model): bool
    {
        return false;
    }
}
