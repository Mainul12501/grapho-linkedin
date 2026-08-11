<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SubscriptionPlan;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPlanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the subscriptionPlan can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the subscriptionPlan can view the model.
     */
    public function view(User $user, SubscriptionPlan $model): bool
    {
        return true;
    }

    /**
     * Determine whether the subscriptionPlan can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the subscriptionPlan can update the model.
     */
    public function update(User $user, SubscriptionPlan $model): bool
    {
        return true;
    }

    /**
     * Determine whether the subscriptionPlan can delete the model.
     */
    public function delete(User $user, SubscriptionPlan $model): bool
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
     * Determine whether the subscriptionPlan can restore the model.
     */
    public function restore(User $user, SubscriptionPlan $model): bool
    {
        return false;
    }

    /**
     * Determine whether the subscriptionPlan can permanently delete the model.
     */
    public function forceDelete(User $user, SubscriptionPlan $model): bool
    {
        return false;
    }
}
