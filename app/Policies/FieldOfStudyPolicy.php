<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FieldOfStudy;
use Illuminate\Auth\Access\HandlesAuthorization;

class FieldOfStudyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the fieldOfStudy can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the fieldOfStudy can view the model.
     */
    public function view(User $user, FieldOfStudy $model): bool
    {
        return true;
    }

    /**
     * Determine whether the fieldOfStudy can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the fieldOfStudy can update the model.
     */
    public function update(User $user, FieldOfStudy $model): bool
    {
        return true;
    }

    /**
     * Determine whether the fieldOfStudy can delete the model.
     */
    public function delete(User $user, FieldOfStudy $model): bool
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
     * Determine whether the fieldOfStudy can restore the model.
     */
    public function restore(User $user, FieldOfStudy $model): bool
    {
        return false;
    }

    /**
     * Determine whether the fieldOfStudy can permanently delete the model.
     */
    public function forceDelete(User $user, FieldOfStudy $model): bool
    {
        return false;
    }
}
