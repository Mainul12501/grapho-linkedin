<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserProfileView;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserProfileViewPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the userProfileView can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the userProfileView can view the model.
     */
    public function view(User $user, UserProfileView $model): bool
    {
        return true;
    }

    /**
     * Determine whether the userProfileView can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the userProfileView can update the model.
     */
    public function update(User $user, UserProfileView $model): bool
    {
        return true;
    }

    /**
     * Determine whether the userProfileView can delete the model.
     */
    public function delete(User $user, UserProfileView $model): bool
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
     * Determine whether the userProfileView can restore the model.
     */
    public function restore(User $user, UserProfileView $model): bool
    {
        return false;
    }

    /**
     * Determine whether the userProfileView can permanently delete the model.
     */
    public function forceDelete(User $user, UserProfileView $model): bool
    {
        return false;
    }
}
