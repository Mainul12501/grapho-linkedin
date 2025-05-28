<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployerCompany;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployerCompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the employerCompany can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employerCompany can view the model.
     */
    public function view(User $user, EmployerCompany $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employerCompany can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the employerCompany can update the model.
     */
    public function update(User $user, EmployerCompany $model): bool
    {
        return true;
    }

    /**
     * Determine whether the employerCompany can delete the model.
     */
    public function delete(User $user, EmployerCompany $model): bool
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
     * Determine whether the employerCompany can restore the model.
     */
    public function restore(User $user, EmployerCompany $model): bool
    {
        return false;
    }

    /**
     * Determine whether the employerCompany can permanently delete the model.
     */
    public function forceDelete(User $user, EmployerCompany $model): bool
    {
        return false;
    }
}
