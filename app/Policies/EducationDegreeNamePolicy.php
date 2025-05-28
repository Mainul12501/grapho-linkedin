<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EducationDegreeName;
use Illuminate\Auth\Access\HandlesAuthorization;

class EducationDegreeNamePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the educationDegreeName can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the educationDegreeName can view the model.
     */
    public function view(User $user, EducationDegreeName $model): bool
    {
        return true;
    }

    /**
     * Determine whether the educationDegreeName can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the educationDegreeName can update the model.
     */
    public function update(User $user, EducationDegreeName $model): bool
    {
        return true;
    }

    /**
     * Determine whether the educationDegreeName can delete the model.
     */
    public function delete(User $user, EducationDegreeName $model): bool
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
     * Determine whether the educationDegreeName can restore the model.
     */
    public function restore(User $user, EducationDegreeName $model): bool
    {
        return false;
    }

    /**
     * Determine whether the educationDegreeName can permanently delete the model.
     */
    public function forceDelete(User $user, EducationDegreeName $model): bool
    {
        return false;
    }
}
