<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SkillsCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class SkillsCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the skillsCategory can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the skillsCategory can view the model.
     */
    public function view(User $user, SkillsCategory $model): bool
    {
        return true;
    }

    /**
     * Determine whether the skillsCategory can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the skillsCategory can update the model.
     */
    public function update(User $user, SkillsCategory $model): bool
    {
        return true;
    }

    /**
     * Determine whether the skillsCategory can delete the model.
     */
    public function delete(User $user, SkillsCategory $model): bool
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
     * Determine whether the skillsCategory can restore the model.
     */
    public function restore(User $user, SkillsCategory $model): bool
    {
        return false;
    }

    /**
     * Determine whether the skillsCategory can permanently delete the model.
     */
    public function forceDelete(User $user, SkillsCategory $model): bool
    {
        return false;
    }
}
