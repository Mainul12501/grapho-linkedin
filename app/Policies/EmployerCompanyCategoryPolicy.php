<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployerCompanyCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployerCompanyCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employerCompanyCategory can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employerCompanyCategory can view the model.
     */
    public function view(User $user, EmployerCompanyCategory $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employerCompanyCategory can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employerCompanyCategory can update the model.
     */
    public function update(User $user, EmployerCompanyCategory $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employerCompanyCategory can delete the model.
     */
    public function delete(User $user, EmployerCompanyCategory $model): bool
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
     * Determine whether the employerCompanyCategory can restore the model.
     */
    public function restore(User $user, EmployerCompanyCategory $model): bool
    {
        return false;
    }

    /**
     * Determine whether the employerCompanyCategory can permanently delete the model.
     */
    public function forceDelete(
        User $user,
        EmployerCompanyCategory $model
    ): bool {
        return false;
    }
}
