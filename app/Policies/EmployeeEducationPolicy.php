<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeEducation;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeEducationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employeeEducation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeEducation can view the model.
     */
    public function view(User $user, EmployeeEducation $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeEducation can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeEducation can update the model.
     */
    public function update(User $user, EmployeeEducation $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeEducation can delete the model.
     */
    public function delete(User $user, EmployeeEducation $model): bool
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
     * Determine whether the employeeEducation can restore the model.
     */
    public function restore(User $user, EmployeeEducation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the employeeEducation can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeEducation $model): bool
    {
        return false;
    }
}
