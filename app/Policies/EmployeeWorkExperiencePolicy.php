<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeWorkExperience;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeWorkExperiencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employeeWorkExperience can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeWorkExperience can view the model.
     */
    public function view(User $user, EmployeeWorkExperience $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeWorkExperience can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeWorkExperience can update the model.
     */
    public function update(User $user, EmployeeWorkExperience $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeWorkExperience can delete the model.
     */
    public function delete(User $user, EmployeeWorkExperience $model): bool
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
     * Determine whether the employeeWorkExperience can restore the model.
     */
    public function restore(User $user, EmployeeWorkExperience $model): bool
    {
        return false;
    }

    /**
     * Determine whether the employeeWorkExperience can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeWorkExperience $model): bool
    {
        return false;
    }
}
