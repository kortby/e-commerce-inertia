<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Services\GetParentAndChildByAuthenticated;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view-any-user');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if (auth()->user()->hasAnyRole(config('roles-permissions'))) {

            return $user->can('view-user');
        }

        return $user->can('view-user') && $this->getEligibleUserIds($model);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create-user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if (auth()->user()->hasAnyRole(config('roles-permissions'))) {

            return $user->can('update-user');
        }

        return ($user->can('update-user') && $this->getEligibleUserIds($model)) || $user->id == $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if (auth()->user()->hasAnyRole(config('roles-permissions'))) {

            return $user->can('delete-user');
        }

        return $user->can('delete-user') && $this->getEligibleUserIds($model);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        if (auth()->user()->hasAnyRole(config('roles-permissions'))) {

            return $user->can('restore-user');
        }

        return $user->can('restore-user') &&  $this->getEligibleUserIds($model);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        if (auth()->user()->hasAnyRole(config('roles-permissions'))) {

            return $user->can('force-delete-user');
        }

        return $user->can('force-delete-user') && $this->getEligibleUserIds($model);
    }

    /**
     * @param User $model
     * @return bool
     */
    private function getEligibleUserIds(User $model): bool
    {
        return in_array($model->parent_id, (new GetParentAndChildByAuthenticated())->handle());
    }
}
