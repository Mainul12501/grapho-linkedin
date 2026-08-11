<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeDocument;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeeDocumentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employeeDocument can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeDocument can view the model.
     */
    public function view(User $user, EmployeeDocument $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeDocument can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeDocument can update the model.
     */
    public function update(User $user, EmployeeDocument $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employeeDocument can delete the model.
     */
    public function delete(User $user, EmployeeDocument $model): bool
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
     * Determine whether the employeeDocument can restore the model.
     */
    public function restore(User $user, EmployeeDocument $model): bool
    {
        return false;
    }

    /**
     * Determine whether the employeeDocument can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeDocument $model): bool
    {
        return false;
    }
}
