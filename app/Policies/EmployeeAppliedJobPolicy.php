<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeAppliedJob;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeAppliedJobPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employeeAppliedJob can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeAppliedJob can view the model.
     */
    public function view(User $user, EmployeeAppliedJob $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeAppliedJob can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeAppliedJob can update the model.
     */
    public function update(User $user, EmployeeAppliedJob $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeAppliedJob can delete the model.
     */
    public function delete(User $user, EmployeeAppliedJob $model): bool
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
     * Determine whether the employeeAppliedJob can restore the model.
     */
    public function restore(User $user, EmployeeAppliedJob $model): bool
    {
        return false;
    }

    /**
     * Determine whether the employeeAppliedJob can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeAppliedJob $model): bool
    {
        return false;
    }
}
