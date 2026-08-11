<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EducationSubjectName;
use Illuminate\Auth\Access\HandlesAuthorization;

class EducationSubjectNamePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the educationSubjectName can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the educationSubjectName can view the model.
     */
    public function view(User $user, EducationSubjectName $model): bool
    {
        return true;
    }

    /**
     * Determine whether the educationSubjectName can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the educationSubjectName can update the model.
     */
    public function update(User $user, EducationSubjectName $model): bool
    {
        return true;
    }

    /**
     * Determine whether the educationSubjectName can delete the model.
     */
    public function delete(User $user, EducationSubjectName $model): bool
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
     * Determine whether the educationSubjectName can restore the model.
     */
    public function restore(User $user, EducationSubjectName $model): bool
    {
        return false;
    }

    /**
     * Determine whether the educationSubjectName can permanently delete the model.
     */
    public function forceDelete(User $user, EducationSubjectName $model): bool
    {
        return false;
    }
}
