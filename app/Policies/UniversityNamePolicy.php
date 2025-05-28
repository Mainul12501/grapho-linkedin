<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UniversityName;
use Illuminate\Auth\Access\HandlesAuthorization;

class UniversityNamePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the universityName can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the universityName can view the model.
     */
    public function view(User $user, UniversityName $model): bool
    {
        return true;
    }

    /**
     * Determine whether the universityName can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the universityName can update the model.
     */
    public function update(User $user, UniversityName $model): bool
    {
        return true;
    }

    /**
     * Determine whether the universityName can delete the model.
     */
    public function delete(User $user, UniversityName $model): bool
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
     * Determine whether the universityName can restore the model.
     */
    public function restore(User $user, UniversityName $model): bool
    {
        return false;
    }

    /**
     * Determine whether the universityName can permanently delete the model.
     */
    public function forceDelete(User $user, UniversityName $model): bool
    {
        return false;
    }
}
