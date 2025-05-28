<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Advertisement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvertisementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the advertisement can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the advertisement can view the model.
     */
    public function view(User $user, Advertisement $model): bool
    {
        return true;
    }

    /**
     * Determine whether the advertisement can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the advertisement can update the model.
     */
    public function update(User $user, Advertisement $model): bool
    {
        return true;
    }

    /**
     * Determine whether the advertisement can delete the model.
     */
    public function delete(User $user, Advertisement $model): bool
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
     * Determine whether the advertisement can restore the model.
     */
    public function restore(User $user, Advertisement $model): bool
    {
        return false;
    }

    /**
     * Determine whether the advertisement can permanently delete the model.
     */
    public function forceDelete(User $user, Advertisement $model): bool
    {
        return false;
    }
}
