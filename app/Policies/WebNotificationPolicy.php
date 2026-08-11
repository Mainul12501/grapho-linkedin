<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WebNotification;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebNotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the webNotification can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the webNotification can view the model.
     */
    public function view(User $user, WebNotification $model): bool
    {
        return true;
    }

    /**
     * Determine whether the webNotification can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the webNotification can update the model.
     */
    public function update(User $user, WebNotification $model): bool
    {
        return true;
    }

    /**
     * Determine whether the webNotification can delete the model.
     */
    public function delete(User $user, WebNotification $model): bool
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
     * Determine whether the webNotification can restore the model.
     */
    public function restore(User $user, WebNotification $model): bool
    {
        return false;
    }

    /**
     * Determine whether the webNotification can permanently delete the model.
     */
    public function forceDelete(User $user, WebNotification $model): bool
    {
        return false;
    }
}
